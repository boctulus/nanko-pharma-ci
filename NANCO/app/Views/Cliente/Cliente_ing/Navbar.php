  <nav class="navbar navbar-expand-md sticky navbar-custom navbar-light " id="navbar" style="z-index: 2;">
        <div class="mx-auto order-0">
            <a class="navbar-brand " href="/Clientes"><img src="/assets/img/logovr.png" class="img-fluid" alt=""/></a>
        </div>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target=".dual-collapse2">
          <span class="navbar-toggler-icon"></span>
      </button>
      <div class="navbar-collapse collapse w-100 order-1 order-md-0 dual-collapse2 ">
          <ul class="navbar-nav">
              <li class="nav-item  <?php if (uri_string() == "Clientes") { echo 'active'; } ?>">
                  <a class="nav-link" href="/Clientes">Home<i class="fas fa-home ml-1"></i></a>
              </li>
              <li class="nav-item <?php if (uri_string() == "Clientes/nosotros") { echo 'active'; } ?>">
                  <!-- <a class="nav-link" href="/Clientes/nosotros">Nosotros</a> -->
                  <a class="nav-link" href="/Clientes/nosotros">About</a>
              </li>
              <li class="nav-item <?php if (uri_string() == "Clientes/blog") { echo 'active'; } ?>">
                  <a class="nav-link" href="/Clientes/blog">Blog</a>
              </li>
              <li class="nav-item <?php if (uri_string() == "Clientes/contacto") { echo 'active'; } ?>">
                  <a class="nav-link" href="/Clientes/contacto">Contact</a>
              </li>
              <li class="nav-item <?php if (strpos(uri_string(), "Clientes/tienda") !== false) { echo 'active'; } ?>">
                  <a class="nav-link" href="/Clientes/tienda">Shop<i class="fas fa-store ml-1"></i></a>
              </li>
              <li class="nav-item <?php if (uri_string() == "Clientes/dosis") { echo 'active'; } ?>">
                  <a class="nav-link" href="/Clientes/dosis">Dose <i class="fas fa-eye-dropper ml-1"></i></a>
              </li>
          </ul>
      </div>


      <div class="navbar-collapse collapse w-100 order-3 dual-collapse2">
          <ul class="navbar-nav ml-auto">
              <!-- <li class="nav-item">
                      <a type="button" class="nav-link pull-right" data-toggle="modal" data-target="#Registro" href="#">Regístrate</a>
                  </li> -->
                  <li class="nav-item <?php if (uri_string() == "Clientes/paises") { echo 'active'; } ?>">
                      <a class="nav-link mr-3" href="/Clientes/paises">Country</a>
                  </li>
              <?php
              if (session('usuario')) : ?>
                  <li class="nav-item dropdown">
                      <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          <?php $porciones = explode(" ", session('usuario')['nombre']); echo $porciones[0]; ?>
                      </a>
                      <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                          <a class="dropdown-item" href="#">My account</a>
                          <a class="dropdown-item" href="/Clientes/ordenes">My orders</a>
                          <div class="dropdown-divider"></div>
                          <a class="dropdown-item" href="/Usuarios/salir">Login out</a>
                      </div>
                  </li>
                <?php else : ?>

                    <li class="nav-item">
                        <a type="button" data-toggle="modal" data-target="#login" href="#" class="btn botonav colorbotonav" href="#">Login</a>
                    </li>
                <?php endif; ?>
                <?php if ((strpos(uri_string(), "Clientes/tienda") !== false) || (strpos(uri_string(), "Clientes/producto") !== false)): ?>
                    <li class="nav-item">
                        <a class="nav-link" id="menu-toggle" href="#" tabindex="-1" aria-disabled="true"><i class="fa fa-shopping-cart"></i></a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" id="menu-toggle" href="/Clientes/carrito" tabindex="-1" aria-disabled="true"><i class="fa fa-shopping-cart"></i></a>
                    </li>
                <?php endif; ?>

        </ul>
    </div>
</nav>
