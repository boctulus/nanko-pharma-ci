<head>
<!-- Required meta tags -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<!-- Bootstrap CSS -->
<link rel="apple-touch-icon" href="/assets/img/logo.png">
<link rel="shortcut icon" type="image/x-icon" href="/assets/img/logo.png">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
<link rel="stylesheet" href="/assets/fonts/font-awesome.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
<link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet'>
<link rel="stylesheet" href="/assets/css/index.css">
<!-- <link rel="stylesheet" href="/assets/css/openpay.css"> -->
<script src="/assets/js/wow.min.js"></script>
<link rel="stylesheet" href="/assets/css/styleIco.css">
<script src="https://kit.fontawesome.com/f7929717e2.js" crossorigin="anonymous"></script>


<script>
  new WOW().init();
</script>

<title>Método de Pago</title>
</head>

<body>
<?php echo view('Cliente/Navbar'); ?>

<!-- inicio ingles -->
<?php if (session('region') == 3 || session('region') == 5): ?>
  <h1>Pagina en ingles</h1>


<?php endif; ?>
<!-- final ingles -->

<!-- inicio español -->
<?php if (session('region') < 3 || session('region') == 4): ?>


<!-- Dosis form inicio -->
<div class="margennd">
</div>
<div class="container-fluid d-inline-block">
  <div class="container bg-white py-3 px-3" style="  border-radius: 10px 10px 10px 10px;">
    <h1 class="text-center">Pago</h1>
    <div class="row">
      <div class="col-md-12">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a class="btn-link" href="/Clientes/finalize_purchase">Dirección</a></li>
            <li class="breadcrumb-item active "><a href="#" class="btn-link">Pagar</a></li>
          </ol>
        </nav>
      </div>
    </div>
    <h1 class="text-center">Resumen de costos</h1>
    <div class="row wow animate__animated animate__fadeInRight">
      <div class="col-md-12">
        <!-- <ul class="list-group list-group-flush" id="sidebar-cart"> -->
        <table class="table table-striped text-center">
          <thead class="thead-light>" <tr>
            <th scope="col">Producto</th>
            <th scope="col">Cantidad</th>
            <th scope="col">Precio</th>
            <th scope="col">Total</th>
            <!-- <th>Opci</th> -->
            </tr>
          </thead>
          <tbody>
            <?php
            foreach (session('cart') as $articulo) : ?>
              <tr>
                <td>
                  <!-- <div class="card mb-3" style="max-width: 540px;"> -->
                  <div class="row no-gutters">
                    <div class="col-md-4">
                      <img src="<?php echo $articulo['img']; ?>" class="card-img" alt="<?php echo $articulo['nombre']; ?>">
                    </div>
                    <div class="col-md-8">
                      <div class="card-body">
                        <h5 class="card-title"><strong><?php echo $articulo['nombre']; ?></strong></h5>
                      </div>
                    </div>
                  </div>
                  <!-- </div> -->
                </td>
                <td>
                  <p><?php echo $articulo['cantidad']; ?></p>
                </td>
                <td>
                  <p>$<?php echo $articulo['precio']; ?></p>
                </td>
                <td>
                  <p>$<?php echo $articulo['cantidad'] * $articulo['precio']; ?></p>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
          <thead class="thead-light">
            <tr>
              <th class="text-right" scope="col" colspan="2">Envio:</th>
              <th class="text-right" scope="col" colspan="2">$<?php echo $envio; ?></th>
            </tr>
          </thead>
          <?php if (isset(session('usuario')['descuento'])): ?>
            <thead class="thead-light">
              <tr>
                <th class="text-right" scope="col" colspan="2">Descuento de Colaborador:</th>
                <th class="text-right" scope="col" colspan="2">- $<?php echo $descuento; ?></th>
              </tr>
            </thead>
            <thead class="thead-light">
              <tr>
                <th class="text-right" colspan="2" scope="col">Total a pagar:</th>
                <th class="text-right" scope="col" colspan="2"><strong>$<?php echo $subtotal; ?></strong></th>
              </tr>
            </thead>
          <?php else: ?>
            <thead class="thead-light">
              <tr>
                <th scope="col"></th>
                <th class="text-right" colspan="2" scope="col">Total a pagar:</th>
                <th scope="col"><strong>$<?php echo $subtotal; ?></strong></th>
              </tr>
            </thead>
          <?php endif; ?>
        </table>
      </div>
    </div>
    <h1 class="text-center">Seleccionar Método de pago</h1>
    <div class="row">

      <div class="col-md-12">
        <div class="accordion" id="accordionExample">
          <div class="card">
            <div class="card-header" id="headingOne">
              <h2 class="mb-0">
                <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                  Pago con Tarjeta de Crédito/Débito
                </button>
              </h2>
            </div>

            <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
              <div class="card-body">

                <?php echo form_open("Clientes/pagar", 'class="credit-card-div" id="payment-form"') ?>

                <input type="hidden" name="token_id" id="token_id" />
                <fieldset>
                  <legend>Datos de la tarjeta</legend>

                  <div class="card active colorjumbotron pt-3 pb-3 pr-3 pl-3 borderr">
                    <div class="tarjeta col-xl-12 borderr mb-3">
                      <h2 class="pl-3 pt-2" style="width:100%">Tarjeta de crédito o débito</h2>
                    </div>
                    <div class="row">
                      <div class="col-md-3 col-sm-3 col-xs-3">
                        <div>
                          <label class="textos" style="font-size:14px;"><strong>Tarjetas de crédito</strong></label>
                          <img src="/assets/openpay/cards1.png" class="img-fluid" alt="" />
                        </div>
                      </div>
                      <div class="col-md-7 col-sm-3 col-xs-3" style="border-left: 1px solid #000000;">
                        <div>
                          <label class="textos" style="font-size:14px;"><strong>Tarjetas de debito</strong></label>
                          <img src="/assets/openpay/cards2.png" class="img-fluid" />
                        </div>
                      </div>
                    </div>

                    <div class="row ">
                      <div class="col-md-8 col-sm-3 col-xs-3 mt-2">
                        <label for="nametarj" class="textos"> <strong>Nombre del titular</strong></label>
                        <input type="text" class="form-control" autocomplete="off" data-openpay-card="holder_name" placeholder="Como aparece en la tarjeta" style="max-width:50%;" required />
                      </div>
                    </div>
                    <div class="row ">
                      <div class="col-md-8 col-sm-3 col-xs-3 mt-2">
                        <label for="numbt" class="textos"> <strong>Número de tarjeta</strong></label>
                        <input type="text" autocomplete="off" data-openpay-card="card_number" class="form-control" style="max-width:50%" required />
                      </div>
                    </div>
                    <div class="row mt-2">
                      <div class="col-md-3 col-sm-3 col-xs-3 pr-5">
                        <span class="help-block small-font"><strong>Mes expiración</strong></span>
                        <input type="text" class="form-control" placeholder="MM" size="2" data-openpay-card="expiration_month" required />
                      </div>
                      <div class="col-md-3 col-sm-3 col-xs-3  pr-5">
                        <span class="help-block small-font"><strong>Año expiración</strong></span>
                        <input type="text" class="form-control" placeholder="YY" size="2" data-openpay-card="expiration_year" required />
                      </div>
                      <div class="col-md-3 col-sm-3 col-xs-3 pr-5">
                        <span class="help-block small-font"><strong>CCV</strong> </span> <//img src="/assets/openpay/cvv.png"  style="max-width:10%" />
                        <input type="text" class="form-control" autocomplete="off" data-openpay-card="cvv2" placeholder="CCV" required />
                        <img src="/assets/openpay/cvv.png" class="img-fluid" style="max-width:60%" />
                      </div>
                      <div class="col-md-3 col-sm-3 col-xs-3">
                        <img src="/assets/openpay/openpay.png" class="img-fluid" />
                        <label style="font-style: italic; font-size: 12px;">Tus pagos se realizan de forma segura con encriptación de 256 bits</label>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6 col-sm-6 col-xs-6 pad-adjust mt-3">
                        <input type="button" class="btn btn-warning btn-block" id="save-button" value="PAY NOW" />
                      </div>
                    </div>

                  </div>
                </fieldset>
                <?php echo form_close(); ?>

              </div>
            </div>
          </div>
          <div class="card">
            <div class="card-header" id="headingTwo">
              <h2 class="mb-0">
                <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                  Pago en tienda
                </button>
              </h2>
            </div>
            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
              <div class="card-body">
                <button type="button" id="pago_tienda" class="btn btn-primary btn-lg btn-block" onclick="pago_tienda()">Pago en tienda</button>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>
<?php endif; ?>
<!-- final español -->
<!-- Footer -->
<?php echo view('Cliente/Footer'); ?>
<!-- Footer -->


  <!-- <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script> -->
  <script type="text/javascript" src="https://js.openpay.mx/openpay.v1.min.js"></script>
  <script type='text/javascript' src="https://js.openpay.mx/openpay-data.v1.min.js"></script>
  <!-- fin footer -->
  <script type="text/javascript">
    $(document).ready(function() {
      OpenPay.setId('mm1jczp4xpgq3drlq8nj');
      OpenPay.setApiKey('pk_91f8c4efa0f84a33bf1872d9d5b00bdc');
      OpenPay.setSandboxMode(false);

      var deviceSessionId = OpenPay.deviceData.setup("payment-form", "deviceId");

      $('#save-button').on('click', function(event) {
        event.preventDefault();
        $("#save-button").prop("disabled", true);
        OpenPay.token.extractFormAndCreate('payment-form', sucess_callbak, error_callbak);
      });

      var sucess_callbak = function(response) {
        var token_id = response.data.id;
        $('#token_id').val(token_id);
        $('#payment-form').submit();
      };

      var error_callbak = function(response) {
        var desc = response.data.description != undefined ? response.data.description : response.message;
        $("#save-button").prop("disabled", false);
        Swal.fire(
          'Error',
          desc,
          'error'
        );
        //alert("ERROR [" + response.status + "] " + desc);
      };
    });

  function pago_tienda() {
    $("#pago_tienda").prop("disabled", true);
    $.ajax({
      async: true,
      cache: false,
      dataType: "html",
      type: 'POST',
      url: '<?php echo base_url('Clientes/pago_tienda'); ?>',
      //data: {id_producto:id,cantidad:1},
      success: function(data) {
        let datos = JSON.parse(data);
        if (datos.bandera == 1) {
          window.open(datos.url, '_blank');
          window.location.href = '<?php echo base_url('Clientes/Ordenes'); ?>';
        } else {
          Swal.fire(
            'Error',
            datos.respuesta,
            'error'
          );
        }
      },
      beforeSend: function() {},
      error: function(objXMLHttpRequest) {}
    });
  }
</script>
</body>
