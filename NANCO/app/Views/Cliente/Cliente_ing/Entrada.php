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

    <title>Nanko/Blog</title>
</head>

<body>
    <?php echo view('Cliente/Navbar'); ?>

    <div class="container margennt border px-5 mb-3" style="background-color:white;">
        <div class="row text-dark">
            <div class="col-md-12 text-center">
                <h1><b><?php echo $entrada['titulo']; ?></b></h1>
                <p class="text-left textos" style="font-size: 1rem /* width and color */"><i><?php echo $entrada['fecha']; ?></i></p>
                <img src="<?php echo $entrada['img']; ?>" class="img-fluid" style="max-height: 300px;" alt="">
            </div>
        </div>
        <div class="row">
            <?php echo $entrada['contenido']; ?>
        </div>
    </div>

    <!-- Footer -->
    <?php echo view('Cliente/Footer'); ?>
    <!-- fin footer -->
</body>
