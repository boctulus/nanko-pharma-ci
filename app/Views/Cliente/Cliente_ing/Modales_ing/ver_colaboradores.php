<div class="modal fade" id="ver" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Colaboradores</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col-md-12 mt-3">
                    <?php if ($colaboradores): ?>
                        <ul class="list-group">
                            <?php foreach ($colaboradores as $obj): ?>
                                <li class="list-group-item">
                                    <h5 class="card-title"><?php echo $obj['nombre']; ?></h5>
                                    <p class="card-text"><?php echo $obj['estado']; ?></p>
                                    <p class="card-text">Teléfono: <a href="tel:<?php echo $obj['telefono']; ?>"><?php echo $obj['telefono']; ?></a></p>
                                    <p class="card-text">Correo: <a href="mailto:<?php echo $obj['correo']; ?>"><?php echo $obj['correo']; ?></a></p>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                        <?php else: ?>
                            <p>Aún no hay colaboradores en tu País</p>
                    <?php endif; ?>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>