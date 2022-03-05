<!-- BEGIN: SideNav-->
<aside class="sidenav-main nav-expanded nav-lock nav-collapsible sidenav-dark sidenav-active-rounded">
    <div class="brand-sidebar">
    <?php if (session('usuario')['tipo_usuario'] == 1): ?>
        <h1 class="logo-wrapper"><a class="brand-logo darken-1" href="<?php echo base_url("Usuarios");?>"><img class="hide-on-med-and-down " src="/assets/img/logo.png" alt="materialize logo" /><img class="show-on-medium-and-down hide-on-med-and-up" src="/assets/img/logo.png" alt="materialize logo" /><span class="logo-text hide-on-med-and-down">Nanko</span></a><a class="navbar-toggler" href="#"><i class="material-icons">radio_button_checked</i></a></h1>
      <?php endif; ?>
      <?php if (session('usuario')['tipo_usuario'] == 4): ?>
        <h1 class="logo-wrapper"><a class="brand-logo darken-1" href="<?php echo base_url("Envios");?>"><img class="hide-on-med-and-down " src="/assets/img/logo.png" alt="materialize logo" /><img class="show-on-medium-and-down hide-on-med-and-up" src="/assets/img/logo.png" alt="materialize logo" /><span class="logo-text hide-on-med-and-down">Nanko</span></a><a class="navbar-toggler" href="#"><i class="material-icons">radio_button_checked</i></a></h1>
      <?php endif; ?>
        
    </div>
    <ul class="sidenav sidenav-collapsible leftside-navigation collapsible sidenav-fixed menu-shadow" id="slide-out" data-menu="menu-navigation" data-collapsible="accordion">
        <li class="navigation-header">
            <a class="navigation-header-text">Páginas </a>
            <i class="navigation-header-icon material-icons">more_horiz</i>
        </li>
        <?php if (session('usuario')['tipo_usuario'] == 1): ?>
            <li class="bold">
            <a class="waves-effect waves-cyan " href="<?php echo base_url("Blog"); ?>">
                <i class="material-icons">face</i>
                <span class="menu-title" data-i18n="User">Blog</span>
            </a>
        </li>
        <li class="bold">
            <a class="waves-effect waves-cyan " href="<?php echo base_url("Usuarios/mostrar_clientes"); ?>">
                <i class="material-icons">face</i>
                <span class="menu-title" data-i18n="User">Clientes</span>
            </a>
        </li>
        <li class="bold">
            <a class="waves-effect waves-cyan " href="<?php echo base_url("Colaboradores"); ?>">
                <i class="material-icons">face</i>
                <span class="menu-title" data-i18n="User">Colaboradores</span>
            </a>
        </li>
        <li class="bold">
            <a class="waves-effect waves-cyan " href="<?php echo base_url("Contacto"); ?>">
                <i class="material-icons">face</i>
                <span class="menu-title" data-i18n="User">Contacto</span>
            </a>
        </li>

        <li class="bold">
            <a class="waves-effect waves-cyan " href="<?php echo base_url("Envios"); ?>">
                <i class="material-icons">face</i>
                <span class="menu-title" data-i18n="User">Envios</span>
            </a>
        </li>

        <li class="bold">
            <a class="waves-effect waves-cyan " href="<?php echo base_url("Padecimientos"); ?>">
                <i class="material-icons">face</i>
                <span class="menu-title" data-i18n="User">Padecimientos</span>
            </a>
        </li>
        <li class="bold">
            <a class="waves-effect waves-cyan " href="<?php echo base_url("Productos"); ?>">
                <i class="material-icons">face</i>
                <span class="menu-title" data-i18n="User">Productos</span>
            </a>
        </li>
        <li class="bold">
            <a class="waves-effect waves-cyan " href="<?php echo base_url("Testimonios"); ?>">
                <i class="material-icons">face</i>
                <span class="menu-title" data-i18n="User">Testimonios</span>
            </a>
        </li>
        <li class="bold">
            <a class="waves-effect waves-cyan " href="<?php echo base_url("Usuarios"); ?>">
                <i class="material-icons">face</i>
                <span class="menu-title" data-i18n="User">Usuarios</span>
            </a>
        </li>
        <?php elseif (session('usuario')['tipo_usuario'] == 4): ?>
            <li class="bold">
                <a class="waves-effect waves-cyan " href="<?php echo base_url("Envios"); ?>">
                    <i class="material-icons">face</i>
                    <span class="menu-title" data-i18n="User">Envios</span>
                </a>
            </li>
            <li class="bold">
                <a class="waves-effect waves-cyan " href="<?php echo base_url("Productos"); ?>">
                    <i class="material-icons">face</i>
                    <span class="menu-title" data-i18n="User">Productos</span>
                </a>
            </li>
        <?php endif; ?>
        
    </ul>
    <div class="navigation-background"></div><a class="sidenav-trigger btn-sidenav-toggle btn-floating btn-medium waves-effect waves-light hide-on-large-only" href="#" data-target="slide-out"><i class="material-icons">menu</i></a>
</aside>
<!-- END: SideNav-->
