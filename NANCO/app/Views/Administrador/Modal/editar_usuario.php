<div id="editar" class="modal">
    <?php
        $hidden = [
            'id_login' => $id_login
        ];

        echo form_open('Usuarios/editar_usuario','', $hidden);
    ?>
        <div class="modal-content">
            <h4>Editar Usuario</h4>
            <div class="row">
                <div class="input-field col s6">
                    <input required name="nombre" id="nombre_e" type="text" class="validate" value="<?php echo $nombre; ?>">
                    <label for="nombre_e">Nombre</label>
                </div>
                <div class="input-field col s6">
                    <input required name="correo" id="last_name_e" type="email" class="validate" value="<?php echo $correo; ?>">
                    <label for="last_name_e">Correo</label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s12">
                    <select id="select_e" required name="tipo">
                        <option <?php if($tipo_usuario == 1){echo "selected";}?> value="1">Administrador</option>
                        <option <?php if($tipo_usuario == 4){echo "selected";}?> value="4">Envíos</option>
                    </select>
                    <label>Tipo de Usuario</label>
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
        $('#select_e').formSelect();
        $('#editar').modal('open');
    });

</script>
