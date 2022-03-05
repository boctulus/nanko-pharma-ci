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
  <link rel="stylesheet" href="/assets/css/styleIco.css">
  <script src="https://kit.fontawesome.com/f7929717e2.js" crossorigin="anonymous"></script>
  <script src="/assets/js/wow.min.js"></script>
  <script>
  new WOW().init();
  </script>

  <title>Seleccionar Dirección</title>
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
      <div class="container bg-white py-3 px-3 wow animate__animated animate__fadeInRight" style="  border-radius: 10px 10px 10px 10px;">
        <h1 class="text-center"><strong>Seleccionar Dirección</strong></h1>
        <div class="row">
          <div class="col-md-12">
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item active "><a class="btn-link" href="#">Dirección</a></li>
                <!-- <li class="breadcrumb-item">Método de Pago</li> -->
                <li class="breadcrumb-item " aria-current="page">Pagar</li>
              </ol>
            </nav>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <?php $k=0; foreach ($direcciones as $obj): ?>
              <?php if ($k == 0): ?>
                <div class="card-deck">
                <?php endif; ?>
                <div class="card mb-3">
                  <div class="card-header"><?php echo $obj['nombre']; ?></div>
                  <div class="card-body ">
                    <h5 class="card-title"><?php echo $obj['direccion']; ?></h5>
                    <p class="card-text"><?php echo $obj['colonia']; ?></p>
                    <p class="card-text"><?php echo $obj['ciudad']; ?> <?php echo $obj['cp']; ?></p>
                    <p class="card-text">Teléfono: <?php echo $obj['tel']; ?></p>
                    <div class="row mb-2">
                      <div class="col-md-12">
                        <a href="/Clientes/seleccionar_direccion/<?php echo $obj['id_direccion'] ?>"><button type="button" class="btn botoncolor btn-block">Seleccionar</button></a>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <a href=""><button type="button" class="btn btn-dark btn-block">Editar</button></a>
                      </div>
                      <div class="col-md-6">
                        <a href=""><button type="button" class="btn btn-dark btn-block mt-2">Eliminar</button></a>
                      </div>
                    </div>
                  </div>
                </div>

                <?php if($k == 2){
                  echo "</div>";
                  $k = 0;
                }else{
                  $k++;
                } ?>
              <?php endforeach; ?>
              <?php if ($k != 0): //pare cerrar el deck ?>
              </div>
            <?php endif; ?>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <h1 class="text-center">Nueva Dirección</h1>
            <?php echo form_open('Clientes/agregar_direccion'); ?>
            <div class="form-group">
              <label for="exampleInputEmail1">Pais</label>
              <input type="text" class="form-control" disabled value="México">
            </div>
            <div class="form-group">
              <label for="estado">Estado</label>
              <input type="text" id="estado" name="estado" class="form-control" required>
            </div>
            <div class="form-group">
              <label for="city">Ciudad</label>
              <input type="text" id="city" name="city" class="form-control" required>
            </div>
            <div class="form-group">
              <label for="cp">Código Postal</label>
              <input type="text" id="cp" name="cp" class="form-control" required>
            </div>
            <div class="form-group">
              <label for="name">Nombre Completo (Nombre y Apellidos)</label>
              <input type="text" id="name" name="name" class="form-control" required>
            </div>
            <div class="form-group">
              <label for="address">Dirección de la calle</label>
              <input type="text" id="address" name="address" class="form-control" required>
            </div>
            <div class="form-group">
              <label for="colonia">Colonia</label>
              <input type="text" id="colonia" name="colonia" class="form-control" required>
            </div>
            <div class="form-group">
              <label for="tel">Número de teléfono</label>
              <input type="text" id="tel" name="tel" class="form-control" required>
            </div>
            <div class="form-group">
              <label for="instrucciones">Instrucciones de Entrega</label>
              <textarea class="form-control" name="instrucciones" id="instrucciones" rows="3"></textarea>
            </div>
            <button type="submit" class="btn botoncolor">Agregar</button>
            <?php echo form_close(); ?>
          </div>
        </div>
      </div>
    </div>
    <!-- /dosis form fin -->
  <?php endif; ?>
  <!-- final español -->
  <!-- Footer -->
  <?php echo view('Cliente/Footer'); ?>
  <!-- fin footer -->

</body>
