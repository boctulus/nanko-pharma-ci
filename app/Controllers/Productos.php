<?php namespace App\Controllers;

class Productos extends BaseController
{
    public function __construct(){
		header('X-Content-Type-Options:nosniff');
		header('X-Frame-Options:SAMEORIGIN');
		header('X-XSS-Protection:1;mode=block');
		helper('url');
		helper('form');
		lang('Test.longTime', [time()], 'es');
    }

    public function index(){
		if ($this->session->get('usuario')) {
			$this->mostrar_productos();
		} else {
			$this->session->setFlashdata('error', 'Por favor inicie sesión');
			return redirect()->to('login');
		}
	}

	public function get_dosis(){
		if ($this->request->isAJAX()){
			$Dosis_model = model('App\Models\Dosis_model', false);
			$Padecimientos_model = model('App\Models\Padecimientos_model', false);
			$post = $this->request->getVar(null, FILTER_SANITIZE_STRING);
			$id_prod = $this->encrypter->decrypt(base64_decode($post['id_prod']));
			//$producto = $Dosis_model->find($id_prod);

			$dosis_aux = $Dosis_model->where("id_producto = '".$id_prod."'")
			->findAll();
			$dosis = array();
			if ($dosis_aux) {
				foreach ($dosis_aux as $obj) {
					$subir = "";
					if ($obj['subir_1']) {
						$subir = "Subir 1 gota pasadas dos semanas.";
					}else if($obj['subir_2']){
						$subir = "Subir 2 gotas pasadas dos semanas.";
					}

					$id_padecimientos = explode(":", $obj['padecimientos']);
					$padecimientos_nombre = "";
					foreach ($id_padecimientos as $pad) {
					  $pad_aux = $Padecimientos_model->where("idPadecimiento = '".$pad."'")
							->findAll();
					  $padecimientos_nombre .= $pad_aux[0]['nombre_p'].", ";
					}

					$dosis[] = array(
						'id_dosis' => base64_encode($this->encrypter->encrypt($obj['id_dosis'])),
						'padecimiento' => $padecimientos_nombre,
						'edad_min' => $obj['edad_min'],
						'edad_max' => $obj['edad_max'],
						'peso_min' => $obj['peso_min'],
						'peso_max' => $obj['peso_max'],
						'resultado' => $obj['resultado_m'].", ".$obj['resultado_t'].", ".$obj['resultado_n'],
						'fecha' => strftime("%d/%B/%Y",strtotime($obj['fecha'])),
						'estado' => ($obj['estado'] == 1)?"Activa":"Eliminada",
						'subir' => $subir
					);
				}
			}
			$data = array(
				'dosis' => $dosis
			);
			return view("Administrador/Modal/detalles_dosis",$data);
		}
	}

	public function nueva_dosis(){
		$validation = [
			'id_producto' => ['label' => '', 'rules' => 'required|valid_base64'],
			'padecimientos' => ['label' => 'Padecimientos', 'rules' => 'required'],
			'edad' => ['label' => 'Edad', 'rules' => 'required'],
			'peso' => ['label' => 'Peso', 'rules' => 'required'],
			'subir' => ['label' => 'Subir gotas despues de semanas', 'rules' => 'required'],
			'num_gotas_m' => ['label' => 'Número de gotas mañana', 'rules' => 'permit_empty'],
			'num_gotas_t' => ['label' => 'Número de gotas tarde', 'rules' => 'permit_empty'],
			'num_gotas_n' => ['label' => 'Número de gotas noche', 'rules' => 'permit_empty']
		];
		if (!$this->validate($validation)){ //si algo sale mal en el form
			//$post = $this->request->getVar(null, FILTER_SANITIZE_STRING);
			//$this->session->setFlashdata('error',['tipo' => 'nuevo','error' => $this->validator->getErrors(),'id_producto' => $post['id_producto']]);
			//return $this->mostrar_productos();
			$respuesta = array(
				'bandera' => 0,
				'mensaje' => "Error al crear la dosis"
			);
			echo json_encode($respuesta);

		}
		$Dosis_model = model('App\Models\Dosis_model', false);

		$post = $this->request->getVar(null, FILTER_SANITIZE_STRING);
		$edades = json_decode(strip_tags($this->request->getPost('edad')));
		$pesos = json_decode(strip_tags($this->request->getPost('peso')));

		$padecimientos_aux = json_decode(strip_tags($this->request->getPost('padecimientos')));
		$padecimientos = $this->encrypter->decrypt(base64_decode($padecimientos_aux[0]));
		for ($i=1; $i < count($padecimientos_aux); $i++) {
			$padecimientos .= ":".$this->encrypter->decrypt(base64_decode($padecimientos_aux[$i])).':';
		}
		$data = [
			'id_producto' => $this->encrypter->decrypt(base64_decode($post['id_producto'])),
			'edad_min' => $edades[0],
			'edad_max' => $edades[1],
			'peso_min' => $pesos[0],
			'peso_max' => $pesos[1],
			'padecimientos' => $padecimientos,
			'subir_1' => ($post['subir'] == 1) ? 1:null,
			'subir_2' => ($post['subir'] == 2) ? 1:null,
			'resultado_m' => ($post['num_gotas_m']) ? $post['num_gotas_m']:null,
			'resultado_t' => ($post['num_gotas_t']) ? $post['num_gotas_t']:null,
			'resultado_n' => ($post['num_gotas_n']) ? $post['num_gotas_n']:null,
		];

		$Dosis_model->insert($data);

		$respuesta = array(
			'bandera' => 1,
		);

		echo json_encode($respuesta);
	}

	public function eliminar_dosis(){
		if ($this->request->isAJAX()){
			$Dosis_model = model('App\Models\Dosis_model', false);
			$post = $this->request->getVar(null, FILTER_SANITIZE_STRING);
			$id_dosis = $this->encrypter->decrypt(base64_decode($post['id_dosis']));
			$Dosis_model->set('estado', 0);
			$Dosis_model->where('id_dosis', $id_dosis);
			$Dosis_model->update();
			echo 1;
		}
	}

	public function reactivar_dosis(){
		if ($this->request->isAJAX()){
			$Dosis_model = model('App\Models\Dosis_model', false);
			$post = $this->request->getVar(null, FILTER_SANITIZE_STRING);
			$id_dosis = $this->encrypter->decrypt(base64_decode($post['id_dosis']));
			$Dosis_model->set('estado', 1);
			$Dosis_model->where('id_dosis', $id_dosis);
			$Dosis_model->update();
			echo 1;
		}
	}

  public function nuevo_producto(){
    $file = $this->request->getFileMultiple('fotos_sec');
    if ($file) {
      if ($file[0]->isValid()) {
        $validation = [
    			'nombre' => ['label' => 'Nombre', 'rules' => 'required'],
    			'nombre_ing' => ['label' => 'Nombre inglés', 'rules' => 'permit_empty'],
    			'region' => ['label' => 'Regiones', 'rules' => 'required'],
    			'categoria' => ['label' => 'Categoría', 'rules' => 'required|valid_base64'],
    			'descripcion' => ['label' => 'Descripción', 'rules' => 'required'],
    			'descripcion_ing' => ['label' => 'Descripción en inglés', 'rules' => 'required'],
    			'precio_1' => ['label' => 'Precio México', 'rules' => 'decimal|permit_empty'],
    			'precio_2' => ['label' => 'Precio Perú', 'rules' => 'decimal|permit_empty'],
    			'precio_3' => ['label' => 'Precio Europa', 'rules' => 'decimal|permit_empty'],
    			'precio_4' => ['label' => 'Precio Argentina', 'rules' => 'decimal|permit_empty'],
    			'precio_5' => ['label' => 'Precio Resto del mundo', 'rules' => 'decimal|permit_empty'],
    			'desc_mex' => ['label' => 'Descuento México', 'rules' => 'permit_empty|less_than_equal_to[50]'],
    			'desc_peru' => ['label' => 'Descuento Perú', 'rules' => 'permit_empty|less_than_equal_to[50]'],
    			'desc_eur' => ['label' => 'Descuento Europa', 'rules' => 'permit_empty|less_than_equal_to[50]'],
    			'desc_arg' => ['label' => 'Descuento Argentina', 'rules' => 'permit_empty|less_than_equal_to[50]'],
    			'desc_rest' => ['label' => 'Descuento Resto del mundo', 'rules' => 'permit_empty|less_than_equal_to[50]'],
    			'foto' => ['label' => 'Foto', 'rules' => 'uploaded[foto]|max_size[foto,5240]|ext_in[foto,jpg,jpeg,png]'],
    			'fotos_sec' => ['label' => 'Fotos Secundarias', 'rules' => 'uploaded[fotos_sec]|max_size[fotos_sec,5120]|ext_in[fotos_sec,jpg,jpeg,png]'],
    			'peso' => ['label' => 'Peso', 'rules' => 'required|decimal'],
        ];
      } else {
        $validation = [
    			'nombre' => ['label' => 'Nombre', 'rules' => 'required'],
    			'nombre_ing' => ['label' => 'Nombre inglés', 'rules' => 'permit_empty'],
    			'region' => ['label' => 'Regiones', 'rules' => 'required'],
    			'categoria' => ['label' => 'Categoría', 'rules' => 'required|valid_base64'],
    			'descripcion' => ['label' => 'Descripción', 'rules' => 'required'],
    			'descripcion_ing' => ['label' => 'Descripción en inglés', 'rules' => 'required'],
    			'precio_1' => ['label' => 'Precio México', 'rules' => 'decimal|permit_empty'],
    			'precio_2' => ['label' => 'Precio Perú', 'rules' => 'decimal|permit_empty'],
    			'precio_3' => ['label' => 'Precio Europa', 'rules' => 'decimal|permit_empty'],
    			'precio_4' => ['label' => 'Precio Argentina', 'rules' => 'decimal|permit_empty'],
    			'precio_5' => ['label' => 'Precio Resto del mundo', 'rules' => 'decimal|permit_empty'],
    			'desc_mex' => ['label' => 'Descuento México', 'rules' => 'permit_empty|less_than_equal_to[50]'],
    			'desc_peru' => ['label' => 'Descuento Perú', 'rules' => 'permit_empty|less_than_equal_to[50]'],
    			'desc_eur' => ['label' => 'Descuento Europa', 'rules' => 'permit_empty|less_than_equal_to[50]'],
    			'desc_arg' => ['label' => 'Descuento Argentina', 'rules' => 'permit_empty|less_than_equal_to[50]'],
    			'desc_rest' => ['label' => 'Descuento Resto del mundo', 'rules' => 'permit_empty|less_than_equal_to[50]'],
    			'foto' => ['label' => 'Foto', 'rules' => 'uploaded[foto]|max_size[foto,5240]|ext_in[foto,jpg,jpeg,png]'],
    			'peso' => ['label' => 'Peso', 'rules' => 'required|decimal'],
        ];
      }
    } else {
      $validation = [
        'nombre' => ['label' => 'Nombre', 'rules' => 'required'],
        'nombre_ing' => ['label' => 'Nombre inglés', 'rules' => 'permit_empty'],
        'region' => ['label' => 'Regiones', 'rules' => 'required'],
        'categoria' => ['label' => 'Categoría', 'rules' => 'required|valid_base64'],
        'descripcion' => ['label' => 'Descripción', 'rules' => 'required'],
        'descripcion_ing' => ['label' => 'Descripción en inglés', 'rules' => 'required'],
        'precio_1' => ['label' => 'Precio México', 'rules' => 'decimal|permit_empty'],
        'precio_2' => ['label' => 'Precio Perú', 'rules' => 'decimal|permit_empty'],
        'precio_3' => ['label' => 'Precio Europa', 'rules' => 'decimal|permit_empty'],
        'precio_4' => ['label' => 'Precio Argentina', 'rules' => 'decimal|permit_empty'],
        'precio_5' => ['label' => 'Precio Resto del mundo', 'rules' => 'decimal|permit_empty'],
    		'desc_mex' => ['label' => 'Descuento México', 'rules' => 'permit_empty|less_than_equal_to[50]'],
    		'desc_peru' => ['label' => 'Descuento Perú', 'rules' => 'permit_empty|less_than_equal_to[50]'],
    		'desc_eur' => ['label' => 'Descuento Europa', 'rules' => 'permit_empty|less_than_equal_to[50]'],
    		'desc_arg' => ['label' => 'Descuento Argentina', 'rules' => 'permit_empty|less_than_equal_to[50]'],
    		'desc_rest' => ['label' => 'Descuento Resto del mundo', 'rules' => 'permit_empty|less_than_equal_to[50]'],
        'foto' => ['label' => 'Foto', 'rules' => 'uploaded[foto]|max_size[foto,5240]|ext_in[foto,jpg,jpeg,png]'],
        'peso' => ['label' => 'Peso', 'rules' => 'required|decimal'],
      ];
    }

		if (! $this->validate($validation)){ //si algo sale mal en el form
			$this->session->setFlashdata('error',['tipo' => 'nuevo','error' => $this->validator->getErrors()]);
			return $this->mostrar_productos();
		}

		$Producto_model = model('App\Models\Producto_model', false);
		$post = $this->request->getVar(null, FILTER_SANITIZE_STRING);

		$regiones = strip_tags($post['region'][0]);
    for ($i=1; $i < count($post['region']); $i++) {
    	$regiones = $regiones.":".strip_tags($post['region'][$i]);
    }

    $data = [
			'idCategoria' => $this->encrypter->decrypt(base64_decode($post['categoria'])),
  		'nombre' => $post['nombre'],
			'nombre_ing' => isset($post['nombre_ing']) ? $post['nombre_ing']:null,
			'descripcion' => $post['descripcion'],
			'descripcion_ingles' => $post['descripcion_ing'],
			'precio_1' => isset($post['precio_1']) ? $post['precio_1']:null,
			'precio_2' => isset($post['precio_2']) ? $post['precio_2']:null,
			'precio_3' => isset($post['precio_3']) ? $post['precio_3']:null,
			'precio_4' => isset($post['precio_4']) ? $post['precio_4']:null,
			'precio_5' => isset($post['precio_5']) ? $post['precio_5']:null,
      'desc_mex' => (isset($post['desc_mex']) && $post['desc_mex'] != "") ? $post['desc_mex']:null,
  	  'desc_peru' => (isset($post['desc_peru']) && $post['desc_peru'] != "") ? $post['desc_peru']:null,
  	  'desc_eur' => (isset($post['desc_eur']) && $post['desc_eur'] != "") ? $post['desc_eur']:null,
  	  'desc_arg' => (isset($post['desc_arg']) && $post['desc_arg'] != "") ? $post['desc_arg']:null,
  	  'desc_rest' => (isset($post['desc_rest']) && $post['desc_rest'] != "") ? $post['desc_rest']:null,
			'stock' => $post['stock'],
			'peso' => $post['peso'],
			'regiones' => $regiones
		];
		$Producto_model->insert($data);
		$id_insert = $Producto_model->insertID();

		$path = null;
		$file = $this->request->getFile('foto');

		if ($file->isValid()){
			$name = $file->getRandomName();
			$this->request->getFile('foto')->store('../../../public_html/productos_img/'.$id_insert."/",$name);
			$path = "/productos_img/".$id_insert."/".$name;
		}

		$file = $this->request->getFileMultiple('fotos_sec');
		$path_sec = "";
		if ($file) {
			$i=0;
			foreach ($file as $file_obj) {
				if ($file_obj->isValid()){
					$name = $file_obj->getRandomName();
					$this->request->getFileMultiple('fotos_sec')[$i++]->store('../../../public_html/productos_img/'.$id_insert."/",$name);
          $path_sec = $path_sec.":/productos_img/".$id_insert."/".$name;
				}
			}
		}

		$Producto_model->set('img_port', $path);
		$Producto_model->set('img_sec', $path_sec);
		$Producto_model->where('idProducto', $id_insert);
		$Producto_model->update();

		$this->session->setFlashdata('aviso', 'El producto fue creado exitosamente.');
		return redirect()->to('mostrar_productos');
	}

	public function editar_dosis(){
		$validation = [
			'id_dosis' => ['label' => 'id', 'rules' => 'required|valid_base64'],
			'padecimientos' => ['label' => 'Padecimientos', 'rules' => 'required'],
			'edad' => ['label' => 'Edad', 'rules' => 'required'],
			'peso' => ['label' => 'Peso', 'rules' => 'required'],
			'subir' => ['label' => 'Subir gotas despues de semanas', 'rules' => 'required'],
			'num_gotas_m' => ['label' => 'Número de gotas mañana', 'rules' => 'permit_empty'],
			'num_gotas_t' => ['label' => 'Número de gotas tarde', 'rules' => 'permit_empty'],
			'num_gotas_n' => ['label' => 'Número de gotas noche', 'rules' => 'permit_empty']
		];

		if (! $this->validate($validation)){ //si algo sale mal en el form
			$post = $this->request->getVar(null, FILTER_SANITIZE_STRING);

			if (isset($post['id_dosis'])) {
				$Dosis_model = model('App\Models\Dosis_model', false);

				$this->session->setFlashdata('error',['tipo' => 'editar','error' => $this->validator->getErrors(),'dosis' => $post['id_dosis']]);
				$id_dosis = $this->encrypter->decrypt(base64_decode($post['id_dosis']));
				$dosis = $Dosis_model->find($id_dosis);
				if ($dosis) {
					$data = array(
						'id_dosis' => $post['id_dosis'],
						'edad_min' => $dosis['edad_min'],
						'edad_max' => $dosis['edad_max'],
						'peso_min' => $dosis['peso_min'],
						'peso_max' => $dosis['peso_max'],
						'resultado_m' => ($dosis['resultado_m']) ? $dosis['resultado_m']:null,
						'resultado_t' => ($dosis['resultado_t']) ? $dosis['resultado_t']:null,
						'resultado_n' => ($dosis['resultado_n']) ? $dosis['resultado_n']:null,
					);
					if ($dosis['subir_1']) {
						$data['subir'] = 1;
					}elseif($dosis['subir_2']) {
						$data['subir'] = 2;
					}
					$this->mostrar_productos();
					return view("Administrador/Modal/editar_dosis",$data);
				}
			} else {
				$Dosis_model = model('App\Models\Dosis_model', false);
				$Padecimientos_model = model('App\Models\Padecimientos_model', false);

				$id_dosis = $this->encrypter->decrypt(base64_decode($post['id_ds']));
				$dosis = $Dosis_model->find($id_dosis);
				if ($dosis) {

					$padecimiento_aux = $Padecimientos_model->where("estado != 0")->findAll();
					$padecimientos_seleccionados = array();

					$padecimientos_dosis = explode(':',$dosis['padecimientos']);

					if ($padecimiento_aux) {
						foreach ($padecimiento_aux as $obj) {
							$id_aux = base64_encode($this->encrypter->encrypt($obj['idPadecimiento']));
							foreach ($padecimientos_dosis as $pad_dos) {
								if ($obj['idPadecimiento'] == $pad_dos) {
									$padecimientos_seleccionados[] = $id_aux;
								}
							}
							$padecimientos_drop[$id_aux] = $obj['nombre_p'];
						}
					}
					$data = array(
						'id_dosis' => $post['id_ds'],
						'padecimientos_select' => $padecimientos_seleccionados,
						'padecimientos_drop' => $padecimientos_drop,
						'edad_min' => $dosis['edad_min'],
						'edad_max' => $dosis['edad_max'],
						'peso_min' => $dosis['peso_min'],
						'peso_max' => $dosis['peso_max'],
						'resultado_m' => ($dosis['resultado_m']) ? $dosis['resultado_m']:null,
						'resultado_t' => ($dosis['resultado_t']) ? $dosis['resultado_t']:null,
						'resultado_n' => ($dosis['resultado_n']) ? $dosis['resultado_n']:null,
					);
					if ($dosis['subir_1']) {
						$data['subir'] = 1;
					}elseif($dosis['subir_2']) {
						$data['subir'] = 2;
					}
					return view("Administrador/Modal/editar_dosis",$data);
				}
			}
		}
		$Dosis_model = model('App\Models\Dosis_model', false);
		$post = $this->request->getVar(null, FILTER_SANITIZE_STRING);

		$id_dosis = $this->encrypter->decrypt(base64_decode($post['id_dosis']));
		$dosis = $Dosis_model->find($id_dosis);
		$edades = json_decode(strip_tags($this->request->getPost('edad')));
		$pesos = json_decode(strip_tags($this->request->getPost('peso')));

		$padecimientos_aux = json_decode(strip_tags($this->request->getPost('padecimientos')));
		$padecimientos = $this->encrypter->decrypt(base64_decode($padecimientos_aux[0]));
		for ($i=1; $i < count($padecimientos_aux); $i++) {
			$padecimientos .= ":".$this->encrypter->decrypt(base64_decode($padecimientos_aux[$i])).":";
		}

		$data = [
			'edad_min' => $edades[0],
			'edad_max' => $edades[1],
			'peso_min' => $pesos[0],
			'peso_max' => $pesos[1],
			'padecimientos' => $padecimientos,
			'subir_1' => ($post['subir'] == 1) ? 1:null,
			'subir_2' => ($post['subir'] == 2) ? 1:null,
			'resultado_m' => (isset($post['num_gotas_m'])) ? $post['num_gotas_m']:null,
			'resultado_t' => (isset($post['num_gotas_t'])) ? $post['num_gotas_t']:null,
			'resultado_n' => (isset($post['num_gotas_n'])) ? $post['num_gotas_n']:null,
		];

		$Dosis_model->update($id_dosis,$data);
		// $this->session->setFlashdata('aviso', 'La dosis fue editada exitosamente.');
		// return redirect()->to('mostrar_productos');
		$respuesta = array(
			'bandera' => 1,
		);

		echo json_encode($respuesta);
	}

  public function editar_producto(){
    $validation = [
      'id_producto' => ['label' => 'id', 'rules' => 'required|valid_base64'],
      'nombre' => ['label' => 'Nombre', 'rules' => 'required'],
      'nombre_ing' => ['label' => 'Nombre Inglés', 'rules' => 'permit_empty'],
      'estado' => ['label' => 'Estado', 'rules' => 'required'],
      'region' => ['label' => 'Regiones', 'rules' => 'required'],
      'categoria' => ['label' => 'Categoría', 'rules' => 'required|valid_base64'],
      'descripcion' => ['label' => 'Descripción', 'rules' => 'required'],
      'descripcion_ing' => ['label' => 'Descripción en inglés', 'rules' => 'required'],
      'precio_1' => ['label' => 'Precio México', 'rules' => 'permit_empty|decimal'],
      'precio_2' => ['label' => 'Precio Perú', 'rules' => 'permit_empty|decimal'],
      'precio_3' => ['label' => 'Precio Europa', 'rules' => 'permit_empty|decimal'],
      'precio_4' => ['label' => 'Precio Argentina', 'rules' => 'permit_empty|decimal'],
      'precio_5' => ['label' => 'Precio Resto del mundo', 'rules' => 'permit_empty|decimal'],

  	  'desc_mex' => ['label' => 'Descuento México', 'rules' => 'permit_empty|less_than_equal_to[50]'],
  	  'desc_peru' => ['label' => 'Descuento Perú', 'rules' => 'permit_empty|less_than_equal_to[50]'],
  	  'desc_eur' => ['label' => 'Descuento Europa', 'rules' => 'permit_empty|less_than_equal_to[50]'],
  	  'desc_arg' => ['label' => 'Descuento Argentina', 'rules' => 'permit_empty|less_than_equal_to[50]'],
  	  'desc_rest' => ['label' => 'Descuento Resto del mundo', 'rules' => 'permit_empty|less_than_equal_to[50]'],

      'peso' => ['label' => 'Peso', 'rules' => 'required|decimal'],
      //'foto' => ['label' => 'Foto', 'rules' => 'uploaded[foto]|max_size[foto,5240]|ext_in[foto,jpg,jpeg,png]'],
      //'fotos_sec' => ['label' => 'Fotos Secundarias', 'rules' => 'uploaded[fotos_sec]|max_size[fotos_sec,5120]|ext_in[fotos_sec,jpg,jpeg,png]'],
    ];

    $file = $this->request->getFile('foto');
    if ($file){
      if ($file->isValid()) {
        $validation['foto'] = ['label' => 'Foto', 'rules' => 'uploaded[foto]|max_size[foto,5240]|ext_in[foto,jpg,jpeg,png]'];
      }
    }

    $file = $this->request->getFileMultiple('fotos_sec');
    $path_sec = "";
    if ($file) {
      if ($file[0]->isValid()) {
        $validation['fotos_sec'] = ['label' => 'Fotos Secundarias', 'rules' => 'uploaded[fotos_sec]|max_size[fotos_sec,5120]|ext_in[fotos_sec,jpg,jpeg,png]'];
      }
    }

    if (! $this->validate($validation)){ //si algo sale mal en el form
      $post = $this->request->getVar(null, FILTER_SANITIZE_STRING);

      if (isset($post['id_producto'])) {
        $this->session->setFlashdata('error',['tipo' => 'editar','error' => $this->validator->getErrors()]);
        $Categoria_model = model('App\Models\Categoria_model', false);
        $Producto_model = model('App\Models\Producto_model', false);
        //$Padecimientos_model = model('App\Models\Padecimientos_model', false);
        $post = $this->request->getVar(null, FILTER_SANITIZE_STRING);
        $id_prod = $this->encrypter->decrypt(base64_decode($post['id_producto']));
        $producto = $Producto_model->find($id_prod);
        if ($producto) {
          $db = \Config\Database::connect();
          $query = $db->query('SELECT nombre_p FROM padecimiento WHERE id_producto = '.$id_prod);
          $results = $query->getResult();

          $categorias_aux = $Categoria_model->findAll();
          $categorias = array(''=>'Sin Producto');
          if ($categorias_aux) {
            foreach ($categorias_aux as $obj) {
              if ($producto['idCategoria'] == $obj['id_categoria']) {
                $producto['idCategoria'] = base64_encode($this->encrypter->encrypt($obj['id_categoria']));
                $categorias[$producto['idCategoria']] = $obj['nombre'];
              }else {
                $categorias[base64_encode($this->encrypter->encrypt($obj['id_categoria']))] = $obj['nombre'];
              }
            }
          }

          $data = array(
            'idProducto' => $post['id_producto'],
            'url' => $post['url'],
            'categoria' => $Categoria_model->find($producto['idCategoria'])['nombre'],
            'id_categoria' => $producto['idCategoria'],
            'categorias_drop' => $categorias,
            'total_vendidas' => $producto['cantidad_vendida'],
            'stock' => $producto['stock'],
            'padecimientos' => $results,
            'nombre' => $producto['nombre'],
            'nombre_ing' => $producto['nombre_ing'],
            'descripcion' => $producto['descripcion'],
            'descripcion_ingles' => $producto['descripcion_ingles'],
            'precio_1' => ($producto['precio_1']) ? $producto['precio_1']:null,
            'precio_2' => ($producto['precio_2']) ? $producto['precio_2']:null,
            'precio_3' => ($producto['precio_3']) ? $producto['precio_3']:null,
            'precio_4' => ($producto['precio_4']) ? $producto['precio_4']:null,
            'precio_5' => ($producto['precio_5']) ? $producto['precio_5']:null,

            'desc_mex' => ($producto['desc_mex'] != null) ? $producto['desc_mex']:null,
      			'desc_peru' => ($producto['desc_peru'] != null) ? $producto['desc_peru']:null,
      			'desc_eur' => ($producto['desc_eur'] != null) ? $producto['desc_eur']:null,
      			'desc_arg' => ($producto['desc_arg'] != null) ? $producto['desc_arg']:null,
      			'desc_rest' => ($producto['desc_rest'] != null) ? $producto['desc_rest']:null,

            'regiones' => $producto['regiones'],
            'estado' => $producto['estado'],
            'peso' => $producto['peso'],
            'img_port' => $producto['img_port'],
            'img_sec' => explode(":", $producto['img_sec']),
          );
          $this->mostrar_productos();
          return view("Administrador/Modal/detalles_producto",$data);
        }
      } else {
        $Categoria_model = model('App\Models\Categoria_model', false);
        $Producto_model = model('App\Models\Producto_model', false);
        //$Padecimientos_model = model('App\Models\Padecimientos_model', false);
        $post = $this->request->getVar(null, FILTER_SANITIZE_STRING);
        $id_prod = $this->encrypter->decrypt(base64_decode($post['id_prod']));
        $producto = $Producto_model->find($id_prod);
        if ($producto) {
          $db = \Config\Database::connect();
          $query = $db->query('SELECT nombre_p FROM padecimiento WHERE id_producto = '.$id_prod);
          $results = $query->getResult();

          $categorias_aux = $Categoria_model->findAll();
          $categorias = array(''=>'Sin Producto');
          if ($categorias_aux) {
            foreach ($categorias_aux as $obj) {
              if ($producto['idCategoria'] == $obj['id_categoria']) {
                $producto['idCategoria'] = base64_encode($this->encrypter->encrypt($obj['id_categoria']));
                $categorias[$producto['idCategoria']] = $obj['nombre'];
              }else {
                $categorias[base64_encode($this->encrypter->encrypt($obj['id_categoria']))] = $obj['nombre'];
              }
            }
          }

          $data = array(
            'idProducto' => $post['id_prod'],
            'url' => $post['url'],
            'categoria' => $Categoria_model->find($producto['idCategoria'])['nombre'],
            'id_categoria' => $producto['idCategoria'],
            'categorias_drop' => $categorias,
            'total_vendidas' => $producto['cantidad_vendida'],
            'stock' => $producto['stock'],
            'padecimientos' => $results,
            'nombre' => $producto['nombre'],
            'nombre_ing' => $producto['nombre_ing'],
            'estado' => $producto['estado'],
            'descripcion' => $producto['descripcion'],
            'descripcion_ingles' => $producto['descripcion_ingles'],
            'precio_1' => $producto['precio_1'],
            'precio_2' => $producto['precio_2'],
            'precio_3' => $producto['precio_3'],
            'precio_4' => $producto['precio_4'],
            'precio_5' => $producto['precio_5'],

            'desc_mex' => ($producto['desc_mex'] != null) ? $producto['desc_mex']:null,
      			'desc_peru' => ($producto['desc_peru'] != null) ? $producto['desc_peru']:null,
      			'desc_eur' => ($producto['desc_eur'] != null) ? $producto['desc_eur']:null,
      			'desc_arg' => ($producto['desc_arg'] != null) ? $producto['desc_arg']:null,
      			'desc_rest' => ($producto['desc_rest'] != null) ? $producto['desc_rest']:null,

            'regiones' => $producto['regiones'],
            'estado' => $producto['estado'],
            'img_port' => $producto['img_port'],
            'peso' => $producto['peso'],
            'img_sec' => explode(":", $producto['img_sec']),
          );
          return view("Administrador/Modal/detalles_producto",$data);
        }
      }
    }
    $Producto_model = model('App\Models\Producto_model', false);
    $post = $this->request->getVar(null, FILTER_SANITIZE_STRING);

    $regiones = strip_tags($post['region'][0]);
        for ($i=1; $i < count($post['region']); $i++) {
          $regiones = $regiones.":".strip_tags($post['region'][$i]);
        }

    $id_prod = $this->encrypter->decrypt(base64_decode($post['id_producto']));
    $producto = $Producto_model->find($id_prod);

    $path = null;
    $file = $this->request->getFile('foto');

    if ($file->isValid()){
      $name = $file->getRandomName();
      $this->request->getFile('foto')->store('../../../public_html/productos_img/'.$id_prod."/",$name);
      $path = "/productos_img/".$id_prod."/".$name;
    }

    $file = $this->request->getFileMultiple('fotos_sec');
    $path_sec = "";
    if ($file) {
      $i=0;
      foreach ($file as $file_obj) {
        if ($file_obj->isValid()){
          $name = $file_obj->getRandomName();
          $this->request->getFileMultiple('fotos_sec')[$i++]->store('../../../public_html/productos_img/'.$id_prod."/",$name);
          $path_sec = $path_sec.":/productos_img/".$id_prod."/".$name;
        }
      }
    }

    $data = [
      'idCategoria' => $this->encrypter->decrypt(base64_decode($post['categoria'])),
      'nombre' => $post['nombre'],
      'nombre_ing' => isset($post['nombre_ing'])?$post['nombre_ing']:null,
      'descripcion' => $post['descripcion'],
      'descripcion_ingles' => $post['descripcion_ing'],
      'precio_1' => (isset($post['precio_1']))?$post['precio_1']:$producto['precio_1'],
      'precio_2' => (isset($post['precio_2']))?$post['precio_2']:$producto['precio_2'],
      'precio_3' => (isset($post['precio_3']))?$post['precio_3']:$producto['precio_3'],
      'precio_4' => (isset($post['precio_4']))?$post['precio_4']:$producto['precio_4'],
      'precio_5' => (isset($post['precio_5']))?$post['precio_5']:$producto['precio_5'],

  	  'desc_mex' => isset($post['desc_mex']) ? $post['desc_mex']:null,
  	  'desc_peru' => isset($post['desc_peru']) ? $post['desc_peru']:null,
  	  'desc_eur' => isset($post['desc_eur']) ? $post['desc_eur']:null,
  	  'desc_arg' => isset($post['desc_arg']) ? $post['desc_arg']:null,
  	  'desc_rest' => isset($post['desc_rest']) ? $post['desc_rest']:null,

      'estado' => $post['estado'],
      'peso' => $post['peso'],
      'stock' => $post['stock'],
      'regiones' => $regiones,
      'img_port' => ($path) ? $path:$producto['img_port'],
      'img_sec' => ($path_sec) ? $path_sec:$producto['img_sec'],
    ];

    $Producto_model->update($id_prod, $data);

    $this->session->setFlashdata('aviso', 'El producto fue editado exitosamente.');
    return redirect()->to(base_url($post['url']));

  }

	public function get_detalles(){
		if ($this->request->isAJAX()){

		}
	}

    public function mostrar_productos($id_categoria = null){
		$pager = \Config\Services::pager();
		$Categoria_model = model('App\Models\Categoria_model', false);
		$Producto_model = model('App\Models\Producto_model', false);
		$Padecimientos_model = model('App\Models\Padecimientos_model', false);

		$categorias_aux = $Categoria_model->where("categoria_padre",null)->findAll();
		$categorias = array();
		$categorias_drop = array();
		foreach ($categorias_aux as $cat) {
			$cat_hija_aux = $Categoria_model->where("categoria_padre ",$cat['id_categoria'])
			->findAll();
			$cat_hijas = array();
			$categorias_drop[base64_encode($this->encrypter->encrypt($cat['id_categoria']))] = $cat['nombre'];
			if ($cat_hija_aux) {
				foreach ($cat_hija_aux as $cat_h) {
					$categorias_drop[base64_encode($this->encrypter->encrypt($cat_h['id_categoria']))] = $cat_h['nombre'];
					$cat_hijas [] = array(
						'id_categoria' => base64_encode($cat_h['id_categoria']),
						'nombre' => $cat_h['nombre'],
					);
				}
			}

			$categorias[] = array(
				'id_categoria' => base64_encode($cat['id_categoria']),
				'nombre' => $cat['nombre'],
				'cat_hijas' => $cat_hijas
			);
		}

		if ($id_categoria) {
			$id_categoria_aux = base64_decode($id_categoria);
			$producto_aux = $Producto_model->where("idCategoria = $id_categoria_aux")->paginate(9);
		}else {
			$producto_aux = $Producto_model->paginate(9);
		}

		$producto = array();
		if ($producto_aux) {
			foreach ($producto_aux as $obj) {
				$producto[]= array(
				'idProducto' => base64_encode($this->encrypter->encrypt($obj['idProducto'])),
				'categoria' => $Categoria_model->find($obj['idCategoria'])['nombre'],
				'nombre' => $obj['nombre'],
				'img' => $obj['img_port'],
				'precio_1' => $obj['precio_1'],
				'precio_2' => $obj['precio_2'],
				'precio_3' => $obj['precio_3'],
				'precio_4' => $obj['precio_4'],
				'precio_5' => $obj['precio_5'],
				'regiones' => $obj['regiones'],
				'estado' => $obj['estado'],
				'stock' => $obj['stock']
				);
			}
		}

		$padecimiento_aux = $Padecimientos_model->where("estado != 0")->findAll();
		$padecimientos = array();
		if ($padecimiento_aux) {
			foreach ($padecimiento_aux as $obj) {
				$padecimientos[]= array(
					'idPadecimiento' => base64_encode($this->encrypter->encrypt($obj['idPadecimiento'])),
					'nombre' => $obj['nombre_p'],
				);
				$padecimientos_drop[base64_encode($this->encrypter->encrypt($obj['idPadecimiento']))] = $obj['nombre_p'];
			}
		}

		$data = array(
			'categorias' => $categorias,
      'id_categoria' => $id_categoria,
			'categorias_drop' => $categorias_drop,
			'producto' => $producto,
			'padecimientos' => $padecimientos,
			'padecimientos_drop' => $padecimientos_drop,
			'pager' => $Producto_model->pager,
			'session' => $this->session
		);

		echo view('Administrador/mostrar_productos',$data);
	}
}
