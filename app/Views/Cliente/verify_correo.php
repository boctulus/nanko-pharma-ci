
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
  <!-- <link rel="stylesheet" href="/assets/css/Style.css"> -->
  <link rel="stylesheet" href="/assets/css/styleIco.css">
  <script src="/assets/js/wow.min.js"></script>
  <script>
  new WOW().init();
  </script>
  <script src="https://kit.fontawesome.com/f7929717e2.js" crossorigin="anonymous"></script>

  <title>Nankö</title>
</head>

<body>


  <!-- inicio ingles -->
  <?php if (session('region') == 3 || session('region') == 5): ?>
     <?php echo view('Cliente/Cliente_ing/verify_correo'); ?>
  <?php endif; ?>
  <!-- final ingles -->

  <!-- inicio español -->
  <?php if (session('region') < 3 || session('region') == 4): ?>
      <?php echo view('Cliente/Navbar');?>
    <div style="padding-top: 17em; padding-bottom: 17em;">
      <?php if($status == 0){?>
        <h1 class="text-center">Cuenta Nankö verificada.</h1>
        <h4 class="text-center">Ahora puede iniciar sesion con su usuario y contraseña especificado.</h4>
      <?php }
      if($status == 1){ ?>
        <h1 class="text-center"> Su cuenta ya fue activada con anterioridad.</h1>
      <?php }
      if($status == 2){ ?>
        <h1>Error interno del servidor.</h1>
      <?php } ?>
    </div>

</body>

<footer>
  <!-- Footer -->
  <?php echo view('Cliente/Footer'); ?>
  <!-- fin footer -->
</footer>
<?php endif; ?>
<!-- final español -->
