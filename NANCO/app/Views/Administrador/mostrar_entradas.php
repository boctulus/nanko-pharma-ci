<!DOCTYPE html>
<!-- <html class="loading" lang="en" data-textdirection="ltr"> -->

<?php echo view("Layout/header"); ?>

<!-- <body class="vertical-layout page-header-light vertical-menu-collapsible vertical-dark-menu preload-transitions 2-columns   " data-open="click" data-menu="vertical-dark-menu" data-col="2-columns"> -->
    
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
    
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>

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
                            <h5 class="breadcrumbs-title mt-0 mb-0"><span>Entradas de blog</span></h5>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col s12">
                <div class="container">
                    <!-- users list start -->
                    <section class="users-list-wrapper section">
                        
                        <!-- Modal Trigger -->
                        <a class="waves-effect waves-light btn modal-trigger" href="#nuevo">Nueva Entrada</a>
                        <div class="users-list-table">
                            
                            <div class="card">
                                <div class="card-content">
                                    <!-- datatable start -->
                                    <div class="responsive-table">
                                        <table id="lista" class="table">
                                            <thead>
                                                <tr>
                                                    <th>Fecha</th>
                                                    <th>Título</th>
                                                    <th>Estado</th>
                                                    <th>Editar</th>
                                                    <th>Manejo</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i=0;foreach ($entradas as $obj): ?>
                                                    <tr>
                                                        <td><a><?php echo $obj['fecha'] ?></a></td>
                                                        <td><a><?php echo $obj['titulo'] ?></a></td>
                                                        <td id="ent_<?= $i; ?>">
                                                            <?php if ($obj['estado'] == "Activa"): ?>
                                                                <span class="chip green lighten-5">
                                                                    <span class="green-text">Activa</span>
                                                                </span>
                                                            <?php endif; ?>
                                                            <?php if ($obj['estado'] == "Eliminada"): ?>
                                                                <span class="chip red lighten-5">
                                                                    <span class="red-text">Eliminada</span>
                                                                </span>
                                                            <?php endif; ?>
                                                        </td>
                                                        <td><a href="#" onclick="editar('<?php echo $obj['id_blog'];?>',<?= $i; ?>)"><i class="material-icons">edit</i></a></td>
                                                        <td id="op_<?= $i; ?>">
                                                            <?php if ($obj['estado'] == "Activa"): ?>
                                                                <a href="#" onclick="eliminar('<?php echo $obj['id_blog'];?>',<?= $i; ?>)"><i class="material-icons">delete</i></a>
                                                            <?php endif; ?>
                                                            <?php if ($obj['estado'] == "Eliminada"): ?>
                                                                <a href="#" onclick="reactivar('<?php echo $obj['id_blog'];?>',<?= $i; ?>)"><i class="material-icons">add_circle_outline</i></a>
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
    <?php echo view("Administrador/Modal/nueva_entrada"); ?>
    <div id="modal"></div>

    <!-- fin modales -->

    <!-- END: Footer-->



    <script type="text/javascript">
      $('#summernote').summernote({
        // placeholder: 'Hello stand alone ui',
//        airMode: true,
        tabsize: 2,
        height: 120,
        toolbar: [
          ['style', ['style']],
          ['font', ['bold', 'underline', 'clear']],
          ['color', ['color']],
          ['para', ['ul', 'ol', 'paragraph']],
          ['table', ['table']],
          ['insert', ['link', 'picture', 'video']],
          ['view', ['fullscreen', 'codeview', 'help']]
        ],
        callbacks: {
            onDialogShown: function() {
                $('.note-modal-backdrop').remove();
            }
        }
      });

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
                { data: 'Título' },
                { data: 'Estado' },
                { data: 'Información' },
                { data: 'Manejo' },
            ],
            language: {
                url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
            }
        } );

        $(document).ready(function(){
            $('#nuevo').modal();
            //$('#select').formSelect();
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

        function editar(id) {
            $.ajax({
                async:true,
                cache:false,
                dataType:"html",
                type: 'POST',
                url: '<?php echo base_url('Blog/editar_blog'); ?>',
                data: {id_blg:id},
                success:  function(data){
                    if(data){
                        $('#modal').html(data);
                        $('#editar').modal();
                    }
                },
                beforeSend:function(){},
                error:function(objXMLHttpRequest){}
                });
        }

        function eliminar(id,num){
            Swal.fire({
            title: '¿Seguro de desactivar la entrada?',
            // text: "El padecimiento será desactivado y no podrá acceder al sistema.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Desactivar'
            }).then((result) => {
            if (result.value) {
                $.ajax({
                async:true,
                cache:false,
                dataType:"html",
                type: 'POST',
                url: '<?php echo base_url('Blog/eliminar_blog'); ?>',
                data: {id_blg:id},
                success:  function(data){
                    if(data){
                        $('#ent_'+num).html("<span class=\"chip red lighten-5\"><span class=\"red-text\">Eliminada</span></span>");
                        $('#op_'+num).html("<a href=\"#\" onclick=\"reactivar('"+id+"',"+num+")\"><i class=\"material-icons\">add_circle_outline</i></a>");
                        Swal.fire(
                            'Desactivado',
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

        function reactivar(id,num){
            Swal.fire({
            title: '¿Seguro de reactivar la entrada?',
            // text: "El padecimiento podrá volver acceder al sistema.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Reactivar'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                    async:true,
                    cache:false,
                    dataType:"html",
                    type: 'POST',
                    url: '<?php echo base_url('Blog/reactivar_blog'); ?>',
                    data: {id_blg:id},
                    success:  function(data){
                        if(data){
                            $('#ent_'+num).html("<span class=\"chip green lighten-5\"><span class=\"green-text\">Activa</span></span>");
                            $('#op_'+num).html("<a href=\"#\" onclick=\"eliminar('"+id+"',"+num+")\"><i class=\"material-icons\">delete</i></a>");
                            Swal.fire(
                                'Reactivado',
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
