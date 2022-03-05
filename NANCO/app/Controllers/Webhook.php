<?php

namespace App\Controllers;

class Webhook extends BaseController
{
	public function __construct()
	{
		// header('X-Content-Type-Options:nosniff');
		// header('X-Frame-Options:SAMEORIGIN');
		// header('X-XSS-Protection:1;mode=block');
    }

    public function index()
	{
			$data = json_decode(file_get_contents('php://input'), true);
			$Config_model = model('App\Models\Config_model', false);
			$array = array(
					'nombre' => "operacion",
					'descr' => json_encode($data)
			);
			$Config_model->insert($array);

	        switch ($data['type']) {
            case 'verification':
                $this->configurar($data);
								$this->response->setStatusCode(200, 'Ok');
                break;
            case 'charge.created':
                $this->pago($data);
								$this->response->setStatusCode(200, 'Ok');
								break;
            case 'charge.succeeded':
								$this->pago($data);
								$this->response->setStatusCode(200, 'Ok');
                break;
            case 'charge.refunded':
                $this->pago($data);
								$this->response->setStatusCode(200, 'Ok');
                break;
            case 'payout.created':
                $this->pago($data);
								$this->response->setStatusCode(200, 'Ok');
                break;
            case 'payout.succeeded':
                $this->pago($data);
								$this->response->setStatusCode(200, 'Ok');
                break;
            case 'payout.failed':
                $this->pago($data);
								$this->response->setStatusCode(200, 'Ok');
                break;
            default:
								$this->pago($data);
                $this->response->setStatusCode(200, 'Ok');
                break;
        }
    }

    public function pago($data)
    {
        $Orden_model = model('App\Models\Orden_model', false);

        $Orden_model->set('estado_pago', $data['transaction']['status']);
        $Orden_model->where('id_pago', $data['transaction']['id']);
        $Orden_model->update();
        return 1;
    }

    public function configurar($data)
    {
        $Config_model = model('App\Models\Config_model', false);
        $data = array(
            'nombre' => "Código Openpay",
            'descr' => $data['verification_code']
        );
        $Config_model->insert($data);
        return 1;
    }
}
