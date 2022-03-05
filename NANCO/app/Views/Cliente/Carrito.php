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

<script src="/assets/js/wow.min.js"></script>
<link rel="stylesheet" href="/assets/css/styleIco.css">
<script src="https://kit.fontawesome.com/f7929717e2.js" crossorigin="anonymous"></script>

<script>
  new WOW().init();
</script>

<title>Carrito</title>
</head>

<body>
<?php echo view('Cliente/Navbar'); ?>

<!--  form carrito -->
<div class="margennd">
</div>
<!-- inicio ingles -->
<?php if (session('region') == 3 || session('region') == 5): ?>
  <h1>Pagina en ingles</h1>


<?php endif; ?>
<!-- final ingles -->

<!-- inicio español -->
<?php if (session('region') < 3 || session('region') == 4): ?>


<div class="container-fluid d-inline-block">
  <div class="container bg-white py-3 px-3" style="  border-radius: 10px 10px 10px 10px;">
    <h1 class="text-center">Carrito</h1>
    <div class="row wow animate__animated animate__fadeInRight mt-5" id="cart">
      <div class="col-md-12 table-responsive">
        <!-- <ul class="list-group list-group-flush" id="sidebar-cart"> -->
        <table class="table table-striped text-center">
          <thead class="thead-light>" <tr>
            <th scope="col">Opciones</th>
            <th scope="col">Producto</th>
            <th scope="col">Cantidad</th>
            <th scope="col">Precio</th>
            <th scope="col">Total</th>
            <!-- <th>Opci</th> -->
            </tr>
          </thead>
          <tbody>
            <?php
            $i=0;
            foreach ($productos as $articulo) : ?>
              <tr id="prod_<?php echo $i;?>">
                <td>
                  <a role="button" onclick="eliminar_cart('<?php echo $articulo['id_producto']; ?>',<?php echo $i++; ?>)"><i class="fas fa-trash ml-1"></i></a>
                </td>
                <td>
                  <!-- <div class="card mb-3" style="max-width: 540px;"> -->
                  <div class="row no-gutters">
                    <div class="col-md-4">
                      <a href="/Clientes/producto/<?php echo $articulo['id_producto']; ?>">
                        <img src="<?php echo $articulo['img']; ?>" class="card-img" alt="<?php echo $articulo['nombre']; ?>">
                      </a>
                    </div>
                    <div class="col-md-8">
                      <div class="card-body">
                        <a href="/Clientes/producto/<?php echo $articulo['id_producto']; ?>">
                          <h5 class="card-title"><strong><?php echo $articulo['nombre']; ?></strong></h5>
                        </a>
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

          <?php if (isset(session('usuario')['descuento'])): ?>
            <thead class="thead-light">
            <tr>
              <th scope="col"></th>
              <th scope="col"></th>
              <th class="text-right" colspan="2" scope="col">Descuento de Colaborador:</th>
              <th scope="col"><strong id="desc">- $<?php echo $descuento; ?></strong></th>
              <!-- <th>Opci</th> -->
            </tr>
          </thead>
          <?php endif; ?>

          <thead class="thead-light">
            <tr>
              <th scope="col"></th>
              <th scope="col"></th>
              <th class="text-right" colspan="2" scope="col">Total en carrito:</th>
              <th scope="col"><strong id="subtotal">$<?php echo $subtotal ?> + envio</strong></th>
              <!-- <th>Opci</th> -->
            </tr>
          </thead>
        </table>

        <!-- </ul> -->
      </div>
    </div>
    <div class="row">
      <div class="col-md-6">
        <a href="/Clientes/limpiar_carro">
          <button type="button" class="btn btn-danger btn-block mb-2 mt-3">Limpiar Carrito</button>
        </a>
      </div>
      <div class="col-md-6">
        <?php if (session('usuario')): ?>
          <a href="/Clientes/finalize_purchase"><button type="button" class="btn btn-dark btn-block mt-3">Finalizar Compra</button></a>
        <?php else: ?>
          <button type="button" class="btn btn-dark btn-block" onclick="aviso_sesion()">Finalizar Compra</button>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>
<?php endif; ?>
<!-- final español -->

<!-- Footer -->
<?php echo view('Cliente/Footer'); ?>
<!-- Footer -->
  <script>
    <?php if (!(session('usurio'))): ?>
      function aviso_sesion(params) {
        Swal.fire(
          'Error',
          'Inicia sesión por favor.',
          'error'
        );
      }
    <?php endif; ?>

    function eliminar_cart(id,pos){
      $.ajax({
        async:true,
        cache:false,
        dataType:"html",
        type: 'POST',
        url: '<?php echo base_url('Clientes/eliminar_carro'); ?>',
        data: {id_producto:id},
        success:  function(data){
            let datos = JSON.parse(data);
            if(datos.bandera == 1){

              $('#prod_'+pos).html('');
              <?php if (isset(session('usuario')['descuento'])): ?>
                $('#desc').html('- $'+datos.descuento);
              <?php endif; ?>
              $('#subtotal').html('$'+datos.subtotal);

              Toast.fire({
                  icon: 'success',
                  title: datos.respuesta
              });
            }else{
                Swal.fire(
                    'Error',
                    datos.respuesta,
                    'error'
                );
            }
        },
        beforeSend:function(){},
        error:function(objXMLHttpRequest){}
      });
    }
  </script>
</body>
