<?php

namespace App\Controllers;

class Envios extends BaseController
{
	public function __construct()
	{
		header('X-Content-Type-Options:nosniff');
		header('X-Frame-Options:SAMEORIGIN');
		header('X-XSS-Protection:1;mode=block');
		helper('url');
		helper('form');
		lang('Test.longTime', [time()], 'es');
	}

	public function index(){
        //TODO: poner validaciones para que solo entren los administrativos
		$this->mostrar_ordenes();
    }

    public function ver_productos()
    {
        if ($this->request->isAJAX()){
            $Orden_model = model('App\Models\Orden_model', false);
            $Orden_Prod_model = model('App\Models\Orden_Prod_model', false);
            $Producto_model = model('App\Models\Producto_model', false);
            $Login_model = model('App\Models\Login_model', false);
            $Direccion_model = model('App\Models\Direccion_model', false);

            $post = $this->request->getVar(null, FILTER_SANITIZE_STRING);
            $orden = $Orden_model->find($post['id_orden']);
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
												'cantidad' => $obj['cantidad'],
                        'peso' => $producto['peso']
                    );
                }
            }
            $data = array(
                'productos' => $productos,
                'cliente' => $cliente,
                'orden' => $orden,
                'direccion' => $Direccion_model->find($orden['id_direccion'])
            );
            echo view('Administrador/Modal/ver_productos',$data);
        }

    }

    public function cancelar_orden()
    {
		if ($this->request->isAJAX()){
            $Orden_model = model('App\Models\Orden_model', false);
            $Colaboradores_model = model('App\Models\Colaboradores_model', false);
            $Login_model = model('App\Models\Login_model', false);

			$post = $this->request->getVar(null, FILTER_SANITIZE_STRING);
            $id_orden = $post['id_orden'];

            $orden = $Orden_model->find($id_orden);
            if ($orden) {
                $usuario = $Login_model->find($orden['id_usuario']);

                $Orden_model->set('estado', 0);
                $Orden_model->where('id_orden', $id_orden);
                $Orden_model->update();

                            //envio de correo
                //Establecemos esta configuración
                $email = \Config\Services::email();

                $email->setFrom('not_reply@nanko.com.mx', 'Nanko');
                //colaborador
                if ($usuario['tipo_usuario'] == 2) {
                    $colaborador = $Colaboradores_model->find($usuario['fk_usuario']);
                    $more_email = array(
                        $usuario['correo'],
                        $colaborador['correo_p']
                    );
                    $email->setTo($more_email);
                } else {
                    $email->setTo($usuario['correo']);
                }
                $email->setSubject('Su orden fue cancelada');
                $encabezado = "Estimado. ".$usuario['nombre'].".<br> ";
                $cuerpo = "Le informamos que su orden fue cancelada, si usted realizó un pago, su reembolzo está en proceso.</b><br>";
                $despedida = "<br><br>Gracias, por su atención. Este es un correo automático, por lo que le pedimos no contestar este e-mail<br>Para cualquier consulta enviar correo a <a href='mailto:contacto@nanko.com.mx'>contacto@nanko.com.mx</a>.";
                $email->setMessage($encabezado.$cuerpo.$despedida);
                if($email->send()){
                    $respuesta = array(
                        'bandera' => 1,
                        'mensaje' => "La orden fue correctamente cancelada, no olvide realizar el reembolzo en caso de que tenga pago."
                    );
                }else{
                    $respuesta = array(
                        'bandera' => 0,
                        'mensaje' => $email->printDebugger()
                    );
                }
                echo json_encode($respuesta);
            }
        }
    }

    public function finalizar_orden()
    {
		if ($this->request->isAJAX()){
			$Orden_model = model('App\Models\Orden_model', false);
			$post = $this->request->getVar(null, FILTER_SANITIZE_STRING);
            $id_orden = $post['id_orden'];

            $Orden_model->set('estado', 4);
			$Orden_model->where('id_orden', $id_orden);
			$Orden_model->update();
			echo 1;
        }
    }

    public function aceptar_orden(){
		if ($this->request->isAJAX()){
			$Orden_model = model('App\Models\Orden_model', false);
			$Colaboradores_model = model('App\Models\Colaboradores_model', false);
			$Orden_Prod_model = model('App\Models\Orden_Prod_model', false);
            $Producto_model = model('App\Models\Producto_model', false);
            $Login_model = model('App\Models\Login_model', false);

			$post = $this->request->getVar(null, FILTER_SANITIZE_STRING);
            $id_orden = $post['id_orden'];
            $orden = $Orden_model->find($id_orden);
            if ($orden['estado_pago'] != "completed") {
                $respuesta = array(
                    'bandera' => 0,
                    'mensaje' => "Antes se tiene que acreditar el pago"
                );
            }else{
                $productos = $Orden_Prod_model->Where('id_orden',$id_orden)->findAll();

                //revisar disponibilidad de productos
                foreach ($productos as $obj) {
                    $producto = $Producto_model->find($obj['id_producto']);
                    if ($producto['stock'] < $obj['cantidad']) {
                        $respuesta = array(
                            'bandera' => 0,
                            'mensaje' => "No hay disponibilidad del producto: ".$producto['nombre']
                        );
                        echo json_encode($respuesta);
                        return;
                    }
                }

                $Orden_model->set('estado', 2);
                $Orden_model->where('id_orden', $id_orden);
                $Orden_model->update();

                foreach ($productos as $obj) {
                    $Producto_model->set('stock', 'stock - '.$obj['cantidad'],false); //TODO: validar las cantidades
                    $Producto_model->set('cantidad_vendida', 'cantidad_vendida + '.$obj['cantidad'],false); //TODO: validar las cantidades
                    $Producto_model->where('idProducto', $obj['id_producto']);
                    $Producto_model->update();
                }

                $usuario = $Login_model->find($orden['id_usuario']);
                //envio de correo
                //Establecemos esta configuración
                $email = \Config\Services::email();

                $email->setFrom('not_reply@nanko.com.mx', 'Nanko');
                //colaborador
                if ($usuario['tipo_usuario'] == 2) {
                    $colaborador = $Colaboradores_model->find($usuario['fk_usuario']);
                    $more_email = array(
                        $usuario['correo'],
                        $colaborador['correo_p']
                    );
                    $email->setTo($more_email);
                } else {
                    $email->setTo($usuario['correo']);
                }
                $email->setSubject('Su orden fue confirmada');
                $encabezado = "Estimado. ".$usuario['nombre'].".<br> ";
                $cuerpo = "Le informamos que su pago ha sido aceptado y su orden confirmada.<br>";
                $despedida = "<br><br>Gracias, por su atención. Este es un correo automático, por lo que le pedimos no contestar este e-mail<br>Para cualquier consulta enviar correo a <a href='mailto:contacto@nanko.com.mx'>contacto@nanko.com.mx</a>.";
                $email->setMessage($encabezado.$cuerpo.$despedida);
                if($email->send()){
                    $respuesta = array(
                        'bandera' => 1,
                        'mensaje' => "La orden fue aceptada y el cliente fue notificado."
                    );
                }else{
                    $respuesta = array(
                        'bandera' => 0,
                        'mensaje' => $email->printDebugger()
                    );
                }
            }
            echo json_encode($respuesta);
		}
    }

    public function enviar_guia(){
        if ($this->request->isAJAX()){
            $Orden_model = model('App\Models\Orden_model', false);
            $Login_model = model('App\Models\Login_model', false);
            $Colaboradores_model = model('App\Models\Colaboradores_model', false);
            $post = $this->request->getVar(null, FILTER_SANITIZE_STRING);
            $id_orden = $post['id'];
            $orden = $Orden_model->find($id_orden);
            if ($orden) {
                $usuario = $Login_model->find($orden['id_usuario']);

                $Orden_model->set('num_guia',$post['numero']);
                $Orden_model->set('estado',3);
                $Orden_model->where('id_orden', $id_orden);
                $Orden_model->update();

                //envio de correo
                //Establecemos esta configuración
                $email = \Config\Services::email();

                $email->setFrom('not_reply@nanko.com.mx', 'Nanko');
                //colaborador
                if ($usuario['tipo_usuario'] == 2) {
                    $colaborador = $Colaboradores_model->find($usuario['fk_usuario']);
                    $more_email = array(
                        $usuario['correo'],
                        $colaborador['correo_p']
                    );
                    $email->setTo($more_email);
                } else {
                    $email->setTo($usuario['correo']);
                }
                $email->setSubject('Su paquete fue enviado');
                $encabezado = "Estimado. ".$usuario['nombre'].".<br> ";
                $cuerpo = "Le informamos que su paquete fue enviado con el siguiente número de guia: <b>".$post['numero']."</b><br>Puede realizar su seguimiento del paquete dando clic <a href=\"https://www.dhl.com/mx-es/home/rastreo.html\" target=\"_blank\">aquí</a>";
                $despedida = "<br><br>Gracias, por su atención. Este es un correo automático, por lo que le pedimos no contestar este email<br>Para cualquier consulta enviar correo a <a href='mailto:contacto@nanko.com.mx'>contacto@nanko.com.mx</a>";
                $email->setMessage($encabezado.$cuerpo.$despedida);
                if($email->send()){
                    $respuesta = array(
                        'bandera' => 1,
                        'mensaje' => "La guia fue correctamente enviada al cliente."
                    );
                }else{
                    $respuesta = array(
                        'bandera' => 0,
                        'mensaje' => $email->printDebugger()
                    );
                }

                echo json_encode($respuesta);
            }
        }
    }

    public function mostrar_ordenes(){
        $Orden_model = model('App\Models\Orden_model', false);
        $Login_model = model('App\Models\Login_model', false);

        $ordenes_aux = $Orden_model->findAll();
        $ordenes = array();
        if ($ordenes_aux) {
            foreach ($ordenes_aux as $obj) {
                $cliente = $Login_model->find($obj['id_usuario']);

                $estado = "";
                $tipo = "";
                $tipo_pago = "";
                switch ($cliente['tipo_usuario']) {
                    case 2:
                        $tipo = "Colaborador";
                        break;
                    case 3:
                        $tipo = "Cliente";
                        break;

                    default:
                        $tipo = "Adminsitrativo";
                        break;
                }

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

                switch ($obj['tipo_pago']) {
                    case 1:
						$tipo_pago = "Tarjeta";
						break;
					case 2:
						$tipo_pago = "Tienda";
						break;
					default:
						break;
                }

                $ordenes[] = array(
                    'id_orden' => $obj['id_orden'],
                    'cliente' => $cliente['nombre']." ".$cliente['apellidos'],
                    'tipo' => $tipo,
                    'fecha' => strftime("%d/%B/%Y", strtotime($obj['fecha'])),
                    'precio' => '$'.$obj['precio_total'], //TODO revisar moneda por región
                    'precio_envio' => '$'.$obj['precio_envio'], //TODO revisar moneda por región
                    'estado' => $estado,
                    'tipo_pago' => $tipo_pago,
                    'id_openpay' => $obj['id_pago'],
                    'estado_pago' => $obj['estado_pago']
                );
            }
        }

        $data = array(
            'ordenes' => $ordenes,
        );
        echo view('Administrador/mostrar_ordenes',$data);
    }
}
