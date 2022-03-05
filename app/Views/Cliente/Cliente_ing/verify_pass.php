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

  <title>Nankö</title>
</head>

<body>
  <?php echo view('Cliente/Navbar'); ?>

    <div class="container-fluid pb-5 d-inline-block" style="padding-top: 17em; padding-bottom: 17em;">
      <div class="container botonavcolor py-3 px-3 wow animate__animated animate__fadeInRight" style="  border-radius: 10px 10px 10px 10px;">
        <h1 class="text-center"><strong>Recover Nankö password</strong></h1>
        <div class="row">
          <div class="col-md-8 mt-2">
            <?php $hidden = ['id' => $id];echo form_open('Clientes/verify_pass','',$hidden);?>
            <div class="form-group">
              <label for="password">New password</label>
              <input type="password" id="password" name="password" class="form-control" placeholder="Nueva Contraseña" required  onchange="verificarpass()"/>
            </div>
            <div class="form-group">
              <label for="correo">Repeat password</label>
              <input type="password" id="password2" name="password2" class="form-control" placeholder="Repetir contraseña" required  onchange="verificarpass()"/>
            </div>
            <button type="submit" name="smb" id="smb" class="btn botoncolor mt-2">Done</button>
            <?php echo form_close(); ?>
          </div>
        </div>
      </div>
    </div>

  <!-- Footer -->
  <?php echo view('Cliente/Footer'); ?>
  <!-- fin footer -->

</body>
<script>
function verificarpass() {
  let aux = $("#password2")[0].value;
  let aux2 = $("#password")[0].value;

  if (aux.length > 0 && aux2.length > 0) {
    if (($("#password")[0].value) != ($("#password2")[0].value)) {

      $('#smb').prop('disabled', true);
      Swal.fire({
        confirmButtonText: 'Ok',
        confirmButtonAriaLabel: 'Ok',
        //showCancelButton: true,
        title: 'Aviso',
        text: 'Las contraseñas no coninciden.'
      });

    } else {
      $('#smb').prop('disabled', false);
    }

  }


}

</script>
