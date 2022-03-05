<div id="nuevo" class="modal">
    <?php

    echo form_open('Colaboradores/nuevo_colaborador');
    ?>

    <div class="modal-content">
        <h4>Nuevo Colaborador</h4>
        <div class="row">
            <div class="input-field col s6">
                <input required name="nombre" id="nombre_c" type="text" class="validate" onchange="generarcorreo()">
                <label for="nombre_c">Nombre</label>
            </div>
            <div class="input-field col s6">
                <input required name="apellidos" id="apellidos_c" type="text" class="validate" onchange="generarcorreo()">
                <label for="apellidos_c">Apellidos</label>
            </div>
            <div class="input-field col s6">
                <input required name="correo_n" id="correoN" readonly value="">
            </div>
            <div class="input-field col s6">
                <select name="pais" id="pais_c" class="validate" onchange="get_estados()">
                    <option value=""  selected disabled>Seleccione la región</option>
                    <option value="1">México</option>
                    <option value="2">Perú</option>
                    <option value="3">Europa</option>
                    <option value="4">Argentina</option>
                    <option value="5">Resto del mundo</option>
                </select>
                <label>País</label>
            </div>
            <div class="input-field col s6">
                <input type="text" id="estado_p" name="estado_p" class="autocomplete" disabled>
                <label for="estado_p">Estado</label>
            </div>
            <div class="input-field col s6">
                <input required name="correo_p" id="correoP" type="email" class="validate" value=>
                <label for="correoP">Correo Personal</label>
            </div>
            <div class="input-field col s6">
                <input required name="cp" id="codeP" type="text" class="validate">
                <label for="codeP">C.P</label>
            </div>
            <div class="input-field col s6">
                <input required name="telefono" id="telefono_c" type="text" class="validate">
                <label for="telefono_c">Telefono</label>
            </div>
            <div class="input-field col s6">
                <input required name="descuento" id="descuento_c" type="number" min="0" max="50" class="validate">
                <label for="descuento_c">Descuento</label>
            </div>
            <div class="input-field col s12">
                <input required name="direccion" id="direccion_c" type="text" class="validate">
                <label for="direccion">Direccion</label>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s6">
                <input required name="pass" id="password" type="password" class="validate" onchange="verificarpass()">
                <label for="password">Contraseña</label>
            </div>

            <div class="input-field col s6">
                <input required name="pass2" id="password2" type="password" class="validate" onchange="verificarpass()">
                <label for="password2">Repetir Contraseña</label>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <a href="#!" class="modal-close waves-effect waves-green btn-flat">Cerrar</a>
        <button type="submit" id="smb" class=" waves-effect waves-green btn-flat">Guardar</button>
    </div>
    </form>
</div>
<script type="text/javascript">

    function get_estados() {
        if($('#pais_c').val() != null){
            $('#estado_p').prop('disabled', false);
            $.ajax({
                async: true,
                cache: false,
                dataType: "html",
                type: 'POST',
                url: '<?php echo base_url('Colaboradores/get_estados'); ?>',
                data: {
                    pais: $('#pais_c').val()
                },
                success: function(data) {
                    let estados = JSON.parse(data);
                    $('input.autocomplete').autocomplete({
                        data: estados,
                    });
                },
                beforeSend: function() {},
                error: function(objXMLHttpRequest) {}
            });
        }else{
            $('#estado_p').val('');
            $('#estado_p').prop('disabled', true);
        }
    }

    function removeAccents(str) {
      return str.normalize("NFD").replace(/[\u0300-\u036f]/g, "");
    }

    function generarcorreo(count = 0) {
        let colabn = '';
        if (count > 0) {
            colabn += count;
        }
        let gencorreo = document.getElementById('nombre_c').value;
        let gencorreoaux = document.getElementById('apellidos_c').value;
        gencorreo = gencorreo.split(' ');
        gencorreoaux = gencorreoaux.split(' ');
        let correoN = gencorreoaux[0] + gencorreo[0] + colabn;
        $("#correoN").val(removeAccents(correoN.replace('.', ''))+ "@nanko.com.mx");
        $.ajax({
            async: true,
            cache: false,
            dataType: "html",
            type: 'POST',
            url: '<?php echo base_url('Usuarios/check_correo'); ?>',
            data: {
                correo: $('#correoN').val()
            },
            success: function(data) {

                if (data == 1) { //existe el correo
                    // $("#email").removeClass( "bg-success text-white" ).addClass( "bg-danger text-white" );
                    $('#smb').prop('disabled', true);
                    generarcorreo(count + 1);
                    console.log(count);
                } else { //no existe el correo
                    //$("#email").removeClass( "bg-danger text-white" ).addClass( "bg-success text-white" );
                    $('#smb').prop('disabled', false);
                }
            },
            beforeSend: function() {},
            error: function(objXMLHttpRequest) {}
        });
    }

    function verificarpass() {
        let aux = $("#password2")[0].value;
        let aux2 = $("#password")[0].value;

        if (aux.length > 0 && aux2.length > 0) {
            if (($("#password")[0].value) != ($("#password2")[0].value)) {

                $('#smb').prop('disabled', true);
                Swal.fire({
                    confirmButtonText: 'Ok',
                    confirmButtonAriaLabel: 'Ok',
                    //showCancelButton: true,
                    title: 'Aviso',
                    text: 'Las contraseñas no coninciden.'
                });

            } else {
                $('#smb').prop('disabled', false);
            }

        }


    }
</script>
