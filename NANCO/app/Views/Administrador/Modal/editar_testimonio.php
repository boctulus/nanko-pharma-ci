<div id="editar" class="modal">
    <?php
        $hidden = [
            'id_testimonio' => $id_testimonio
        ];
        echo form_open_multipart('Testimonios/editar_testimonio','',$hidden);
    ?>
        <div class="modal-content">
            <h4>Editar Testimonio</h4>
            <div class="row">
                <div class="input-field col s12 center-align">
                    <img style="max-width: 25%;" class="responsive-img" src="<?php echo $img; ?>">
                </div>
            </div>
            <div class="row">
                <div class="input-field col s12">
                    <input required name="nombre" id="nombre" type="text" class="validate" value="<?php echo $nombre;?>">
                    <label for="nombre">Nombre</label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s12">
                    <input required name="titulo" id="titulo" type="text" class="validate" value="<?php echo $titulo;?>">
                    <label for="titulo">Título</label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s12">
                    <textarea name="mensaje" id="textarea1_e" class="materialize-textarea"></textarea>
                    <label for="textarea1_e">Mensaje</label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s12">
                    <div class="file-field input-field">
                        <div class="btn">
                            <span>File</span>
                            <input type="file" name="foto" accept=".jpg,.JPG,.png,.PNG,.jpeg,.JPEG" data-allowed-file-extensions='["jpg", "png", "jpeg"]'>
                        </div>
                        <div class="file-path-wrapper">
                            <input class="file-path validate" type="text">
                        </div>
                    </div>
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
        $('#textarea1_e').val('<?php echo $mensaje; ?>');
        $('#editar').modal('open')

        M.updateTextFields();
        M.textareaAutoResize($('#textarea1_e'));
    });
</script>