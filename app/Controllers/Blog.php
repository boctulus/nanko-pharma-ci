<?php namespace App\Controllers;

class Blog extends BaseController
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
		if ($this->session->get('usuario')['tipo_usuario'] == 1) {
			$this->mostrar_entradas();
		} else {
			$this->session->setFlashdata('error', 'Por favor inicie sesión');
			return redirect()->to('login');
		}
	}

	public function editar_blog(){
		$Blog_model = model('App\Models\Blog_model', false);
		$file = $this->request->getFile('foto');
		if ($file){
			if ($file->isValid()) {
				$data = [
					'id_blog' => ['label' => 'id', 'rules' => 'required|valid_base64'],
					'titulo' => ['label' => 'Nombre', 'rules' => 'required'],
					'descripcion' => ['label' => 'Descripción', 'rules' => 'required'],
					'contenido' => ['label' => 'Contenido', 'rules' => 'required'],
					'foto' => ['label' => 'Foto', 'rules' => 'uploaded[foto]|max_size[foto,5240]|ext_in[foto,jpg,jpeg,png]'],
				];
			}else {
				$data = [
					'id_blog' => ['label' => 'id', 'rules' => 'required|valid_base64'],
					'titulo' => ['label' => 'Nombre', 'rules' => 'required'],
					'descripcion' => ['label' => 'Descripción', 'rules' => 'required'],
					'contenido' => ['label' => 'Contenido', 'rules' => 'required'],
				];
			}
		} else {
			$data = [
				'id_blog' => ['label' => 'id', 'rules' => 'required|valid_base64'],
				'titulo' => ['label' => 'Nombre', 'rules' => 'required'],
				'descripcion' => ['label' => 'Descripción', 'rules' => 'required'],
				'contenido' => ['label' => 'Contenido', 'rules' => 'required'],
			];
		}

		if (! $this->validate($data)){ //si algo sale mal en el form
			$post = $this->request->getVar(null, FILTER_SANITIZE_STRING);
			if (isset($post['id_blog'])) {
				$this->session->setFlashdata('error',['tipo' => 'editar','error' => $this->validator->getErrors()]);
				$id_test = $this->encrypter->decrypt(base64_decode($post['id_blog']));
				$entrada = $Blog_model->find($id_test);
				if ($entrada) {
					$data= array(
						'id_blog' => $post['id_blog'],
						'titulo' => $post['titulo'],
						'img' => $entrada['img_portada'],
						'contenido' => preg_replace("/[\r\n|\n|\r]+/", " ", $this->request->getPost('contenido')),
						'descripcion' => $post['descripcion'],
						'session' => $this->session
					);
					$this->mostrar_entradas();
					return view("Administrador/Modal/editar_entrada",$data);
				}
			} else {
				$id_blg = $this->encrypter->decrypt(base64_decode($post['id_blg']));
				$entrada = $Blog_model->find($id_blg);
				if ($entrada) {
					$data= array(
						'id_blog' => $post['id_blg'],
						'titulo' => $entrada['titulo'],
						'img' => $entrada['img_portada'],
						'contenido' => preg_replace("/[\r\n|\n|\r]+/", " ", $entrada['contenido']),
						'descripcion' => $entrada['descripcion'],
						'session' => $this->session
					);
					return view("Administrador/Modal/editar_entrada",$data);
				}
			}

		}
		$path = null;
		$post = $this->request->getVar(null, FILTER_SANITIZE_STRING);

		$id_blog = $this->encrypter->decrypt(base64_decode($post['id_blog']));
		$entrada = $Blog_model->find($id_blog);
		$file = $this->request->getFile('foto');
		if ($file->isValid()){
			$name = $file->getRandomName();
			$this->request->getFile('foto')->store('../../../public_html/blog_img/'.$id_blog."/",$name);
			$path = "/blog_img/".$id_blog."/".$name;
		}

		$data = [
			'titulo' => $post['titulo'],
			'contenido' => $this->request->getPost('contenido'),
			'descripcion' => $post['descripcion'],
			'img_portada' => ($path) ? $path:$entrada['img_portada']
		];

		$Blog_model->update($id_blog, $data);

		$this->session->setFlashdata('aviso', 'La entrada fue editada exitosamente.');
		return redirect()->to('mostrar_entradas');
	}

	public function eliminar_blog(){
		if ($this->request->isAJAX()){
			$Blog_model = model('App\Models\Blog_model', false);
			$post = $this->request->getVar(null, FILTER_SANITIZE_STRING);
			$id_ent = $this->encrypter->decrypt(base64_decode($post['id_blg']));
			$Blog_model->set('estado', 0);
			$Blog_model->where('id_blog', $id_ent);
			$Blog_model->update();
			echo 1;
		}
	}

	public function reactivar_blog(){
		if ($this->request->isAJAX()){
			$Blog_model = model('App\Models\Blog_model', false);
			$post = $this->request->getVar(null, FILTER_SANITIZE_STRING);
			$id_ent = $this->encrypter->decrypt(base64_decode($post['id_blg']));
			$Blog_model->set('estado', 1);
			$Blog_model->where('id_blog', $id_ent);
			$Blog_model->update();
			echo 1;
		}
	}

	public function nueva_entrada(){
		$data = [
			'titulo' => ['label' => 'Nombre', 'rules' => 'required'],
			'descripcion' => ['label' => 'Descripción', 'rules' => 'required'],
			'contenido' => ['label' => 'Contenido', 'rules' => 'required'],
			'foto' => ['label' => 'Foto', 'rules' => 'uploaded[foto]|max_size[foto,5240]|ext_in[foto,jpg,jpeg,png]'],
		];
		if (! $this->validate($data)){ //si algo sale mal en el form
			$this->session->setFlashdata('error',['tipo' => 'nuevo','error' => $this->validator->getErrors()]);
			return $this->mostrar_entradas();
		}

		$Blog_model = model('App\Models\Blog_model', false);
		$post = $this->request->getVar(null, FILTER_SANITIZE_STRING);

		$data = [
			'titulo' => $post['titulo'],
			'contenido' => $this->request->getPost('contenido'),
			// 'contenido' => htmlentities($this->request->getPost('contenido')),
			'descripcion' => $post['descripcion']
		];

		$Blog_model->insert($data);
		$id_insert = $Blog_model->insertID();

		$path = null;
		$file = $this->request->getFile('foto');

		if ($file->isValid()){
			$name = $file->getRandomName();
			$this->request->getFile('foto')->store('../../../public_html/blog_img/'.$id_insert."/",$name);
			$path = "/blog_img/".$id_insert."/".$name;
		}

		$Blog_model->set('img_portada', $path);
		$Blog_model->where('id_blog', $id_insert);
		$Blog_model->update();

		$this->session->setFlashdata('aviso', 'La entrada fue creada exitosamente.');
		return redirect()->to('mostrar_entradas');
	}

	public function mostrar_entradas(){
		$Blog_model = model('App\Models\Blog_model', false);

		$entradas_aux = $Blog_model->findAll();
		$entradas = array();
		if ($entradas_aux) {
			foreach ($entradas_aux as $obj) {
				$entradas[]= array(
					'id_blog' => base64_encode($this->encrypter->encrypt($obj['id_blog'])),
					'fecha' => strftime("%d de %B %Y",strtotime($obj['fecha'])),
					'estado' => ($obj['estado'] == 1)?"Activa":"Eliminada",
					'titulo' => $obj['titulo']
				);
			}
		}

		$data = array(
			'entradas' => $entradas,
			'session' => $this->session
		);
		echo view('Administrador/mostrar_entradas',$data);
	}
}
