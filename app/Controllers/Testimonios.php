<?php namespace App\Controllers;
//This
use  App\Libraries\Bcrypt;

class Testimonios extends BaseController
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
		$this->mostrar_testimonios();
	}

    public function mostrar_testimonios(){
		$Testimonio_model = model('App\Models\Testimonio_model', false);

		$testimonio_aux = $Testimonio_model->findAll();
		$testimonio = array();
		if ($testimonio_aux) {
			foreach ($testimonio_aux as $obj) {
				$testimonio[]= array(
					'id_testimonio' => base64_encode($this->encrypter->encrypt($obj['id_testimonio'])),
					'nombre' => $obj['nombre'],
					'titulo' => $obj['titulo'],
					'img' => $obj['img'],
					'estado' => ($obj['estado'] == 1)?"Activo":"Eliminado",
				);
			}
		}

		$data = array(
			'testimonio' => $testimonio,
			'session' => $this->session
		);
		echo view('Administrador/mostrar_testimonios',$data);
	}

	public function nuevo_testimonio(){
		$data = [
			'nombre' => ['label' => 'Nombre', 'rules' => 'required'],
			'titulo' => ['label' => 'Título', 'rules' => 'required'],
			'mensaje' => ['label' => 'Mensaje', 'rules' => 'required'],
			'foto' => ['label' => 'Foto', 'rules' => 'uploaded[foto]|max_size[foto,5120]|ext_in[foto,jpg,jpeg,png]'],
		];
		if (! $this->validate($data)){ //si algo sale mal en el form
			$this->session->setFlashdata('error',['tipo' => 'nuevo','error' => $this->validator->getErrors()]);
			return $this->mostrar_testimonios();
		}

		$Testimonio_model = model('App\Models\Testimonio_model', false);
		$path = null;
		$file = $this->request->getFile('foto');

		if ($file->isValid()){
			$name = $file->getRandomName();
			//$this->request->getFile('foto')->store('../../../../public_html/testimonios',$name);
			$this->request->getFile('foto')->store('../../../public_html/testimonios_img',$name);
			$path = "/testimonios_img/".$name;
		}
		$post = $this->request->getVar(null, FILTER_SANITIZE_STRING);
		$data = [
			'nombre' => $post['nombre'],
			'titulo' => $post['titulo'],
			'mensaje' => $post['mensaje'],
			'img' => $path,
		];

		$Testimonio_model->insert($data);
		$this->session->setFlashdata('aviso', 'El testimonio fue creado exitosamente.');
		return redirect()->to('mostrar_testimonios');
	}

	public function eliminar_testimonio(){
		if ($this->request->isAJAX()){
			$Testimonio_model = model('App\Models\Testimonio_model', false);
			$post = $this->request->getVar(null, FILTER_SANITIZE_STRING);
			$id_ent = $this->encrypter->decrypt(base64_decode($post['id_test']));
			$Testimonio_model->set('estado', 0);
			$Testimonio_model->where('id_testimonio', $id_ent);
			$Testimonio_model->update();
			echo 1;
		}
	}

	public function reactivar_testimonio(){
		if ($this->request->isAJAX()){
			$Testimonio_model = model('App\Models\Testimonio_model', false);
			$post = $this->request->getVar(null, FILTER_SANITIZE_STRING);
			$id_ent = $this->encrypter->decrypt(base64_decode($post['id_test']));
			$Testimonio_model->set('estado', 1);
			$Testimonio_model->where('id_testimonio', $id_ent);
			$Testimonio_model->update();
			echo 1;
		}
	}

	public function editar_testimonio(){
		$Testimonio_model = model('App\Models\Testimonio_model', false);
		$file = $this->request->getFile('foto');
		if ($file){
			if ($file->isValid()) {
				$data = [
					'id_testimonio' => ['label' => 'id', 'rules' => 'required|valid_base64'],
					'nombre' => ['label' => 'Nombre', 'rules' => 'required'],
					'titulo' => ['label' => 'Título', 'rules' => 'required'],
					'mensaje' => ['label' => 'Mensaje', 'rules' => 'required'],
					'foto' => ['label' => 'Foto', 'rules' => 'uploaded[foto]|max_size[foto,5120]|ext_in[foto,jpg,jpeg,png]'],
				];
			}else {
				$data = [
					'id_testimonio' => ['label' => 'id', 'rules' => 'required|valid_base64'],
					'nombre' => ['label' => 'Nombre', 'rules' => 'required'],
					'titulo' => ['label' => 'Título', 'rules' => 'required'],
					'mensaje' => ['label' => 'Mensaje', 'rules' => 'required'],
				];
			}
		} else {
			$data = [
				'id_testimonio' => ['label' => 'id', 'rules' => 'required|valid_base64'],
				'nombre' => ['label' => 'Nombre', 'rules' => 'required'],
				'titulo' => ['label' => 'Título', 'rules' => 'required'],
				'mensaje' => ['label' => 'Mensaje', 'rules' => 'required'],
			];
		}

		if (! $this->validate($data)){ //si algo sale mal en el form
			$post = $this->request->getVar(null, FILTER_SANITIZE_STRING);
			if (isset($post['id_testimonio'])) {
				$this->session->setFlashdata('error',['tipo' => 'editar','error' => $this->validator->getErrors()]);
				$id_test = $this->encrypter->decrypt(base64_decode($post['id_testimonio']));
				$entrada = $Testimonio_model->find($id_test);
				if ($entrada) {
					$data= array(
						'id_testimonio' => $post['id_testimonio'],
						'nombre' => $entrada['nombre'],
						'titulo' => $entrada['titulo'],
						'mensaje' => $entrada['mensaje'],
						'img' => $entrada['img'],
						'session' => $this->session
					);
					$this->mostrar_testimonios();
					return view("Administrador/Modal/editar_testimonio",$data);
				}
			} else {
				$id_test = $this->encrypter->decrypt(base64_decode($post['id_test']));
				$entrada = $Testimonio_model->find($id_test);
				if ($entrada) {
					$data= array(
						'id_testimonio' => $post['id_test'],
						'nombre' => $entrada['nombre'],
						'titulo' => $entrada['titulo'],
						'mensaje' => $entrada['mensaje'],
						'img' => $entrada['img'],
						'session' => $this->session
					);
					return view("Administrador/Modal/editar_testimonio",$data);
				}
			}

		}
		$path = null;
		$post = $this->request->getVar(null, FILTER_SANITIZE_STRING);

		$id_test = $this->encrypter->decrypt(base64_decode($post['id_testimonio']));
		$file = $this->request->getFile('foto');
		if ($file->isValid()){
      		$name = $file->getRandomName();
			$this->request->getFile('foto')->store('../../../public_html/testimonios',$name);
			$path = "/testimonios/".$name;
		}

		$Testimonio_model->set('nombre', $post['nombre']);
		$Testimonio_model->set('titulo', $post['titulo']);
		$Testimonio_model->set('mensaje', $post['mensaje']);
		if ($path != null) {
			$Testimonio_model->set('img', $path);
		}

		$Testimonio_model->where('id_testimonio', $id_test);
		$Testimonio_model->update();

		$this->session->setFlashdata('aviso', 'El testimonio fue editado exitosamente.');
		return redirect()->to('mostrar_testimonios');
	}
}
