<div id="nuevo" class="modal">
    <?php
        echo form_open_multipart('Productos/nuevo_producto');
    ?>
        <div class="modal-content">
            <h4>Nuevo Producto</h4>
            <div class="row">
                <div class="input-field col s12">
                    <input required name="nombre" id="nombre" type="text" class="validate">
                    <label for="nombre">Nombre</label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s12">
                    <input name="nombre_ing" id="nombre_ing" type="text" class="validate">
                    <label for="nombre">Nombre en inglés</label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s6">
                    <?php echo form_dropdown('categoria', $categorias_drop, '', 'class="form-control" id="select" required'); ?>
                    <label for="select">Categoría</label>
                </div>
                <div class="input-field col s6">
                    <input required name="peso" id="peso" type="text" class="validate">
                    <label for="peso">Peso en gr</label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s12">
                    <textarea required name="descripcion" id="textarea1" class="materialize-textarea"></textarea>
                    <label for="textarea1">Descripción</label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s12">
                    <textarea required name="descripcion_ing" id="textareai" class="materialize-textarea"></textarea>
                    <label for="textareai">Descripción en inglés</label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s12">
                    <h5 >Regiones de venta</h5>
                    <div class="col s6">
                        <p>
                            <label>
                                <input name="region[]" value="1" type="checkbox" class="filled-in" checked="checked" onchange="togle_disabled(1)"/>
                                <span>México</span>
                            </label>
                        </p>
                        <p>
                            <label>
                                <input name="region[]" value="2" type="checkbox" class="filled-in" checked="checked" onchange="togle_disabled(2)"/>
                                <span>Perú</span>
                            </label>
                        </p>
                        <p>
                            <label>
                                <input name="region[]" value="3" type="checkbox" class="filled-in" checked="checked" onchange="togle_disabled(3)"/>
                                <span>Europa</span>
                            </label>
                        </p>
                    </div>
                    <div class="col s6">
                        <p>
                            <label>
                                <input name="region[]" value="4" type="checkbox" class="filled-in" checked="checked" onchange="togle_disabled(4)"/>
                                <span>Argentina</span>
                            </label>
                        </p>
                        <p>
                            <label>
                                <input name="region[]" value="5" type="checkbox" class="filled-in" checked="checked" onchange="togle_disabled(5)"/>
                                <span>Resto del Mundo</span>
                            </label>
                        </p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s6 m3">
                    <input required name="precio_1" id="precio_1" type="number" class="validate" min="0" step="any">
                    <label for="precio_1">Precio México</label>
                </div>
                <div class="input-field col s6 m3">
                    <input name="desc_mex" id="desc_1" value="50" type="text" class="validate" onchange="checkDesc(1)">
                    <label for="desc_1">Descuento Máximo México</label>
                </div>
                <div class="input-field col s6 m3">
                    <input required name="precio_2" id="precio_2" type="number" class="validate" min="0" step="any">
                    <label for="precio_2">Precio Perú</label>
                </div>
                <div class="input-field col s6 m3">
                    <input name="desc_peru" id="desc_2" value="50" type="text" class="validate" onchange="checkDesc(2)">
                    <label for="desc_2">Descuento Máximo Perú</label>
                </div>
                <div class="input-field col s6 m3">
                    <input required name="precio_3" id="precio_3" type="text" class="validate" min="0" step="any">
                    <label for="precio_3">Precio Europa</label>
                </div>
                <div class="input-field col s6 m3">
                    <input name="desc_eur" id="desc_3" value="50" type="text" class="validate" onchange="checkDesc(3)">
                    <label for="desc_3">Descuento Máximo Europa</label>
                </div>
                <div class="input-field col s6 m3">
                    <input required name="precio_4" id="precio_4" type="text" class="validate" min="0" step="any">
                    <label for="precio_4">Precio Argentina</label>
                </div>
                <div class="input-field col s6 m3">
                    <input name="desc_arg" id="desc_4" value="50" type="text" class="validate" onchange="checkDesc(4)">
                    <label for="desc_4">Descuento Máximo Argentina</label>
                </div>
                <div class="input-field col s6 m3">
                    <input required name="precio_5" id="precio_5" type="text" class="validate" min="0" step="any">
                    <label for="precio_5">Precio Resto del Mundo</label>
                </div>
                <div class="input-field col s6 m3">
                    <input name="desc_rest" id="desc_5" value="50" type="text" class="validate" onchange="checkDesc(5)">
                    <label for="desc_5">Descuento Máximo Resto</label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s12">
                    <input required name="stock" id="stock" type="number" class="validate" min="0">
                    <label for="stock">Stock</label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s12">
                    <div class="file-field input-field">
                        <div class="btn">
                            <span>Foto de portada</span>
                            <input type="file" name="foto" required accept=".jpg,.JPG,.png,.PNG,.jpeg,.JPEG" data-allowed-file-extensions='["jpg", "png", "jpeg"]'>
                        </div>
                        <div class="file-path-wrapper">
                            <input class="file-path validate" type="text">
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="input-field col s12">
                    <div class="file-field input-field">
                        <div class="btn">
                            <span>Fotos Secundarias(opcional)</span>
                            <input type="file" multiple name="fotos_sec[]" accept=".jpg,.JPG,.png,.PNG,.jpeg,.JPEG" data-allowed-file-extensions='["jpg", "png", "jpeg"]'>
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
            <button id="submitButton" type="submit" class=" waves-effect waves-green btn-flat">Guardar</button>
        </div>
    </form>
</div>

<script>
    function togle_disabled(num){
        $("#precio_"+num).prop("disabled", (_, val) => !val);
        $("#desc_"+num).prop("disabled", (_, val) => !val);
    }

    function checkDesc(id) {
        let val = $('#desc_'+id).val();
        if (isNaN(val)) {
            $("#submitButton").prop("disabled", true);
            Swal.fire({
                confirmButtonText: 'Ok',
                confirmButtonAriaLabel: 'Ok',
                //showCancelButton: true,
                title: 'Error',
                icon: 'error',
                text: 'El descuento solo debe contener números decimales.'
            });
        } else if (val > 50) {
            $("#submitButton").prop("disabled", true);
            Swal.fire({
                confirmButtonText: 'Ok',
                confirmButtonAriaLabel: 'Ok',
                //showCancelButton: true,
                title: 'Error',
                icon: 'error',
                text: 'El descuento debe ser menor a 50.'
            });
        }
        else {
            $("#submitButton").prop("disabled", false);
        }
    }
</script>
<!-- $('#textarea1').val('New Text'); -->
