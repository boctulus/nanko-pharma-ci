<!-- Modal -->
<div class="modal fade" id="ver" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Detalles de la orden</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col-md-12 mt-3">
                    <div class="accordion" id="accordionExample">
                        <div class="card">
                            <div class="card-header" id="headingOne">
                                <h2 class="mb-0">
                                    <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                        Detalles de envio
                                    </button>
                                </h2>
                            </div>

                            <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="envio">Precio de Envio:</label>
                                        <input type="text" id="envio" value="$<?php echo $orden['precio_envio']; ?>" readonly class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="total">Precio de Total:</label>
                                        <input type="text" id="total" value="$<?php echo $orden['precio_total']; ?>" readonly class="form-control">
                                    </div>
                                    <?php if ($orden['num_guia']) : ?>
                                        <div class="form-group">
                                            <label for="num_guia">N??mero de Gu??a:</label>
                                            <input type="text" id="num_guia" value="<?php echo $orden['num_guia']; ?>" readonly class="form-control">
                                        </div>
                                    <?php endif; ?>
                                    <div class="form-group">
                                        <label for="nombre">Nombre de quien recibe:</label>
                                        <input type="text" id="nombre" value="<?php echo $direccion['nombre']; ?>" readonly class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="tel_rec">Tel??fono:</label>
                                        <input type="text" id="tel_rec" value="<?php echo $direccion['tel']; ?>" readonly class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="pais">Pais:</label>
                                        <input type="text" id="pais" value="<?php echo "M??xico";//$direccion['pais']; ?>" readonly class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="estado">Estado:</label>
                                        <input type="text" id="estado" value="<?php echo $direccion['estado']; ?>" readonly class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="municipio">Municipio:</label>
                                        <input type="text" id="municipio" value="<?php echo $direccion['municipio']; ?>" readonly class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="ciudad">Ciudad:</label>
                                        <input type="text" id="ciudad" value="<?php echo $direccion['ciudad']; ?>" readonly class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="cp">C.P.:</label>
                                        <input type="text" id="cp" value="<?php echo $direccion['cp']; ?>" readonly class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="colonia">Colonia:</label>
                                        <input type="text" id="colonia" value="<?php echo $direccion['colonia']; ?>" readonly class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="calle">Calle:</label>
                                        <input type="text" id="calle" value="<?php echo $direccion['calle']; ?>" readonly class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="num_ext">N??mero exterior:</label>
                                        <input type="text" id="num_ext" value="<?php echo $direccion['num_ext']; ?>" readonly class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="num_int">N??mero interior:</label>
                                        <input type="text" id="num_int" value="<?php echo $direccion['num_int']; ?>" readonly class="form-control">
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header" id="headingTwo">
                                <h2 class="mb-0">
                                    <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                        Detalles de la orden
                                    </button>
                                </h2>
                            </div>
                            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                                <div class="card-body">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Producto</th>
                                                <th>Cantidad</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($productos as $obj) : ?>
                                                <tr>
                                                    <th><?php echo $obj['nombre']; ?></th>
                                                    <th><?php echo $obj['cantidad']; ?></th>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <?php if ($orden['url_pdf']): ?>
                    <a href="<?php echo $orden['url_pdf']; ?>" target="_blank" class="btn btn-dark">Ver Recibo Tienda</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
