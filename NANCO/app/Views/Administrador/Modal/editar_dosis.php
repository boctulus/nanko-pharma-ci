<div id="editar_dosis_p" class="modal">
    <?php // echo form_open('Productos/editar_dosis','onsubmit="return checkeo_e()"'); ?>
        <div class="modal-content">
            <h4>Detalles de dosis</h4>
            <div class="row">
                <div class="input-field col s12">
                    <?php echo form_dropdown('padecimientos', $padecimientos_drop, '', 'class="select2 browser-default form-control" multiple="multiple" id="select_drop_e" required '); ?>
                    <label for="select_drop_e">Padecimientos</label>

                </div>
            </div>
            <div class="row">
                <div class="input-field col s12">
                    <span>Edad</span>
                    <div id="slider_edad_e"></div>
                    <input type="hidden" name="edad" id="edad_e">
                    <input type="hidden" name="id_dosis" id="id_dosis_e" value="<?php echo $id_dosis; ?>">
                </div>
            </div>
            <div class="row">
                <div class="input-field col s12">
                    <span>Peso</span>
                    <div id="slider_peso_e"></div>
                    <input type="hidden" name="peso" id="peso_e">
                </div>
            </div>
            <div class="row">
                <div class="input-field col s12">
                    <p>
                        <label>
                            <input name="subir_e" value="1" type="radio" required <?php if($subir == 1){echo "checked";} ?>/>
                            <span>Subir 1 gota después de dos semanas</span>
                        </label>
                    </p>
                    <p>
                        <label>
                            <input name="subir_e" value="2" type="radio" required <?php if($subir == 2){echo "checked";} ?>/>
                            <span>Subir 2 gotas después de dos semanas</span>
                        </label>
                    </p>
                </div>
            </div>
            <div class="input-field col s4">
                    <input id="num_gotas_m_e" type="text" class="validate" name="num_gotas_m" value="<?php echo $resultado_m; ?>">
                    <label for="num_gotas_m_e">Gotas en mañana</label>
                </div>
                <div class="input-field col s4">
                    <input id="num_gotas_t_e" type="text" class="validate" name="num_gotas_t" value="<?php echo $resultado_t; ?>">
                    <label for="num_gotas_t_e">Gotas en tarde</label>
                </div>
                <div class="input-field col s4">
                    <input id="num_gotas_n_e" type="text" class="validate" name="num_gotas_n" value="<?php echo $resultado_n; ?>">
                    <label for="num_gotas_n_e">Gotas en noche</label>
                </div>
            </div>

        <div class="modal-footer">
            <a href="#!" class="modal-close waves-effect waves-green btn-flat">Cerrar</a>
            <button type="button" class=" waves-effect waves-green btn-flat" onclick="send_info_e()">Guardar</button>
        </div>
    <!-- </form> -->

</div>
<script>
    $(document).ready(function(){
        M.updateTextFields();
        $('#editar_dosis_p').modal('open');

        let dropdown = $('#select_drop_e').select2({
            dropdownAutoWidth: true,
            width: '100%',    
            placeholder: "Padecimientos",
            containerCssClass: 'select-lg'
        });    
        <?php if ($padecimientos_select): ?>
            let seleccionados = JSON.parse('<?php echo json_encode($padecimientos_select) ?>');
            console.log(seleccionados);
            dropdown.val(seleccionados).trigger("change");
        <?php endif; ?>

    });

    var slider_peso_e = document.getElementById('slider_peso_e');
    noUiSlider.create(slider_peso_e, {
        start: [<?php echo $peso_min; ?>, <?php echo $peso_max; ?>],
        connect: true,
        step: 1,
        orientation: 'horizontal',
        range: {
            'min': 0,
            'max': 150
        },
        format: wNumb({
            decimals: 0
        })
    });

    var slider_edad_e = document.getElementById('slider_edad_e');
    noUiSlider.create(slider_edad_e, {
        start: [<?php echo $edad_min; ?>, <?php echo $edad_max; ?>],
        connect: true,
        step: 1,
        orientation: 'horizontal',
        range: {
            'min': 0,
            'max': 100
        },
        format: wNumb({
            decimals: 0
        })
    });

    function chequeo_e() {
        let bandera_check = true;
        let padecimientos = JSON.stringify($('#select_drop').val());
        if (padecimientos.length == 0) {
            bandera_check = false;
            Swal.fire({
                title: '<strong><u>Debe seleccionar al menos un padecimiento</u></strong>',
                icon: 'error',
                showCloseButton: true,
                focusConfirm: false,
            });
        }
        return bandera_check;
    }

    function send_info_e() {
        if (chequeo_e()) {

            let datos_dosis = {
                'id_dosis' : $('#id_dosis_e').val(),
                'padecimientos' : JSON.stringify($('#select_drop_e').val()),
                'edad' : JSON.stringify(slider_edad_e.noUiSlider.get()),
                'peso' : JSON.stringify(slider_peso_e.noUiSlider.get()),
                'subir' : $('input[name=subir_e]:checked').val(),
                'num_gotas_m' : $('#num_gotas_m_e').val(),
                'num_gotas_t' : $('#num_gotas_t_e').val(),
                'num_gotas_n' : $('#num_gotas_n_e').val(),
            };
            
            $.ajax({
                async:true,
                cache:false,
                dataType:"html",
                type: 'POST',
                url: '<?php echo base_url('Productos/editar_dosis'); ?>',
                data: datos_dosis,
                success:  function(data){
                    let datos = JSON.parse(data)
                    if(data){
                        Toast.fire({
                            icon: 'success',
                            title: 'Dosis editada'
                        });
                        $('#editar_dosis_p').modal('close');
                        get_dosis($('#id_producto_dosis').val());
                    }
                },
                beforeSend:function(){},
                error:function(objXMLHttpRequest){}
            });
        }
    }
</script>