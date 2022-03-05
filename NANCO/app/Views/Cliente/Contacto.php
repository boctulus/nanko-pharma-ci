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

  <title>Contacto</title>
</head>

<body>


  <!-- inicio ingles -->
  <?php if (session('region') == 3 || session('region') == 5): ?>
  <?php echo view('Cliente/Cliente_ing/Contacto'); ?>
  <?php endif; ?>
  <!-- final ingles -->

  <!-- inicio español -->
  <?php if (session('region') < 3 || session('region') == 4): ?>
    <?php echo view('Cliente/Navbar'); ?>
    <div class="margennd">
    </div>
    <div class="container-fluid pb-5 d-inline-block">
      <div class="container botonavcolor py-3 px-3 wow animate__animated animate__fadeInRight" style="  border-radius: 10px 10px 10px 10px;">
        <h1 class="text-center"><strong>Contacto Nankö</strong></h1>
        <div class="row">
          <div class="col-md-6 ">
            <!-- <img src="/assets/img/img_parallax1.jpg" class="img-fluid" alt=""> -->
            <!-- <i class="fas fa-phone-square" style="font-size:400px; color: rgba(72,197,57,0.7);"></i> -->
            <i class="mr-4 ml-3" style="font-size:45px;"><img src="/assets/img/Contacto_Telefono.jpg" class="img-fluid" style=""/></i>
          </div>
          <div class="col-md-6 mt-2">
            <?php echo form_open("Clientes/crear_contacto"); ?>
            <div class="form-group">
              <label for="nombre">Nombre</label>
              <input type="text" id="nombre" name="nombre" class="form-control" placeholder="José Perez" required />
            </div>
            <div class="form-group">
              <label for="correo">Correo</label>
              <input type="text" id="correo" name="correo" class="form-control" placeholder="correo@email.com" required />
            </div>
            <div class="form-group">
              <label for="telefono">Teléfono</label>
              <input type="text" id="telefono" name="telefono" class="form-control" placeholder="Tu teléfono aquí" />
            </div>
            <div class="form-group">
              <label for="asunto">Asunto</label>
              <input type="text" id="asunto" name="asunto" class="form-control" placeholder="Quiero ser Colaborador" required />
            </div>
            <div class="form-group">
              <label for="mensaje">Mensaje</label>
              <textarea type="text" id="mensaje" name="mensaje" class="form-control" placeholder="Me encantaría pertenecer al equipo de NankÖ" required></textarea>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="checkbox" id="eq_med" value="1" name="eq_med">
              <label class="form-check-label" for="eq_med">
                Quiero contactarme con el departamento médico
              </label>
            </div>
            <button type="submit" class="btn botoncolor mt-2 pull-right" style=" width:90px; height:50px;">Enviar</button>

            <?php echo form_close(); ?>
          </div>
        </div>
      </div>
    </div>



  <!-- Footer -->
  <?php echo view('Cliente/Footer'); ?>
  <!-- fin footer -->
<?php endif; ?>
<!-- final español -->
</body>
