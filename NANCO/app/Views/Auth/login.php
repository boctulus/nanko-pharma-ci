<!-- materialize css cdn link -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">


<!-- add css style -->
<style>
  body{
    background-image: url("/assets/img/img.JPG");
    background-repeat: no-repeat;
    background-size: cover;
    color:#fff;
  }

  .login .card{
    background: rgba(0, 0, 0, .6);
  }
  .login label{
    font-size: 16px;
    color:#CCC;
  }
  .login input{
    font-size: 20px !important;
    color: #FFF;
  }
  .login button:hover{
    padding:0px 40px;
  }
</style>

<div class="row login">
  <div class="col s12 m4 offset-m4">
    <div class="card">
      <div class="card-action light-green-text center-align ">
        <h3>Iniciar sesión</h3>
      </div>
      <?php echo form_open('Usuarios/login');?>
        <div class="card-content">
          <div class="form-field">
            <label for="correo">Correo</label>
            <input type="email" name="correo" id="correo" required>
          </div><br>
          <div class="form-field">
            <label for="password">Contraseña</label>
            <input type="password" name="pass" id="password" required>
          </div><br>
          <div class="form-field" action="#">
            <p>
              <label>
                <input id="Recordarme" type="checkbox" />
                <span>Recordarme</span>
              </label>
            </p>
          </div><br>
          <div class="form-field center-align">
            <button class="btn-large pulse light-green" type="submit">Entrar</button>
          </div><br>
          <div class="labelpass">
            <a href="#">Olvide micontraseña</a>
          </div><br>
        </div>
      <?php echo form_close(); ?>
      <?php if ( $session->getFlashdata('error') ): ?>
        <div class="alert alert-info">
          <?php echo $session->getFlashdata('error') ?>
        </div>
      <?php endif; ?>
    </div>
  </div>
</div>
