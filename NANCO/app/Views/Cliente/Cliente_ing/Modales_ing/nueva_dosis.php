<!-- Modal -->
<div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">New Dose</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-info" role="alert">
                    These calculations only apply to NankÖ articles
                </div>
                <div class="col-md-12 mt-3">
                    <div class="form-group">
                        <label for="exampleFormControlSelect1">Condition</label>
                        <?php echo form_dropdown('padecimiento', $padecimientos, '', 'class="form-control clase_validar" id="padecimiento" required'); ?>
                    </div>
                    <div class="form-group wow animate__animated animate__fadeInUp">
                        <label for="validation01">Age</label>
                        <input type="number" step="any" name="edad" id="edadD" class="form-control clase_validar" id="validation01" onkeypress="return validarN(event,this);" placeholder="Age" required>
                    </div>
                    <div class="form-group wow animate__animated animate__fadeInUp">
                        <label for="validation02">Weight Kg</label>
                        <input step="any" type="number" name="peso" id="pesoD" class="form-control clase_validar" id="validation02" placeholder="65" required onkeypress="return validarN(event,this);">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn botoncolor" onclick="calcular()">Create</button>
            </div>
        </div>
    </div>
</div>

<script>
    function validarN(evt, input) {
        var key = window.Event ? evt.which : evt.keyCode;
        var chark = String.fromCharCode(key);
        var tempValue = input.value + chark;
        if (key >= 48 && key <= 57) {
            if (filter(tempValue) === false) {
                return false;
            } else {
                return true;
            }
        } else {
            if (key == 8 || key == 13 || key == 0) {
                return true;
            } else if (key == 46) {
                if (filter(tempValue) === false) {
                    return false;
                } else {
                    return true;
                }
            } else {
                return false;
            }
        }
    }

    function filter(__val__) {
        var preg = /^([0-9]+\.?[0-9]{0,2})$/;
        if (preg.test(__val__) === true) {
            return true;
        } else {
            return false;
        }
    }

    function calcular() {

        $(".clase_validar").each(function() {
            if ($(this)[0].value == "") {
                Swal.fire(
                    'Error',
                    'To calculate the dose there cannot be empty fields',
                    'error'
                );
                return;
            }
        });

        if($('#padecimiento').val() == 0){
            Swal.fire(
                'Error',
                'Please select the condition.',
                'error'
            );
            return;
        }

        $.ajax({
            async: true,
            cache: false,
            dataType: "html",
            type: 'POST',
            url: '<?php echo base_url('Clientes/calcular_dosis_ing'); ?>',
            data: {
                edad: $('#edadD').val(),
                peso: $('#pesoD').val(),
                padecimiento: $('#padecimiento').val(),
            },
            success: function(data) {
                let datos = JSON.parse(data);
                if (datos.bandera == 1) {
                    $('#exampleModalLong').modal('hide');
                    $('#modal').html(datos.modal);
                    $('#ver').modal();
                }else{
                    Swal.fire(
                        'Error',
                        'There is no dose for the data provided',
                        'error'
                    );
                }

            },
            beforeSend: function() {},
            error: function(objXMLHttpRequest) {}
        });
    }

    function guardar(id_dosis) {
        $.ajax({
            async: true,
            cache: false,
            dataType: "html",
            type: 'POST',
            url: '<?php echo base_url('Clientes/guardar_dosis'); ?>',
            data: {
                edad: $('#edadD').val(),
                peso: $('#pesoD').val(),
                id_dosis:id_dosis
            },
            success: function(data) {
                let datos = JSON.parse(data);
                if (datos.bandera) {
                    location.reload();
                }else{
                    Swal.fire(
                        'Error',
                        datos.mensaje,
                        'error'
                    );
                }

            },
            beforeSend: function() {},
            error: function(objXMLHttpRequest) {}
        });
    }
</script>
