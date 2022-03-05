<!DOCTYPE html>
<!-- <html class="loading" lang="en" data-textdirection="ltr"> -->

<?php echo view("Layout/header"); ?>

<!-- <body class="vertical-layout page-header-light vertical-menu-collapsible vertical-dark-menu preload-transitions 2-columns   " data-open="click" data-menu="vertical-dark-menu" data-col="2-columns"> -->

    <?php echo view("Layout/navbar"); ?>

    <!-- BEGIN: SideNav-->
    <?php echo view("Layout/sidebar") ;?>
    <!-- END: SideNav-->

    <!-- BEGIN: Page Main-->
    <div id="main">
        <div class="row">
            <div id="breadcrumbs-wrapper" data-image="/app-assets/images/gallery/breadcrumb-bg.jpg">
                <!-- Search for small screen-->
                <div class="container">
                    <div class="row">
                        <div class="col s12 m12 l6">
                            <h5 class="breadcrumbs-title mt-0 mb-0"><span>Clientes</span></h5>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col s12">
                <div class="container">
                    <!-- users list start -->
                    <section class="users-list-wrapper section">
                        <div class="users-list-table">
                            <div class="card">
                                <div class="card-content">
                                    <!-- datatable start -->
                                    <div class="responsive-table">
                                        <table id="lista" class="table">
                                            <thead>
                                                <tr>
                                                    <th>Nombre</th>
                                                    <th>Correo</th>
                                                    <th>Teléfono</th>
                                                    <th>País</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if ($clientes): ?>                                         
                                                    <?php $i=0;foreach ($clientes as $obj): ?>
                                                        <tr>
                                                            <td>
                                                                <a><?php echo $obj['nombre'] ?></a>
                                                            </td>
                                                            <td><?php echo $obj['correo'] ?></td>
                                                            <td><?php echo $obj['telefono'] ?></td>
                                                            <td><?php echo $obj['pais'] ?></td>
                                                        </tr>
                                                        <?php $i++; ?>
                                                    <?php endforeach; ?>
                                                <?php endif; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- datatable ends -->
                                </div>
                            </div>
                        </div>
                    </section>
                    <!-- users list ends -->
                </div>
                <div class="content-overlay"></div>
            </div>
        </div>
    </div>
    <!-- END: Page Main-->

    <!-- BEGIN: Footer-->

    <footer class="page-footer footer footer-static footer-light navbar-border navbar-shadow">
        <div class="footer-copyright">
            <div class="container"><span>&copy; 2020 <a href="http://themeforest.net/user/pixinvent/portfolio?ref=pixinvent" target="_blank">PIXINVENT</a> All rights reserved.</span><span class="right hide-on-small-only">Design and Developed by <a href="https://pixinvent.com/">PIXINVENT</a></span></div>
        </div>
    </footer>

    <!-- modales -->
    <?php // echo view("Administrador/Modal/nuevo_usuario"); ?>
    <div id="modal"></div>

    <!-- fin modales -->

    <!-- END: Footer-->
    <!-- BEGIN VENDOR JS-->
    <script src="/app-assets/js/vendors.min.js"></script>
    <!-- BEGIN VENDOR JS-->
    <!-- BEGIN PAGE VENDOR JS-->
      <script src="/app-assets/vendors/data-tables/js/jquery.dataTables.min.js"></script>
      <script src="/app-assets/vendors/data-tables/extensions/responsive/js/dataTables.responsive.min.js"></script>
    <!-- END PAGE VENDOR JS-->
    <!-- BEGIN THEME  JS-->
    <script src="/app-assets/js/plugins.js"></script>
    <script src="/app-assets/js/search.js"></script>
    <script src="/app-assets/js/custom/custom-script.js"></script>
    <!-- END THEME  JS-->
    <!-- BEGIN PAGE LEVEL JS-->
    <script src="/app-assets/js/scripts/page-users.js"></script>
    <!-- END PAGE LEVEL JS-->
    <script src="/sweetalert2/dist/sweetalert2.all.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.js"></script>




    <script >
        var tabla_partida = $('#lista').DataTable( {
            select: true,
            searching: true,
            ordering:  true,
            info:     true,
            scrollCollapse: true,
            paging:         true,
            //"emptyTable": "No disponible en la tabla",

            columns: [
                { data: 'Nombre' },
                { data: 'Correo' },
                { data: 'Teléfono' },
                { data: 'País' }
            ],
            language: {
                url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
            }
        } );
        $(document).ready(function(){
            $('#nuevo').modal();
            $('#select').formSelect();
            <?php if ( $session->getFlashdata('aviso') ): ?>
                Swal.fire({
                    //title: '<strong><u>Formulario incompleto</u></strong>',
                    icon: 'info',
                    html:'<p class="text-left" style="font-size:15px;"><?php echo $session->getFlashdata('aviso') ?></p>',
                    showCloseButton: true,
                    focusConfirm: false,
                });
            <?php endif; ?>
        <?php if ( $session->getFlashdata('error') ): ?>
            Swal.fire({
                title: '<strong><u>Formulario incompleto</u></strong>',
                icon: 'error',
                html:'<p class="text-left" style="font-size:15px;"><?php foreach ($session->getFlashdata('error')['error'] as $error) {echo "-$error <br>";} ?></p>',
                showCloseButton: true,
                focusConfirm: false,
            });
            <?php if ( $session->getFlashdata('error')['tipo'] == "nuevo" ): ?>
                $('#nuevo').modal('open');
            <?php endif; ?>

        <?php endif; ?>
    });

    </script>
</body>

</html>
