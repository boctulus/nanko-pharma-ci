<div class="modal fade" id="ver" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
              <!-- inicio ingles -->
              <?php if (session('region') == 3 || session('region') == 5): ?>
                <h5 class="modal-title" id="exampleModalLongTitle">Collaborators</h5>
              <?php endif; ?>
              <!-- final ingles -->

              <!-- inicio español -->
              <?php if (session('region') < 3 || session('region') == 4): ?>
                <h5 class="modal-title" id="exampleModalLongTitle">Colaboradores</h5>
              <?php endif; ?>
              <!-- final español -->
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col-md-12 mt-3">
                    <?php if ($colaboradores): ?>
                        <ul class="list-group">
                            <?php foreach ($colaboradores as $obj): ?>
                              <!-- inicio ingles -->
                              <?php if (session('region') == 3 || session('region') == 5): ?>
                                <li class="list-group-item">
                                    <h5 class="card-title"><?php echo $obj['nombre']; ?></h5>
                                    <p class="card-text"><?php echo $obj['estado']; ?></p>
                                    <p class="card-text">Phone: <a href="tel:<?php echo $obj['telefono']; ?>"><?php echo $obj['telefono']; ?></a></p>
                                    <p class="card-text">Mail: <a href="mailto:<?php echo $obj['correo']; ?>"><?php echo $obj['correo']; ?></a></p>
                                </li>                              <?php endif; ?>
                              <!-- final ingles -->

                              <!-- inicio español -->
                              <?php if (session('region') < 3 || session('region') == 4): ?>
                                <li class="list-group-item">
                                    <h5 class="card-title"><?php echo $obj['nombre']; ?></h5>
                                    <p class="card-text"><?php echo $obj['estado']; ?></p>
                                    <p class="card-text">Teléfono: <a href="tel:<?php echo $obj['telefono']; ?>"><?php echo $obj['telefono']; ?></a></p>
                                    <p class="card-text">Correo: <a href="mailto:<?php echo $obj['correo']; ?>"><?php echo $obj['correo']; ?></a></p>
                                </li>                              <?php endif; ?>
                              <!-- final español -->

                            <?php endforeach; ?>
                        </ul>
                        <?php else: ?>
                          <!-- inicio ingles -->
                          <?php if (session('region') == 3 || session('region') == 5): ?>
                            <p>There are no collaborators in your Country yet</p>
                          <?php endif; ?>
                          <!-- final ingles -->

                          <!-- inicio español -->
                          <?php if (session('region') < 3 || session('region') == 4): ?>
                            <p>Aún no hay colaboradores en tu País</p>
                          <?php endif; ?>
                          <!-- final español -->
                    <?php endif; ?>
                </div>
            </div>
            <div class="modal-footer">
              <!-- inicio ingles -->
              <?php if (session('region') == 3 || session('region') == 5): ?>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <?php endif; ?>
              <!-- final ingles -->

              <!-- inicio español -->
              <?php if (session('region') < 3 || session('region') == 4): ?>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
              <?php endif; ?>
              <!-- final español -->
            </div>
        </div>
    </div>
</div>
