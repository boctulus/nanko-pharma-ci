<div id="nueva_dosis" class="modal">
    <?php
        //echo form_open('Productos/nueva_dosis','onsubmit="return checkeo()"');
    ?>
        <div class="modal-content">
            <h4>Nueva dosis</h4>
            <div class="row">
                <div class="input-field col s12">
                    <?php echo form_dropdown('padecimientos', $padecimientos_drop, '', 'class="select2 browser-default form-control" multiple="multiple" id="select_drop" required '); ?>
                    <label for="select_drop">Padecimientos</label>

                </div>
            </div>
            <div class="row">
                <div class="input-field col s12">
                    <span>Edad</span>
                    <!-- <label for="slider_edad">Edad</label> -->
                    <div id="slider_edad"></div>
                    <input type="hidden" id="edad" name="edad">
                    <input type="hidden" id="id_producto_dosis" name="id_producto" value="">
                    <input type="hidden" id="padecimientos_dosis" name="padecimientos" value="">
                </div>
            </div>
            <div class="row">
                <div class="input-field col s12">
                    <span>Peso</span>
                    <!-- <label for="slider_peso">Peso</label> -->
                    <div id="slider_peso"></div>
                    <input type="hidden" id="peso_dosis" name="peso">
                </div>
            </div>
            <div class="row">
                <div class="input-field col s12">
                    <p>
                        <label>
                            <input name="subir" value="1" type="radio" required checked />
                            <span>Subir 1 gota después de dos semanas</span>
                        </label>
                    </p>
                    <p>
                        <label>
                            <input name="subir" value="2" type="radio" required />
                            <span>Subir 2 gotas después de dos semanas</span>
                        </label>
                    </p>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s4">
                    <input id="num_gotas_m" type="text" class="validate" name="num_gotas_m" value="" placeholder="1">
                    <label for="num_gotas_m">Gotas en mañana</label>
                </div>
                <div class="input-field col s4">
                    <input id="num_gotas_t" type="text" class="validate" name="num_gotas_t" value="" placeholder="2">
                    <label for="num_gotas_t">Gotas en tarde</label>
                </div>
                <div class="input-field col s4">
                    <input id="num_gotas_n" type="text" class="validate" name="num_gotas_n" value="" placeholder="3">
                    <label for="num_gotas_n">Gotas en noche</label>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <a href="#!" class="modal-close waves-effect waves-green btn-flat">Cerrar</a>
            <button type="button" class=" waves-effect waves-green btn-flat" onclick="send_info()">Guardar</button>
        </div>
    <!-- </form> -->

</div>
<script>
    var slider_edad = document.getElementById('slider_edad');
    noUiSlider.create(slider_edad, {
        start: [10,50],
        connect: true,
        step: 1,
        orientation: 'horizontal',
        range: {
            'min': 0,
            'max': 100
        },
        format: wNumb({
            decimals: 0
        }),
    });
    var slider_peso = document.getElementById('slider_peso');
    noUiSlider.create(slider_peso, {
        start: [19, 79],
        connect: true,
        step: 0.5,
        orientation: 'horizontal',
        range: {
            'min': 0,
            'max': 200
        },
        format: wNumb({
            decimals: 0
        })
    });

    function chequeo() {
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

    function send_info() {
        if (chequeo()) {
            let datos_dosis = {
                'id_producto' : $('#id_producto_dosis').val(),
                'padecimientos' : JSON.stringify($('#select_drop').val()),
                'edad' : JSON.stringify(slider_edad.noUiSlider.get()),
                'peso' : JSON.stringify(slider_peso.noUiSlider.get()),
                'subir' : $('input[name=subir]:checked').val(),
                'num_gotas_m' : $('#num_gotas_m').val(),
                'num_gotas_t' : $('#num_gotas_t').val(),
                'num_gotas_n' : $('#num_gotas_n').val(),
            };
            
            $.ajax({
                async:true,
                cache:false,
                dataType:"html",
                type: 'POST',
                url: '<?php echo base_url('Productos/nueva_dosis'); ?>',
                data: datos_dosis,
                success:  function(data){
                    let datos = JSON.parse(data)
                    if(data){
                        Toast.fire({
                            icon: 'success',
                            title: 'Dosis creada'
                        });
                        $('#nueva_dosis').modal('close');
                        get_dosis($('#id_producto_dosis').val());
                    }
                },
                beforeSend:function(){},
                error:function(objXMLHttpRequest){}
            });
        }
    }
</script>