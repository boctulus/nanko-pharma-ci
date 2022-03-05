<!DOCTYPE html>
<!-- <html class="loading" lang="en" data-textdirection="ltr"> -->

<?php echo view("Layout/header"); ?>
<link rel="stylesheet" type="text/css" href="/app-assets/css/pages/eCommerce-products-page.css">

    <!-- BEGIN: Header-->
    <?php echo view("Layout/navbar"); ?>
    <!-- END: Header-->

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
                            <h5 class="breadcrumbs-title mt-0 mb-0"><span>Productos</span></h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col s12">
                <div class="container">
                    <div class="section">

                    <a class="waves-effect waves-light btn modal-trigger" href="#nuevo">Nuevo Producto</a>

                        <div class="row" id="ecommerce-products">
                            <div class="col s12 m3 l3 pr-0 hide-on-med-and-down animate fadeLeft">
                                <div class="card">
                                    <div class="card-content">
                                        <span class="card-title">Categorías</span>
                                        <hr class="p-0 mb-10">
                                        <ul class="collapsible categories-collapsible">
                                          <li>
                                              <div class="collapsible-header">
                                                  <a href="/Productos/mostrar_productos/">Todos</a>
                                              </div>
                                          </li>
                                            <?php foreach ($categorias as $cat): ?>
                                                <li>
                                                    <?php if ($cat['cat_hijas']): ?>
                                                        <div class="collapsible-header"><a href="/Productos/mostrar_productos/<?php echo $cat['id_categoria']?>"><?php echo $cat['nombre'] ?></a><i class="material-icons"> keyboard_arrow_right </i></div>
                                                            <div class="collapsible-body">
                                                            <?php foreach ($cat['cat_hijas'] as $hija): ?>
                                                                <a href="/Productos/mostrar_productos/ <?php echo $hija['id_categoria']?>"><p><?php echo $hija['nombre']?></p></a>
                                                            <?php endforeach; ?>
                                                            </div>
                                                    <?php else: ?>
                                                        <div class="collapsible-header"><a href="/Productos/mostrar_productos/<?php echo $cat['id_categoria']?>"> <?php echo $cat['nombre']; ?></a></div>
                                                    <?php endif; ?>
                                                </li>
                                            <?php endforeach; ?>
                                        </ul>

                                        <?php if ($padecimientos): ?>
                                            <span class="card-title mt-10">Padecimientos</span>
                                            <hr class="p-0 mb-10">
                                            <form action="#" class="display-grid">
                                                <?php foreach ($padecimientos as $pad): ?>
                                                    <label>
                                                        <input type="checkbox" />
                                                        <span><?php echo $pad['nombre']?></span>
                                                    </label>
                                                <?php endforeach; ?>
                                            </form>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>

                            <div class="col s12 m12 l9 pr-0">
                                <?php foreach ($producto as $obj): ?>
                                    <div class="col s12 m4 l4">
                                        <div class="card animate fadeLeft" style="max-height:681px; max-width:372px;">
                                            <div class="card-content">
                                                <p><?php echo $obj['categoria'] ?></p>
                                                <span class="card-title text-ellipsis" data-toggle="tooltip" data-placement="top" title="<?php echo $obj['nombre'] ?>" ><?php echo $obj['nombre'] ?></span>
                                                <img  src="<?php echo $obj['img']; ?>" style="max-height:400px; max-width:260px;" class="responsive-img" alt="">
                                                <div class="display-flex flex-wrap justify-content-left">
                                                    <h6 class="mt-3">Disponibilidad: <?php echo $obj['stock'] ?><h6>
                                                    <div class="col s12 m12">
                                                        <h6 class="mt-3">
                                                            <?php
                                                                if (strpos($obj['regiones'], "1") !== false) {
                                                                    echo "$".$obj['precio_1']."MX &nbsp;";
                                                                }
                                                                if (strpos($obj['regiones'], "2") !== false) {
                                                                    echo "S/ ".$obj['precio_2']."&nbsp;";
                                                                }
                                                                if (strpos($obj['regiones'], "3") !== false) {
                                                                    echo "€".$obj['precio_3']."EUR &nbsp;";
                                                                }
                                                                if (strpos($obj['regiones'], "4") !== false) {
                                                                    echo "$".$obj['precio_4']."ARG &nbsp;";
                                                                }
                                                                if (strpos($obj['regiones'], "5") !== false) {
                                                                    echo "$".$obj['precio_5']."US &nbsp;";
                                                                }
                                                            ?>
                                                        </h6>
                                                    </div>
                                                    <button class=" col s12 m12 mt-2 waves-effect waves-light gradient-45deg-deep-purple-blue btn btn-block" onclick="get_detalles('<?php echo $obj['idProducto'];?>')">Detalles</button>
                                                    <button class=" col s12 m12 mt-2 waves-effect waves-light gradient-45deg-deep-purple-blue btn btn-block" onclick="get_dosis('<?php echo $obj['idProducto'];?>')">Dosis</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                                <!-- Pagination -->
                                <div class="col s12 center">
                                    <ul class="pagination">
                                    <?php if ($pager) :?>
                                        <?php $pagi_path = 'Productos/mostrar_productos/'.$id_categoria; ?>
                                        <?php $pager->setPath($pagi_path); ?>
                                        <?= $pager->links() ?>
                                    <?php endif ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- <div style="bottom: 50px; right: 19px;" class="fixed-action-btn direction-top"><a class="btn-floating btn-large gradient-45deg-light-blue-cyan gradient-shadow"><i class="material-icons">add</i></a>
                        <ul>
                            <li><a href="css-helpers.html" class="btn-floating blue"><i class="material-icons">help_outline</i></a></li>
                            <li><a href="cards-extended.html" class="btn-floating green"><i class="material-icons">widgets</i></a></li>
                            <li><a href="app-calendar.html" class="btn-floating amber"><i class="material-icons">today</i></a></li>
                            <li><a href="app-email.html" class="btn-floating red"><i class="material-icons">mail_outline</i></a></li>
                        </ul>
                    </div> -->
                </div>
                <div class="content-overlay"></div>
            </div>
        </div>
    </div>
    <!-- END: Page Main-->

    <!-- BEGIN VENDOR JS-->
    <script src="/app-assets/js/vendors.min.js"></script>
    <!-- BEGIN VENDOR JS-->
    <!-- BEGIN PAGE VENDOR JS-->
    <script src="/app-assets/vendors/noUiSlider/nouislider.min.js"></script>
    <!-- END PAGE VENDOR JS-->
    <!-- BEGIN THEME  JS-->
    <script src="/app-assets/js/plugins.js"></script>
    <script src="/app-assets/js/search.js"></script>
    <script src="/app-assets/js/custom/custom-script.js"></script>
    <!-- END THEME  JS-->
    <!-- BEGIN PAGE LEVEL JS-->
    <script src="/app-assets/js/scripts/advance-ui-modals.js"></script>
    <script src="/app-assets/js/scripts/eCommerce-products-page.js"></script>
    <script src="/sweetalert2/dist/sweetalert2.all.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.js"></script>
    <script src="/app-assets/vendors/select2/select2.full.min.js"></script>
    <script src="/app-assets/js/scripts/form-select2.min.js"></script>
    <!-- END PAGE LEVEL JS-->

    <!-- modales -->
    <?php echo view("Administrador/Modal/nuevo_producto"); ?>
    <?php echo view("Administrador/Modal/nueva_dosis"); ?>
    <div id="modal"></div>
    <div id="modal_dosis"></div>
    <!-- end modales -->

    <script>
        var producto_actual = null;

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
        });

        $(document).ready(function(){
        //    $('#nuevo').modal();
            $('.modal').modal();
            $('.select2').select2({
                dropdownAutoWidth: true,
                width: '100%',
                placeholder: "Padecimientos",
                containerCssClass: 'select-lg'
            });
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
                    <?php if (isset($session->getFlashdata('error')['id_producto'])): ?>
                        $('#id_producto_dosis')[0].value = "<?php echo $session->getFlashdata('error')['id_producto']; ?>";
                        $('#nueva_dosis').modal('open');
                    <?php else: ?>
                        $('#nuevo').modal('open');
                    <?php endif; ?>
                <?php endif; ?>

            <?php endif; ?>
        });

        function get_detalles(id) {
            $.ajax({
            async:true,
            cache:false,
            dataType:"html",
            type: 'POST',
            url: '<?php echo base_url('Productos/editar_producto'); ?>',
            data: {
                id_prod:id,
                url: '<?php echo uri_string(true).'?'.current_url(true)->getQuery(); ?>'
            },
            success:  function(data){
                if(data){
                    producto_actual = id;
                    $('#modal').html(data);
                    $('#editar').modal();
                }
            },
            beforeSend:function(){},
            error:function(objXMLHttpRequest){}
            });
        }

        function get_dosis(id) {
            $.ajax({
            async:true,
            cache:false,
            dataType:"html",
            type: 'POST',
            url: '<?php echo base_url('Productos/get_dosis'); ?>',
            data: {id_prod:id},
            success:  function(data){
                if(data){
                    $('#id_producto_dosis')[0].value = id;
                    $('#modal').html(data);
                    $('#dosis_modal_tabla').modal();
                }
            },
            beforeSend:function(){},
            error:function(objXMLHttpRequest){}
            });
        }
    </script>
</body>

</html>
