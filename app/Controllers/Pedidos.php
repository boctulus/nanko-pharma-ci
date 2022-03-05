<?php

namespace App\Controllers;

class Pedidos extends BaseController
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

    public function index($value='')
    {
        // API URL
        $url = 'https://api-demo.skydropx.com/v1/shipments/'.$value;

        // Create a new cURL resource
        $ch = curl_init($url);

        // Setup request to send json via POST
        $data = array(
            'username' => 'codexworld',
            'password' => '123456'
        );
        $payload = json_encode(array("user" => $data));

        // Attach encoded JSON string to the POST fields
        // curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

        // Set the content type to application/json
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
          'Content-Type: application/json',
          'Authorization: Token token=Qjd5tcuvDQt4m9AsgPBLIImSX9QLXWX6c8jBGvXUklYt'
        ));

        // Return response instead of outputting
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Execute the POST request
        $result = curl_exec($ch);

        // Close cURL resource
        curl_close($ch);
        // echo $result;
        $resPonse = array('data'=>$result);
        echo view('pedidos',$resPonse);
    }

    public function pedido_nuevo()
    {
      // API URL
      $url = 'https://api-demo.skydropx.com/v1/shipments';
      $post = $this->request->getVar(null, FILTER_SANITIZE_STRING);
      // Create a new cURL resource
      $ch = curl_init($url);

      // Setup request to send json via POST
      $data = [
        'address_from' => [
          'province' => 'Ciudad de México',
          'city' => 'Azcapotzalco',
          'name' => 'Jose Fernando',
          'zip' => '02900',
          'country' => 'MX',
          'address1' => 'Av. Principal #234',
          'company' => 'skydropx',
          'address2' => 'Centro',
          'phone' => '5555555555',
          'email' => 'skydropx@email.com',
        ],
        'parcels' => [
          [
            'weight' => 3,
            'distance_unit' => 'CM',
            'mass_unit' => 'KG',
            'height' => 10,
            'width' => 10,
            'length' => 10,
          ],
        ],
        'address_to' => [
          'province' => $post['province'],
          'city' => $post['city'],
          'name' => $post['name'],
          'zip' => $post['zip'],
          'country' => $post['country'],
          'address1' => $post['address1'],
          'company' => $post['company'],
          'address2' => $post['address2'],
          'phone' => $post['phone'],
          'email' => $post['email'],
          'references' => $post['references'],
          'contents' => '123345',
        ],
      ];
      $payload = json_encode($data);

      // Attach encoded JSON string to the POST fields
      // curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

      // Set the content type to application/json
      curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Authorization: Token token=Qjd5tcuvDQt4m9AsgPBLIImSX9QLXWX6c8jBGvXUklYt'
      ));
      curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
      // Return response instead of outputting
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

      // Execute the POST request
      $result = curl_exec($ch);

      // Close cURL resource
      curl_close($ch);

      echo $result;
    }
}
