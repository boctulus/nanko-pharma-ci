<?php namespace App\Libraries;

require_once APPPATH.'/ThirdParty/Openpay/Openpay.php';
use Openpay;
//use OpenpayApiTransactionError;

class Pago extends Openpay
{
    private $openpay;

    public function __construct()
    {
        parent::__construct();
        Openpay::setId('mm1jczp4xpgq3drlq8nj');
        Openpay::setApiKey('sk_a774c7cd76254043b1efb9f9fdfc1275');
        $this->openpay = Openpay::getInstance('mm1jczp4xpgq3drlq8nj', 'sk_a774c7cd76254043b1efb9f9fdfc1275', 'MX');
        Openpay::setProductionMode(true);
    }

    public function get_client($id)
    {
        return $this->openpay->customers->get($id);
    }

    public function get_id()
    {
        return "mm1jczp4xpgq3drlq8nj";
    }

    public function get_pago($id_customer,$id_payout)
    {
        $customer = $this->openpay->customers->get($id_customer);
        $charge = $customer->charges->get($id_payout);
        return $charge;
    }

    public function pago($chargeData,$customer){
        // try {
            $charge =  $customer->charges->create($chargeData);
            $respuesta = array(
                'bandera' => 1,
                'charge' => $charge
            );

            return $respuesta;
        // } catch (\OpenpayApiTransactionError $e) {
        //     $respuesta = array(
        //         'mensaje' => $e->getMessage(),
        //         'bandera' => 0
        //     );
        //     return $respuesta;

        // } catch (\OpenpayApiRequestError $e) {
        //     $respuesta = array(
        //         'mensaje' => $e->getMessage(),
        //         'bandera' => 0
        //     );
        //     return $respuesta;
        // } catch (\OpenpayApiConnectionError $e) {
        //     $respuesta = array(
        //         'mensaje' => $e->getMessage(),
        //         'bandera' => 0
        //     );
        //     return $respuesta;
        // } catch (\OpenpayApiAuthError $e) {
        //     $respuesta = array(
        //         'mensaje' => $e->getMessage(),
        //         'bandera' => 0
        //     );
        //     return $respuesta;
        // } catch (\OpenpayApiError $e) {
        //     $respuesta = array(
        //         'mensaje' => $e->getMessage(),
        //         'bandera' => 0
        //     );
        //     return $respuesta;
        // } catch (\Exception $e) {
        //     $respuesta = array(
        //         'mensaje' => $e->getMessage(),
        //         'bandera' => 0
        //     );
        //     return $respuesta;
        // }
    }

    public function add_client($data){
        $customerData = array(
            'name' => $data["client_name"],
            'email' => $data["cliente_email"],
            'last_name' => $data["apellido"],
            'phone_number' => $data["telefono"],
            'requires_account' => false);

        return $this->openpay->customers->add($customerData);
    }

    public function add_card($customer, $data)
    {
        $cardDataRequest = array(
            'token_id' => $data['source_id'],
            'device_session_id' => $data['device_session_id']
        );

        $customer->cards->add($cardDataRequest);
        return 1;
    }
}
