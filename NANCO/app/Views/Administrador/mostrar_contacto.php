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
                            <h5 class="breadcrumbs-title mt-0 mb-0"><span>Contacto</span></h5>
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
                                                    <th>Fecha</th>
                                                    <th>Nombre</th>
                                                    <th>Correo</th>
                                                    <th>Departamento Médico</th>
                                                    <th>Estado</th>
                                                    <th>Detalles</th>
                                                    <th>Manejo</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i=0;foreach ($contacto as $obj): ?>
                                                    <tr>
                                                        <td><?php echo $obj['fecha'] ?></td>
                                                        <td>
                                                            <a>
                                                                <?php echo $obj['nombre'] ?>
                                                            </a>
                                                        </td>
                                                        <td><?php echo $obj['correo'] ?></td>
                                                        <td><?php if($obj['dep_med']){ echo "Sí"; }else{ echo "No"; } ?></td>
                                                        <td id="ent_<?= $i; ?>">
                                                            <?php if ($obj['estado'] == "Recibida"): ?>
                                                                <span class="chip green lighten-5">
                                                                    <span class="green-text">Recibida</span>
                                                                </span>
                                                            <?php endif; ?>
                                                            <?php if ($obj['estado'] == "Respondida"): ?>
                                                                <span class="chip blue lighten-5">
                                                                    <span class="black-text">Respondida</span>
                                                                </span>
                                                            <?php endif; ?>
                                                        </td>
                                                        <td><a href="#" onclick="ver('<?php echo $obj['id_contacto'];?>',<?= $i; ?>)"><i class="material-icons">remove_red_eye</i></a></td>
                                                        <td id="op_<?= $i; ?>">
                                                            <?php if ($obj['estado'] == "Recibida"): ?>
                                                                <a href="#" onclick="marcar('<?php echo $obj['id_contacto'];?>',<?= $i; ?>)"><i class="material-icons">check</i></a>
                                                            <?php endif; ?>
                                                        </td>
                                                    </tr>
                                                    <?php $i++; ?>
                                                <?php endforeach; ?>
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
    <script type="text/javascript">
        var tabla_partida = $('#lista').DataTable( {
            select: true,
            searching: true,
            ordering:  true,
            info:     true,
            scrollCollapse: true,
            paging:         true,
            //"emptyTable": "No disponible en la tabla",

            columns: [
                { data: 'Fecha' },
                { data: 'Nombre' },
                { data: 'Correo' },
                { data: 'Departamento Médico' },
                { data: 'Estado' },
                { data: 'Detalles' },
                { data: 'Manejo' },
            ],
            language: {
                url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
            }
        } );
        $(document).ready(function(){
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

    function ver(id) {
        $.ajax({
            async:true,
            cache:false,
            dataType:"html",
            type: 'POST',
            url: '<?php echo base_url('Contacto/detalles_contacto'); ?>',
            data: {id_cnt:id},
            success:  function(data){
                if(data){
                    $('#modal').html(data);
                    $('#ver').modal();
                }
            },
            beforeSend:function(){},
            error:function(objXMLHttpRequest){}
            });
    }

    function marcar(id,num){
        Swal.fire({
        title: '¿Seguro de marcar como leída la solicitud?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Marcar'
        }).then((result) => {
        if (result.value) {
            $.ajax({
            async:true,
            cache:false,
            dataType:"html",
            type: 'POST',
            url: '<?php echo base_url('Contacto/marcar_leida'); ?>',
            data: {id_cnt:id},
            success:  function(data){
                if(data){
                    $('#ent_'+num).html("<span class=\"chip blue lighten-5\"><span class=\"black-text\">Respondida</span></span>");
                    Swal.fire(
                        'Respondida',
                        '',
                        'success'
                    );
                }
            },
            beforeSend:function(){},
            error:function(objXMLHttpRequest){}
            });
        }
        });
    }
    </script>
</body>

</html>
