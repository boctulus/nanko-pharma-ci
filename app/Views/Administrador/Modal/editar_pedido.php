<div id="nuevo" class="modal">
    <?php
        echo form_open('Pedidos/pedido_nuevo');
    ?>

        <div class="modal-content">
            <h4>Nuevo Pedido</h4>
            <div class="row">
              <div class="input-field col s6">
                  <input required name="province" id="province_p" type="text" class="validate"name="province" value="Jalisco">
                  <label for="province_p">Provincia</label>
              </div>
              <div class="input-field col s6">
                  <input required name="city" id="city_p" type="text" class="validate" value="Guadalajara">
                  <label for="city_p">Ciudad</label>
              </div>
              <div class="input-field col s6">
                  <input required name="nombre" id="nombre_p" type="nombre" class="validate" value="Jorge Fernández">
                  <label for="nombre_p">Nombre</label>
              </div>
              <div class="input-field col s6">
                  <input required name="zip" id="zip_p" type="text" class="validate" value="44100">
                  <label for="zip_p">C.P</label>
              </div>
              <div class="input-field col s6">
                  <input required name="country" id="country_p" type="text" class="validate" value="MX">
                  <label for="country_p">País</label>
              </div>
              <div class="input-field col s6">
                  <input required name="address1" id="address1_p" type="text" class="validate" value="Av. Lázaro Cárdenas #234">
                  <label for="address1_p">Dirección 1</label>
              </div>
              <div class="input-field col s6">
                  <input required name="company" id="company_p" type="text" class="validate" value="INC corp">
                  <label for="zip_p">Empresa</label>
              </div>
              <div class="input-field col s6">
                  <input required name="zip" id="zip_p" type="text" class="validate" value="44100">
                  <label for="zip_p">Direccion 2</label>
              </div>
              <div class="input-field col s6">
                  <input required name="telefono" id="telefono_c" type="text" class="validate">
                  <label for="telefono_c">Telefono</label>
              </div>
              <div class="input-field col s6">
                  <input required name="descuento" id="descuento_c" type="text" class="validate">
                  <label for="descuento_c">Correo</label>
              </div>
              <div class="input-field col s6">
                  <input required name="descuento" id="descuento_c" type="text" class="validate">
                  <label for="descuento_c">Referencias</label>
              </div>
            </div>
            <div class="row">
                <div class="input-field col s6">
                    <input required name="pass" id="password" type="password" class="validate">
                    <label for="password">Contraseña</label>
                </div>

                <div class="input-field col s6">
                    <input required id="password2" type="password" class="validate">
                    <label for="password2">Repetir Contraseña</label>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <a href="#!" class="modal-close waves-effect waves-green btn-flat">Cerrar</a>
            <button type="submit" name="smb" class=" waves-effect waves-green btn-flat">Guardar</button>
        </div>
    </form>
</div>
