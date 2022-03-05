<div id="ver" class="modal">
    <div class="modal-content">
        <h4>Detalles de contacto</h4>
        <div class="row">
            <div class="input-field col s12">
                <input readonly id="fecha_v" type="text" class="validate" value="<?php echo $fecha; ?>">
                <label for="fecha_v">Fecha</label>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s12">
                <input readonly id="nombre_v" type="text" class="validate" value="<?php echo $nombre; ?>">
                <label for="nombre_v">Nombre</label>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s12">
                <input readonly id="correo_v" type="text" class="validate" value="<?php echo $correo; ?>">
                <label for="correo_v">Correo</label>
            </div>
        </div>
        <?php if ($telefono): ?>
            <div class="row">
                <div class="input-field col s12">
                    <input readonly id="telefono_v" type="text" class="validate" value="<?php echo $telefono; ?>">
                    <label for="telefono_v">Teléfono</label>
                </div>
            </div>
        <?php endif; ?>
        <div class="row">
            <div class="input-field col s12">
                <textarea readonly name="descripcion" id="textarea1_v" class="materialize-textarea"></textarea>
                <label for="textarea1_v">Mensaje</label>
            </div>
        </div>
        <div class="row">
            <p>
                <label>
                    <input type="checkbox" class="" disabled <?php if($dep_med){ echo "checked"; } ?>/>
                    <span>Departamento Médico</span>
                </label>
            </p>
        </div>
    </div>
    <div class="modal-footer">
        <a href="#!" class="modal-close waves-effect waves-green btn-flat">Cerrar</a>
    </div>
</div>
<script>
    $(document).ready(function(){
        $('#textarea1_v').val('<?php echo $mensaje; ?>');
        $('#ver').modal('open')

        M.updateTextFields();
        M.textareaAutoResize($('#textarea1_v'));
    });
</script>
