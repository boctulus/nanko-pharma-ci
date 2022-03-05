<div id="editar" class="modal">
    <?php
        $hidden = [
            'id_colaborador' => $id_colaborador
        ];

        echo form_open('Colaboradores/editar_colaboradores','', $hidden);
    ?>
        <div class="modal-content">
            <h4>Editar Colaborador</h4>
            <div class="row">
                <div class="input-field col s6">
                    <input required name="nombre" id="nombre_e" type="text" class="validate" value="<?php echo $nombre; ?>">
                    <label for="nombre_e">Nombre</label>
                </div>
                <div class="row">
                </div>
                <div class="input-field col s6">
                    <input required name="apellidos" id="apellidos_e" type="text" class="validate" value="<?php echo $apellidos; ?>">
                    <label for="nombre_e">Apellidos</label>
                </div>
                <div class="input-field col s6">
                    <input required name="correo_n" id="correoN" readonly value="<?php echo $correo_n; ?>">
                </div>
                <div class="input-field col s6">
                    <select name="pais" id="pais_c_e" class="validate" onchange="get_estados_e()">
                        <option value="" disabled>Seleccione la región</option>
                        <option value="1" <?php if($pais == 1){echo "selected";}?>>México</option>
                        <option value="2" <?php if($pais == 2){echo "selected";}?>>Perú</option>
                        <option value="3" <?php if($pais == 3){echo "selected";}?>>Europa</option>
                        <option value="4" <?php if($pais == 4){echo "selected";}?>>Argentina</option>
                        <option value="5" <?php if($pais == 5){echo "selected";}?>>Resto del mundo</option>
                    </select>
                    <label>País</label>
                </div>
                <div class="input-field col s6">
                    <input type="text" id="estado_p_e" name="estado_p" class="autocomplete" value="<?php echo $estado_p; ?>">
                    <label for="estado_p_e">Estado</label>
                </div>
                <div class="input-field col s6">
                    <input required name="direccion" id="direccion_c" type="text" class="validate" value="<?php echo $direccion; ?>">
                    <label for="direccion">Direccion</label>
                </div>
                <div class="input-field col s6">
                    <input required name="correo_p" id="correoP" type="email" class="validate" value="<?php echo $correo_p; ?>">
                    <label for="correoP">Correo Personal</label>
                </div>
                <div class="input-field col s6">
                    <input required name="cp" id="codeP" type="text" class="validate" value="<?php echo $cp; ?>">
                    <label for="codeP">C.P</label>
                </div>
                <div class="input-field col s6">
                    <input required name="descuento" id="descuento_c" type="number" class="validate" value="<?php echo $descuento; ?>">
                    <label for="descuento_c">Descuento</label>
                </div>
                <div class="input-field col s6">
                    <input required name="telefono" id="telefono_c" type="text" class="validate" value="<?php echo $telefono; ?>">
                    <label for="telefono_c">Telefono</label>
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
    $(document).ready(function(){
        M.updateTextFields();
        $('#pais_c_e').formSelect();
        $('#editar').modal('open');
        $.ajax({
                async: true,
                cache: false,
                dataType: "html",
                type: 'POST',
                url: '<?php echo base_url('Colaboradores/get_estados'); ?>',
                data: {
                    pais: $('#pais_c_e').val()
                },
                success: function(data) {
                    let estados = JSON.parse(data);
                    $('input.autocomplete').autocomplete({
                        data: estados,
                    });
                },
                beforeSend: function() {},
                error: function(objXMLHttpRequest) {}
            });
    });

    function get_estados_e() {
        if($('#pais_c_e').val() != null){
            $('#estado_p_e').val("");
            $.ajax({
                async: true,
                cache: false,
                dataType: "html",
                type: 'POST',
                url: '<?php echo base_url('Colaboradores/get_estados'); ?>',
                data: {
                    pais: $('#pais_c_e').val()
                },
                success: function(data) {
                    let estados = JSON.parse(data);
                    $('input.autocomplete').autocomplete({
                        data: estados,
                    });
                },
                beforeSend: function() {},
                error: function(objXMLHttpRequest) {}
            });
        }else{
            $('#estado_p_e').val('');
        }
    }

</script>
