<div id="nuevo" class="modal">
    <?php
        echo form_open('Usuarios/nuevo_usuario');
    ?>
        <div class="modal-content">
            <h4>Nuevo Usuario</h4>
            <div class="row">
                <div class="input-field col s6">
                    <input required name="nombre" id="nombre" type="text" class="validate">
                    <label for="nombre">Nombre</label>
                </div>
                <div class="input-field col s6">
                    <input required name="correo" id="email" type="email" class="validate" onchange="validate_email()">
                    <label for="email">Correo</label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s6">
                    <input required name="pass" id="password" type="password" class="validate" onchange="verificarpass()">
                    <label for="password">Contraseña</label>
                </div>

                <div class="input-field col s6">
                    <input required id="password2" type="password" class="validate" onchange="verificarpass()">
                    <label for="password2">Repetir Contraseña</label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s12">
                    <select id="select" required name="tipo">
                        <option value="" selected>Elige el tipo de usuario</option>
                        <option value="1">Administrador</option>
                        <option value="4">Envíos</option>
                    </select>
                    <label>Tipo de Usuario</label>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <a href="#!" class="modal-close waves-effect waves-green btn-flat">Cerrar</a>
            <button id="smb" type="submit" class=" waves-effect waves-green btn-flat">Guardar</button>
        </div>
    </form>
</div>

<script>
    function validate_email(){
        $.ajax({
            async:true,
            cache:false,
            dataType:"html",
            type: 'POST',
            url: '<?php echo base_url('Usuarios/check_correo'); ?>',
            data: {correo:$('#email')[0].value},
            success:  function(data){
                if (data == 1) {//existe el correo
                    //$("#email").removeClass( "bg-success text-white" ).addClass( "bg-danger text-white" );
                    $('#smb').prop('disabled', true);
                    Swal.fire({
                        confirmButtonText: 'Ok',
                        confirmButtonAriaLabel: 'Ok',
                        //showCancelButton: true,
                        title: 'Aviso',
                        text: 'El correo ya existe'
                    });
                }else { //no existe el correo
                    //$("#email").removeClass( "bg-danger text-white" ).addClass( "bg-success text-white" );
                    $('#smb').prop('disabled', false);
                }
            },
            beforeSend:function(){},
            error:function(objXMLHttpRequest){}
            });
    }

    function verificarpass(){
      let aux = $("#password2")[0].value;
      let aux2 = $("#password")[0].value;

      if (aux.length > 0 && aux2.length > 0) {
        if(($("#password")[0].value) != ($("#password2")[0].value)){

                   $('#smb').prop('disabled', true);
          Swal.fire({
              confirmButtonText: 'Ok',
              confirmButtonAriaLabel: 'Ok',
              //showCancelButton: true,
              title: 'Aviso',
              text: 'Las contraseñas no coinciden.'
          });

        }
        else {
              $('#smb').prop('disabled', false);
        }

      }


    }
</script>
