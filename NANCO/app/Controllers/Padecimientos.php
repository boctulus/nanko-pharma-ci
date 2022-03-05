<?php namespace App\Controllers;
//This
use  App\Libraries\Bcrypt;

class Padecimientos extends BaseController
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
			$this->mostrar_padecimientos();
		} else {
			$this->session->setFlashdata('error', 'Por favor inicie sesión');
			return redirect()->to('login');
		}
	}

	public function editar_padecimiento(){
		$Producto_model = model('App\Models\Producto_model', false);
		$Padecimientos_model = model('App\Models\Padecimientos_model', false);
		$data = [
			'id_padecimiento' => ['label' => 'id', 'rules' => 'required|valid_base64'],
			'nombre' => ['label' => 'Nombre', 'rules' => 'required'],
			'descripcion' => ['label' => 'Descripción', 'rules' => 'required'],
		];
		if (! $this->validate($data)){ //si algo sale mal en el form
			$post = $this->request->getVar(null, FILTER_SANITIZE_STRING);
			if (isset($post['id_padecimiento'])) {
				$this->session->setFlashdata('error',['tipo' => 'editar','error' => $this->validator->getErrors()]);
				$id_ent = $this->encrypter->decrypt(base64_decode($post['id_padecimiento']));
				$padecimiento = $Padecimientos_model->find($id_ent);
				
				if ($padecimiento) {
					$productos_aux = $Producto_model->where("estado = 1")
					->findAll();
					$productos = array(''=>'Sin Producto');
					if ($productos_aux) {
						foreach ($productos_aux as $obj) {
							if ($padecimiento['id_producto'] == $obj['idProducto']) {
								$padecimiento['id_producto'] = base64_encode($this->encrypter->encrypt($obj['idProducto']));
								$productos[$padecimiento['id_producto']] = $obj['nombre'];
							}else {
								$productos[base64_encode($this->encrypter->encrypt($obj['idProducto']))] = $obj['nombre'];
							}
						}
					}
					$data= array(
						'id_padecimiento' => $post['id_padecimiento'],
						'nombre' => $padecimiento['nombre_p'],
						'descripcion' => $padecimiento['descripcion'],
						'producto' => $padecimiento['id_producto'],
						'productos' =>$productos,
						'session' => $this->session
					);
					$this->mostrar_padecimientos();
					return view("Administrador/Modal/editar_padecimiento",$data);
				}
			} else {
				$id_ent = $this->encrypter->decrypt(base64_decode($post['id_pad']));
				$padecimiento = $Padecimientos_model->find($id_ent);

				if ($padecimiento) {
					//para el dropdown
					$productos_aux = $Producto_model->where("estado = 1")
					->findAll();
					$productos = array(''=>'Sin Producto');
					if ($productos_aux) {
						foreach ($productos_aux as $obj) {
							if ($padecimiento['id_producto'] == $obj['idProducto']) {
								$padecimiento['id_producto'] = base64_encode($this->encrypter->encrypt($obj['idProducto']));
								$productos[$padecimiento['id_producto']] = $obj['nombre'];
							}else {
								$productos[base64_encode($this->encrypter->encrypt($obj['idProducto']))] = $obj['nombre'];
							}
						}
					}
					$data= array(
						'id_padecimiento' => $post['id_pad'],
						'nombre' => $padecimiento['nombre_p'],
						'descripcion' => $padecimiento['descripcion'],
						'producto' => $padecimiento['id_producto'],
						'productos' =>$productos,
						'session' => $this->session
					);
					return view("Administrador/Modal/editar_padecimiento",$data);
				}
			}
		}
		$post = $this->request->getVar(null, FILTER_SANITIZE_STRING);
		$id_padecimiento = $this->encrypter->decrypt(base64_decode($post['id_padecimiento']));
		
		$Padecimientos_model->set('nombre_p', $post['nombre']);
		$Padecimientos_model->set('descripcion', $post['descripcion']);
		if ($post['producto']) {
			$Padecimientos_model->set('id_producto',$this->encrypter->decrypt(base64_decode($post['producto'])) );
		}
		$Padecimientos_model->where('idPadecimiento', $id_padecimiento);
		$Padecimientos_model->update();

		$this->session->setFlashdata('aviso', 'El padecimiento fue editado exitosamente.');
		return redirect()->to('mostrar_padecimientos');
	}

    public function mostrar_padecimientos(){
		$Producto_model = model('App\Models\Producto_model', false);
		$Padecimientos_model = model('App\Models\Padecimientos_model', false);
		$padecimientos_aux = $Padecimientos_model->findAll();
		$padecimientos = array();
		if ($padecimientos_aux) {
			foreach ($padecimientos_aux as $obj) {
				$padecimientos[]= array(
					'idPadecimiento' => base64_encode($this->encrypter->encrypt($obj['idPadecimiento'])),
					'nombre_p' => $obj['nombre_p'],
					'estado' => ($obj['estado'] == 1)?"Activo":"Eliminado",
				);
			}
		}

		//para el dropdown
		$productos_aux = $Producto_model->where("estado = 1")
		->findAll();
		$productos = array(''=>'Sin Producto');
		if ($productos_aux) {
		  foreach ($productos_aux as $obj) {
			$productos[base64_encode($this->encrypter->encrypt($obj['idProducto']))] = $obj['nombre'];
		  }
		}

		$data = array(
			'padecimientos' => $padecimientos,
			'productos' => $productos,
			'session' => $this->session
		);
		echo view('Administrador/mostrar_padecimientos',$data);
	}

	public function nuevo_padecimiento(){
		$data = [
			'nombre' => ['label' => 'Nombre', 'rules' => 'required'],
			'descripcion' => ['label' => 'Descripción', 'rules' => 'required'],
			'producto' => ['label' => 'Producto', 'rules' => 'valid_base64'],
		];
		if (! $this->validate($data)){ //si algo sale mal en el form
			$this->session->setFlashdata('error',['tipo' => 'nuevo','error' => $this->validator->getErrors()]);
			return $this->mostrar_padecimientos();
		}
		
		$Padecimientos_model = model('App\Models\Padecimientos_model', false);
		$post = $this->request->getVar(null, FILTER_SANITIZE_STRING);

		$data = [
			'nombre_p' => $post['nombre'],
			'descripcion' => $post['descripcion'],
			'id_producto' => ($post['producto'])?$this->encrypter->decrypt(base64_decode($post['producto'])):null,
		];
		
		$Padecimientos_model->insert($data);
		$this->session->setFlashdata('aviso', 'El padecimiento fue creado exitosamente.');
		return redirect()->to('mostrar_padecimientos');
	}

	public function eliminar_padecimiento(){
		if ($this->request->isAJAX()){
			$Padecimientos_model = model('App\Models\Padecimientos_model', false);
			$post = $this->request->getVar(null, FILTER_SANITIZE_STRING);
			$id_ent = $this->encrypter->decrypt(base64_decode($post['id_pad']));
			$Padecimientos_model->set('estado', 0);
			$Padecimientos_model->where('idPadecimiento', $id_ent);
			$Padecimientos_model->update();
			echo 1;
		}
	}

	public function reactivar_padecimiento(){
		if ($this->request->isAJAX()){
			$Padecimientos_model = model('App\Models\Padecimientos_model', false);
			$post = $this->request->getVar(null, FILTER_SANITIZE_STRING);
			$id_ent = $this->encrypter->decrypt(base64_decode($post['id_pad']));
			$Padecimientos_model->set('estado', 1);
			$Padecimientos_model->where('idPadecimiento', $id_ent);
			$Padecimientos_model->update();
			echo 1;
		}
	}

}