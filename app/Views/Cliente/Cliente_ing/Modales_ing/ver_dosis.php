<div class="modal fade" id="ver" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Dose</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <div class="col-md-12 mt-3">


                    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel" >
                        <ol class="carousel-indicators" style="background-color: black;">
                            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                            <?php for($i=1;$i < count($dosis);$i++){ ?>
                                <li data-target="#carouselExampleIndicators" data-slide-to="<?php echo $i;?> "></li>
                            <?php } ?>
                        </ol>
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <div class="card mb-4 pt-2">
                                    <img src="<?php echo $dosis[0]['img']; ?>" class="card-img-top img-fluid" style="max-width:290px; display:block; margin:auto;" alt="<?php echo $dosis[0]['producto']; ?>">
                                    <div class="card-body">
                                        <h5 class="card-title"><?php echo $dosis[0]['producto']; ?></h5>
                                        <p class="card-text">The dose is: <b><?php echo $dosis[0]['resultado']; ?></b><br>*<?php echo $dosis[0]['subir']; ?></p>
                                        <?php if (session('usuario')): ?>
                                            <a href="#" class="btn btn-primary" onclick="guardar('<?php echo $dosis[0]['dosis']; ?>')">Save Dose</a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <?php for($i=1;$i < count($dosis);$i++){ ?>
                                <div class="carousel-item">
                                    <div class="card mb-4 pt-2">
                                        <img src="<?php echo $dosis[$i]['img']; ?>" class="card-img-top img-fluid" style="max-width:290px; display:block; margin:auto;" alt="<?php echo $dosis[$i]['producto']; ?>">
                                        <div class="card-body">
                                            <h5 class="card-title"><?php echo $dosis[$i]['producto']; ?></h5>
                                            <p class="card-text">The dose is: <b><?php echo $dosis[$i]['resultado']; ?></b><br>*<?php echo $dosis[$i]['subir']; ?></p>
                                            <?php if (session('usuario')): ?>
                                                <a href="#" class="btn btn-primary" onclick="guardar('<?php echo $dosis[$i]['dosis']; ?>')">Save Dose</a>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>

                        </div>
                        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon border  rounded-circle detalles" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                            <span class="carousel-control-next-icon border  rounded-circle detalles" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
