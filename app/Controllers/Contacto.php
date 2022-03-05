<?php namespace App\Controllers;
//This
use  App\Libraries\Bcrypt;

class Contacto extends BaseController
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
			$this->mostrar_contacto();
		} else {
			$this->session->setFlashdata('error', 'Por favor inicie sesión');
			return redirect()->to('login');
		}
	}

  public function detalles_contacto(){
  		$Contacto_model = model('App\Models\Contacto_model', false);
          $post = $this->request->getVar(null, FILTER_SANITIZE_STRING);

          $id_cont = $this->encrypter->decrypt(base64_decode($post['id_cnt']));
          $contacto = $Contacto_model->find($id_cont);

          if ($contacto) {
              $data= array(
                  //'id_contacto' => $post['id_pad'],
  				'nombre' => $contacto['nombre'],
  				'fecha' => strftime("%d de %B %Y %H:%M",strtotime($contacto['fecha'])),
                  'correo' => $contacto['correo'],
                  'mensaje' => $contacto['mensaje'],
                  'dep_med' => $contacto['dep_med'],
                  'telefono' => $contacto['telefono'],
                  'session' => $this->session
              );
              return view("Administrador/Modal/ver_contacto",$data);
          }
  	}

    public function mostrar_contacto(){
		$Contacto_model = model('App\Models\Contacto_model', false);

		$contacto_aux = $Contacto_model->findAll();
		$contacto = array();
		if ($contacto_aux) {
			foreach ($contacto_aux as $obj) {
				$contacto[]= array(
					'id_contacto' => base64_encode($this->encrypter->encrypt($obj['id_contacto'])),
					'fecha' => strftime("%d de %B %Y",strtotime($obj['fecha'])),
					'nombre' => $obj['nombre'],
					'correo' => $obj['correo'],
					'dep_med' => $obj['dep_med'],
					'estado' => ($obj['estado'] == 1)?"Recibida":"Respondida",
				);
			}
		}

		$data = array(
			'contacto' => $contacto,
			'session' => $this->session
		);
		echo view('Administrador/mostrar_contacto',$data);
	}

	public function marcar_leida(){
		if ($this->request->isAJAX()){
			$Contacto_model = model('App\Models\Contacto_model', false);
			$post = $this->request->getVar(null, FILTER_SANITIZE_STRING);
			$id_ent = $this->encrypter->decrypt(base64_decode($post['id_cnt']));
			$Contacto_model->set('estado', 0);
			$Contacto_model->where('id_contacto', $id_ent);
			$Contacto_model->update();
			echo 1;
		}
	}
}
