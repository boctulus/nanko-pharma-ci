<?php

namespace App\Controllers;

use App\Libraries\Bcrypt;
//use App\Libraries\OpenPay;
use App\Libraries\Pago;


class Clientes extends BaseController
{
	private $openpay;
	public function __construct()
	{
		header('X-Content-Type-Options:nosniff');
		header('X-Frame-Options:SAMEORIGIN');
		header('X-XSS-Protection:1;mode=block');
		helper('url');
		helper('form');
		lang('Test.longTime', [time()], 'es');
		$this->openpay = new Pago();
	}

	public function index()
	{
		if (isset($_COOKIE['session_l']) && isset($_COOKIE['session_p'])) {
			$Login_model = model('App\Models\Login_model', false);
			// $post = $this->request->getVar(null, FILTER_SANITIZE_STRING);
			$idlogin = $Login_model->where('id_login', $_COOKIE['session_l'])
				->findAll();
					if ($idlogin){
						$this->session->set('usuario', $idlogin);
					}
		}
		if ($this->session->get('region')) {
			$this->mostrar_inicio();
		}else{
			$this->Paises();
		}
	}

	public function contacto()
	{
		if ($this->session->get('region')) {
			echo view('Cliente/Contacto');
		} else {
			$this->session->setFlashdata('aviso', 'Por favor seleccione su región o Pais/ Please select your Country or Region');
			return redirect()->to('/Clientes/paises');
		}
	}

	public function crear_contacto()
	{
		if ($this->session->get('region')) {
			$data = [
				'nombre' => ['label' => 'Nombre', 'rules' => 'required'],
				'correo' => ['label' => 'Correo', 'rules' => 'required'],
				'asunto' => ['label' => 'Asunto', 'rules' => 'required'],
				'mensaje' => ['label' => 'Mensaje', 'rules' => 'required'],
				'telefono' => ['label' => 'Teléfono', 'rules' => 'permit_empty'],
				'eq_med' => ['label' => 'Equipo Médico', 'rules' => 'permit_empty']
			];

			if (!$this->validate($data)) { //si algo sale mal en el form
				$this->session->setFlashdata('error', ['tipo' => 'nuevo', 'error' => $this->validator->listErrors()]);
				return $this->finalize_purchase();
			}
			$Contacto_model = model('App\Models\Contacto_model', false);
			$post = $this->request->getVar(null, FILTER_SANITIZE_STRING);
			$data = [
				'nombre' => strip_tags($post['nombre']),
				'correo' => strip_tags($post['correo']),
				'asunto' => strip_tags($post['asunto']),
				'mensaje' => strip_tags($post['mensaje']),
				'dep_med' => (isset($post['eq_med']))?strip_tags($post['eq_med']):null,
				'telefono' => (isset($post['telefono']))?strip_tags($post['telefono']):null
			];
			$Contacto_model->insert($data);

			$email = \Config\Services::email();

			$email->setFrom('not_reply@nanko.com.mx', 'Nanko');
			// $email->setTo("vvr11997@gmail.com");
			$email->setTo("contacto123@nanko.com.mx");
			$email->setSubject('Solicitud de contacto');
			$encabezado = "Solicitud de contacto<br>";
			$cuerpo = "Una nueva solicitud de contacto ha sido levantada, los datos son:<br>";
			$cuerpo .= "Nombre: ".strip_tags($post['nombre'])."<br>";
			$cuerpo .= "Correo: ".strip_tags($post['correo'])."<br>";
			$cuerpo .= "Asunto: ".strip_tags($post['asunto'])."<br>";
			$cuerpo .= "Mensaje: ".strip_tags($post['mensaje'])."<br>";
			if (isset($post['telefono'])) {
				$cuerpo .= "Teléfono: ".strip_tags($post['telefono'])."<br>";
			}

			$email->setMessage($encabezado.$cuerpo);
			if(!$email->send()){
				$Config_model = model('App\Models\Config_model', false);
				$array = array(
					'nombre' => "Error Contacto",
					'descr' => $email->printDebugger()
				);
				$Config_model->insert($array);
			}


			if (isset($post['eq_med'])) {
				//envio de correo
				//Establecemos esta configuración
				$email->setFrom('not_reply@nanko.com.mx', 'Nanko');
				$email->setTo("depmed@nanko.com.mx");
				$email->setSubject('Solicitud de contacto');
				$encabezado = "Departamento M&eacute;dico<br>";

				$email->setMessage($encabezado.$cuerpo);
				if(!$email->send()){
					$Config_model = model('App\Models\Config_model', false);
					$array = array(
						'nombre' => "Error Departamento",
						'descr' => $email->printDebugger()
					);
					$Config_model->insert($array);
				}
			}
			if(session('region') < 3 || session('region') == 4){
				$this->session->setFlashdata('aviso', 'Solicitud de contacto enviada.');
			}
			else{
				$this->session->setFlashdata('aviso', 'Contact request sent.');
			}
			return redirect()->to('/Clientes/contacto');
		} else {
			$this->session->setFlashdata('aviso', 'Por favor seleccione su región o Pais/ Please select your Country or Region');
			return redirect()->to('/Clientes/paises');
		}
	}

	public function direcciones() {
		if ($this->session->get('usuario')) {
			$Direccion_model = model('App\Models\Direccion_model', false);
			$direccion_aux = $Direccion_model->Where("id_usuario = ".$this->session->get('usuario')['id_login']." AND estatus = 1")->findAll();
			$direccion = array();
			if ($direccion_aux) {
				foreach ($direccion_aux as $obj) {
					$direccion[] = array(
						'id_direccion' => base64_encode($obj['id_direccion']),
						'nombre' => $obj['nombre'],
						'calle' => $obj['calle'],
						'cp' => $obj['cp'],
						'estado' => $obj['estado'],
						'colonia' => $obj['colonia'],
						'tel' => $obj['tel'],
						'ciudad' => $obj['ciudad'],
						'instrucciones' => $obj['instrucciones'],
						'pais' => $obj['pais']
					);
				}
			}
			$data = array(
				'direcciones' => $direccion,
				'bandera_origen' => 'cuenta'
			);
			echo view('Cliente/Purchase',$data);
		}else{
			$this->session->setFlashdata('error', ['tipo' => 'sesion', 'error' => "Inicie sesión por favor."]);
			return redirect()->to('/Clientes');
		}
	}

	public function finalize_purchase(){
		if ($this->session->get('usuario')) {
			if ($this->session->get('cart')) {
				$Direccion_model = model('App\Models\Direccion_model', false);
				$direccion_aux = $Direccion_model->Where("id_usuario = ".$this->session->get('usuario')['id_login']." AND estatus = 1")->findAll();
				$direccion = array();
				if ($direccion_aux) {
					foreach ($direccion_aux as $obj) {
						$direccion[] = array(
							'id_direccion' => base64_encode($obj['id_direccion']),
							'nombre' => $obj['nombre'],
							'calle' => $obj['calle'],
							'cp' => $obj['cp'],
							'estado' => $obj['estado'],
							'colonia' => $obj['colonia'],
							'tel' => $obj['tel'],
							'ciudad' => $obj['ciudad'],
							'pais' => $obj['pais'],
							'instrucciones' => $obj['instrucciones']
						);
					}
				}
				$data = array(
					'direcciones' => $direccion,
					'bandera_origen' => 'compra'
				);
				echo view('Cliente/Purchase',$data);
			}else{
				$this->session->setFlashdata('error', ['tipo' => 'error', 'error' => "No tiene productos en su carrito" ]);
				return redirect()->to('/Clientes/tienda');
			}
		}else{
			$this->session->setFlashdata('error', ['tipo' => 'sesion', 'error' => "Inicie sesión por favor."]);
			return redirect()->to('/Clientes');
		}
	}

	public function orden($id_orden = null){
		if ($this->session->get('usuario')) {
			if ($id_orden == null) {
				$this->session->setFlashdata('aviso', 'La orden no es válida.');
				return redirect()->to('mostrar_inicio');
			}
			$Orden_Prod_model = model('App\Models\Orden_Prod_model', false);
			$Orden_model = model('App\Models\Orden_model', false);
			$Producto_model = model('App\Models\Producto_model', false);

			$orden_aux = $Orden_model->find(base64_decode($id_orden));
			$orden = array();
			if($orden_aux){
				$productos_aux = $Orden_Prod_model->Where('id_orden',base64_decode($id_orden))->findAll();
				$productos = array();
				if ($productos_aux) {
					foreach ($productos_aux as $obj) {
						$producto = $Producto_model->find($obj['id_producto']);
						$productos[] = array(
							'cantidad' => $obj['cantidad'],
							'producto' => $producto['nombre'],
							'precio' => "$".$obj['cantidad']*$producto['precio_1']
						);
					}
				}
				$orden = array(
					'id_orden' => $id_orden,
					'productos' => $productos
				);

				$data = array(
					'orden' => $orden
				);
				echo view('Cliente/Orden',$data);
			}else{
				$this->session->setFlashdata('aviso', 'La orden no es válida.');
				return redirect()->to('mostrar_inicio');
			}
		}else{
			$this->session->setFlashdata('error', ['tipo' => 'sesion', 'error' => "Inicie sesión por favor."]);
			return redirect()->to('/Clientes');
		}
	}

	public function ordenes(){
		if ($this->session->get('usuario')) {
			$pager = \Config\Services::pager();
			$Orden_model = model('App\Models\Orden_model', false);

			$ordenes_aux = $Orden_model->where('id_usuario',$this->session->get('usuario')['id_login'])->orderBy("fecha",'DESC')->paginate(10);
			$ordenes = array();
			foreach ($ordenes_aux as $obj) {
				$estado = "";
				switch ($obj['estado']) {
					case 0:
						$estado = "Cancelada";
						break;
					case 1: // Pedida
						$estado = "Pedida";
						break;
					case 2: // Confirmada
						$estado = "Confirmada";
						break;
					case 3: // Enviada
						$estado = "Enviada";
						break;
					case 4: // Finalizada
						$estado = "Finalizada";
						break;
					default:
						break;
				}

				$ordenes[] = array(
					'id_orden' => base64_encode($this->encrypter->encrypt($obj['id_orden'])),
					'fecha' => strftime("%d/%B/%Y", strtotime($obj['fecha'])),
					'precio' => '$'.$obj['precio_total'],
					'estado_openpay' => ($obj['id_pago'])? $this->openpay->get_pago($this->session->get('usuario')['openpay'],$obj['id_pago'])->status:"",
					'estado' => $estado
				);
			}
			$data = array(
				'ordenes' => $ordenes,
				'pager' => $Orden_model->pager
			);

			echo view('Cliente/Ordenes', $data);
		}else{
			$this->session->setFlashdata('error', ['tipo' => 'sesion', 'error' => "Inicie sesión por favor."]);
			return redirect()->to('/Clientes');
		}
	}

	public function ver_productos()
    {
			if ($this->session->get('usuario')) {
				$Orden_model = model('App\Models\Orden_model', false);
				$Orden_Prod_model = model('App\Models\Orden_Prod_model', false);
				$Producto_model = model('App\Models\Producto_model', false);
				$Login_model = model('App\Models\Login_model', false);
				$Direccion_model = model('App\Models\Direccion_model', false);

				$post = $this->request->getVar(null, FILTER_SANITIZE_STRING);
				$id_orden = $this->encrypter->decrypt(base64_decode($post['id_orden']));
				$orden = $Orden_model->find($id_orden);
				$cliente_aux = $Login_model->find($orden['id_usuario']);
				$cliente = array(
					'nombre' => $cliente_aux['nombre']." ".$cliente_aux['apellidos'],
				);
				$productos_aux = $Orden_Prod_model->Where('id_orden',$orden['id_orden'])->findAll();
				$productos = array();
				if ($productos_aux) {
					foreach ($productos_aux as $obj) {
						$producto = $Producto_model->find($obj['id_producto']);
						$productos[] = array(
							'nombre' => $producto['nombre'],
							'cantidad' => $obj['cantidad']
						);
					}
				}
				$data = array(
					'productos' => $productos,
					'cliente' => $cliente,
					'orden' => $orden,
					'direccion' => $Direccion_model->find($orden['id_direccion'])
				);
				echo view('Cliente/Modales/ver_productos',$data);
			}else{
				$this->session->setFlashdata('error', ['tipo' => 'sesion', 'error' => "Inicie sesión por favor."]);
				return redirect()->to('/Clientes');
			}

    }

	public function mostrar_inicio()
	{
		if ($this->session->get('region')) {
			$Testimonio_model = model('App\Models\Testimonio_model', false);
			$Padecimientos_model = model('App\Models\Padecimientos_model', false);
			$Producto_model = model('App\Models\Producto_model', false);

			$testimonios_aux = $Testimonio_model->where("estado = 1")
				->findAll();
			$testimonios = array();
			if ($testimonios_aux) {
				foreach ($testimonios_aux as $obj) {
					$testimonios[] = array(
						'nombre' => $obj['nombre'],
						'titulo' => $obj['titulo'],
						'mensaje' => $obj['mensaje'],
						'img' => $obj['img']
					);
				}
			}

			$padecimientos_aux = $Padecimientos_model->where("estado = 1")
				->findAll();
			$padecimientos = array();
			if ($padecimientos_aux) {
				foreach ($padecimientos_aux as $obj) {
					$padecimientos[] = array(
						'nombre' => $obj['nombre_p'],
						'descripcion' => $obj['descripcion'],
						'producto' => $Producto_model->find($obj['id_producto'])['nombre'],
					);
				}
			}
			$productos_aux = $Producto_model->where("estado = 1 AND regiones LIKE '%".$this->session->get('region')."%'")->orderBy("RAND()")
				->findAll(3);
			$productos = array();
			if ($productos_aux) {
				$i = 0;
				foreach ($productos_aux as $obj) {
					$padecimientos_prod_aux = $Padecimientos_model->where("id_producto = ".$obj['idProducto'])->findAll();
					$padecimientos_prod = array();
					foreach ($padecimientos_prod_aux as $pad) {
						$padecimientos_prod[] = array(
							'nombre' => $pad['nombre_p']
						);
					}
					$productos[] = array(
						'id_producto' => base64_encode($obj['idProducto']),
						'nombre' => $obj['nombre'],
						'descripcion' => $obj['descripcion'],
						'descripcion_ingles' => $obj['descripcion_ingles'],
						'img' => $obj['img_port'],
						'disp' => ($obj['stock'] > 0)?1:0,
						'padecimientos' => $padecimientos_prod
					);

					switch ($this->session->get('region')) {
						case 1: //Mexico
							$productos[$i]['precio'] = "$".$obj['precio_1'];
							$productos[$i++]['nombre'] = $obj['nombre'];
							break;
						case 2: //Peru
							$productos[$i]['precio'] = "S/".$obj['precio_2'];
							$productos[$i++]['nombre'] = $obj['nombre'];
							break;
						case 3: //Europa
							$productos[$i]['precio'] = $obj['precio_3']."&#x20AC;";
							$productos[$i++]['nombre'] = $obj['nombre_ing'];
							break;
						case 4: //Argentina
							$productos[$i]['precio'] = "$".$obj['precio_4'];
							$productos[$i++]['nombre'] = $obj['nombre'];
							break;
						case 5: //Resto del mundo
							$productos[$i]['precio'] = "US$".$obj['precio_5'];
							$productos[$i++]['nombre'] = $obj['nombre_ing'];
							break;
						default:
							break;
					}
				}
			}

			$data = array(
				'testimonios' => $testimonios,
				'padecimientos' => $padecimientos,
				'productos' => $productos
			);
			echo view('Cliente/Inicio', $data);
		}else{
			$this->session->setFlashdata('aviso', 'Por favor seleccione su región o Pais/ Please select your Country or Region');
			return redirect()->to('/Clientes/paises');
		}


	}

	public function nosotros()
	{
		if ($this->session->get('region')) {
			$Colaboradores_model = model('App\Models\Colaboradores_model', false);
			$estados = array();
			for ($i=0; $i < 4; $i++) {
				$colaboradores_aux = $Colaboradores_model->where('estado = 1 AND pais = '.($i+1).' group by estado_p order by estado_p')->findAll();
				switch ($i+1) {
					case 1:
						$estados[$i]['pais'] = "México";
						break;
					case 2:
						$estados[$i]['pais'] = "Perú";
						break;
					case 3:
						$estados[$i]['pais'] = "Europa";
						break;
					case 4:
						$estados[$i]['pais'] = "Argentina";
						break;
					case 5:
						$estados[$i]['pais'] = "Resto del mundo";
						break;
					default:
						$estados[$i]['pais'] = "";
						break;
				}
				$estados[$i]['estados'] = array();
				foreach ($colaboradores_aux as $obj) {
					$estados[$i]['estados'][] = $obj['estado_p'];
				}
			}

			$data = array(
				'estados' => $estados,
			);

			echo view('Cliente/Nosotros',$data);
		} else {
			$this->session->setFlashdata('aviso', 'Por favor seleccione su región o Pais/ Please select your Country or Region');
			return redirect()->to('/Clientes/paises');
		}
	}

	public function carrito()
	{
		if ($this->session->get('cart')){
			$Producto_model = model('App\Models\Producto_model', false);

			$subtotal = 0;
			$descuento = 0;
			$productos = array();
			foreach ($this->session->get('cart') as $obj) {
				$producto = $Producto_model->find(base64_decode($obj['id_producto']));

				if (isset($this->session->get('usuario')['descuento'])) {
					$precio_aux = 0;
					switch ($this->session->get('region')) {
						case 1: //Mexico
							if(($producto['desc_mex'] != null) && ($producto['desc_mex'] < $this->session->get('usuario')['descuento'])) {
								$precio_aux = $obj['cantidad'] * ($obj['precio'] * (1 - $producto['desc_mex'] / 100));
							} else {
								$precio_aux = $obj['cantidad'] * ($obj['precio'] * (1 - $this->session->get('usuario')['descuento'] / 100));
							}
							break;
						case 2: //Peru
							if(($producto['desc_peru'] != null) && ($producto['desc_peru'] < $this->session->get('usuario')['descuento'])) {
								$precio_aux = $obj['cantidad'] * ($obj['precio'] * (1 - $producto['desc_peru'] / 100));
							} else {
								$precio_aux = $obj['cantidad'] * ($obj['precio'] * (1 - $this->session->get('usuario')['descuento'] / 100));
							}
							break;
						case 3: //Europa
							if(($producto['desc_eur'] != null) && ($producto['desc_eur'] < $this->session->get('usuario')['descuento'])) {
								$precio_aux = $obj['cantidad'] * ($obj['precio'] * (1 - $producto['desc_eur'] / 100));
							} else {
								$precio_aux = $obj['cantidad'] * ($obj['precio'] * (1 - $this->session->get('usuario')['descuento'] / 100));
							}
							break;
						case 4: //Argentina
							if(($producto['desc_arg'] != null) && ($producto['desc_arg'] < $this->session->get('usuario')['descuento'])) {
								$precio_aux = $obj['cantidad'] * ($obj['precio'] * (1 - $producto['desc_arg'] / 100));
							} else {
								$precio_aux = $obj['cantidad'] * ($obj['precio'] * (1 - $this->session->get('usuario')['descuento'] / 100));
							}
							break;
						case 5: //Resto del mundo
							if(($producto['desc_rest'] != null) && ($producto['desc_rest'] < $this->session->get('usuario')['descuento'])) {
								$precio_aux = $obj['cantidad'] * ($obj['precio'] * (1 - $producto['desc_rest'] / 100));
							} else {
								$precio_aux = $obj['cantidad'] * ($obj['precio'] * (1 - $this->session->get('usuario')['descuento'] / 100));
							}
							break;
						default:
							break;
					}
					$subtotal += $precio_aux;
					$descuento += (($obj['cantidad'] * $obj['precio']) - $precio_aux);
				} else {
					$subtotal+= $obj['cantidad'] * $obj['precio'];
				}

				$productos[] = $obj;
			}
			$data = array(
				'productos' => $productos,
				'subtotal' => $subtotal,
				'descuento' => $descuento
				);
			echo view('Cliente/Carrito',$data);
		}else{
			$this->session->setFlashdata('error', ['tipo' => 'error', 'error' => "No hay productos en tu carrito."]);
			return redirect()->to('/Clientes/tienda');
		}
	}

	public function levantar_orden(){
		if ($this->session->get('cart') && $this->session->get('address')) {
			$Orden_model = model('App\Models\Orden_model', false);
			$Orden_Prod_model = model('App\Models\Orden_Prod_model', false);
			$Producto_model = model('App\Models\Producto_model', false);

			$peso_productos = 0;
			$subtotal = 0;
			foreach ($this->session->get('cart') as $obj) {
				// $subtotal+= $obj['cantidad']*$obj['precio'];
				$producto = $Producto_model->find(base64_decode($obj['id_producto']));
				$peso_productos += $producto['peso'] * $obj['cantidad'];

				if (isset($this->session->get('usuario')['descuento'])) {
					switch ($this->session->get('region')) {
						case 1: //Mexico
							if(($producto['desc_mex'] != null) && ($producto['desc_mex'] < $this->session->get('usuario')['descuento'])) {
								$subtotal+= $obj['cantidad'] * ($obj['precio'] * (1 - $producto['desc_mex'] / 100));
							} else {
								$subtotal+= $obj['cantidad'] * ($obj['precio'] * (1 - $this->session->get('usuario')['descuento'] / 100));
							}
							break;
						case 2: //Peru
							if(($producto['desc_peru'] != null) && ($producto['desc_peru'] < $this->session->get('usuario')['descuento'])) {
								$subtotal+= $obj['cantidad'] * ($obj['precio'] * (1 - $producto['desc_peru'] / 100));
							} else {
								$subtotal+= $obj['cantidad'] * ($obj['precio'] * (1 - $this->session->get('usuario')['descuento'] / 100));
							}
							break;
						case 3: //Europa
							if(($producto['desc_eur'] != null) && ($producto['desc_eur'] < $this->session->get('usuario')['descuento'])) {
								$subtotal+= $obj['cantidad'] * ($obj['precio'] * (1 - $producto['desc_eur'] / 100));
							} else {
								$subtotal+= $obj['cantidad'] * ($obj['precio'] * (1 - $this->session->get('usuario')['descuento'] / 100));
							}
							break;
						case 4: //Argentina
							if(($producto['desc_arg'] != null) && ($producto['desc_arg'] < $this->session->get('usuario')['descuento'])) {
								$subtotal+= $obj['cantidad'] * ($obj['precio'] * (1 - $producto['desc_arg'] / 100));
							} else {
								$subtotal+= $obj['cantidad'] * ($obj['precio'] * (1 - $this->session->get('usuario')['descuento'] / 100));
							}
							break;
						case 5: //Resto del mundo
							if(($producto['desc_rest'] != null) && ($producto['desc_rest'] < $this->session->get('usuario')['descuento'])) {
								$subtotal+= $obj['cantidad'] * ($obj['precio'] * (1 - $producto['desc_rest'] / 100));
							} else {
								$subtotal+= $obj['cantidad'] * ($obj['precio'] * (1 - $this->session->get('usuario')['descuento'] / 100));
							}
							break;
						default:
							break;
					}
				} else {
					$subtotal+= $obj['cantidad'] * $obj['precio'];
				}
			}
			// if (isset($this->session->get('usuario')['descuento'])) {
			// 	$subtotal = $subtotal * (1 - $this->session->get('usuario')['descuento'] / 100);
			// }

			// 0.100 grs a 1 kg $200
			// 1.05 grs a 2 kg $250
			// 2.05 a 3 kg $280
			// 3.05 a 4 kg $310
			// 4.05 a 5 kg $340
			// 5.05 a 6 kg $370
			// 6.05 a 7 kg $400
			// 7.05 a 8 kg $430
			// 8.05 a 9 kg $460
			// 9.05 a 10 kg $490
			// 10.5 a 15 kg $590
			// 15.05 a 20 kg 695

			$peso_productos += 100;
			$envio = 0;
			switch ($peso_productos) {
				case ($peso_productos > 0 && $peso_productos < 1000):
					$envio = 200;
					break;
				case ($peso_productos >= 1000 && $peso_productos < 2000):
					$envio = 250;
					break;
				case ($peso_productos >= 2000 && $peso_productos < 3000):
					$envio = 280;
					break;
				case ($peso_productos >= 3000 && $peso_productos < 4000):
					$envio = 310;
					break;
				case ($peso_productos >= 4000 && $peso_productos < 5000):
					$envio = 340;
					break;
				case ($peso_productos >= 5000 && $peso_productos < 6000):
					$envio = 370;
					break;
				case ($peso_productos >= 6000 && $peso_productos < 7000):
					$envio = 400;
					break;
				case ($peso_productos >= 7000 && $peso_productos < 8000):
					$envio = 430;
					break;
				case ($peso_productos >= 8000 && $peso_productos < 9000):
					$envio = 460;
					break;
				case ($peso_productos >= 9000 && $peso_productos < 10000):
					$envio = 490;
					break;
				case ($peso_productos >= 10000 && $peso_productos < 15000):
					$envio = 590;
					break;
				case ($peso_productos >= 15000 && $peso_productos < 20000):
					$envio = 695;
					break;
				default:
					$envio = 800;
					break;
			}

			$subtotal += $envio;

			$data = array(
				'precio_total' => $subtotal,
				'precio_envio' => $envio,
				'id_usuario' => $this->session->get('usuario')['id_login'],
				'id_direccion' => $this->session->get('address')['id_direccion'],
				'id_pago' => null,
				'tipo_pago' => 2,
				'estado_pago' => null,
				'pais' => $this->session->get('region')
			);
			$Orden_model->insert($data);
			$id_orden = $Orden_model->getInsertID();

			foreach ($this->session->get('cart') as $obj) {
				$data = array(
					'id_producto' => base64_decode($obj['id_producto']),
					'id_orden' => $id_orden,
					'cantidad' => $obj['cantidad']
				);
				$Orden_Prod_model->insert($data);
			}
			//$charge = $openpay->charges->create($chargeData);
			// return redirect()->to('/Clientes/ordenes');
			$this->session->remove('cart');
			$this->session->remove('address');
			$this->session->setFlashdata('aviso', 'Su orden ha sido creada exitosamente, envie su pago a...');

			$respuesta = array(
				'bandera' => 1,
			);

			echo json_encode($respuesta);
		}
	}

	public function pago_tienda(){
		if ($this->session->get('cart') && $this->session->get('address')) {
			$Orden_model = model('App\Models\Orden_model', false);
			$Orden_Prod_model = model('App\Models\Orden_Prod_model', false);
			$Producto_model = model('App\Models\Producto_model', false);

			$peso_productos = 0;
			$subtotal = 0;
			foreach ($this->session->get('cart') as $obj) {
				// $subtotal+= $obj['cantidad']*$obj['precio'];
				$producto = $Producto_model->find(base64_decode($obj['id_producto']));
				$peso_productos += $producto['peso'] * $obj['cantidad'];

				if (isset($this->session->get('usuario')['descuento'])) {
					switch ($this->session->get('region')) {
						case 1: //Mexico
							if(($producto['desc_mex'] != null) && ($producto['desc_mex'] < $this->session->get('usuario')['descuento'])) {
								$subtotal+= $obj['cantidad'] * ($obj['precio'] * (1 - $producto['desc_mex'] / 100));
							} else {
								$subtotal+= $obj['cantidad'] * ($obj['precio'] * (1 - $this->session->get('usuario')['descuento'] / 100));
							}
							break;
						case 2: //Peru
							if(($producto['desc_peru'] != null) && ($producto['desc_peru'] < $this->session->get('usuario')['descuento'])) {
								$subtotal+= $obj['cantidad'] * ($obj['precio'] * (1 - $producto['desc_peru'] / 100));
							} else {
								$subtotal+= $obj['cantidad'] * ($obj['precio'] * (1 - $this->session->get('usuario')['descuento'] / 100));
							}
							break;
						case 3: //Europa
							if(($producto['desc_eur'] != null) && ($producto['desc_eur'] < $this->session->get('usuario')['descuento'])) {
								$subtotal+= $obj['cantidad'] * ($obj['precio'] * (1 - $producto['desc_eur'] / 100));
							} else {
								$subtotal+= $obj['cantidad'] * ($obj['precio'] * (1 - $this->session->get('usuario')['descuento'] / 100));
							}
							break;
						case 4: //Argentina
							if(($producto['desc_arg'] != null) && ($producto['desc_arg'] < $this->session->get('usuario')['descuento'])) {
								$subtotal+= $obj['cantidad'] * ($obj['precio'] * (1 - $producto['desc_arg'] / 100));
							} else {
								$subtotal+= $obj['cantidad'] * ($obj['precio'] * (1 - $this->session->get('usuario')['descuento'] / 100));
							}
							break;
						case 5: //Resto del mundo
							if(($producto['desc_rest'] != null) && ($producto['desc_rest'] < $this->session->get('usuario')['descuento'])) {
								$subtotal+= $obj['cantidad'] * ($obj['precio'] * (1 - $producto['desc_rest'] / 100));
							} else {
								$subtotal+= $obj['cantidad'] * ($obj['precio'] * (1 - $this->session->get('usuario')['descuento'] / 100));
							}
							break;
						default:
							break;
					}
				} else {
					$subtotal+= $obj['cantidad'] * $obj['precio'];
				}
			}
			// if (isset($this->session->get('usuario')['descuento'])) {
			// 	$subtotal = $subtotal * (1 - $this->session->get('usuario')['descuento'] / 100);
			// }

			// 0.100 grs a 1 kg $200
			// 1.05 grs a 2 kg $250
			// 2.05 a 3 kg $280
			// 3.05 a 4 kg $310
			// 4.05 a 5 kg $340
			// 5.05 a 6 kg $370
			// 6.05 a 7 kg $400
			// 7.05 a 8 kg $430
			// 8.05 a 9 kg $460
			// 9.05 a 10 kg $490
			// 10.5 a 15 kg $590
			// 15.05 a 20 kg 695

			$peso_productos += 100;
			$envio = 0;
			switch ($peso_productos) {
				case ($peso_productos > 0 && $peso_productos < 1000):
					$envio = 200;
					break;
				case ($peso_productos >= 1000 && $peso_productos < 2000):
					$envio = 250;
					break;
				case ($peso_productos >= 2000 && $peso_productos < 3000):
					$envio = 280;
					break;
				case ($peso_productos >= 3000 && $peso_productos < 4000):
					$envio = 310;
					break;
				case ($peso_productos >= 4000 && $peso_productos < 5000):
					$envio = 340;
					break;
				case ($peso_productos >= 5000 && $peso_productos < 6000):
					$envio = 370;
					break;
				case ($peso_productos >= 6000 && $peso_productos < 7000):
					$envio = 400;
					break;
				case ($peso_productos >= 7000 && $peso_productos < 8000):
					$envio = 430;
					break;
				case ($peso_productos >= 8000 && $peso_productos < 9000):
					$envio = 460;
					break;
				case ($peso_productos >= 9000 && $peso_productos < 10000):
					$envio = 490;
					break;
				case ($peso_productos >= 10000 && $peso_productos < 15000):
					$envio = 590;
					break;
				case ($peso_productos >= 15000 && $peso_productos < 20000):
					$envio = 695;
					break;
				default:
					$envio = 800;
					break;
			}

			$subtotal += $envio;

			$customer = $this->openpay->get_client($this->session->get('usuario')['openpay']);

			$chargeData = array(
				'method' => 'store',
				'amount' => $subtotal,
				'currency' => 'MXN',
				'description' => 'Cargo a tienda de productos de NankÖ',
				'due_date' => date('Y-m-d', strtotime('+ 7 days'))
			);

			$charge = $this->openpay->pago($chargeData,$customer);
			$respuesta = array();
			if ($charge['bandera'] == 1) { //pago exitoso
				$url = "https://dashboard.openpay.mx/paynet-pdf/".$this->openpay->get_id()."/".$charge['charge']->payment_method->reference;
				$data = array(
					'precio_total' => $subtotal,
					'precio_envio' => $envio,
					'id_usuario' => $this->session->get('usuario')['id_login'],
					'id_direccion' => $this->session->get('address')['id_direccion'],
					'id_pago' => $charge['charge']->id,
					'tipo_pago' => 2,
					'estado_pago' => $charge['charge']->status,
					'pais' => $this->session->get('region'),
					'url_pdf' => $url
				);
				$Orden_model->insert($data);
				$id_orden = $Orden_model->getInsertID();

				foreach ($this->session->get('cart') as $obj) {
					$data = array(
						'id_producto' => base64_decode($obj['id_producto']),
						'id_orden' => $id_orden,
						'cantidad' => $obj['cantidad']
					);
					$Orden_Prod_model->insert($data);
				}

				$email = \Config\Services::email();
				$email->setFrom('not_reply@nanko.com.mx', 'Nanko');
				$email->setTo('envios@nanko.com.mx');
				$email->setSubject('Nueva orden');
				$encabezado = "Una nueva orden fue creada.<br>";
				$cuerpo = "";
				$email->setMessage($encabezado.$cuerpo);
				if(!$email->send()){
					$Config_model = model('App\Models\Config_model', false);
					$array = array(
						'nombre' => "Error Orden",
						'descr' => $email->printDebugger()
					);
					$Config_model->insert($array);
				}

				//$charge = $openpay->charges->create($chargeData);
				// return redirect()->to('/Clientes/ordenes');
				$this->session->remove('cart');
				$this->session->remove('address');
				$this->session->setFlashdata('aviso', 'Su orden ha sido creada exitosamente.');

				$respuesta = array(
					'bandera' => 1,
					'url' => $url
				);
			}else{ //pago rechazado
				$respuesta = array(
					'bandera' => 0,
					'respuesta' => $charge['mensaje']
				);
			}
			echo json_encode($respuesta);
		}
	}

	public function agregar_carro()
	{
		// if ($this->session->get('usuario')) {
			if ($this->request->isAJAX()) {
				$Producto_model = model('App\Models\Producto_model', false);
				$post = $this->request->getVar(null, FILTER_SANITIZE_STRING);
				$id_producto = base64_decode($post['id_producto']);
				$producto = $Producto_model->Where("idProducto = $id_producto AND regiones LIKE '%1%'")->first();
				if ($producto) {
					if ($this->session->get('cart')) {
						$productos = $this->session->get('cart');
						$key = array_search($post['id_producto'], array_column($productos, 'id_producto'));
						if ($key !== false) { //cambiar la cantidad
							$productos[$key]['cantidad'] += $post['cantidad'];
							if ($producto['stock'] < $productos[$key]['cantidad']) {
								$productos[$key]['cantidad'] = $producto['stock'];
							}
							$respuesta=array(
								"bandera" => 2,
								"articulo" => array(
									'id_producto' => $post['id_producto'],
									'img' => $producto['img_port'],
									'nombre' => $producto['nombre'],
									'precio' => $producto['precio_1'],
									'cantidad' => $productos[$key]['cantidad'] ,
								),
								"respuesta" => "El carrito fue actualizado con éxito."
							);
						}else{ //agregar producto al carrito
							$productos[] = array(
								'id_producto' => $post['id_producto'],
								'img' => $producto['img_port'],
								'nombre' => $producto['nombre'],
								'precio' => $producto['precio_1'],
								'cantidad' => ($producto['stock'] < $post['cantidad']) ? $producto['stock']:$post['cantidad'],
							);
							$respuesta=array(
								"bandera" => 1,
								"articulo" => array(
									'id_producto' => $post['id_producto'],
									'img' => $producto['img_port'],
									'nombre' => $producto['nombre'],
									'precio' => $producto['precio_1'],
									'cantidad' => ($producto['stock'] < $post['cantidad']) ? $producto['stock']:$post['cantidad'],
								),
								"respuesta" => "El producto fue agregado al carrito con éxito."
							);
						}
						$this->session->set('cart', $productos);
					}else{//crear carrito
						$productos = array();
						$productos[] = array(
							'id_producto' => $post['id_producto'],
							'img' => $producto['img_port'],
							'nombre' => $producto['nombre'],
							'precio' => $producto['precio_1'],
							'cantidad' => ($producto['stock'] < $post['cantidad']) ? $producto['stock']:$post['cantidad']
						);
						$this->session->set('cart', $productos);
						$respuesta=array(
							"bandera" => 1,
							"articulo" => array(
								'id_producto' => $post['id_producto'],
								'img' => $producto['img_port'],
								'nombre' => $producto['nombre'],
								'precio' => $producto['precio_1'],
								'cantidad' => ($producto['stock'] < $post['cantidad']) ? $producto['stock']:$post['cantidad']
							),
							"respuesta" => "El carrito fue creado con éxito."
						);
					}
				}else{
					$respuesta=array(
						"bandera" => 0,
						"respuesta" => "El producto no existe o no está disponible en la región"
					);
				}
				echo json_encode($respuesta);
			}
		// }else{
		// 	$respuesta=array(
		// 		"bandera" => 0,
		// 		"respuesta" => "Inicia sesión por favor."
		// 	);
		// 	echo json_encode($respuesta);
		// }
	}

	public function seleccionar_direccion($direccion = null){
		if ($this->session->get('usuario') && $this->session->get('cart') ) {
			if($direccion != null){
				$Direccion_model = model('App\Models\Direccion_model', false);
				$id_direccion = base64_decode($direccion);
				$direccion = $Direccion_model->find($id_direccion);
				$this->session->set('address', $direccion);
				return redirect()->to('/Clientes/metodo_pago');
			}else{
				$this->session->setFlashdata('error', ['tipo' => 'error', 'error' => "Dirección no válida" ]);
				return $this->finalize_purchase();
			}
		}
	}

	public function editar_direccion() {
		if ($this->session->get('usuario')) {
			$Direccion_model = model('App\Models\Direccion_model', false);
			$data = [
				'id_direccion' => ['label' => 'id', 'rules' => 'required|valid_base64'],
				'tipo_e' => ['label' => 'Tipo', 'rules' => 'required'],
				'nombre' => ['label' => 'Nombre', 'rules' => 'required'],
				// 'direccion' => ['label' => 'Dirección', 'rules' => 'required'],
				'calle' => ['label' => 'Calle', 'rules' => 'required'],
				'cp' => ['label' => 'Código Postal', 'rules' => 'required'],
				'estado' => ['label' => 'Estado', 'rules' => 'required'],
				'colonia' => ['label' => 'Colonia', 'rules' => 'required'],
				'ciudad' => ['label' => 'Ciudad', 'rules' => 'required'],
				'municipio' => ['label' => 'Municipio', 'rules' => 'required'],
				'num_ext' => ['label' => 'Número exterior', 'rules' => 'required'],
				'num_int' => ['label' => 'Número interior', 'rules' => 'required'],
				'tel' => ['label' => 'Teléfono', 'rules' => 'required'],
				'instrucciones' => ['label' => 'Instrucciones', 'rules' => 'permit_empty'],
			];

			if (! $this->validate($data)){ //si algo sale mal en el form
				$post = $this->request->getVar(null, FILTER_SANITIZE_STRING);
				if (isset($post['id_direccion'])) {
					$this->session->setFlashdata('error',['tipo' => 'editar','error' => $this->validator->getErrors()]);
					$id_dir = base64_decode($post['id_direccion']);
					$direccion = $Direccion_model->find($id_dir);
					if ($direccion) {
						$data = [
							'id_direccion' => $post['id_direccion'],
							'nombre' => $direccion['nombre'],
							'direccion' => $direccion['direccion'],
							'cp' => $direccion['cp'],
							'estado' => $direccion['estado'],
							'colonia' => $direccion['colonia'],
							'ciudad' => $direccion['ciudad'],
							'municipio' => $direccion['municipio'],
							'calle' => $direccion['calle'],
							'num_ext' => $direccion['num_ext'],
							'num_int' => $direccion['num_int'],
							'tel' => $direccion['tel'],
							'instrucciones' => $direccion['instrucciones']
						];
						$this->session->setFlashdata('direccion', json_encode($data));
						$this->direcciones();
						return true;
					}
				} else {
					$id_dir = base64_decode($post['id_dir']);
					$direccion = $Direccion_model->find($id_dir);
					if ($direccion) {
						$data= array(
							'id_direccion' => $post['id_dir'],
							'bandera' => 1,
							'nombre' => $direccion['nombre'],
							'direccion' => $direccion['direccion'],
							'cp' => $direccion['cp'],
							'estado' => $direccion['estado'],
							'colonia' => $direccion['colonia'],
							'ciudad' => $direccion['ciudad'],
							'municipio' => $direccion['municipio'],
							'calle' => $direccion['calle'],
							'num_ext' => $direccion['num_ext'],
							'num_int' => $direccion['num_int'],
							'tel' => $direccion['tel'],
							'instrucciones' => $direccion['instrucciones']
						);
						return json_encode($data);
					} else {
						$data= array(
							'bandera' => 0,
							'mensaje' => 'Dirección no válida'
						);
						return json_encode($data);
					}
				}
			}
			$post = $this->request->getVar(null, FILTER_SANITIZE_STRING);
			$id_direccion = base64_decode($post['id_direccion']);

			$Direccion_model->set('nombre', $post['nombre']);
			// $Direccion_model->set('direccion', $post['direccion']);
			$Direccion_model->set('cp', $post['cp']);
			$Direccion_model->set('estado', $post['estado']);
			$Direccion_model->set('colonia', $post['colonia']);
			$Direccion_model->set('ciudad', $post['ciudad']);
			$Direccion_model->set('municipio', $post['municipio']);
			$Direccion_model->set('calle', $post['calle']);
			$Direccion_model->set('num_ext', $post['num_ext']);
			$Direccion_model->set('num_int', $post['num_int']);
			$Direccion_model->set('tel', $post['tel']);
			$Direccion_model->set('instrucciones', $post['instrucciones']);
			$Direccion_model->where('id_direccion', $id_direccion);
			$Direccion_model->update();
			$this->session->setFlashdata('aviso', 'La dirección fue editada exitosamente.');
			if ($post['tipo_e'] == 'cuenta') {
				return redirect()->to('/Clientes/direcciones');
			} else {
				return redirect()->to('/Clientes/finalize_purchase');
			}
		} else {
			$this->session->setFlashdata('error', ['tipo' => 'error', 'error' => "Inicie sesión por favor."]);
			return redirect()->to('mostrar_inicio');
		}
	}

	public function eliminar_direccion($id = null,$bandera_origen = null) {
		if ($this->session->get('usuario')) {
			if ($id != null) {
				$Direccion_model = model('App\Models\Direccion_model', false);
				$id = base64_decode($id);
				$Direccion_model->set('estatus', 0);
				$Direccion_model->where('id_direccion', $id);
				$Direccion_model->update();
				$this->session->setFlashdata('aviso', 'La dirección fue eliminada exitosamente.');
			} else {
				$this->session->setFlashdata('aviso', 'La dirección no es válida.');
			}
			if ($bandera_origen == 'cuenta') {
				return redirect()->to('/Clientes/direcciones');
			} else {
				return redirect()->to('/Clientes/finalize_purchase');
			}
		} else {
			$this->session->setFlashdata('error', ['tipo' => 'error', 'error' => "Inicie sesión por favor."]);
			return redirect()->to('mostrar_inicio');
		}
	}

	public function agregar_direccion_cuenta(){
		if ($this->session->get('usuario')) {
			$data = [
				'name' => ['label' => 'Nombre', 'rules' => 'required'],
				// 'address' => ['label' => 'Dirección', 'rules' => 'required'],
				'cp' => ['label' => 'Código Postal', 'rules' => 'required'],
				'num_int' => ['label' => 'Número exterior', 'rules' => 'permit_empty'],
				'num_ext' => ['label' => 'Número interior', 'rules' => 'required'],
				'calle' => ['label' => 'Calle', 'rules' => 'required'],
				'estado' => ['label' => 'Estado', 'rules' => 'required'],
				'municipio' => ['label' => 'Muinicipio', 'rules' => 'required'],
				'city' => ['label' => 'Ciudad', 'rules' => 'required'],
				'colonia' => ['label' => 'Colonia', 'rules' => 'required'],
				'tel' => ['label' => 'Teléfono', 'rules' => 'required'],
				'instrucciones' => ['label' => 'Instrucciones', 'rules' => 'permit_empty'],
			];

			if (!$this->validate($data)) { //si algo sale mal en el form´
				$this->session->setFlashdata('error', ['tipo' => 'nuevo', 'error' => $this->validator->listErrors()]);
				return $this->direcciones();
			}
			$Direccion_model = model('App\Models\Direccion_model', false);
			$post = $this->request->getVar(null, FILTER_SANITIZE_STRING);
			$data = [
				'id_usuario' => $this->session->get('usuario')['id_login'],
				'nombre' => $post['name'],
				'calle' => $post['calle'],
				'cp' => $post['cp'],
				'estado' => $post['estado'],
				'colonia' => $post['colonia'],
				'ciudad' => $post['city'],
				'municipio' => $post['municipio'],
				'num_ext' => $post['num_ext'],
				'num_int' => $post['num_int'],
				'tel' => $post['tel'],
				'instrucciones' => $post['instrucciones'],
				'pais' => 1
			];
			$Direccion_model->insert($data);
			$this->session->setFlashdata('aviso', 'La dirección fue creada exitosamente.');

			return redirect()->to('/Clientes/direcciones');
		} else {
			$this->session->setFlashdata('error', ['tipo' => 'error', 'error' => "Inicie sesión por favor."]);
			return redirect()->to('mostrar_inicio');
		}
	}

	public function agregar_direccion(){
		if ($this->session->get('usuario') && $this->session->get('cart') ) {
			$data = [
				'name' => ['label' => 'Nombre', 'rules' => 'required'],
				// 'address' => ['label' => 'Dirección', 'rules' => 'required'],
				'cp' => ['label' => 'Código Postal', 'rules' => 'required'],
				'num_int' => ['label' => 'Número exterior', 'rules' => 'permit_empty'],
				'num_ext' => ['label' => 'Número interior', 'rules' => 'required'],
				'calle' => ['label' => 'Calle', 'rules' => 'required'],
				'estado' => ['label' => 'Estado', 'rules' => 'required'],
				'municipio' => ['label' => 'Muinicipio', 'rules' => 'required'],
				'city' => ['label' => 'Ciudad', 'rules' => 'required'],
				'colonia' => ['label' => 'Colonia', 'rules' => 'required'],
				'tel' => ['label' => 'Teléfono', 'rules' => 'required'],
				'instrucciones' => ['label' => 'Instrucciones', 'rules' => 'permit_empty'],
			];

			if (!$this->validate($data)) { //si algo sale mal en el form´
				$this->session->setFlashdata('error', ['tipo' => 'nuevo', 'error' => $this->validator->listErrors()]);
				return $this->finalize_purchase();
			}
			$Direccion_model = model('App\Models\Direccion_model', false);
			$post = $this->request->getVar(null, FILTER_SANITIZE_STRING);
			$data = [
				'id_usuario' => $this->session->get('usuario')['id_login'],
				'nombre' => $post['name'],
				'calle' => $post['calle'],
				'cp' => $post['cp'],
				'estado' => $post['estado'],
				'colonia' => $post['colonia'],
				'ciudad' => $post['city'],
				'municipio' => $post['municipio'],
				'num_ext' => $post['num_ext'],
				'num_int' => $post['num_int'],
				'tel' => $post['tel'],
				'instrucciones' => $post['instrucciones'],
				'pais' => 1
			];
			$Direccion_model->insert($data);

			$id = $Direccion_model->getInsertID();

			$direccion = $Direccion_model->find($id);
			$this->session->set('address', $direccion);
			return redirect()->to('metodo_pago');
		} else {
			$this->session->setFlashdata('error', ['tipo' => 'error', 'error' => "Inicie sesión por favor."]);
			return redirect()->to('mostrar_inicio');
		}
	}

	public function login()
	{
		if ($this->session->get('region')) {
			$data = [
				'correo' => 'required|valid_email',
				'pass'  => 'required',
			];

			if (!$this->validate($data)) { //si algo sale mal en el form´

				$this->session->setFlashdata('error', ['tipo' => 'login', 'error' => $this->validator->listErrors()]);
				return $this->mostrar_inicio();
			}

			$bcrypt = new Bcrypt();
			$Login_model = model('App\Models\Login_model', false);
			$post = $this->request->getVar(null, FILTER_SANITIZE_STRING);
			$correo = $Login_model->where('correo', $post['correo'])
				->findAll();
			if ($correo) {
				if ($bcrypt->check_password($post['pass'], $correo[0]['pass'])) {
					if ($correo[0]['estado'] == 0) {
						if(session('region') < 3 || session('region') == 4){
							$this->session->setFlashdata('aviso', 'Por favor confirme su correo para iniciar sesión, si no encuentra el correo busque en spam.');
							return redirect()->to('/Clientes');						}
						else{
							$this->session->setFlashdata('aviso', 'Please confirm your email to log in, if you cant find the email look in spam.');
							return redirect()->to('/Clientes');						}

					}
					$this->session->set('usuario', $correo[0]);
					// $_SESSION["usuario"]["id_login"]
					if (isset($_POST['cooki'])) {
						var_dump($correo[0]["id_login"],$correo[0]);
						setcookie('session_l', $this->session->usuario["id_login"] );
						setcookie('session_p', $this->session->usuario["openpay"] );
					}
					switch ($correo[0]['tipo_usuario']) {
						case 1: // Administrador
							return redirect()->to('/Usuarios/mostrar_usuarios');
							break;
						case 2: //Colaborador
							$Colaboradores_model = model('App\Models\Colaboradores_model', false);
							$colaborador = $Colaboradores_model->find($correo[0]['fk_usuario']);
							$correo[0]['descuento'] = $colaborador['descuento'];
							$this->session->set('usuario', $correo[0]);

							return redirect()->to('/Clientes');
							break;
						 case 3: //Cliente
							return redirect()->to('/Clientes');
							break;
						case 4:
							return redirect()->to('/Envios');
							break;
						default:
							# code...
							break;
					}
				} else {
					if(session('region') < 3 || session('region') == 4){
						$this->session->setFlashdata('error', ['tipo' => 'login', 'error' => "Usuario o contraseña incorrecta"]);
						return redirect()->to('mostrar_inicio');					}
					else{
						$this->session->setFlashdata('error', ['tipo' => 'login', 'error' => "Incorrect user or password"]);
						return redirect()->to('mostrar_inicio');
					}
				}
			} else {
				if(session('region') < 3 || session('region') == 4){
					$this->session->setFlashdata('error', ['tipo' => 'login', 'error' => "Usuario o contraseña incorrecta"]);
					return redirect()->to('mostrar_inicio');					}
				else{
					$this->session->setFlashdata('error', ['tipo' => 'login', 'error' => "Incorrect user or password"]);
					return redirect()->to('mostrar_inicio');
				}
			}
		} else {
			$this->session->setFlashdata('aviso', 'Por favor seleccione su región o Pais/ Please select your Country or Region');
			return redirect()->to('/Clientes/paises');
		}


	}

	public function crear_orden(){
		if ($this->session->get('usuario')) {
			$Orden_model = model('App\Models\Orden_model', false);
			$Producto_model = model('App\Models\Producto_model', false);
			$Orden_Prod_model = model('App\Models\Orden_Prod_model', false);
			$id = $_GET['id'];
			if ($id != null) {
				$peso_productos = 0;
				$subtotal = 0;
				foreach ($this->session->get('cart') as $obj) {
					// $subtotal+= $obj['cantidad']*$obj['precio'];
					$producto = $Producto_model->find(base64_decode($obj['id_producto']));
					$peso_productos += $producto['peso'] * $obj['cantidad'];

					if (isset($this->session->get('usuario')['descuento'])) {
						switch ($this->session->get('region')) {
							case 1: //Mexico
								if(($producto['desc_mex'] != null) && ($producto['desc_mex'] < $this->session->get('usuario')['descuento'])) {
									$subtotal += $obj['cantidad'] * ($obj['precio'] * (1 - $producto['desc_mex'] / 100));
								} else {
									$subtotal += $obj['cantidad'] * ($obj['precio'] * (1 - $this->session->get('usuario')['descuento'] / 100));
								}
								break;
							case 2: //Peru
								if(($producto['desc_peru'] != null) && ($producto['desc_peru'] < $this->session->get('usuario')['descuento'])) {
									$subtotal += $obj['cantidad'] * ($obj['precio'] * (1 - $producto['desc_peru'] / 100));
								} else {
									$subtotal += $obj['cantidad'] * ($obj['precio'] * (1 - $this->session->get('usuario')['descuento'] / 100));
								}
								break;
							case 3: //Europa
								if(($producto['desc_eur'] != null) && ($producto['desc_eur'] < $this->session->get('usuario')['descuento'])) {
									$subtotal += $obj['cantidad'] * ($obj['precio'] * (1 - $producto['desc_eur'] / 100));
								} else {
									$subtotal += $obj['cantidad'] * ($obj['precio'] * (1 - $this->session->get('usuario')['descuento'] / 100));
								}
								break;
							case 4: //Argentina
								if(($producto['desc_arg'] != null) && ($producto['desc_arg'] < $this->session->get('usuario')['descuento'])) {
									$subtotal += $obj['cantidad'] * ($obj['precio'] * (1 - $producto['desc_arg'] / 100));
								} else {
									$subtotal += $obj['cantidad'] * ($obj['precio'] * (1 - $this->session->get('usuario')['descuento'] / 100));
								}
								break;
							case 5: //Resto del mundo
								if(($producto['desc_rest'] != null) && ($producto['desc_rest'] < $this->session->get('usuario')['descuento'])) {
									$subtotal += $obj['cantidad'] * ($obj['precio'] * (1 - $producto['desc_rest'] / 100));
								} else {
									$subtotal += $obj['cantidad'] * ($obj['precio'] * (1 - $this->session->get('usuario')['descuento'] / 100));
								}
								break;
							default:
								break;
						}
					} else {
						$subtotal+= $obj['cantidad'] * $obj['precio'];
					}

				}

				// 0.100 grs a 1 kg $200
				// 1.05 grs a 2 kg $250
				// 2.05 a 3 kg $280
				// 3.05 a 4 kg $310
				// 4.05 a 5 kg $340
				// 5.05 a 6 kg $370
				// 6.05 a 7 kg $400
				// 7.05 a 8 kg $430
				// 8.05 a 9 kg $460
				// 9.05 a 10 kg $490
				// 10.5 a 15 kg $590
				// 15.05 a 20 kg 695

				$peso_productos += 100;
				$envio = 0;
				switch ($peso_productos) {
					case ($peso_productos > 0 && $peso_productos < 1000):
						$envio = 200;
						break;
					case ($peso_productos >= 1000 && $peso_productos < 2000):
						$envio = 250;
						break;
					case ($peso_productos >= 2000 && $peso_productos < 3000):
						$envio = 280;
						break;
					case ($peso_productos >= 3000 && $peso_productos < 4000):
						$envio = 310;
						break;
					case ($peso_productos >= 4000 && $peso_productos < 5000):
						$envio = 340;
						break;
					case ($peso_productos >= 5000 && $peso_productos < 6000):
						$envio = 370;
						break;
					case ($peso_productos >= 6000 && $peso_productos < 7000):
						$envio = 400;
						break;
					case ($peso_productos >= 7000 && $peso_productos < 8000):
						$envio = 430;
						break;
					case ($peso_productos >= 8000 && $peso_productos < 9000):
						$envio = 460;
						break;
					case ($peso_productos >= 9000 && $peso_productos < 10000):
						$envio = 490;
						break;
					case ($peso_productos >= 10000 && $peso_productos < 15000):
						$envio = 590;
						break;
					case ($peso_productos >= 15000 && $peso_productos < 20000):
						$envio = 695;
						break;
					default:
						$envio = 800;
						break;
				}

				$subtotal += $envio;
				$pago = $this->openpay->get_pago($this->session->get('usuario')['openpay'],$id);

				if(!isset($pago->serializableData['error_code'])) { //pago exitoso
					$data = array(
						'precio_total' => $subtotal,
						'precio_envio' => $envio,
						'id_usuario' => $this->session->get('usuario')['id_login'],
						'id_direccion' => $this->session->get('address')['id_direccion'],
						'id_pago' => $id,
						'tipo_pago' => 1,
						'estado_pago' => $pago->status,
						'pais' => $this->session->get('region')
					);

					$Orden_model->insert($data);
					$id_orden = $Orden_model->getInsertID();
					foreach ($this->session->get('cart') as $obj) {
						$data = array(
							'id_producto' => base64_decode($obj['id_producto']),
							'id_orden' => $id_orden,
							'cantidad' => $obj['cantidad']
						);
						$Orden_Prod_model->insert($data);
					}
					$this->session->remove('cart');
					$this->session->remove('address');

					$email = \Config\Services::email();
					$email->setFrom('not_reply@nanko.com.mx', 'Nanko');
					$email->setTo('envios@nanko.com.mx');
					$email->setSubject('Nueva orden');
					$encabezado = "Una nueva orden fue creada.<br>";
					$cuerpo = "";
					$email->setMessage($encabezado.$cuerpo);
					if(!$email->send()){
						$Config_model = model('App\Models\Config_model', false);
						$array = array(
							'nombre' => "Error Orden",
							'descr' => $email->printDebugger()
						);
						$Config_model->insert($array);
					}
					$this->session->setFlashdata('aviso', 'Su orden ha sido creada exitosamente.');
					$this->session->setFlashdata('ver', base64_encode($this->encrypter->encrypt($id_orden)));
					return redirect()->to('/Clientes/ordenes');
				}else{
					$mensaje = "";
					switch ($pago->serializableData['error_code']) {
						case 3001:
							$mensaje = "La tarjeta fue rechazada";
							break;
						case 3002:
							$mensaje = "La tarjeta ha expirado";
							break;
						case 3003:
							//$mensaje = "La tarjeta no tiene fondos insuficientes";
							$mensaje = "Tarjeta delinada";
							break;
						case 3004:
							//$mensaje = "La tarjeta ha sido identificada como una tarjeta robada";
							$mensaje = "Tarjeta delinada";
							break;
						case 3005:
							//$mensaje = "La tarjeta ha sido rechazada por el sistema antifraudes";
							$mensaje = "Tarjeta delinada";
							break;
						default:
							$mensaje = "Error en la autenticación con su banco.";
							break;
					}
					$this->session->setFlashdata('error', ['tipo' => 'error', 'error' =>  $mensaje]);
					return redirect()->to('/Clientes/metodo_pago');
				}
			}
		}else{
			$this->session->setFlashdata('error', ['tipo' => 'sesion', 'error' => "Inicie sesión por favor."]);
			return redirect()->to('/Clientes');
		}
	}

	public function ver_colaboradores()
	{
		if ($this->request->isAJAX()){
			$Colaboradores_model = model('App\Models\Colaboradores_model', false);
			$colaboradores_aux = $Colaboradores_model->where('estado = 1 AND pais = '.$this->session->get('region'))->findAll();
			$colaboradores = array();
			foreach ($colaboradores_aux as $obj) {
				$colaboradores[] = array(
					'nombre' => $obj['nombre'],
					'telefono' => $obj['telefono'],
					'correo' => $obj['correo_n'],
					'estado' => $obj['estado_p']
				);
			}
			$data = array(
				'colaboradores' => $colaboradores,
			);

			echo view('Cliente/Modales/ver_colaboradores',$data);
		}
	}

	public function pagar(){
		if ($this->session->get('usuario')) {
			if ($this->session->get('cart') && $this->session->get('address')) {
				$data = [
					'token_id' => ['label' => 'Token', 'rules' => 'required'],
					'deviceId' => ['label' => 'Pago', 'rules' => 'required'],
				];
				if (!$this->validate($data)) { //si algo sale mal en el form
					$this->session->setFlashdata('error', ['tipo' => 'form', 'error' => $this->validator->getErrors()]);
					return $this->metodo_pago();
				}
				$Producto_model = model('App\Models\Producto_model', false);

				$peso_productos = 0;
				$subtotal = 0;
				foreach ($this->session->get('cart') as $obj) {
					// $subtotal+= $obj['cantidad']*$obj['precio'];
					$producto = $Producto_model->find(base64_decode($obj['id_producto']));
					$peso_productos += $producto['peso'] * $obj['cantidad'];

					if (isset($this->session->get('usuario')['descuento'])) {
						switch ($this->session->get('region')) {
							case 1: //Mexico
								if(($producto['desc_mex'] != null) && ($producto['desc_mex'] < $this->session->get('usuario')['descuento'])) {
									$subtotal += $obj['cantidad'] * ($obj['precio'] * (1 - $producto['desc_mex'] / 100));
								} else {
									$subtotal += $obj['cantidad'] * ($obj['precio'] * (1 - $this->session->get('usuario')['descuento'] / 100));
								}
								break;
							case 2: //Peru
								if(($producto['desc_peru'] != null) && ($producto['desc_peru'] < $this->session->get('usuario')['descuento'])) {
									$subtotal += $obj['cantidad'] * ($obj['precio'] * (1 - $producto['desc_peru'] / 100));
								} else {
									$subtotal += $obj['cantidad'] * ($obj['precio'] * (1 - $this->session->get('usuario')['descuento'] / 100));
								}
								break;
							case 3: //Europa
								if(($producto['desc_eur'] != null) && ($producto['desc_eur'] < $this->session->get('usuario')['descuento'])) {
									$subtotal += $obj['cantidad'] * ($obj['precio'] * (1 - $producto['desc_eur'] / 100));
								} else {
									$subtotal += $obj['cantidad'] * ($obj['precio'] * (1 - $this->session->get('usuario')['descuento'] / 100));
								}
								break;
							case 4: //Argentina
								if(($producto['desc_arg'] != null) && ($producto['desc_arg'] < $this->session->get('usuario')['descuento'])) {
									$subtotal += $obj['cantidad'] * ($obj['precio'] * (1 - $producto['desc_arg'] / 100));
								} else {
									$subtotal += $obj['cantidad'] * ($obj['precio'] * (1 - $this->session->get('usuario')['descuento'] / 100));
								}
								break;
							case 5: //Resto del mundo
								if(($producto['desc_rest'] != null) && ($producto['desc_rest'] < $this->session->get('usuario')['descuento'])) {
									$subtotal += $obj['cantidad'] * ($obj['precio'] * (1 - $producto['desc_rest'] / 100));
								} else {
									$subtotal += $obj['cantidad'] * ($obj['precio'] * (1 - $this->session->get('usuario')['descuento'] / 100));
								}
								break;
							default:
								break;
						}
					} else {
						$subtotal+= $obj['cantidad'] * $obj['precio'];
					}
				}

				// 0.100 grs a 1 kg $200
				// 1.05 grs a 2 kg $250
				// 2.05 a 3 kg $280
				// 3.05 a 4 kg $310
				// 4.05 a 5 kg $340
				// 5.05 a 6 kg $370
				// 6.05 a 7 kg $400
				// 7.05 a 8 kg $430
				// 8.05 a 9 kg $460
				// 9.05 a 10 kg $490
				// 10.5 a 15 kg $590
				// 15.05 a 20 kg 695

				$peso_productos += 100;
				$envio = 0;
				switch ($peso_productos) {
					case ($peso_productos > 0 && $peso_productos < 1000):
						$envio = 200;
						break;
					case ($peso_productos >= 1000 && $peso_productos < 2000):
						$envio = 250;
						break;
					case ($peso_productos >= 2000 && $peso_productos < 3000):
						$envio = 280;
						break;
					case ($peso_productos >= 3000 && $peso_productos < 4000):
						$envio = 310;
						break;
					case ($peso_productos >= 4000 && $peso_productos < 5000):
						$envio = 340;
						break;
					case ($peso_productos >= 5000 && $peso_productos < 6000):
						$envio = 370;
						break;
					case ($peso_productos >= 6000 && $peso_productos < 7000):
						$envio = 400;
						break;
					case ($peso_productos >= 7000 && $peso_productos < 8000):
						$envio = 430;
						break;
					case ($peso_productos >= 8000 && $peso_productos < 9000):
						$envio = 460;
						break;
					case ($peso_productos >= 9000 && $peso_productos < 10000):
						$envio = 490;
						break;
					case ($peso_productos >= 10000 && $peso_productos < 15000):
						$envio = 590;
						break;
					case ($peso_productos >= 15000 && $peso_productos < 20000):
						$envio = 695;
						break;
					default:
						$envio = 800;
						break;
				}

				$subtotal += $envio;
				$customer = $this->openpay->get_client($this->session->get('usuario')['openpay']);

				$chargeData = array(
					'method' => 'card',
					'source_id' => $_POST["token_id"],
					'amount' => $subtotal,
					'currency' => 'MXN',
					'use_3d_secure' => true,
				 	'device_session_id' => $_POST["deviceId"],
					'description' => "Productos de NankÖ",
					'redirect_url' => base_url('Clientes/crear_orden/'),
				);

				$charge = $this->openpay->pago($chargeData,$customer);
				if ($charge['bandera'] == 1) { //pago exitoso
					//$this->__redirect($charge['charge']->payment_method->url);
					return redirect()->to($charge['charge']->payment_method->url);
				}else{ //pago rechazado
					$this->session->setFlashdata('error', ['tipo' => 'error', 'error' =>  $charge['mensaje']]);
					return redirect()->to('/Clientes/metodo_pago');
				}
			}else{
				$this->session->setFlashdata('error', ['tipo' => 'error', 'error' => "No tiene productos por pagar."]);
				return redirect()->to('/Clientes/tienda');
			}
		}else{
			$this->session->setFlashdata('error', ['tipo' => 'sesion', 'error' => "Inicie sesión por favor."]);
			return redirect()->to('/Clientes');
		}
	}

	public function metodo_pago(){
		if ($this->session->get('usuario')) {
			if ($this->session->get('cart') &&  $this->session->get('address')) {
				$Producto_model = model('App\Models\Producto_model', false);
				//calcular el peso
				$carrito = $this->session->get('cart');
				$peso_productos = 0;
				$descuento = 0;
				$subtotal = 0;
				foreach ($carrito as $obj) {
					$producto = $Producto_model->find(base64_decode($obj['id_producto']));
					$peso_productos += $producto['peso'] * $obj['cantidad'];

					if (isset($this->session->get('usuario')['descuento'])) {
						$precio_aux = 0;
						switch ($this->session->get('region')) {
							case 1: //Mexico
								if(($producto['desc_mex'] != null) && ($producto['desc_mex'] < $this->session->get('usuario')['descuento'])) {
									$precio_aux = $obj['cantidad'] * ($obj['precio'] * (1 - $producto['desc_mex'] / 100));
								} else {
									$precio_aux = $obj['cantidad'] * ($obj['precio'] * (1 - $this->session->get('usuario')['descuento'] / 100));
								}
								break;
							case 2: //Peru
								if(($producto['desc_peru'] != null) && ($producto['desc_peru'] < $this->session->get('usuario')['descuento'])) {
									$precio_aux = $obj['cantidad'] * ($obj['precio'] * (1 - $producto['desc_peru'] / 100));
								} else {
									$precio_aux = $obj['cantidad'] * ($obj['precio'] * (1 - $this->session->get('usuario')['descuento'] / 100));
								}
								break;
							case 3: //Europa
								if(($producto['desc_eur'] != null) && ($producto['desc_eur'] < $this->session->get('usuario')['descuento'])) {
									$precio_aux = $obj['cantidad'] * ($obj['precio'] * (1 - $producto['desc_eur'] / 100));
								} else {
									$precio_aux = $obj['cantidad'] * ($obj['precio'] * (1 - $this->session->get('usuario')['descuento'] / 100));
								}
								break;
							case 4: //Argentina
								if(($producto['desc_arg'] != null) && ($producto['desc_arg'] < $this->session->get('usuario')['descuento'])) {
									$precio_aux = $obj['cantidad'] * ($obj['precio'] * (1 - $producto['desc_arg'] / 100));
								} else {
									$precio_aux = $obj['cantidad'] * ($obj['precio'] * (1 - $this->session->get('usuario')['descuento'] / 100));
								}
								break;
							case 5: //Resto del mundo
								if(($producto['desc_rest'] != null) && ($producto['desc_rest'] < $this->session->get('usuario')['descuento'])) {
									$precio_aux = $obj['cantidad'] * ($obj['precio'] * (1 - $producto['desc_rest'] / 100));
								} else {
									$precio_aux = $obj['cantidad'] * ($obj['precio'] * (1 - $this->session->get('usuario')['descuento'] / 100));
								}
								break;
							default:
								break;
						}

						$subtotal += $precio_aux;
						$descuento += (($obj['cantidad'] * $obj['precio']) - $precio_aux);
					} else {
						$subtotal+= $obj['cantidad'] * $obj['precio'];
					}

				}

				// 0.100 grs a 1 kg $200
				// 1.05 grs a 2 kg $250
				// 2.05 a 3 kg $280
				// 3.05 a 4 kg $310
				// 4.05 a 5 kg $340
				// 5.05 a 6 kg $370
				// 6.05 a 7 kg $400
				// 7.05 a 8 kg $430
				// 8.05 a 9 kg $460
				// 9.05 a 10 kg $490
				// 10.5 a 15 kg $590
				// 15.05 a 20 kg 695

				$peso_productos += 100;
				$envio = 0;
				switch ($peso_productos) {
					case ($peso_productos > 0 && $peso_productos < 1000):
						$envio = 200;
						break;
					case ($peso_productos >= 1000 && $peso_productos < 2000):
						$envio = 250;
						break;
					case ($peso_productos >= 2000 && $peso_productos < 3000):
						$envio = 280;
						break;
					case ($peso_productos >= 3000 && $peso_productos < 4000):
						$envio = 310;
						break;
					case ($peso_productos >= 4000 && $peso_productos < 5000):
						$envio = 340;
						break;
					case ($peso_productos >= 5000 && $peso_productos < 6000):
						$envio = 370;
						break;
					case ($peso_productos >= 6000 && $peso_productos < 7000):
						$envio = 400;
						break;
					case ($peso_productos >= 7000 && $peso_productos < 8000):
						$envio = 430;
						break;
					case ($peso_productos >= 8000 && $peso_productos < 9000):
						$envio = 460;
						break;
					case ($peso_productos >= 9000 && $peso_productos < 10000):
						$envio = 490;
						break;
					case ($peso_productos >= 10000 && $peso_productos < 15000):
						$envio = 590;
						break;
					case ($peso_productos >= 15000 && $peso_productos < 20000):
						$envio = 695;
						break;
					default:
						$envio = 800;
						break;
				}

				$subtotal += $envio;

				$data = array(
					'subtotal' => $subtotal,
					'descuento' => $descuento,
					'envio' => $envio
				);
				echo view('Cliente/Cards',$data);
			}else{
				$this->session->setFlashdata('error', ['tipo' => 'error', 'error' => "No tiene productos por pagar."]);
				return redirect()->to('/Clientes/tienda');
			}
		}else{
			$this->session->setFlashdata('error', ['tipo' => 'sesion', 'error' => "Inicie sesión por favor."]);
			return redirect()->to('/Clientes');
		}
	}

	public function registrar_cliente()
	{
		if ($this->session->get('region')) {
			$data = [
				'nombre' => ['label' => 'Nombre', 'rules' => 'required'],
				'apellido' => ['label' => 'Apellido', 'rules' => 'required'],
				'correo' => ['label' => 'Correo', 'rules' => 'required|is_unique[login.correo]'],
				'telefono' => ['label' => 'Teléfono', 'rules' => 'required'],
				'pass' => ['label' => 'Contraseña', 'rules' => 'required'],
				'fecha_nacimiento' => ['label' => 'Fecha de nacimiento', 'rules' => 'required']
			];
			if (!$this->validate($data)) { //si algo sale mal en el form
				$this->session->setFlashdata('error', ['tipo' => 'nuevo', 'error' => $this->validator->listErrors()]);
				return $this->mostrar_inicio();
			}
			$Login_model = model('App\Models\Login_model', false);
			$Usuarios_model = model('App\Models\Usuarios_model', false);
			$post = $this->request->getVar(null, FILTER_SANITIZE_STRING);

			$opciones = ['cost' => 11,];
			$pass = password_hash(strip_tags($post['pass']), PASSWORD_BCRYPT, $opciones);
			$hash = md5(rand(0, 1000));

			$data_user = [
				'nombre' => $post['nombre'],
				'apellidos' => $post['apellido'],
				'correo' => $post['correo'],
				'pass' => $pass,
				'fecha_nacimiento' => $post['fecha_nacimiento'],
				'telefono' => $post['telefono'],
				'tipo_usuario' => 3,
				'pais' => $this->session->get('region'),
			];
			$Usuarios_model->insert($data_user);

			$data_login = [
				'nombre' => $post['nombre'],
				'apellidos'=> $post['apellido'],
				'correo' => $post['correo'],
				'pass' => $pass,
				'telefono' => $post['telefono'],
				'tipo_usuario' => 3,
				'estado' => 0,
				'fk_usuario' => $Usuarios_model->getInsertID(),
				'pais' => $this->session->get('region'),
				'token_v' => $hash,
				'estado' => 0,
			];
			$Login_model->insert($data_login);

			$user_id = $Login_model->getInsertID();
			//TODO confirmar correo
			//TODO meter esto en la confirmacion
			$client_openpay = array(
				'client_name' => $post['nombre'],
				'cliente_email' => $data_user['correo'],
				'apellido' => $post['apellido'],
				'telefono' => $post['telefono'],
			);

			$id_client = $this->openpay->add_client($client_openpay);

			$Login_model->set('openpay', $id_client->id);
			$Login_model->where('id_login', $user_id);
			$Login_model->update();
			//fin de la confirmacion

			if(session('region') < 3 || session('region') == 4){
				$this->session->setFlashdata('aviso', 'Su cuenta fue creada exitosamente. Verifique su correo para activar su cuenta. Verifique en su buzón de spam o principal.');
			}
			else{
				$this->session->setFlashdata('alert', 'Your account was created successfully. Check your email to activate your account. Check your spam or main mailbox.');
			}
			$this->confirmacion_email($post['correo'],$hash);
			return redirect()->to('mostrar_inicio');
		}else{
			$this->session->setFlashdata('aviso', 'Por favor seleccione su región o Pais/ Please select your Country or Region');
			return redirect()->to('/Clientes/paises');
		}


	}

	public function confirmacion_email($correo,$hash){
		$email = \Config\Services::email();
	  	$email->setFrom('not_reply@nanko.com.mx', 'Nanko');
	  	//$email->setFrom('behemothbaphomet@gmail.com', 'Nanko');
		$email->setTo($correo);
		if (session('region') == 3 || session('region') == 5){
			$email->setSubject('E-mail confirmation');
			$encabezado = "Dear user. <br> ";
			$cuerpo = "Click on the following link to verify your NankÖ account.<b> </b><br> Click  <a href=\"".base_url().'/Clientes/verify_email/'.$hash.'/'.$correo."\"> here </a> To confirm your account, if the link does not work please copy the following link: <br>".base_url().'/Clientes/verify_email/'.$hash.'/'.$correo;
			$despedida = "<br><br>Thanks  for your attention, this is an automatic email so we ask you not to reply to this email <br> For any questions send email to <a href='mailto:contacto@nanko.com.mx'>contacto@nanko.com.mx</a>";
		}
		if (session('region') < 3 || session('region') == 4){
			$email->setSubject('Confirmacion de correo');
			$encabezado = "Estimado Usuario. <br> ";
			$cuerpo = "De click en el siguiente enlace para verificar tu cuenta de NankÖ.<b> </b><br> Click  <a href=\"".base_url().'/Clientes/verify_email/'.$hash.'/'.$correo."\"> aqui </a> para confirmar su cuenta, si el link no funciona por favor copiar el siguiente enlace: <br>".base_url().'/Clientes/verify_email/'.$hash.'/'.$correo;
			$despedida = "<br><br>Gracias por su atención, este es un correo automático por lo que le pedimos no contestar este email<br>Para cualquier consulta enviar correo a <a href='mailto:contacto@nanko.com.mx'>contacto@nanko.com.mx</a>";
		}
		$email->setMessage($encabezado.$cuerpo.$despedida);
		$email->send();
		return redirect()->to('mostrar_inicio');
	}

	public function verify_email($hash=null,$correo=null){

		$Login_model = model('App\Models\Login_model', false);
		$data_login = $Login_model->where('correo', $correo)
		->first();

		$data['status'] = 2;

		if($data_login){
			if((strcmp($data_login['correo'],$correo) === 0) && (strcmp($data_login['token_v'],$hash ) === 0) && (strcmp($data_login['estado'], '0') === 0)){
				/*echo '<pre>';
				var_dump ((strcmp($data_login['correo'],$correo) === 0));
				var_dump ((strcmp($data_login['token_v'],$hash ) === 0));
				var_dump ((strcmp($data_login['estado'], '0') === 0));
				echo '</pre>';
				Die();*/
				$Login_model->set('estado', 1);
				$Login_model->set('token_v', NULL);
				$Login_model->where('correo', $correo);
				$Login_model->update();
				$data['status'] = 0;
			}else{
				$data['status'] = 1;
			}
		}
		echo view('Cliente/verify_correo',$data);
	}

	public function recuperarpass(){
		$email = \Config\Services::email();
		$hash = md5(rand(0, 1000));

		$Login_model = model('App\Models\Login_model', false);
		$Login_model->set('token_v', $hash);
		$Login_model->where('correo', $_POST['correo']);
		$Login_model->update();
		$data = [
			'correo' => ['label' => 'Correo', 'rules' => 'required']
		];
		$Login_model = model('App\Models\Login_model', false);
		$data_login = $Login_model->where('correo', $_POST['correo'])
		->findAll();
		if ($data_login) {
			$email->setFrom('not_reply@nanko.com.mx', 'Nanko');
			//$email->setFrom('behemothbaphomet@gmail.com', 'Nanko');
			$email->setTo($_POST['correo']);
			if (session('region') == 3 || session('region') == 5){
				$email->setSubject('Nankö password change');
				$encabezado = "Dear user. <br> ";
				$cuerpo = "A password change was requested in your account if it was you, enter the link below to be able to change your password. If it was not you, we recommend that you change your Nankö account password.<br><b> </b><br><a href=\"".base_url().'/Clientes/verifypassview/'.$_POST['correo'].'/'.$hash."\">Click here.</a>, If the link does not work please copy the following link: <br>".base_url().'/Clientes/verifypassview/'.$_POST['correo'].'/'.$hash;
				$despedida = "<br><br> Thank you for your attention, this is an automatic email so we ask you not to reply to this email <br> For any questions send email to <a href='mailto:contacto@nanko.com.mx'>contacto@nanko.com.mx</a>";
			}
			if (session('region') < 3 || session('region') == 4){
				$email->setSubject('Cambio de contraseña Nankö');
				$encabezado = "Estimado Usuario. <br> ";
				$cuerpo = "Se solicito un cambio de contraseña en su cuenta si fue usted, ingrese al enlace de abajo para poder cambiar su contraseña. Si no fue usted le recomendamos cambiar la contraseña de su cuenta  Nankö.<br><b> </b><br><a href=\"".base_url().'/Clientes/verifypassview/'.$_POST['correo'].'/'.$hash."\">Click aqui.</a>, si el link no funciona por favor copiar el siguiente enlace: <br>".base_url().'/Clientes/verifypassview/'.$_POST['correo'].'/'.$hash;
				$despedida = "<br><br>Gracias por su atención, este es un correo automático por lo que le pedimos no contestar este email<br>Para cualquier consulta enviar correo a <a href='mailto:contacto@nanko.com.mx'>contacto@nanko.com.mx</a>";
			}
			$email->setMessage($encabezado.$cuerpo.$despedida);
			if($email->send()){
				if (session('region') == 3 || session('region') == 5){
					$this->session->setFlashdata('aviso', 'Check your email to recover your password. <br> <br> You will receive an email from Nankö with the instructions to recover it. <br> Check your spam or main mailbox.');
				}
				if (session('region') < 3 || session('region') == 4){
					$this->session->setFlashdata('aviso', 'Verifique su correo electronico para recuperar su contraseña.<br> <br>Le llegara un correo de Nankö con las intrucciones para recuperarla.<br>Verifique en su buzón de spam o principal. ');
				}
				return redirect()->to('mostrar_inicio');
			}else{
				if (session('region') == 3 || session('region') == 5){
					$this->session->setFlashdata('aviso', 'Error Verifying your email. <br>');
				}
				if (session('region') < 3 || session('region') == 4){
					$this->session->setFlashdata('aviso', 'Error al Verificar su correo electronico.<br> ');
				}
			return redirect()->to('mostrar_inicio');
			}
		}
		else {
			if (session('region') == 3 || session('region') == 5){
				$this->session->setFlashdata('aviso', 'Error Verifying your email. <br>');
			}
			if (session('region') < 3 || session('region') == 4){
				$this->session->setFlashdata('aviso', 'Error al Verificar su correo electronico.<br> ');
			}
			return redirect()->to('mostrar_inicio');
		}
	}
	public function verifypassview($email=null, $token=null){
		$Login_model = model('App\Models\Login_model', false);

		$data_login = $Login_model->where('correo', $email)
		->first();
		if($data_login){
			if((strcmp($data_login['correo'],$email) === 0) && (strcmp($data_login['token_v'],$token ) === 0)){

				$Login_model->set('token_v', NULL);
				$Login_model->where('correo', $email);
				$Login_model->update();
				$data = array(
					'id' => base64_encode($this->encrypter->encrypt($data_login['id_login'])),
				);
				if (session('region') == 3 || session('region') == 5){
					echo view('Cliente/Cliente_ing/verify_pass', $data);
				}
				if (session('region') < 3 || session('region') == 4){
					echo view('Cliente/verify_pass', $data);
				}
			}else{
				if (session('region') == 3 || session('region') == 5){
					$this->session->setFlashdata('aviso', 'Link expired, please try to retrieve your password again.');
				}
				if (session('region') < 3 || session('region') == 4){
					$this->session->setFlashdata('aviso', 'Enlace caducado vuelva a intentar recuperar su contraseña.');
				}
				return redirect()->to('/Clientes/mostrar_inicio');
			}
		}
	}

	public function verify_pass(){

		$data = [
			'id' => ['label' => 'id', 'rules' => 'required'],
			'password' => ['label' => 'Contraseña', 'rules' => 'required'],
		];

		if (!$this->validate($data)) { //si algo sale mal en el form
			$this->session->setFlashdata('aviso', 'Error de formulario.');
			return $this->mostrar_inicio();
		}
		$Login_model = model('App\Models\Login_model', false);
		$post = $this->request->getVar(null, FILTER_SANITIZE_STRING);
		$data = array('id' => $this->encrypter->decrypt(base64_decode($post['id'])),);
		$opciones = ['cost' => 11,];
		$pass = password_hash(strip_tags($post['password']), PASSWORD_BCRYPT, $opciones);
		$cambiopass = $Login_model->where('id_login', $data['id'])
		->findAll();
		if($cambiopass){
		$Login_model->set('pass', $pass);
		$Login_model->where('id_login', $data['id']);
		$Login_model->update();
		if (session('region') == 3 || session('region') == 5){
			$this->session->setFlashdata('aviso', 'password changed successfully !. <br> you can now log in with your new password.');
		}
		if (session('region') < 3 || session('region') == 4){
			$this->session->setFlashdata('aviso', 'contraseña cambiada con éxito!.<br>ya puede iniciar sesion con su nueva contaseña.');
		}
		return redirect()->to('/Clientes/mostrar_inicio');

		}else{
			if (session('region') == 3 || session('region') == 5){
				$this->session->setFlashdata('aviso', 'Error changing password, try again !.');
			}
			if (session('region') < 3 || session('region') == 4){
				$this->session->setFlashdata('aviso', 'Error al cambiar contraseña, intentelo nuevamente!.');
			}
		}
	}

	public function limpiar_carro()
	{
		$this->session->remove('cart');
		$this->session->setFlashdata('aviso', 'El carrito está vacío.');
		return redirect()->to('/Clientes/tienda');
	}

	public function eliminar_carro(){
		if ($this->request->isAJAX()){
			if ($this->session->get('cart')) {
				$post = $this->request->getVar(null, FILTER_SANITIZE_STRING);

				$productos = $this->session->get('cart');
				$key = array_search($post['id_producto'], array_column($productos, 'id_producto'));
				if ($key !== false) { //eliminar del carrito
					$productos_aux = $productos;
					$productos = array();
					$subtotal = 0;
					foreach ($productos_aux as $obj) {
						if ((strcmp($obj['id_producto'],$post['id_producto']) !== 0) ) {
							$subtotal += $obj['precio'] * $obj['cantidad'];
							$productos[] = $obj;
						}
					}

					$this->session->set('cart', $productos);
					$respuesta=array(
						"bandera" => 1,
						"respuesta" => "El carrito fue actualizado con éxito.",
						"subtotal" => $subtotal,
						"descuento" => 0
					);

					if (isset($this->session->get('usuario')['descuento'])) {
						$respuesta['subtotal'] = $subtotal * (1 - $this->session->get('usuario')['descuento'] / 100);
						$respuesta['descuento'] = $subtotal * ($this->session->get('usuario')['descuento'] / 100);
					}

					echo json_encode($respuesta);

				}
			}else{
				$respuesta = array(
					'bandera' => 0,
					'respuesta' => "El carrito aún o fue creado"
				);
				echo json_encode($respuesta);
			}
		}
	}

	public function eliminar_orden()
    {
		if ($this->request->isAJAX()){
            $Orden_model = model('App\Models\Orden_model', false);

			$post = $this->request->getVar(null, FILTER_SANITIZE_STRING);
            $id_orden = $post['id_orden'];

            $orden = $Orden_model->find($id_orden);
            if ($orden) {
                $Orden_model->set('estado', 0);
                $Orden_model->where('id_orden', $id_orden);
                $Orden_model->update();

				$respuesta = array(
					'bandera' => 1,
					'mensaje' => "La orden fue correctamente cancelada."
				);

                echo json_encode($respuesta);
            }
        }
    }

	public function nueva_dosis()
	{
		$data = [
			'edad' => ['label' => 'Edad', 'rules' => 'required'],
			'peso' => ['label' => 'Peso', 'rules' => 'required'],
			'dosis' => ['label' => 'Dosis', 'rules' => 'required|valid_base64']
		];
		if (!$this->validate($data)) { //si algo sale mal en el form
			$this->session->setFlashdata('error', ['tipo' => 'nuevo', 'error' => $this->validator->listErrors()]);
			return $this->dosis();
		}

		$Dosis_User_model = model('App\Models\Dosis_User_model', false);

		$post = $this->request->getVar(null, FILTER_SANITIZE_STRING);
		$id_dosis = $this->encrypter->decrypt(base64_decode($post['dosis']));
		$data = [
			'id_usuario' => $this->session->get('usuario')['id_login'],
			'id_dosis' => $id_dosis,
			'edad' => $post['edad'],
			'peso' => $post['peso']
		];

		$Dosis_User_model->insert($data);
		$this->session->setFlashdata('aviso', 'La dosis fue guardada exitosamente.');
		return redirect()->to('dosis');
	}

	public function guardar_dosis()
	{
		if ($this->request->isAJAX()) {
			if ($this->session->get('usuario')) {
				$Dosis_User_model = model('App\Models\Dosis_User_model', false);
				$post = $this->request->getVar(null, FILTER_SANITIZE_STRING);
				$id_dosis = $this->encrypter->decrypt(base64_decode($post['id_dosis']));

				$data = array(
					'id_dosis' => $id_dosis,
					'id_usuario' => $this->session->get('usuario')['id_login'],
					'edad' => $post['edad'],
					'peso' => $post['peso']
				);

				$Dosis_User_model->insert($data);
				$this->session->setFlashdata('aviso', 'La dosis fue guardada exitosamente.');
				$respuesta = array(
					'bandera' => 1,
					'mensaje' => "Dosis correctamente guardada."
				);
			} else {
				$respuesta = array(
					'bandera' => 0,
					'mensaje' => "Para guardar una dosis debe iniciar sesión"
				);
			}
			echo json_encode($respuesta);
		}
	}

	public function calcular_dosis_ing()
	{
		if ($this->request->isAJAX()) {
			$Dosis_model = model('App\Models\Dosis_model', false);
			$Padecimientos_model = model('App\Models\Padecimientos_model', false);
			$Producto_model = model('App\Models\Producto_model', false);
			$post = $this->request->getVar(null, FILTER_SANITIZE_STRING);
			$id_padecimiento = $this->encrypter->decrypt(base64_decode($post['padecimiento']));
			$padecimiento = $Padecimientos_model->find($id_padecimiento);
			$data = null;
			if ($padecimiento) {
				$dosis_aux = $Dosis_model->where("estado = 1 AND padecimientos LIKE '%:".$padecimiento['idPadecimiento'].":%' AND (edad_min <= " . $post['edad'] . " AND edad_max >= " . $post['edad'] . ") AND (peso_min <= " . $post['peso'] . " AND peso_max >= " . $post['peso'] . ")")->find();
				$dosis = array();

				if ($dosis_aux) {
					foreach ($dosis_aux as $obj) {
						$subir = "";
						if ($obj['subir_1']) {
							$subir = "Upload 1 drop after two weeks";
						} elseif ($obj['subir_2']) {
							$subir = "Up 2 drop after two weeks";
						}

						$producto = $Producto_model->find($obj['id_producto']);

						$resultado = "";

						if ($obj['resultado_m'] != null) {
							$resultado .= $obj['resultado_m']." drops in the morning, ";
						}
						if ($obj['resultado_t'] != null) {
							$resultado .= $obj['resultado_t']." drops in the afternoon, ";
						}
						if ($obj['resultado_n'] != null) {
							$resultado .= $obj['resultado_n']." drops at night";
						}
						$dosis[]=array(
							'dosis' => base64_encode($this->encrypter->encrypt($obj['id_dosis'])),
							'producto' => $producto['nombre_ing'],
							'img' => $producto['img_port'],
							'resultado' => $resultado,
							'subir' => $subir
						);
					}
					$data_modal=array(
						'dosis' => $dosis
					);

					$data = array(
						'bandera' => 1,
						'modal' => view('Cliente/Cliente_ing/Modales_ing/ver_dosis',$data_modal)
					);
				} else {
					$data = array(
						'bandera' => 0,
						'mensaje' => "There is no dosage for your weight / age."
					);
				}
			}else{
				$data = array(
					'bandera' => 0,
					'mensaje' => "Condition not available"
				);
			}
			return json_encode($data);
		}
	}

	public function calcular_dosis()
	{
		if ($this->request->isAJAX()) {
			$Dosis_model = model('App\Models\Dosis_model', false);
			$Padecimientos_model = model('App\Models\Padecimientos_model', false);
			$Producto_model = model('App\Models\Producto_model', false);
			$post = $this->request->getVar(null, FILTER_SANITIZE_STRING);
			$id_padecimiento = $this->encrypter->decrypt(base64_decode($post['padecimiento']));
			$padecimiento = $Padecimientos_model->find($id_padecimiento);
			$data = null;
			if ($padecimiento) {
				$dosis_aux = $Dosis_model->where("estado = 1 AND padecimientos LIKE '%:".$padecimiento['idPadecimiento'].":%' AND (edad_min <= " . $post['edad'] . " AND edad_max >= " . $post['edad'] . ") AND (peso_min <= " . $post['peso'] . " AND peso_max >= " . $post['peso'] . ")")->find();
				$dosis = array();

				if ($dosis_aux) {
					foreach ($dosis_aux as $obj) {
						$subir = "";
						if ($obj['subir_1']) {
							$subir = "Subir 1 gota pasadas dos semanas";
						} elseif ($obj['subir_2']) {
							$subir = "Subir 2 gota pasadas dos semanas";
						}

						$producto = $Producto_model->find($obj['id_producto']);

						$resultado = "";

						if ($obj['resultado_m'] != null) {
							$resultado .= $obj['resultado_m']." gotas en la mañana, ";
						}
						if ($obj['resultado_t'] != null) {
							$resultado .= $obj['resultado_t']." gotas en la tarde, ";
						}
						if ($obj['resultado_n'] != null) {
							$resultado .= $obj['resultado_n']." gotas en la noche";
						}
						$dosis[]=array(
							'dosis' => base64_encode($this->encrypter->encrypt($obj['id_dosis'])),
							'producto' => $producto['nombre'],
							'img' => $producto['img_port'],
							'resultado' => $resultado,
							'subir' => $subir
						);
					}
					$data_modal=array(
						'dosis' => $dosis
					);

					$data = array(
						'bandera' => 1,
						'modal' => view('Cliente/Modales/ver_dosis',$data_modal)
					);
				} else {
					$data = array(
						'bandera' => 0,
						'mensaje' => "No existe una dosis para tu peso/edad."
					);
				}
			}else{
				$data = array(
					'bandera' => 0,
					'mensaje' => "Padecimiento no disponible"
				);
			}
			return json_encode($data);
		}
	}

	public function dosis()
	{
		$dosis_array = array();
		$Padecimientos_model = model('App\Models\Padecimientos_model', false);
		$Producto_model = model('App\Models\Producto_model', false);
		if ($this->session->get('usuario')) {
			$Dosis_model = model('App\Models\Dosis_model', false);
			$Dosis_User_model = model('App\Models\Dosis_User_model', false);

			$dosis_aux = $Dosis_User_model->where('id_usuario', $this->session->get('usuario')['id_login'])
				->findAll();
			foreach ($dosis_aux as $obj) {
				$dosis = $Dosis_model->find($obj['id_dosis']);
				$resultado = "";
				if ($dosis['subir_1']) {
					$creada = strtotime(date($obj['fecha'], strtotime('+1 weeks')));
					$sistema = strtotime(date('Y-m-d H:i:s'));

					if ($creada < $sistema) {
						if ($dosis['resultado_m']) {
							$resultado .= $dosis['resultado_m']." gotas en la mañana, ";
						}
						if ($dosis['resultado_t']) {
							$resultado .= $dosis['resultado_t']." gotas en la tarde, ";
						}
						if ($dosis['resultado_n']) {
							$resultado .= $dosis['resultado_n']." gotas en la noche";
						}
					}
				} elseif ($dosis['subir_2']) {
					$creada = strtotime(date($obj['fecha'], strtotime('+2 weeks')));
					$sistema = strtotime(date('Y-m-d H:i:s'));

					if ($creada < $sistema) {
						if ($dosis['resultado_m']) {
							$resultado .= $dosis['resultado_m']." gotas en la mañana, ";
						}
						if ($dosis['resultado_t']) {
							$resultado .= $dosis['resultado_t']." gotas en la tarde, ";
						}
						if ($dosis['resultado_n']) {
							$resultado .= $dosis['resultado_n']." gotas en la noche";
						}
					}
				}

				$dosis_array[] = array(
					'producto' => $Producto_model->find($dosis['id_producto'])['nombre'],
					'fecha' => strftime("%d/%B/%Y", strtotime($obj['fecha'])),
					'edad' => $obj['edad'],
					'peso' => $obj['peso'],
					'resultado' => $resultado
				);
			}
		}

		//$padecimientos_aux = $Padecimientos_model->where("idProducto in (select id_producto from dosis where estado = 1 group by id_producto)")->findAll();
		$padecimientos_aux = $Padecimientos_model->where("estado = 1")->findAll();
		if (session('region') == 3 || session('region') == 5){
				$padecimientos = array('0' => 'Select the condition');
		}
		if (session('region') < 3 || session('region') == 4){
				$padecimientos = array('0' => 'Seleccione el padecimiento');
		}
		if ($padecimientos_aux) {
			foreach ($padecimientos_aux as $obj) {
				$padecimientos[base64_encode($this->encrypter->encrypt($obj['idPadecimiento']))] = $obj['nombre_p'];
			}
		}

		$data = array(
			'dosis' => $dosis_array,
			'padecimientos' => $padecimientos,
		);
		echo view('Cliente/Dosis', $data);
	}

	public function get_colaboradores(){
		if ($this->request->isAJAX()){
            $Colaboradores_model = model('App\Models\Colaboradores_model', false);
			$post = $this->request->getVar(null, FILTER_SANITIZE_STRING);

			$colaboradores_aux = $Colaboradores_model->where("estado = 1 AND estado_p = '".$post['estado']."'")->findAll();
			$colaboradores = array();
			if ($colaboradores_aux) {
				foreach ($colaboradores_aux as $obj) {
					$colaboradores[] = array(
						'nombre' => $obj['nombre'],
						'telefono' => $obj['telefono'],
						'correo' => $obj['correo_n']
					);
				}
			}

			$respuesta = array(
				'bandera' => 1,
				'colaboradores' => $colaboradores
			);
			echo json_encode($respuesta);
		}
	}

	public function entrada($entrada = null){
		if ($entrada == null) {
			$this->session->setFlashdata('aviso', 'La entrada no es válida.');
			return redirect()->to('blog');
		}
		$Blog_model = model('App\Models\Blog_model', false);
		$entrada_aux = $Blog_model->find(base64_decode(strip_tags($entrada)));
		$entrada = array();
		if ($entrada_aux) {
			$entrada = array(
				'titulo' => $entrada_aux['titulo'],
				'contenido' => $entrada_aux['contenido'],
				'descripcion' => $entrada_aux['descripcion'],
				'img' => $entrada_aux['img_portada'],
				'fecha' => strftime("%d/%B/%Y", strtotime($entrada_aux['fecha'])),
			);
			$data = array(
				'entrada' => $entrada,
			);
			echo view('Cliente/Entrada',$data);
		}
	}

	public function blog()
	{
		$pager = \Config\Services::pager();

		$Blog_model = model('App\Models\Blog_model', false);
		$entradas_aux = $Blog_model->where("estado = 1")->orderBy("fecha",'ASC')->paginate(9);
		$entradas = array();
		if ($entradas_aux) {
			foreach ($entradas_aux as $obj) {
				$entradas[] = array(
					'id_blog' => base64_encode($obj['id_blog']),
					'titulo' => $obj['titulo'],
					'descripcion' => $obj['descripcion'],
					'img' => $obj['img_portada'],
					'fecha' => strftime("%d/%B/%Y", strtotime($obj['fecha'])),
				);
			}
		}
		$data = array(
			'entradas' => $entradas,
			'pager' => $Blog_model->pager
		 );
		echo view('Cliente/Blog',$data);
	}

	public function producto($id_producto = null)
	{
		if ($this->session->get('region')) {
			if ($id_producto == null) {
				$this->session->setFlashdata('aviso', 'El producto no es válido.');
				return redirect()->to('tienda');
			}
			$Categoria_model = model('App\Models\Categoria_model', false);
			$Producto_model = model('App\Models\Producto_model', false);
			$Padecimientos_model = model('App\Models\Padecimientos_model', false);
			$producto_aux = $Producto_model->Where("idProducto = ".base64_decode(strip_tags($id_producto))." AND regiones LIKE '%".$this->session->get('region')."%'")->first();
			$producto = array();
			if ($producto_aux) {
				$categoria = $Categoria_model->find($producto_aux['idCategoria']);
				$producto = array(
					'id_producto' => base64_encode($producto_aux['idProducto']),
					'nombre' => $producto_aux['nombre'],
					'categoria' => array('nombre' => $categoria['nombre'], 'id_categoria' => base64_encode($categoria['id_categoria'])),
					'categoria_ing' => array('nombre_ing' => $categoria['nombre_ing'], 'id_categoria' => base64_encode($categoria['id_categoria'])),
					'descripcion' => $producto_aux['descripcion'],
					'descripcion_ingles' => $producto_aux['descripcion_ingles'],
					'stock' => $producto_aux['stock'],
					'disp' => ($producto_aux['stock'] > 0)?1:0,
					'img' => $producto_aux['img_port'],
					'img_sec' => ($producto_aux['img_sec']) ? explode(":", $producto_aux['img_sec']):null
				);

				switch ($this->session->get('region')) {
					case 1: //Mexico
						$producto['precio'] = "$".$producto_aux['precio_1'];
						$producto['nombre'] = $producto_aux['nombre'];
						break;
					case 2: //Peru
						$producto['precio'] = "S/".$producto_aux['precio_2'];
						$producto['nombre'] = $producto_aux['nombre'];
						break;
					case 3: //Europa
						$producto['precio'] = $producto_aux['precio_3']."&#x20AC;";
						$producto['nombre'] = $producto_aux['nombre_ing'];
						break;
					case 4: //Argentina
						$producto['precio'] = "$".$producto_aux['precio_4'];
						$producto['nombre'] = $producto_aux['nombre'];
						break;
					case 5: //Resto del mundo
						$producto['precio'] = "US$".$producto_aux['precio_5'];
						$producto['nombre'] = $producto_aux['nombre_ing'];
						break;
					default:
						break;
				}

				$productos_aux = $Producto_model->where("estado = 1 AND regiones LIKE '%".$this->session->get('region')."%'")->orderBy("RAND()")
					->findAll(3);
				$productos = array();
				if ($productos_aux) {
					$i=0;
					foreach ($productos_aux as $obj) {

						$padecimientos_prod_aux = $Padecimientos_model->where("id_producto = ".$obj['idProducto'])->findAll();
						$padecimientos_prod = array();
						foreach ($padecimientos_prod_aux as $pad) {
							$padecimientos_prod[] = array(
								'nombre' => $pad['nombre_p']
							);
						}

						$productos[] = array(
							'id_producto' => base64_encode($obj['idProducto']),
							// 'nombre' => $obj['nombre'],
							'descripcion' => $obj['descripcion'],
							'descripcion_ingles' => $obj['descripcion_ingles'],
							'img' => $obj['img_port'],
							'disp' => ($obj['stock'] > 0)?1:0,
							'padecimientos' => $padecimientos_prod
						);

						switch ($this->session->get('region')) {
							case 1: //Mexico
								$productos[$i]['precio'] = "$".$obj['precio_1'];
								$productos[$i++]['nombre'] = $obj['nombre'];
								break;
							case 2: //Peru
								$productos[$i]['precio'] = "S/".$obj['precio_2'];
								$productos[$i++]['nombre'] = $obj['nombre'];
								break;
							case 3: //Europa
								$productos[$i]['precio'] = $obj['precio_3']."&#x20AC;";
								$productos[$i++]['nombre'] = $obj['nombre_ing'];
								break;
							case 4: //Argentina
								$productos[$i]['precio'] = "$".$obj['precio_4'];
								$productos[$i++]['nombre'] = $obj['nombre'];
								break;
							case 5: //Resto del mundo
								$productos[$i]['precio'] = "US$".$obj['precio_5'];
								$productos[$i++]['nombre'] = $obj['nombre_ing'];
								break;
							default:
								break;
						}

					}
				}

				$data = array(
					'producto' => $producto,
					'productos' => $productos,
				);
				echo view('Cliente/Producto', $data);
			} else {
				$this->session->setFlashdata('aviso', 'El producto no existe o no está disponible en tu región.');
				return redirect()->to('tienda');
			}
		}else{
			$this->session->setFlashdata('aviso', 'Por favor seleccione su región o Pais/ Please select your Country or Region');
			return redirect()->to('/Clientes/paises');
		}
	}

	public function tienda($id_categoria = null)
	{
		if ($this->session->get('region')) {
			$pager = \Config\Services::pager();

			$Producto_model = model('App\Models\Producto_model', false);
			$Categoria_model = model('App\Models\Categoria_model', false);
			$Padecimientos_model = model('App\Models\Padecimientos_model', false);
			if ($id_categoria) {
				$id_categoria_aux = base64_decode($id_categoria);
				$productos_aux = $Producto_model->where("estado = 1 AND idCategoria = $id_categoria_aux AND regiones LIKE '%".$this->session->get('region')."%'")->paginate(9);
			}else{
				$productos_aux = $Producto_model->where("estado = 1 AND regiones LIKE '%".$this->session->get('region')."%'")->paginate(9);
			}
			$productos = array();
			if ($productos_aux) {
				$i = 0;
				foreach ($productos_aux as $obj) {
					$categoria = $Categoria_model->find($obj['idCategoria']);

					$padecimientos_prod_aux = $Padecimientos_model->where("id_producto = ".$obj['idProducto'])->findAll();
					$padecimientos_prod = array();
					foreach ($padecimientos_prod_aux as $pad) {
						$padecimientos_prod[] = array(
							'nombre' => $pad['nombre_p']
						);
					}
					$productos[] = array(
						'id_producto' => base64_encode($obj['idProducto']),
						// 'nombre' => $obj['nombre'],
						'categoria' => array('nombre' => $categoria['nombre'], 'id_categoria' => base64_encode($categoria['id_categoria'])),
						'categoria_ing' => array('nombre_ing' => $categoria['nombre_ing'], 'id_categoria' => base64_encode($categoria['id_categoria'])),
						'descripcion' => $obj['descripcion'],
						'descripcion_ingles' => $obj['descripcion_ingles'],
						'img' => $obj['img_port'],
						'disp' => ($obj['stock'] > 0)?1:0,
						'padecimientos' => $padecimientos_prod
						// 'precio' => $obj['precio_1']
					);
					switch ($this->session->get('region')) {
						case 1: //Mexico
							$productos[$i]['precio'] = "$".$obj['precio_1'];
							$productos[$i++]['nombre'] = $obj['nombre'];
							break;
						case 2: //Peru
							$productos[$i]['precio'] = "S/".$obj['precio_2'];
							$productos[$i++]['nombre'] = $obj['nombre'];
							break;
						case 3: //Europa
							$productos[$i]['precio'] = $obj['precio_3']."&#x20AC;";
							$productos[$i++]['nombre'] = $obj['nombre_ing'];
							break;
						case 4: //Argentina
							$productos[$i]['precio'] = "$".$obj['precio_4'];
							$productos[$i++]['nombre'] = $obj['nombre'];
							break;
						case 5: //Resto del mundo
							$productos[$i]['precio'] = "US$".$obj['precio_5'];
							$productos[$i++]['nombre'] = $obj['nombre_ing'];
							break;
						default:
							break;
					}
				}
			}

			$categorias_aux = $Categoria_model->findAll();
			$categorias = array();
			foreach ($categorias_aux as $obj) {
				$categorias[] = array(
					'id_categoria' => base64_encode($obj['id_categoria']),
					'nombre' => $obj['nombre'],
					'nombre_ing' => $obj['nombre_ing']
				);
			}
			$data = array(
				'categoria' => $id_categoria,
				'productos' => $productos,
				'categorias' => $categorias,
				'pager' => $Producto_model->pager
			);
			echo view('Cliente/Tienda', $data);
		}else{
			$this->session->setFlashdata('aviso', 'Por favor seleccione su región o Pais/ Please select your Country or Region');
			return redirect()->to('/Clientes/paises');
		}
	}

	public function seleccionar_region($region=null)
	{
		$this->session->set('region', $region);
		return redirect()->to('/Clientes');
	}

	public function Paises()
	{
		echo view('Cliente/Paises');
	}
	public function privacidad()
	{
		echo view('Cliente/Privacidad');
	}
	public function privacidadi()
	{
		echo view('Cliente/Cliente_ing/Privacidad');
	}
	public function envios_devolucion()
	{
		echo view('Cliente/envios_devolucion');
	}
}
