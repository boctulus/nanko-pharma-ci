<div id="editar" class="modal">
    <?php
            $hidden = [
                'id_producto' => $idProducto,
                'url' => $url
            ];

        echo form_open_multipart('Productos/editar_producto','', $hidden);
    ?>
        <div class="modal-content">
            <h4>Detalles</h4>
            <div class="row">
                <div class="carousel">
                    <a class="carousel-item" href="#one!"><img src="<?php echo $img_port; ?>"></a>
                    <?php if ($img_sec): ?>
                        <?php foreach ($img_sec as $img): ?>
                            <?php if ($img): ?>
                                <a class="carousel-item" href="#two!"><img src="<?php echo $img; ?>"></a>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>

            </div>

            <div class="row">
                <div class="input-field col s12">
                    <input required name="nombre" id="nombre_e" type="text" class="validate" value="<?php echo $nombre; ?>">
                    <label for="nombre">Nombre</label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s12">
                    <select name="estado">
                        <option value="" disabled selected>Estado</option>
                        <option value="1" <?php if($estado == 1){ echo "selected"; } ?>>Activo</option>
                        <option value="0" <?php if($estado == 0){ echo "selected"; } ?>>Desactivado</option>
                    </select>
                    <label>Estado</label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s6">
                    <?php echo form_dropdown('categoria', $categorias_drop, $id_categoria, 'class="form-control" id="select_e" required'); ?>
                    <label for="textarea1">Categoría</label>
                </div>
                <div class="input-field col s6">
                    <input required name="peso" id="peso" type="text" class="validate"  value="<?php echo $peso; ?>">
                    <label for="peso">Peso en gr</label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s12">
                    <textarea required name="descripcion" id="textarea1_e" class="materialize-textarea"></textarea>
                    <label for="textarea1">Descripción</label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s12">
                    <textarea required name="descripcion_ing" id="textareai_e" class="materialize-textarea"></textarea>
                    <label for="textareai">Descripción en inglés</label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s12">
                    <h5 >Regiones de venta</h5>
                    <div class="col s6">
                        <p>
                            <label>
                                <input name="region[]" value="1" type="checkbox" class="filled-in" <?php if(strpos($regiones, "1") !== false){ echo "checked"; } ?>  onchange="togle_disabled_e(1)"/>
                                <span>México</span>
                            </label>
                        </p>
                        <p>
                            <label>
                                <input name="region[]" value="2" type="checkbox" class="filled-in" <?php if(strpos($regiones, "2") !== false){ echo "checked"; } ?> onchange="togle_disabled_e(2)"/>
                                <span>Peru</span>
                            </label>
                        </p>
                        <p>
                            <label>
                                <input name="region[]" value="3" type="checkbox" class="filled-in" <?php if(strpos($regiones, "3") !== false){ echo "checked"; } ?> onchange="togle_disabled_e(3)"/>
                                <span>Europa</span>
                            </label>
                        </p>
                    </div>
                    <div class="col s6">
                        <p>
                            <label>
                                <input name="region[]" value="4" type="checkbox" class="filled-in" <?php if(strpos($regiones, "4") !== false){ echo "checked"; } ?> onchange="togle_disabled_e(4)"/>
                                <span>Argentina</span>
                            </label>
                        </p>
                        <p>
                            <label>
                                <input name="region[]" value="5" type="checkbox" class="filled-in" <?php if(strpos($regiones, "5") !== false){ echo "checked"; } ?> onchange="togle_disabled_e(5)"/>
                                <span>Resto del Mundo</span>
                            </label>
                        </p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s6 m3">
                    <input required name="precio_1" id="precioe_1" <?php if(strpos($regiones, "1") !== false){ echo "value=\"".$precio_1."\""; }else{ echo "disabled";} ?> type="number" class="validate" min="0" step="any">
                    <label for="precio_1">Precio México</label>
                </div>
                <div class="input-field col s6 m3">
                    <input name="desc_mex" id="desce_1" type="text" class="validate" <?php if(strpos($regiones, "1") !== false){ echo "value=\"".$desc_mex."\""; }else{ echo "disabled";} ?> onchange="checkDesc_e(1)">
                    <label for="desce_1">Descuento Máximo México</label>
                </div>
                <div class="input-field col s6 m3">
                    <input required name="precio_2" id="precioe_2" <?php if(strpos($regiones, "2") !== false){ echo "value=\"".$precio_2."\""; }else{ echo "disabled";} ?> type="number" class="validate" min="0" step="any">
                    <label for="precio_2">Precio Perú</label>
                </div>
                <div class="input-field col s6 m3">
                    <input name="desc_peru" id="desce_2" type="text" class="validate" <?php if(strpos($regiones, "2") !== false){ echo "value=\"".$desc_peru."\""; }else{ echo "disabled";} ?> onchange="checkDesc_e(2)">
                    <label for="desce_2">Descuento Máximo Perú</label>
                </div>
                <div class="input-field col s6 m3">
                    <input required name="precio_3" id="precioe_3" <?php if(strpos($regiones, "3") !== false){ echo "value=\"".$precio_3."\""; }else{ echo "disabled";} ?> type="text" class="validate" min="0" step="any">
                    <label for="precio_3">Precio Europa</label>
                </div>
                <div class="input-field col s6 m3">
                    <input name="desc_eur" id="desce_3" type="text" class="validate" <?php if(strpos($regiones, "3") !== false){ echo "value=\"".$desc_eur."\""; }else{ echo "disabled";} ?> onchange="checkDesc_e(3)">
                    <label for="desce_3">Descuento Máximo Europa</label>
                </div>
                <div class="input-field col s6 m3">
                    <input required name="precio_4" id="precioe_4" <?php if(strpos($regiones, "4") !== false){ echo "value=\"".$precio_4."\""; }else{ echo "disabled";} ?> type="text" class="validate" min="0" step="any">
                    <label for="precio_4">Precio Argentina</label>
                </div>
                <div class="input-field col s6 m3">
                    <input name="desc_arg" id="desce_4" type="text" class="validate" <?php if(strpos($regiones, "4") !== false){ echo "value=\"".$desc_arg."\""; }else{ echo "disabled";} ?> onchange="checkDesc_e(4)">
                    <label for="desce_4">Descuento Máximo Argentina</label>
                </div>
                <div class="input-field col s6 m3">
                    <input required name="precio_5" id="precioe_5" <?php if(strpos($regiones, "5") !== false){ echo "value=\"".$precio_5."\""; }else{ echo "disabled";} ?> type="text" class="validate" min="0" step="any">
                    <label for="precio_5">Precio Resto del Mundo</label>
                </div>
                <div class="input-field col s6 m3">
                    <input name="desc_rest" id="desce_5" type="text" class="validate" <?php if(strpos($regiones, "5") !== false){ echo "value=\"".$desc_rest."\""; }else{ echo "disabled";} ?> onchange="checkDesc_e(5)">
                    <label for="desce_5">Descuento Máximo Resto</label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s12">
                    <input required name="stock" id="stock" type="number" class="validate" value="<?php echo $stock; ?>" min="0">
                    <label for="stock">Stock</label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s12">
                    <div class="file-field input-field">
                        <div class="btn">
                            <span>Foto de portada</span>
                            <input type="file" name="foto" accept=".jpg,.JPG,.png,.PNG,.jpeg,.JPEG" data-allowed-file-extensions='["jpg", "png", "jpeg"]'>
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
            <button id="submitButtone" type="submit" class=" waves-effect waves-green btn-flat">Guardar</button>
        </div>
    </form>
</div>

<script>
    $(document).ready(function(){
        $('#textarea1_e').val('<?php echo preg_replace("/[\r\n|\n|\r]+/", " ", $descripcion); ?>');
        $('#textareai_e').val('<?php echo preg_replace("/[\r\n|\n|\r]+/", " ", $descripcion_ingles); ?>');
        $('#editar').modal('open');
        $('.carousel').carousel();
        $('select').formSelect();


        M.updateTextFields();
        M.textareaAutoResize($('#textarea1_e'));
        M.textareaAutoResize($('#textareai_e'));
    });

    function togle_disabled_e(num){
        $("#precioe_"+num).prop("disabled", (_, val) => !val);
        $("#desce_"+num).prop("disabled", (_, val) => !val);
    }

    function checkDesc_e(id) {
        let val = $('#desce_'+id).val();
        if (isNaN(val)) {
            $("#submitButtone").prop("disabled", true);
            Swal.fire({
                confirmButtonText: 'Ok',
                confirmButtonAriaLabel: 'Ok',
                //showCancelButton: true,
                title: 'Error',
                icon: 'error',
                text: 'El descuento solo debe contener números decimales.'
            });
        } else if (val > 50) {
            $("#submitButtone").prop("disabled", true);
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
            $("#submitButtone").prop("disabled", false);
        }
    }
</script>
<!-- $('#textarea1').val('New Text'); -->
