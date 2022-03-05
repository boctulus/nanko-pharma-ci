<div id="editar" class="modal">
    <?php
        $hidden = [
            'id_blog' => $id_blog
        ];
        echo form_open_multipart('Blog/editar_blog','onsubmit="return guardar_summernote_e()"',$hidden);
    ?>

        <div class="modal-content">
            <h4>Editar Entrada</h4>
            <div class="row">
                <div class="input-field col s12 center-align">
                    <img style="max-width: 25%;" class="responsive-img" src="<?php echo $img; ?>">
                </div>
            </div>
            <div class="row">
                <div class="input-field col s12">
                    <input required name="titulo" id="titulo_e" type="text" class="validate" value="<?php echo $titulo; ?>">
                    <label for="titulo_e">Título</label>
                    <input name="contenido" id="contenido_e" type="hidden"/>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s12">
                    <textarea required name="descripcion" id="textarea1_e" class="materialize-textarea"></textarea>
                    <label for="textarea1_e">Descripción</label>
                </div>
            </div>
            <div class="row">
                <div id="summernote_e"></div>
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
        let code = '<?php echo $contenido; ?>';
        $('#summernote_e').summernote({
            // code: code,
            callbacks: {
                onDialogShown: function() {
                    $('.note-modal-backdrop').remove();
                }
            }
        });
        $('#summernote_e').summernote('code',code);

        $('#textarea1_e').val('<?php echo $descripcion; ?>');
        $('#editar').modal('open')

        M.updateTextFields();
        M.textareaAutoResize($('#textarea1_e'));
    });


    function guardar_summernote_e() {
        $('#contenido_e')[0].value = $('#summernote_e').summernote('code');
        return true;
    }
</script>