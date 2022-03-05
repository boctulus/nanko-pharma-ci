<div id="nuevo" class="modal">
    <?php
        echo form_open_multipart('Testimonios/nuevo_testimonio');
    ?>
        <div class="modal-content">
            <h4>Nuevo Testimonio</h4>
            <div class="row">
                <div class="input-field col s12">
                    <input required name="nombre" id="nombre" type="text" class="validate">
                    <label for="nombre">Nombre</label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s12">
                    <input required name="titulo" id="titulo" type="text" class="validate">
                    <label for="titulo">Título</label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s12">
                    <textarea name="mensaje" id="textarea1" class="materialize-textarea"></textarea>
                    <label for="textarea1">Mensaje</label>
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

<!-- $('#textarea1').val('New Text'); -->
