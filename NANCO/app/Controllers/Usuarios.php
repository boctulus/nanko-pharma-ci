<?php namespace App\Controllers;
//This
use  App\Libraries\Bcrypt;

class Usuarios extends BaseController
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
			$this->mostrar_usuarios();
		} else {
			$this->session->setFlashdata('error', 'Por favor inicie sesión');
			return redirect()->to('login');
		}
	}

	public function check_correo(){
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
			echo 0;
		}
	}

	public function editar_usuario(){
		$Login_model = model('App\Models\Login_model', false);
		$data = [
			'id_login' => ['label' => 'id', 'rules' => 'required|valid_base64'],
			'nombre' => ['label' => 'Nombre', 'rules' => 'required|alpha_numeric_space'],
			'correo' => ['label' => 'Correo', 'rules' => 'required|valid_email'],
			'tipo' => ['label' => 'Tipo de Usuario', 'rules' => 'required'],
		];
		if (! $this->validate($data)){ //si algo sale mal en el form
			$post = $this->request->getVar(null, FILTER_SANITIZE_STRING);
			if (isset($post['id_login'])) {
				$this->session->setFlashdata('error',['tipo' => 'editar','error' => $this->validator->getErrors()]);
				$id_ent = $this->encrypter->decrypt(base64_decode($post['id_login']));
				$usuario = $Login_model->find($id_ent);
				if ($usuario) {
					$data= array(
						'id_login' => $post['id_login'],
						'nombre' => $usuario['nombre'],
						'correo' => $usuario['correo'],
						'tipo_usuario' => $usuario['tipo_usuario'],
						'session' => $this->session
					);
					$this->mostrar_usuarios();
					return view("Administrador/Modal/editar_usuario",$data);
				}
			} else {
				$id_ent = $this->encrypter->decrypt(base64_decode($post['id_user']));
				$usuario = $Login_model->find($id_ent);
				if ($usuario) {
					$data= array(
						'id_login' => $post['id_user'],
						'nombre' => $usuario['nombre'],
						'correo' => $usuario['correo'],
						'tipo_usuario' => $usuario['tipo_usuario'],
						'session' => $this->session
					);
					return view("Administrador/Modal/editar_usuario",$data);
				}
			}
		}
		$post = $this->request->getVar(null, FILTER_SANITIZE_STRING);
		$id_login = $this->encrypter->decrypt(base64_decode($post['id_login']));

		$Login_model->set('nombre', $post['nombre']);
		$Login_model->set('correo', $post['correo']);
		$Login_model->set('tipo', $post['tipo']);

		$Login_model->where('id_login', $id_login);
		$Login_model->update();

		$this->session->setFlashdata('aviso', 'El usuario fue editado exitosamente.');
		return redirect()->to('mostrar_usuarios');
	}

	public function nuevo_usuario(){
		$data = [
			'nombre' => ['label' => 'Nombre', 'rules' => 'required|alpha_numeric_space'],
			'pass' => ['label' => 'Contraseña', 'rules' => 'required'],
			'correo' => ['label' => 'Correo', 'rules' => 'required|valid_email'],
			'tipo' => ['label' => 'Tipo de usuario', 'rules' => 'required'],
		];
		if (! $this->validate($data)){ //si algo sale mal en el form
			$this->session->setFlashdata('error',['tipo' => 'nuevo','error' => $this->validator->getErrors()]);
			return $this->mostrar_usuarios();
		}

		$Login_model = model('App\Models\Login_model', false);
		$post = $this->request->getVar(null, FILTER_SANITIZE_STRING);

		$opciones = ['cost' => 11,];
		$pass=password_hash(strip_tags($post['pass']), PASSWORD_BCRYPT, $opciones);

		$data = [
			'nombre' => $post['nombre'],
			'correo' => $post['correo'],
			'tipo_usuario' => $post['tipo'],
			'pass' => $pass
		];

		$Login_model->insert($data);
		$this->session->setFlashdata('aviso', 'El usuario fue creado exitosamente.');
		return redirect()->to('mostrar_usuarios');
	}

	public function ver_cliente(){
		if ($this->request->isAJAX()){
			$Login_model = model('App\Models\Login_model', false);
			$post = $this->request->getVar(null, FILTER_SANITIZE_STRING);
			$id_ent = $this->encrypter->decrypt(base64_decode($post['id_user']));
			$Login_model->set('estado', 0);
			$Login_model->where('id_login', $id_ent);
			$Login_model->update();
			echo 1;
		}
	}

	public function eliminar_usuario(){
		if ($this->request->isAJAX()){
			$Login_model = model('App\Models\Login_model', false);
			$post = $this->request->getVar(null, FILTER_SANITIZE_STRING);
			$id_ent = $this->encrypter->decrypt(base64_decode($post['id_user']));
			$Login_model->set('estado', 0);
			$Login_model->where('id_login', $id_ent);
			$Login_model->update();
			echo 1;
		}
	}

	public function reactivar_usuario(){
		if ($this->request->isAJAX()){
			$Login_model = model('App\Models\Login_model', false);
			$post = $this->request->getVar(null, FILTER_SANITIZE_STRING);
			$id_ent = $this->encrypter->decrypt(base64_decode($post['id_user']));
			$Login_model->set('estado', 1);
			$Login_model->where('id_login', $id_ent);
			$Login_model->update();
			echo 1;
		}
	}

		public function mostrar_clientes(){
		$Usuarios_model = model('App\Models\Usuarios_model', false);
		$clientes_aux = $Usuarios_model->findAll();
		$clientes = array();
		if ($clientes_aux) {
			foreach ($clientes_aux as $obj) {
				$pais = "";
				switch ($obj['pais']) {
					case 1:
						$pais = "México";
						break;
					case 2:
						$pais = "Perú";
						break;
					case 3:
						$pais = "Argentina";
						break;
					case 4:
						$pais = "Europa";
						break;
					case 5:
						$pais = "Resto del mundo";
						break;
					default:
						# code...
						break;
				}
				$clientes[]= array(
					'id_usuario' => base64_encode($this->encrypter->encrypt($obj['id_usuario'])),
					'nombre' => $obj['nombre'],
					'pais' => $pais,
					'telefono' => $obj['telefono'],
					'correo' => $obj['correo'],
					'estado' => ($obj['estado'] == 1)?"Activo":"Eliminado",
				);
			}
		}
		$data = array(
			'clientes' => $clientes,
			'session' => $this->session
		);
		echo view('Administrador/mostrar_clientes',$data);
	}

	public function mostrar_usuarios(){
		$Login_model = model('App\Models\Login_model', false);
		$login_aux = $Login_model->where("tipo_usuario = 1 or tipo_usuario = 4")
		->findAll();
		$login = array();
		if ($login_aux) {
			foreach ($login_aux as $obj) {
				$tipo = "";
				switch ($obj['tipo_usuario']) {
					case 1:
						$tipo = "Administrador";
						break;
					case 4:
						$tipo = "Envios";
					break;
					default:
						# code...
						break;
				}
				$login[]= array(
					'id_login' => base64_encode($this->encrypter->encrypt($obj['id_login'])),
					'nombre' => $obj['nombre'],
					'correo' => $obj['correo'],
					'tipo_usuario' => $tipo,
					'estado' => ($obj['estado'] == 1)?"Activo":"Eliminado",
				);
			}
		}
		$data = array(
			'login' => $login,
			'session' => $this->session
		);
		echo view('Administrador/mostrar_usuarios',$data);
	}

	public function salir(){
    helper('cookie');
		$this->session->destroy();
    // setcookie('ci_session','',time()-3600);
    // setcookie('session_l','',time()-3600);
    // setcookie('session_p','',time()-3600);
    // unset($_COOKIE['ci_session']);
    // unset($_COOKIE['session_l']);
    // unset($_COOKIE['session_p']);

    delete_cookie('ci_session', 'localhost', '/'); 

		return redirect()->to('/Clientes');
	}

    public function login(){
        $data = [
            'correo' => 'required|valid_email',
            'pass'  => 'required|alpha_numeric_space',
        ];

		if (! $this->validate($data)){ //si algo sale mal en el form
			$page['session'] = $this->session;
            return view('Auth/login',$page);
		}

		$bcrypt = new Bcrypt();
		$Login_model = model('App\Models\Login_model', false);
		$post = $this->request->getVar(null, FILTER_SANITIZE_STRING);
		$correo = $Login_model->where('correo', $post['correo'])
		->findAll();
		if ($correo) {
			if($bcrypt->check_password($post['pass'], $correo[0]['pass'])){
				$this->session->set('usuario', $correo[0]);
				switch ($correo[0]['tipo_usuario']) {
					case 1: // Administrador
						return redirect()->to('mostrar_usuarios');
					break;
					case 2: //Proveedor
						return redirect()->to('/Clientes');
					break;
					case 3: //Cliente
						return redirect()->to('/Clientes');
					break;
					default:
						# code...
						break;
				}

			}else {
				$this->session->setFlashdata('error', 'El correo o contraseña no es el correcto');
				return redirect()->to('login');
			}
		} else {
			$this->session->setFlashdata('error', 'El correo o contraseña no es el correcto');
			return redirect()->to('login');
		}
	}

}
