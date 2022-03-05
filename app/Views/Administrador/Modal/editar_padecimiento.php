<div id="editar" class="modal">
    <?php
        $hidden = [
            'id_padecimiento' => $id_padecimiento
        ];

        echo form_open('Padecimientos/editar_padecimiento','',$hidden);
    ?>
        <div class="modal-content">
            <h4>Editar Padecimiento</h4>
            <div class="row">
                <div class="input-field col s12">
                    <input required name="nombre" id="nombre" type="text" class="validate" value="<?php echo $nombre; ?>">
                    <label for="nombre">Nombre</label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s12">
                    <textarea name="descripcion" id="textarea1_e" class="materialize-textarea"></textarea>
                    <label for="textarea1_e">Descripción</label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s12">
                    <?php echo form_dropdown('producto', $productos, $producto, 'class="form-control" id="select_e"'); ?>
                    <label for="textarea1">Producto asignado</label>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <a href="#!" class="modal-close waves-effect waves-green btn-flat">Cerrar</a>
            <button type="submit" class=" waves-effect waves-green btn-flat">Guardar</button>
        </div>
    </form>
</div>

<script>
    $('#productos').DataTable( {
        select: false,
        searching: false,
        ordering:  false,
        info:     false,
        scrollCollapse: false,
        paging:         false,
        columns: [
            { data: 'Nombre' },
        ],
        language: {
            url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        }
    } );

    $(document).ready(function(){
        $('#textarea1_e').val('<?php echo $descripcion; ?>');
        $('#editar').modal('open');
        $('#select_e').formSelect();

        M.updateTextFields();
        M.textareaAutoResize($('#textarea1_e'));
    });
</script>
