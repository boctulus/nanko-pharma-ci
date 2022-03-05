<?php namespace App\Controllers;
//This
use  App\Libraries\Bcrypt;
use App\Libraries\Pago;

class Colaboradores extends BaseController{

    private $openpay;
	public function __construct(){
		header('X-Content-Type-Options:nosniff');
		header('X-Frame-Options:SAMEORIGIN');
		header('X-XSS-Protection:1;mode=block');
		helper('url');
		helper('form');
		lang('Test.longTime', [time()], 'es');
	    $this->openpay = new Pago();
	}

	public function index(){
		if ($this->session->get('usuario')) {
			$this->mostrar_Colaboradores();
		} else {
			$this->session->setFlashdata('error', 'Por favor inicie sesión');
			return redirect()->to('login');
		}
	}

  public function check_correopersonal(){
    $post = $this->request->getVar(null, FILTER_SANITIZE_STRING);
    $Login_model = model('App\Models\Login_model', false);
    $Login_model->where("tipo_usuario = 1 or tipo_usuario = 2")
    ->findAll();
    $correo = null;
     if (isset($post['id_user'])) {
      $correo = $Login_model->where("id_login = ".$this->encrypter->decrypt(base64_decode($post['id_user']))."and correo = '".$post['correo']."'")
      ->findAll();
     }else {
      $correo = $Login_model->where("correo = '".$post['correo']."'")
      ->findAll();
     }
    if ($correo) {
      echo 1;
    }else {
      $Colaborador_model = model('App\Models\Colaborador_model', false);
      // $Colaborador_model->where("tipo_usuario = 1 or tipo_usuario = 2")
      // ->findAll();
        $correo = null;
        $correo = $Login_model->where("correo_p = '".$post['correo']."'")
        ->findAll();
        if ($correo) {
          echo 2;
        }else {
          echo 0;}
    }
  }

	public function editar_colaboradores(){
		$Colaboradores_model = model('App\Models\Colaboradores_model', false);
		$data = [
			'id_colaborador' => ['label' => 'id', 'rules' => 'required|valid_base64'],
			'nombre' => ['label' => 'Nombre', 'rules' => 'required'],
      'apellidos' => ['label' => 'Apellidos', 'rules' => 'required'],
			'direccion' => ['label' => 'Direccion', 'rules' => 'required'],
			'correo_n' => ['label' => 'Correo Nanko', 'rules' => 'required|valid_email'],
			'correo_p' => ['label' => 'Correo Personal', 'rules' => 'required|valid_email'],
			'cp' => ['label' => 'Codigo postal', 'rules' => 'required'],
			'descuento' => ['label' => 'Descuento', 'rules' => 'required'],
			'telefono' => ['label' => 'Telefono', 'rules' => 'required'],
			'pais' => ['label' => 'País', 'rules' => 'required'],
			'estado_p' => ['label' => 'País', 'rules' => 'required']
		];
		if (! $this->validate($data)){ //si algo sale mal en el form
			$post = $this->request->getVar(null, FILTER_SANITIZE_STRING);
			if (isset($post['id_colaborador'])) {
				$this->session->setFlashdata('error',['tipo' => 'editar','error' => $this->validator->getErrors()]);
				$id_ent = $this->encrypter->decrypt(base64_decode($post['id_colaborador']));
				$Colaborador = $Colaboradores_model->find($id_ent);
				if ($Colaborador) {
					$data= array(
						'id_colaborador' => $post['id_colaborador'],
						'nombre' => $Colaborador['nombre'],
           				'apellidos' => $Colaborador['apellidos'],
						'direccion' => $Colaborador['direccion'],
						'correo_n' => $Colaborador['correo_n'],
						'correo_p' => $Colaborador['correo_p'],
						'cp' => $Colaborador['cp'],
						'descuento' => $Colaborador['descuento'],
						'telefono' => $Colaborador['telefono'],
						'pais' => $Colaborador['pais'],
						'estado_p' => $Colaborador['estado_p'],
						'session' => $this->session
					);

					$this->mostrar_Colaboradores();
					return view("Administrador/Modal/editar_colaborador",$data);
				}
			} else {
				$id_ent = $this->encrypter->decrypt(base64_decode($post['id_colab']));
				$Colaborador = $Colaboradores_model->find($id_ent);
				if ($Colaborador) {
					$data= array(
            'id_colaborador' => $post['id_colab'],
						'nombre' => $Colaborador['nombre'],
            'apellidos' => $Colaborador['apellidos'],
						'direccion' => $Colaborador['direccion'],
						'correo_n' => $Colaborador['correo_n'],
            'correo_p' => $Colaborador['correo_p'],
            'cp' => $Colaborador['cp'],
            'descuento' => $Colaborador['descuento'],
            'telefono' => $Colaborador['telefono'],
						'estado_p' => $Colaborador['estado_p'],
						'pais' => $Colaborador['pais'],
						'session' => $this->session
					);
					return view("Administrador/Modal/editar_colaborador",$data);
				}
			}
		}
		$post = $this->request->getVar(null, FILTER_SANITIZE_STRING);
		$id_colaborador = $this->encrypter->decrypt(base64_decode($post['id_colaborador']));

		$Colaboradores_model->set('nombre', $post['nombre']);
    	$Colaboradores_model->set('apellidos', $post['apellidos']);
		$Colaboradores_model->set('direccion', $post['direccion']);
		$Colaboradores_model->set('correo_n', $post['correo_n']);
		$Colaboradores_model->set('correo_p', $post['correo_p']);
		$Colaboradores_model->set('cp', $post['cp']);
		$Colaboradores_model->set('descuento', $post['descuento']);
		$Colaboradores_model->set('telefono', $post['telefono']);
		$Colaboradores_model->set('pais', $post['pais']);
		$Colaboradores_model->where('id_colaborador', $id_colaborador);
		$Colaboradores_model->update();
		$this->session->setFlashdata('aviso', 'El colaborador fue editado exitosamente.');
		return redirect()->to('mostrar_Colaboradores');
	}

	public function nuevo_colaborador(){
		$data = [
			'nombre' => ['label' => 'Nombre', 'rules' => 'required'],
      		'apellidos' => ['label' => 'Apellidos', 'rules' => 'required'],
			'direccion' => ['label' => 'Direccion', 'rules' => 'required'],
			'correo_n' => ['label' => 'Correo Nanko', 'rules' => 'required|valid_email'],
			'correo_p' => ['label' => 'Correo Personal', 'rules' => 'required|valid_email'],
			'cp' => ['label' => 'Codigo postal', 'rules' => 'required'],
			'descuento' => ['label' => 'Descuento', 'rules' => 'required'],
			'telefono' => ['label' => 'Telefono', 'rules' => 'required'],
			'pass' => ['label' => 'Contraseña', 'rules' => 'required'],
			'pais' => ['label' => 'País', 'rules' => 'required'],
			'estado_p' => ['label' => 'Estado', 'rules' => 'required'],
		];

		if (! $this->validate($data)){ //si algo sale mal en el form
			$this->session->setFlashdata('error',['tipo' => 'nuevo','error' => $this->validator->getErrors()]);
			return $this->mostrar_Colaboradores();
		}
		$Login_model = model('App\Models\Login_model', false);
		$Colaboradores_model = model('App\Models\Colaboradores_model', false);

		$post = $this->request->getVar(null, FILTER_SANITIZE_STRING);

		$data2 = array (
			'nombre' => $post['nombre'],
      		'apellidos' => $post['apellidos'],
			'direccion' => $post['direccion'],
			'correo_n' => $post['correo_n'],
			'correo_p' => $post['correo_p'],
			'cp' => $post['cp'],
			'descuento' => $post['descuento'],
			'telefono' => $post['telefono'],
			'estado' => 1,
			'estado_p' => $post['estado_p'],
			'pais' => $post['pais']
			// 'pass' => $pass
		);
		$Colaboradores_model->insert($data2);

		$opciones = ['cost' => 11,];
		$pass=password_hash(strip_tags($post['pass']), PASSWORD_BCRYPT, $opciones);

		$data = [
			'nombre' => $post['nombre'],
      		'apellidos' => $post['apellidos'],
			'correo' => $post['correo_n'],
			'telefono' => $post['telefono'],
			'fk_usuario' => $Colaboradores_model->getInsertID(),
			'tipo_usuario' => 2,
			'pass' => $pass,
			'pais' => $post['pais'],
			'estado' => 1
		];

		$Login_model->insert($data);
		
		$client_openpay = array(
			'client_name' => $post['nombre'],
			'cliente_email' => $post['correo_n'],
			'apellido' => $post['apellidos'],
			'telefono' => $post['telefono'],
		);
		$user_id = $Login_model->getInsertID();
		$id_client = $this->openpay->add_client($client_openpay);
    
		$Login_model->set('openpay', $id_client->id);
		$Login_model->where('id_login', $user_id);
		$Login_model->update();

		$this->session->setFlashdata('aviso', 'El colaborador fue creado exitosamente.');
		return redirect()->to('mostrar_Colaboradores');
	}

	public function eliminar_colaborador(){
		if ($this->request->isAJAX()){
			$Colaboradores_model = model('App\Models\Colaboradores_model', false);
			$post = $this->request->getVar(null, FILTER_SANITIZE_STRING);
			$id_ent = $this->encrypter->decrypt(base64_decode($post['id_colab']));
			$Colaboradores_model->set('estado', 0);
			$Colaboradores_model->where('id_colaborador', $id_ent);
			$Colaboradores_model->update();
			echo 1;
		}
	}

	public function reactivar_colaborador(){
		if ($this->request->isAJAX()){
			$Colaboradores_model = model('App\Models\Colaboradores_model', false);
			$post = $this->request->getVar(null, FILTER_SANITIZE_STRING);
			$id_ent = $this->encrypter->decrypt(base64_decode($post['id_colab']));
			$Colaboradores_model->set('estado', 1);
			$Colaboradores_model->where('id_colaborador', $id_ent);
			$Colaboradores_model->update();
			echo 1;
		}
	}

	public function get_estados()
	{
		$Colaboradores_model = model('App\Models\Colaboradores_model', false);
		$post = $this->request->getVar(null, FILTER_SANITIZE_STRING);

		$estados_aux = $Colaboradores_model->where('pais = '.$post['pais'].' group by estado_p')->findAll();
		$estados = array();

		foreach ($estados_aux as $obj) {
			$estados[$obj['estado_p']] = $obj['estado_p'];
		}
		echo json_encode($estados);
	}

	public function mostrar_Colaboradores(){
		$Colaboradores_model = model('App\Models\Colaboradores_model', false);
		$login_aux = $Colaboradores_model->findAll();
		$login = array();
		if ($login_aux) {
			foreach ($login_aux as $obj) {
				$pais = "";
				switch ($obj['pais']) {
					case 1:
						$pais = "México";
						break;
					case 2:
						$pais = "Perú";
						break;
					case 3:
						$pais = "Europa";
						break;
					case 4:
						$pais = "Argentina";
						break;
					case 5:
						$pais = "Resto del mundo";
						break;
					default:
						$pais = "";
						break;
				}
				$login[]= array(
					'id_colaborador' => base64_encode($this->encrypter->encrypt($obj['id_colaborador'])),
					'nombre' => $obj['nombre'],
          'apellidos' => $obj['apellidos'],
					'correo_n' => $obj['correo_n'],
					'correo_p' => $obj['correo_p'],
					'descuento' => $obj['descuento'],
					'telefono' => $obj['telefono'],
					'pais' => $pais,
					'estado' => ($obj['estado'] == 1)?"Activo":"Desactivado",
				);
			}
		}
		$data = array(
			'colaboradores' => $login,
			'session' => $this->session,
		);
		echo view('Administrador/mostrar_colaboradores',$data);
	}
}
