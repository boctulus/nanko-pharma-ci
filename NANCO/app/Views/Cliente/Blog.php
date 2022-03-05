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

  <title>Blog</title>
</head>

<body>
  <!-- inicio ingles -->
  <?php if (session('region') == 3 || session('region') == 5): ?>
  <?php echo view('Cliente/Cliente_ing/Blog'); ?>
  <?php endif; ?>
  <!-- final ingles -->

  <!-- inicio español -->
  <?php if (session('region') < 3 || session('region') == 4): ?>
    <?php echo view('Cliente/Navbar'); ?>

    <!-- inicio parallax -->
    <div class="bgimg-4">
      <div class="caption">
        <div class="container colorjumbotron borderr wow animate__animated animate__fadeInUp">
          <div class="row text-dark">
            <div class="col-md-12">
              <!-- <h1 class="text-center"><strong>NankÖ</strong></h1> -->
              <!-- <p class="text-center" style="color:black; font-size: 2rem /* width and color */">SOLUCIONES ALTERNATIVAS<br> ¡ VIVE BIEN, SIÉNTETE BIEN !</p> -->
            </div>
          </div>

        </div>
      </div>
    </div>

    <style>
    .img-container {
      width: auto;
      max-height: 300px;
      overflow: hidden;
    }

    .img-container img {
      width: 100%;
      height: auto
    }
    </style>

    <!-- fin parallax -->
    <div class="container my-5">
      <h1 class="wow animate__animated animate__fadeInUp"><strong>Entradas del blog</strong></h1>
      <div class="row">
        <div class="card-deck ">
          <?php if ($entradas) : ?>
            <?php foreach ($entradas as $obj) : ?>
              <div class="col-md-4 my-2">
                <div class="card wow animate__animated animate__fadeInUp">
                  <div class="img-container">
                    <img href="/Clientes/entrada/<?php echo $obj['id_blog']; ?>" src="<?php echo $obj['img']; ?>">
                  </div>
                  <!-- <img href="/Clientes/entrada/<?php echo $obj['id_blog']; ?>" src="<?php echo $obj['img']; ?>" style=" width:100%; max-height:300px;" class="card-img-top" > -->
                  <div class="card-body">
                    <a href="/Clientes/entrada/<?php echo $obj['id_blog']; ?>">
                      <h5 class="card-title btn botoncolor" style="width:100%;"><?php echo $obj['titulo'] ?></h5>
                    </a>
                    <p class="card-text" style="font-style: italic;"><?php echo $obj['descripcion'] ?></p>
                  </div>
                  <div class="card-footer">
                    <small class="text-muted"><?php echo $obj['fecha'] ?></small>
                  </div>
                </div>
              </div>
            <?php endforeach; ?>
          <?php endif; ?>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12 wow animate__animated animate__fadeInLeft">
          <?php if ($pager) : ?>
            <?php $pagi_path = 'Clientes/blog/'; ?>
            <?php $pager->setPath($pagi_path); ?>
            <?= $pager->links() ?>
          <?php endif ?>
        </div>
      </div>
    </div>



  <!-- Footer -->
  <?php echo view('Cliente/Footer'); ?>
  <!-- fin footer -->
<?php endif; ?>
<!-- final español -->
</body>
