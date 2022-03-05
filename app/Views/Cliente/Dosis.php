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
  <script src="/assets/js/wow.min.js"></script>
  <script>
  new WOW().init();
  </script>
  <script src="https://kit.fontawesome.com/f7929717e2.js" crossorigin="anonymous"></script>

  <title>Dosis</title>
</head>
<body>
  <!-- inicio ingles -->
  <?php if (session('region') == 3 || session('region') == 5): ?>
  <?php echo view('Cliente/Cliente_ing/Dosis'); ?>

  <?php endif; ?>
  <!-- final ingles -->


  <!-- inicio español -->
  <?php if (session('region') < 3 || session('region') == 4): ?>
  <?php //echo view('Cliente/Navbar'); ?>
    <!-- Dosis form inicio -->
    <div class="margennd">
    </div>
    <div class="container-fluid h-100 d-inline-block">
      <div class="container py-3 px-3 wow d-none" style="border-radius: 10px 10px 10px 10px;" id="new_dosis_panel">
        <h1 class="text-center"><strong>Dosificación</strong></h1>
        <div class="row">
          <div class="col-md-12">
            <!-- Button trigger modal -->

            <div class="text-center mt-4">
                <button type="button" class="btn botoncolor" data-toggle="modal" data-target="#exampleModalLong">
                <strong style="color:#ffffff"><i class="fas fa-eye-dropper mr-2"></i>Nueva Dosis +</strong>
                </button>
            </div>

        </div>
          <?php if ($dosis): ?>
            <div class="col-md-12 mt-2 table-responsive">
              <table class="table table-bordered round_table colorletra">
                <thead>
                  <tr class="bg-succes colortabla">
                    <th scope="col" style="color:#fAfAfA">Fecha de creación</th>
                    <th scope="col" style="color:#fAfAfA">Edad</th>
                    <th scope="col" style="color:#fAfAfA">Peso</th>
                    <th scope="col" style="color:#fAfAfA">Producto</th>
                    <th scope="col" style="color:#fAfAfA">Dosis (Gotas)</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($dosis as $obj): ?>
                    <tr>
                      <td><?php echo $obj['fecha']; ?></td>
                      <td><?php echo $obj['edad']; ?></td>
                      <td><?php echo $obj['peso']; ?> Kg.</td>
                      <td><?php echo $obj['producto']; ?></td>
                      <td><?php echo $obj['resultado']; ?></td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          <?php endif; ?>
        </div>
      </div>
    </div>
    <!-- /dosis form fin -->

  <!-- Footer -->
  <?php //echo view('Cliente/Footer'); ?>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>


    <style>
        body {
            overflow: -moz-scrollbars-horizontal;
            overflow-y: hidden;
            overflow-x: auto;
            }
    </style>

  <!-- fin footer -->
  <div id="modal"></div>
  <?php echo view("Cliente/Modales/nueva_dosis"); ?>

  <?php if (count($dosis) == 0): ?>
    <script>
    $(document).ready(function() {
        $('#exampleModalLong').modal();
    });

    setTimeout(function(){
        $("#new_dosis_panel").removeClass("d-none")
    }, 1500);
    </script>


  <?php endif; ?>
<?php endif; ?>
<!-- final español -->
</body>
