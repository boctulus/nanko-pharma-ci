<div id="nuevo" class="modal">
    <?php
        echo form_open('Padecimientos/nuevo_padecimiento');
    ?>
        <div class="modal-content">
            <h4>Nuevo Padecimiento</h4>
            <div class="row">
                <div class="input-field col s12">
                    <input required name="nombre" id="nombre" type="text" class="validate">
                    <label for="nombre">Nombre</label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s12">
                    <textarea name="descripcion" id="textarea1" class="materialize-textarea"></textarea>
                    <label for="textarea1">Descripción</label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s12">
                    <?php echo form_dropdown('producto', $productos, '', 'class="form-control" id="select"'); ?>
                    <label for="textarea1">Producto</label>
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
