<div id="ver" class="modal">
    <div class="modal-content">
        <h4>Detalles Orden</h4>
        <div class="row">
            <div class="input-field col s12">
                <input readonly type="text" class="validate" value="<?php echo $cliente['nombre']; ?>">
                <label>Cliente</label>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s12 m6">
                <input readonly type="text" class="validate" value="$<?php echo $orden['precio_envio']; ?>">
                <label>Precio de Envio</label>
            </div>
            <div class="input-field col s12 m6">
                <input readonly type="text" class="validate" value="$<?php echo $orden['precio_total']; ?>">
                <label>Precio Total</label>
            </div>
        </div>

        <?php if ($orden['num_guia']) : ?>
            <div class="row">
                <div class="input-field col s12">
                    <input readonly type="text" class="validate" value="<?php echo $orden['num_guia']; ?>">
                    <label>Número de Guía</label>
                </div>
            </div>
        <?php endif; ?>
        <h4>Dirección de envío</h4>
        <div class="row">
            <div class="input-field col s12">
                <input readonly type="text" class="validate" value="<?php echo $direccion['nombre']; ?>">
                <label>Nombre de quien recibe</label>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s12">
                <input readonly type="text" class="validate" value="<?php echo $direccion['tel']; ?>">
                <label>Teléfono</label>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s12 m6">
                <input readonly type="text" class="validate" value="<?php echo $direccion['estado']; ?>">
                <label>Estado</label>
            </div>
            <div class="input-field col s12 m6">
                <input readonly type="text" class="validate" value="<?php echo $direccion['municipio']; ?>">
                <label>Municipio</label>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s12 m6">
                <input readonly type="text" class="validate" value="<?php echo $direccion['ciudad']; ?>">
                <label>Ciudad</label>
            </div>
            <div class="input-field col s12 m6">
                <input readonly type="text" class="validate" value="<?php echo $direccion['cp']; ?>">
                <label>C.P.</label>
            </div>

        </div>
        <div class="row">
            <div class="input-field col s12 m6">
                <input readonly type="text" class="validate" value="<?php echo $direccion['colonia']; ?>">
                <label>Colonia</label>
            </div>
            <div class="input-field col s12 m6">
                <input readonly type="text" class="validate" value="<?php echo $direccion['calle']; ?>">
                <label>Calle</label>
            </div>
        </div>

        <div class="row">
            <div class="input-field col s12 m6">
                <input readonly type="text" class="validate" value="<?php echo $direccion['num_ext']; ?>">
                <label>Número exterior</label>
            </div>
            <div class="input-field col s12 m6">
                <input readonly type="text" class="validate" value="<?php echo $direccion['num_int']; ?>">
                <label>Número interior</label>
            </div>
        </div>

        <div class="row">
            <div class="input-field col s12">
                <textarea readonly id="instrucciones_v" class="materialize-textarea"></textarea>
                <label for="instrucciones_v">Instrucciones</label>
            </div>
        </div>
        <h4>Productos</h4>
        <div class="row">
            <div class="input-field col s12">
                <table id="lista" class="table">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Cantidad</th>
                            <th>Peso Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($productos as $obj): ?>
                            <tr>
                                <th><?php echo $obj['nombre']; ?></th>
                                <th><?php echo $obj['cantidad']; ?></th>
                                <th><?php echo $obj['peso'] * $obj['cantidad']; ?> gr.</th>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <a href="#!" class="modal-close waves-effect waves-green btn-flat">Cerrar</a>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#ver').modal('open')
        $('#instrucciones_v').val('<?php echo preg_replace("/[\r\n|\n|\r]+/", " ", $direccion['instrucciones']); ?>');

        M.updateTextFields();
    });
</script>
