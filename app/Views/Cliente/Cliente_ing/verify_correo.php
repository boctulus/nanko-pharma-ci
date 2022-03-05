
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

  <?php echo view('Cliente/Navbar');?>
    <div style="padding-top: 17em; padding-bottom: 17em;">
      <?php if($status == 0){?>
        <h1 class="text-center">Nankö account verified.</h1>
        <h4 class="text-center">You can now log in with your specified username and password.</h4>
      <?php }
      if($status == 1){ ?>
        <h1 class="text-center"> Your account was previously activated.</h1>
      <?php }
      if($status == 2){ ?>
        <h1>Internal Server Error.</h1>
      <?php } ?>
    </div>
</body>

<footer>
  <!-- Footer -->
  <?php echo view('Cliente/Footer'); ?>
  <!-- fin footer -->
</footer>
