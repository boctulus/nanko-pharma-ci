<!DOCTYPE html>
<!-- <html class="loading" lang="en" data-textdirection="ltr"> -->
<?php echo view("Layout/header"); ?>
<title>Ordenes</title>

<!-- <body class="vertical-layout page-header-light vertical-menu-collapsible vertical-dark-menu preload-transitions 2-columns   " data-open="click" data-menu="vertical-dark-menu" data-col="2-columns"> -->

<?php echo view("Layout/navbar"); ?>

<!-- BEGIN: SideNav-->
<?php echo view("Layout/sidebar"); ?>
<!-- END: SideNav-->

<!-- BEGIN: Page Main-->
<div id="main">
    <div class="row">
        <div id="breadcrumbs-wrapper" data-image="/app-assets/images/gallery/breadcrumb-bg.jpg">
            <!-- Search for small screen-->
            <div class="container">
                <div class="row">
                    <div class="col s12 m12 l6">
                        <h5 class="breadcrumbs-title mt-0 mb-0"><span>Órdenes</span></h5>
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
                                                <th>No Orden</th>
                                                <th>Cliente</th>
                                                <th>Tipo</th>
                                                <th>Fecha</th>
                                                <th>Precio de Envio</th>
                                                <th>Precio Total</th>
                                                <th>Estado</th>
                                                <th>Tipo Pago</th>
                                                <th>ID Pago</th>
                                                <th>Estado Pago</th>
                                                <th>Opciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if ($ordenes) : ?>
                                                <?php $i = 0;
                                                foreach ($ordenes as $obj) : ?>
                                                    <tr>
                                                        <td><?php echo $obj['id_orden'] ?></td>
                                                        <td><?php echo $obj['cliente'] ?></td>
                                                        <td><?php echo $obj['tipo'] ?></td>
                                                        <td><?php echo $obj['fecha'] ?></td>
                                                        <td><?php echo $obj['precio_envio'] ?></td>
                                                        <td><?php echo $obj['precio'] ?></td>
                                                        <td id="ent_<?= $i; ?>">
                                                            <?php if ($obj['estado'] == "Pedida") : ?>
                                                                <span class="chip teal lighten-5">
                                                                    <span class="teal-text">Pedida</span>
                                                                </span>
                                                            <?php endif; ?>
                                                            <?php if ($obj['estado'] == "Confirmada") : ?>
                                                                <span class="chip light-blue lighten-5">
                                                                    <span class="light-blue-text">Confirmada</span>
                                                                </span>
                                                            <?php endif; ?>
                                                            <?php if ($obj['estado'] == "Enviada") : ?>
                                                                <span class="chip green lighten-5">
                                                                    <span class="green-text">Enviada</span>
                                                                </span>
                                                            <?php endif; ?>
                                                            <?php if ($obj['estado'] == "Finalizada") : ?>
                                                                <span class="chip grey lighten-5">
                                                                    <span class="grey-text">Finalizada</span>
                                                                </span>
                                                            <?php endif; ?>
                                                            <?php if ($obj['estado'] == "Cancelada") : ?>
                                                                <span class="chip red lighten-5">
                                                                    <span class="red-text">Cancelada</span>
                                                                </span>
                                                            <?php endif; ?>
                                                        </td>
                                                        <td><?php echo $obj['tipo_pago'] ?></td>

                                                        <td>
                                                            <?php echo $obj['id_openpay'] ?>
                                                        </td>
                                                        <td>
                                                            <?php echo $obj['estado_pago'] ?>
                                                        </td>
                                                        <td id="op_<?= $i; ?>">
                                                            <a href="#" title="Ver Productos" onclick="ver('<?php echo $obj['id_orden']; ?>')"><i class="material-icons">remove_red_eye</i></a>
                                                            <?php if ($obj['estado'] == "Enviada") : ?>
                                                                <a href="#" title="Finalizar Orden" onclick="finalizar('<?php echo $obj['id_orden']; ?>',<?= $i; ?>)"><i class="material-icons">done_all</i></a>
                                                            <?php endif; ?>
                                                            <?php if ($obj['estado'] == "Pedida") : ?>
                                                                <a href="#" title="Aceptar Orden" onclick="aceptar('<?php echo $obj['id_orden']; ?>',<?= $i; ?>)"><i class="material-icons">check</i></a>
                                                                <a href="#" title="Cancelar Orden" onclick="eliminar('<?php echo $obj['id_orden']; ?>',<?= $i; ?>)"><i class="material-icons">delete</i></a>
                                                            <?php endif; ?>
                                                            <?php if ($obj['estado'] == "Confirmada") : ?>
                                                                <a href="#" title="Añadir número de guía" onclick="num_guia('<?php echo $obj['id_orden']; ?>',<?= $i; ?>)"><i class="material-icons">add</i></a>
                                                            <?php endif; ?>
                                                        </td>
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




<script>
    var tabla_partida = $('#lista').DataTable({
        select: true,
        searching: true,
        ordering: true,
        info: true,
        scrollCollapse: true,
        paging: true,
        //"emptyTable": "No disponible en la tabla",
        columns: [{
                data: 'No Orden'
            },
            {
                data: 'Cliente'
            },
            {
                data: 'Tipo'
            },
            {
                data: 'Fecha'
            },
            {
                data: 'Tipo Pago'
            },
            {
                data: 'Precio de Envio'
            },
            {
                data: 'Precio Total'
            },
            {
                data: 'Estado'
            },
            {
                data: 'ID Pago'
            },
            {
                data: 'Estado Pago'
            },
            {
                data: 'Opciones'
            }
        ],
        language: {
            url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        }
    });

    $(document).ready(function() {
        <?php if (session('aviso')) : ?>
            Swal.fire({
                icon: 'info',
                html: '<p class="text-left" style="font-size:15px;"><?php echo session('aviso') ?></p>',
                showCloseButton: true,
                focusConfirm: false,
            });
        <?php endif; ?>
        <?php if (session('error')) : ?>
            Swal.fire({
                title: '<strong><u>Formulario incompleto</u></strong>',
                icon: 'error',
                html: '<p class="text-left" style="font-size:15px;"><?php foreach (session('error')['error'] as $error) { echo "-$error <br>"; } ?></p>',
                showCloseButton: true,
                focusConfirm: false,
            });
            <?php if (session('error')['tipo'] == "nuevo") : ?>
                $('#nuevo').modal('open');
            <?php endif; ?>

        <?php endif; ?>
    });

    function num_guia(id, num) {
        Swal.fire({
            title: 'Escriba el número de guía',
            input: 'text',
            inputAttributes: {
                autocapitalize: 'off'
            },
            confirmButtonText: 'Enviar',
            showLoaderOnConfirm: true,
            preConfirm: (num) => {
                return $.ajax({
                    async: true,
                    cache: false,
                    dataType: "html",
                    type: 'POST',
                    url: '<?php echo base_url('Envios/enviar_guia'); ?>',
                    data: {
                        numero: num,
                        id: id,
                    },
                    success: function(data_cod) {
                        let datos_cod = JSON.parse(data_cod);
                        if (datos_cod.bandera == 1) {
                            return datos_cod.mensaje;

                        } else if (datos_cod.bandera == 0) {
                            Swal.showValidationMessage(datos_cod.mensaje);
                            return false;
                        }
                    },
                    beforeSend: function() {},
                    error: function(objXMLHttpRequest) {}
                });
            },
        }).then((result) => {
            if (result.value) {
                let datos = JSON.parse(result.value);
                $('#ent_' + num).html("<span class=\"chip green lighten-5\"><span class=\"green-text\">Enviada</span></span>");
                $('#op_' + num).html("<a href=\"#\" title=\"Ver Productos\" onclick=\"ver('" + id + "')\"><i class=\"material-icons\">remove_red_eye</i></a> <a href=\"#\" title=\"Finalizar Orden\" onclick=\"finalizar('" + id + "'," + num + ")\"><i class=\"material-icons\">done_all</i></a>");
                Swal.fire(
                    'Aviso',
                    datos.mensaje,
                    'success'
                );
            }
        });
    }

    function ver(id) {
        $.ajax({
            async: true,
            cache: false,
            dataType: "html",
            type: 'POST',
            url: '<?php echo base_url('Envios/ver_productos'); ?>',
            data: {
                id_orden: id
            },
            success: function(data) {
                if (data) {
                    $('#modal').html(data);
                    $('#ver').modal();
                }
            },
            beforeSend: function() {},
            error: function(objXMLHttpRequest) {}
        });
    }

    function editar(id) {
        $.ajax({
            async: true,
            cache: false,
            dataType: "html",
            type: 'POST',
            url: '<?php echo base_url('Usuarios/editar_usuario'); ?>',
            data: {
                id_user: id
            },
            success: function(data) {
                if (data) {
                    $('#modal').html(data);
                    $('#editar').modal();
                }
            },
            beforeSend: function() {},
            error: function(objXMLHttpRequest) {}
        });
    }

    function eliminar(id, num) {
        Swal.fire({
            title: '¿Seguro de cancelar la orden?',
            text: "La orden será cancelada y el usuario será notificado.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Cancelar'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    async: true,
                    cache: false,
                    dataType: "html",
                    type: 'POST',
                    url: '<?php echo base_url('Envios/cancelar_orden'); ?>',
                    data: {
                        id_orden: id
                    },
                    success: function(data) {
                        let datos_cod = JSON.parse(data);
                        if (datos_cod.bandera == 1) {
                            $('#ent_' + num).html("<span class=\"chip red lighten-5\"><span class=\"red-text\">Cancelada</span></span>");
                            $('#op_' + num).html("<a href=\"#\" title=\"Ver Productos\" onclick=\"ver('" + id + "')\"><i class=\"material-icons\">remove_red_eye</i></a> ");
                            Swal.fire(
                                'Cancelada',
                                datos_cod.mensaje,
                                'success'
                            );
                        } else if (datos_cod.bandera == 0) {
                            Swal.fire(
                                'Error',
                                datos_cod.mensaje,
                                'error'
                            );
                        }

                    },
                    beforeSend: function() {},
                    error: function(objXMLHttpRequest) {}
                });
            }
        });
    }

    function finalizar(id, num) {
        Swal.fire({
            title: '¿Seguro de finalizar la orden?',
            text: "Esto significa que el paquete fue recibido por el cliente.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Finalizar'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    async: true,
                    cache: false,
                    dataType: "html",
                    type: 'POST',
                    url: '<?php echo base_url('Envios/finalizar_orden'); ?>',
                    data: {
                        id_orden: id
                    },
                    success: function(data) {
                        if (data) {
                            $('#ent_' + num).html("<span class=\"chip grey lighten-5\"><span class=\"grey-text\">Finalizada</span></span>");
                            $('#op_' + num).html("<a href=\"#\" title=\"Ver Productos\" onclick=\"ver('" + id + "')\"><i class=\"material-icons\">remove_red_eye</i></a> ");
                            Swal.fire(
                                'Finalizada',
                                '',
                                'success'
                            );
                        }
                    },
                    beforeSend: function() {},
                    error: function(objXMLHttpRequest) {}
                });
            }
        });
    }

    function aceptar(id, num) {
        Swal.fire({
            title: '¿Seguro de aceptar la orden?',
            text: "Los productos serán apartados del stock y se permitirá escribir la orden de envío",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Aceptar'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    async: true,
                    cache: false,
                    dataType: "html",
                    type: 'POST',
                    url: '<?php echo base_url('Envios/aceptar_orden'); ?>',
                    data: {
                        id_orden: id
                    },
                    success: function(data) {
                        let datos = JSON.parse(data);
                        if (datos.bandera == 1) {
                            console.log(num);
                            $('#ent_' + num).html("<span class=\"chip light-blue lighten-5\"><span class=\"light-blue-text\">Confirmada</span></span>");
                            $('#op_' + num).html("<a href=\"#\" title=\"Ver Productos\" onclick=\"ver('" + id + "')\"><i class=\"material-icons\">remove_red_eye</i></a>  <a href=\"#\" title=\"Añadir número de guía\" onclick=\"num_guia('" + id + "'," + num + ")\"><i class=\"material-icons\">add</i></a>");
                            Swal.fire(
                                'Confirmada',
                                datos.mensaje,
                                'success'
                            );
                        }else{
                            Swal.fire(
                                'Error',
                                datos.mensaje,
                                'error'
                            );
                        }
                    },
                    beforeSend: function() {},
                    error: function(objXMLHttpRequest) {}
                });
            }
        });
    }

</script>
</body>

</html>
