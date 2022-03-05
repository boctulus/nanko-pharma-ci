<div id="dosis_modal_tabla" class="modal">
    <div class="modal-content">
        <h4>Ver Dosis</h4>
        <div class="row">
            <table id="dosis_table" class="table">
                <thead>
                    <tr>
                        <th>Padecimiento</th>
                        <th>Fecha Creación</th>
                        <th>Edad Mínima</th>
                        <th>Edad Máxima</th>
                        <th>Peso Mínimo</th>
                        <th>Peso Máximo</th>
                        <th>Aumentar dosis</th>
                        <th>Número de gotas</th>
                        <th>Estatus</th>
                        <th>Opciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i=0;foreach ($dosis as $obj): ?>
                        <tr>
                            <td><?php echo $obj['padecimiento'] ?></td>
                            <td><?php echo $obj['fecha'] ?></td>
                            <td><?php echo $obj['edad_min'] ?></td>
                            <td><?php echo $obj['edad_max'] ?></td>
                            <td><?php echo $obj['peso_min'] ?></td>
                            <td><?php echo $obj['peso_max'] ?></td>
                            <td><?php echo $obj['subir'] ?></td>
                            <td><?php echo $obj['resultado'] ?></td>
                            <td id="dos_<?= $i; ?>">
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
                            <td id="opds_<?= $i; ?>">
                                <a href="#" onclick="editar_dosis('<?php echo $obj['id_dosis'];?>',<?= $i; ?>)"><i class="material-icons">edit</i></a>
                                <?php if ($obj['estado'] == "Activa"): ?>
                                    <a href="#" onclick="eliminar_dosis('<?php echo $obj['id_dosis'];?>',<?= $i; ?>)"><i class="material-icons">delete</i></a>
                                <?php endif; ?>
                                <?php if ($obj['estado'] == "Eliminada"): ?>
                                    <a href="#" onclick="reactivar_dosis('<?php echo $obj['id_dosis'];?>',<?= $i; ?>)"><i class="material-icons">add_circle_outline</i></a>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php $i++; ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="modal-footer">
        <a href="#!" class="modal-close waves-effect waves-green btn-flat">Cerrar</a>
        <button class=" waves-effect waves-green btn-flat" onclick="nueva_dosis()">Nueva Dosis</button>
    </div>
</div>

<script>
    var tabla_dosis = $('#dosis_table').DataTable( {
        select: true,
        searching: false,
        ordering:  false,
        info:     false,
        scrollCollapse: true,
        paging:         true,
        //"emptyTable": "No disponible en la tabla",

        columns: [
            { data: 'Padecimiento' },
            { data: 'Fecha Creación' },
            { data: 'Edad Mínima' },
            { data: 'Edad Máxima' },
            { data: 'Peso Mínimo' },
            { data: 'Peso Máximo' },
            { data: 'Aumentar dosis' },
            { data: 'Número de gotas' },
            { data: 'Estatus' },
            { data: 'Opciones' }
        ],
        language: {
            url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        }
    } );

    $(document).ready(function(){
        $('#dosis_modal_tabla').modal('open');
    });


    function nueva_dosis(){
        $('#dosis_modal_tabla').modal('close');
        $('#nueva_dosis').modal('open');
    }

    function editar_dosis(id) {
        $.ajax({
            async:true,
            cache:false,
            dataType:"html",
            type: 'POST',
            url: '<?php echo base_url('Productos/editar_dosis'); ?>',
            data: {id_ds:id},
            success:  function(data){
                if(data){
                    $('#dosis_modal_tabla').modal('close');
                    $('#modal_dosis').html(data);
                    $('#editar_dosis_p').modal();
                }
            },
            beforeSend:function(){},
            error:function(objXMLHttpRequest){}
        });
    }

    function eliminar_dosis(id,num){
        Swal.fire({
        title: '¿Seguro de desactivar la dosis?',
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
            url: '<?php echo base_url('Productos/eliminar_dosis'); ?>',
            data: {id_dosis:id},
            success:  function(data){
                if(data){
                    $('#dos_'+num).html("<span class=\"chip red lighten-5\"><span class=\"red-text\">Eliminada</span></span>");
                    $('#opds_'+num).html("<a href=\"#\" onclick=\"reactivar_dosis('"+id+"',"+num+")\"><i class=\"material-icons\">add_circle_outline</i></a>");
                    Swal.fire(
                        'Desactivada',
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

    function reactivar_dosis(id,num){
        Swal.fire({
        title: '¿Seguro de reactivar la dosis?',
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
                url: '<?php echo base_url('Productos/reactivar_dosis'); ?>',
                data: {id_dosis:id},
                success:  function(data){
                    if(data){
                        $('#ent_'+num).html("<span class=\"chip green lighten-5\"><span class=\"green-text\">Activo</span></span>");
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
