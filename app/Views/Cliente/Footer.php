
<!-- inicio ingles -->
<?php if (session('region') == 3 || session('region') == 5): ?>
<?php echo view('Cliente/Cliente_ing/Footer'); ?>

<?php endif; ?>
<!-- final ingles -->


<!-- inicio español -->
<?php if (session('region') < 3 || session('region') == 4): ?>
<!-- Modal Registro -->
<div class="modal fade" id="Registro" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <?php echo form_open('Clientes/registrar_cliente'); ?>
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title wow animate__animated animate__fadeInLeft" id="exampleModalLongTitle">Crear Cuenta</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <?php if (isset(session('error')['tipo'])  && (session('error')['tipo']== "nuevo")) : ?>
          <div class="alert alert-danger" role="alert">
            <?php echo session('error')['error']?>
          </div>
        <?php endif; ?>
        <div class="col-md-12 mt-3">
          <form>
            <div class="form-group wow animate__animated animate__fadeInLeft">
              <label>Nombre</label>
              <input type="text" name="nombre" class="form-control" placeholder="Nombre" required>
            </div>
            <div class="form-group wow animate__animated animate__fadeInLeft">
              <label>Apellidos</label>
              <input step="any" name="apellido" class="form-control" placeholder="Apellido" required>
            </div>
            <div class="form-group wow animate__animated animate__fadeInLeft">
              <label>Correo</label>
              <input type="email" name="correo" id="correo" class="form-control" placeholder="Correo" required>
            </div>
            <div class="form-group wow animate__animated animate__fadeInLeft">
              <label>Telefono</label>
              <input type="number" name="telefono" id="telefono" class="form-control" placeholder="Telefono" required>
            </div>
            <div class="form-group wow animate__animated animate__fadeInLeft">
              <label>Fecha de nacimiento</label>
              <input type="date" name="fecha_nacimiento" id="fecha_nac" class="form-control" required>
            </div>
            <div class="form-group wow animate__animated animate__fadeInLeft">
              <label>Contraseña</label>
              <div class="input-group">
                <input type="password" name="pass" id="passr" class="form-control" placeholder="Contraseña" onchange="verificarpass()" required>
              </div>
            </div>
            <div class="form-group wow animate__animated animate__fadeInLeft">
              <label>Repetir Contraseña</label>
              <div class="input-group">
                <input type="password" name="passr" id="passrv" class="form-control" placeholder="Repetir contraseña" onchange="verificarpass()" required>
              </div>
            </div>
          </form>
        </div>
      </div>
      <div class="modal-footer wow animate__animated animate__fadeInRight">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="submit" class="btn botoncolor" id="smb2">Crear Cuenta</button>
      </div>
    </div>
    <?php echo form_close(); ?>
  </div>
</div>
<!-- Modal Registro fin -->
<!-- Modal Login -->
<div class="modal fade" id="login" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <?php echo form_open('Clientes/login'); ?>
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title wow animate__animated animate__fadeInLeft" id="exampleModalLongTitle">Iniciar Sesión</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <?php if (session('error')['tipo'] == "login") : ?>
          <div class="alert alert-danger" role="alert">
            <?php echo session('error')['error'] ?>
          </div>
        <?php endif;?>
        <div class="col-md-12 mt-3">
          <div class="form-group wow animate__animated animate__fadeInLeft">
            <label class="text-center">Correo</label>
            <input type="email" name="correo" class="form-control" placeholder="Correo electronico"  required>
          </div>
          <div class="form-group wow animate__animated animate__fadeInLeft">
            <label class="text-center">Contraseña</label>
            <input type="password" name="pass" class="form-control" placeholder="Contraseña" required>
          </div>
          <div class="form-group wow animate__animated animate__fadeInLeft">
            <input type="checkbox" name="cooki" value="1" id="defaultCheck1">
            <label for="defaultCheck1">
              Recordar
            </label>
          </div>
          <div class="form-group wow animate__animated animate__fadeInLeft">
            <p>Si no tienes cuenta, regístrate <a href="#" onclick="registrarse()">aquí.</a></p>
          </div>
          <div class="form-group wow animate__animated animate__fadeInLeft">
            <p><a href="#" onclick="recuperarp()">Olvide mi contraseña?</a></p>
          </div>
        </div>
      </div>
      <div class="modal-footer wow animate__animated animate__fadeInRight">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="submit" class="btn botoncolor">Iniciar sesión</button>
      </div>
    </div>
    <?php echo form_close(); ?>
  </div>
</div>
<!-- Modal Login fin -->
<!-- Modal recuperar pass -->
<div class="modal fade" id="recuperarpass" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <?php echo form_open('Clientes/recuperarpass'); ?>
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title wow animate__animated animate__fadeInLeft" id="exampleModalLongTitle">Recuperar contraseña</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="col-md-12 mt-3">
          <div class="form-group wow animate__animated animate__fadeInLeft">
            <h5>Si olvido su contraseña, ponga el correo electronico vinculado a su cuenta Nankö. <br></h5>
            <label class="text-center"></label>
            <input type="email" name="correo" class="form-control" placeholder="Correo electronico"  required>
            <button type="submit" class="btn botoncolor mt-2">Recuperar</button>
          </div>
        </div>
      </div>
    </div>
    <?php echo form_close(); ?>
  </div>
</div>
<!-- Modal recuperar pass fin -->

<!-- Modal Envios -->
<div class="modal fade" id="envios" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Costos de envíos</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <p>Los costos de envío son dependientes del peso del paquete final con la siguiente relación</p>
          <ul class="text-justify">
            <li>1Kg: $200</li>
            <li>2Kg: $230</li>
            <li>3Kg: $260</li>
            <li>4Kg: $290</li>
            <li>5Kg: $320</li>
            <li>6Kg: $350</li>
            <li>7Kg: $380</li>
            <li>8Kg: $410</li>
            <li>9Kg: $440</li>
            <li>10Kg: $470</li>
          </ul>
      </div>
    </div>
  </div>
</div>
<!-- Modal Envios fin -->

<script>
function registrarse(){
  $('#login').modal('hide');
  $('#Registro').modal();
}
function recuperarp(){
  $('#login').modal('hide');
  $('#recuperarpass').modal();
}
</script>


<!-- Optional JavaScript; choose one of the two! -->
<!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
<script src="/sweetalert2/dist/sweetalert2.all.min.js"></script>
<div class="btn-whatsapp">
  <a href="https://api.whatsapp.com/send?phone=+522284002882&text=Hola!%20Me%20gustaría%20hacer%20una%20consulta" target="_blank">
    <img src="/assets/img/btn_whatsapp.png" alt="" width="45px" height="45px">
  </a>
</div>
<div class="container-fluid pb-0 mb-0 justify-content-center colorfooter">
  <footer>
    <div class="row justify-content-center py-5">
      <div class="col-11">
        <div class="row ">
          <div class="col-xl-8 col-md-4 col-sm-4 col-12 my-auto mx-auto a">
            <div class="row">
              <div class="col-md-4">
                <a><img src="/assets/img/logobr.png" class="img-fluid img_centro" alt="" style="max-width:30%"/> </a>
              </div>
              <div class="col-md-8 mt-5 img_centro">
                <p><span><i class="icon-hecho-me-lines-01 iconcolorf ml-3" style="font-size:70px;" aria-hidden="true"></i></span>
                  <span class="ml-2"><i class="icon-organic-dark-01 iconcolorf ml-3" style="font-size:70px;" aria-hidden="true"></i></span>
                  <span class="ml-2"><i class="icon-Recycle-dark iconcolorf ml-3" style="font-size:70px;" aria-hidden="true"></i></span>
                </p>
              </div>
            </div>
          </div>
          <div class="col-xl-2 col-md-4 col-sm-4 col-12">
            <h6 class="mb-3 mb-lg-4 texto_centro" style="color:rgba(233,236,239,0.9);"><b>MENU</b></h6>
            <ul class="list-unstyled colorletraf texto_centro">
                <li><a class="colorletraf" href="/Clientes">Inicio</a></li>
                <li><a class="colorletraf" href="/Clientes/nosotros">Nosotros</a></li>
                <li><a class="colorletraf" href="/Clientes/dosis">Dosis</a></li>
                <li><a class="colorletraf" href="/Clientes/blog">Blog</a></li>
                <li><a class="colorletraf" href="/Clientes/tienda">Tienda</a></li>

              </ul>
            </div>
            <div class="col-xl-2 col-md-4 col-sm-4 col-12 texto_centro">
              <h6 class="mb-3 mb-lg-4 bold-text" style="color:rgba(233,236,239,0.9);"><b>Contacto & ayuda</b></h6>
              <ul class="list-unstyled">
                <li><a class="colorletraf" data-toggle="modal" data-target="#envios" href="#" >Costo de envío</a></li>
                <li><a class="colorletraf" href="/Clientes/envios_devolucion" target="_blank">Política de envios y devolución</a></li>
                <li><a class="colorletraf"  href="/Clientes/privacidad" target="_blank">Política de privacidad</a></li>
                <li><a class="colorletraf" href="/Clientes/contacto">Solicitud de contacto</a></li>
              </ul>
            </div>
          </div>
          <div class="row ">
            <div class="col-md-8 ml-5 mr-5" style="color:rgba(233,236,239,0.9);">
              <small class=" bold-text"><b>VERACRUZ - MÉXICO</b></small>
            </div>
          </div>

          <div class="row texto_centro">
            <div class="col-xl-4 col-md-4 col-sm-4 my-md-0 mt-5 order-sm-1 order-3 align-self-end">
              <p class="social text-muted mb-0 pb-0 bold-text">
                <span class="mx-2">
                  <a href="https://www.facebook.com/NankoCBDMX" target="_blank">
                    <i class="fa fa-facebook-square facebookc" style="font-size:35px;" aria-hidden="true"></i>
                  </a>
                </span>
                <span class="mx-2">
                  <a href="https://www.instagram.com/nankocbd/?fbclid=IwAR2sFxOwnqTT6OejqwX8mciiAVpRpjbLqw35802YLeKAK6skHHvIiPJa38c" target="_blank">
                    <i class="fa fa-instagram instagramc" aria-hidden="true" style="font-size:35px;"></i>
                  </a>
                </span>
                <span class="mx-2">
                  <a href="https://www.youtube.com/channel/UC7FlvKsga0g1jTVMhcFPEYw" target="_blank">
                    <i class="fa fa-youtube-play youtubec" aria-hidden="true" style="font-size:35px;"></i>
                  </a>
              </span>
            </p>
            </div>
            <div class="col-xl-4 col-md-4 col-sm-4 order-1 align-self-end " style="color:rgba(233,236,239,0.9);">
              <h6 class="mt-55 mt-2 bold-text" ><b>Contacto y Soporte</b></h6>
              <small>
                <span>
                  <i class="fa fa-envelope" aria-hidden="true"></i>
                </span>
                <a class="ml-1 colorletraf" href="mailto:contacto@nanko.com.mx">contacto@nanko.com.mx</a>
              </small>
              <small>
                <span>
                  <i class="fa fa-whatsapp" aria-hidden="true"></i>
                </span>
                <a class="ml-1 colorletraf" href="https://api.whatsapp.com/send?phone=+522284000040&text=Hola!%20Me%20gustaría%20hacer%20una%20consulta" target="_blank">228 400 0040</a>
              </small>
              <br>
              <small>
                <span>
                  <i class="fa fa-envelope" aria-hidden="true"></i>
                </span>
                <a class="ml-1 colorletraf" href="mailto:soporte@nanko.com.mx">soporte@nanko.com.mx</a>
              </small>
              <small>
                <i class="fa fa-whatsapp" aria-hidden="true"></i>
              </span>
              <a class="ml-1 colorletraf" href="https://api.whatsapp.com/send?phone=+522321405326&text=Hola!%20Me%20gustaría%20hacer%20una%20consulta" target="_blank">232 140 5326</a>
            </small>
            </div>
            <div class="col-xl-4 col-md-4 col-sm-4 order-2 align-self-end mt-3 " style="color:rgba(233,236,239,0.9);">
              <h6 class=" bold-text"><b>Departamento médico</b></h6>
              <small>
                <span>
                  <i class="fa fa-envelope" aria-hidden="true"></i>
                </span>
                <span>
                  <a class="ml-1 colorletraf" href="mailto:depmed@nanko.com.mx">depmed@nanko.com.mx</a>
                  <br>
                  <i class="fa fa-whatsapp" aria-hidden="true"></i>
                </span>
                <a class="ml-1 colorletraf" href="https://api.whatsapp.com/send?phone=+522284002882&text=Hola!%20Me%20gustaría%20hacer%20una%20consulta" target="_blank">228 400 2882</a>
              </small>
            </div>
          </div>
        </div>
      </div>
    </footer>
  </div>

  <script>
  function verificarpass(){
    let aux = $("#passrv")[0].value;
    let aux2 = $("#passr")[0].value;

    if (aux.length > 0 && aux2.length > 0) {
      if(($("#passr")[0].value) != ($("#passrv")[0].value)){

        $('#smb2').prop('disabled', true);
        Swal.fire({
          confirmButtonText: 'Ok',
          confirmButtonAriaLabel: 'Ok',
          //showCancelButton: true,
          title: 'Aviso',
          text: 'Las contraseñas no coninciden.'
        });

      }
      else {
        $('#smb2').prop('disabled', false);
      }
    }
  }
  const Toast = Swal.mixin({
    toast: true,
    position: 'bottom-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
      toast.addEventListener('mouseenter', Swal.stopTimer)
      toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
  })

  <?php if (session('error')['tipo'] == "sesion") : ?>
  $(document).ready(function() {
    Swal.fire({
      title: '<strong><u>Error</u></strong>',
      icon: 'error',
      html: '<p class="text-left" style="font-size:15px;"><?php foreach (session('error')['error'] as $error) { echo "-$error <br>";} ?></p>',
      showCloseButton: true,
      focusConfirm: false,
    });
  });
  <?php endif; ?>

  <?php if (session('error')['tipo'] == "form") : ?>
  $(document).ready(function() {
    Swal.fire({
      title: '<strong><u>Error</u></strong>',
      icon: 'error',
      html: '<p class="text-left" style="font-size:15px;"><?php foreach (session('error')['error'] as $error) { echo "-$error <br>";} ?></p>',
      showCloseButton: true,
      focusConfirm: false,
    });
  });
  <?php endif; ?>


  <?php if (session('error')['tipo'] == "login") : ?>
  $(document).ready(function() {
    $("#login").modal('show');
  });
  <?php endif; ?>

  <?php if (session('error')['tipo'] == "nuevo") : ?>
  $(document).ready(function() {
    $("#Registro").modal('show');
  });
  <?php endif; ?>

  <?php if (session('error')['tipo'] == "error") : ?>
  $(document).ready(function() {
    Swal.fire(
      'Error',
      "<?php echo session('error')['error']; ?>",
      'error'
    );
  });
  <?php endif; ?>

  <?php if (session('aviso')) : ?>
    $(document).ready(function() {
      Swal.fire(
        'Aviso',
        '<?php echo session('aviso'); ?>',
        'info'
      );
    });
  <?php endif; ?>

  <?php if (session('ver')) : ?>
    $(document).ready(function() {
      ver_productos(<?php echo session('ver') ?>);
    });
  <?php endif; ?>

</script>

<?php endif; ?>
<!-- final ingles -->
