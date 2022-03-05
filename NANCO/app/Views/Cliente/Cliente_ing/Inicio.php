
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="apple-touch-icon" href="/assets/img/logo.png">
  <link rel="shortcut icon" type="image/x-icon" href="/assets/img/logo.png">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
  <link rel="stylesheet" href="/assets/fonts/font-awesome.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
  <link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet'>
  <link rel="stylesheet" href="/assets/css/index.css">
  <!-- <link rel="stylesheet" href="/assets/css/Style.css"> -->
  <link rel="stylesheet" href="/assets/css/styleIco.css">
  <script src="/assets/js/wow.min.js"></script>
  <script>
  new WOW().init();
  </script>
  <script src="https://kit.fontawesome.com/f7929717e2.js" crossorigin="anonymous"></script>

  <title>Nankö®</title>
</head>

<body>

  <?php echo view('Cliente/Navbar'); ?>


    <!-- inicio parallax -->
    <div class="bgimg-1">
      <div class="caption">
        <div class="container colorjumbotron borderr">
          <div class="row text-dark wow animate__animated animate__fadeIn">
            <div class="col-md-12">

              <!-- <h1 class="text-center mt-2"><strong>Nankö</strong></h1> -->
              <strong><p class="text-center" style="color:black; font-size: 2.5rem /* width and color */">ALTERNATIVE SOLUTIONS<br> LIVE WELL, FEEL WELL!</p></strong>
            </div>
          </div>

        </div>
      </div>
    </div>
    <!-- fin parallax -->

    <!-- inicio carrusel de jumbotron -->
    <div class="jumbotron jumbotron-fluid wow animate__animated animate__fadeIn">
      <div class="container">
        <h1 class="display-4 icon-eco-friendly-dark-01">Nankö<small style="font-size: 20px">®</small></h1>
        <p class="lead textos">Nankö is a Mexican Cannabis Association with eight years of experience in the alternative medicine market. Which is born from the search for options to improve the quality of life, being a safe and effective alternative to take care of the health of the whole family, offering them a 100% natural option.</p>
      </div>
    </div>
    <!-- fin de jumbotron -->

    <!-- inicio carrusel de cartas Testimonio-->
    <?php if ($testimonios): ?>
      <div class="container text-center my-3 wow animate__animated animate__fadeInRight borderr">
        <h2><strong>Testimonials</strong></h2>
        <div class="row mx-auto my-auto">
          <div id="recipeCarousel" class="carousel slide w-100 borderr" data-ride="carousel">
            <div class="carousel-inner w-100" role="listbox">
              <?php $i=0; foreach ($testimonios as $obj): ?>
                <div class="carousel-item <?php if($i== 0){echo "active";$i++;} ?>">
                  <div class="col-md-12">
                    <div class="card card-body">
                      <h4 class="card-title"><?php echo $obj['titulo']; ?></h4>
                      <div><img src="<?php echo $obj['img'] ?>" alt="Responsive image enuin" class="circular--landscape rounded-circle"></div>
                      <div class="mt-3">
                        <h5 style="font-style: italic;"><?php echo $obj['nombre']; ?></h5>
                      </div>
                      <div class="mt-3 textos">
                        <p><?php echo $obj['mensaje'] ?></p>
                      </div>
                    </div>
                  </div>
                </div>
              <?php endforeach; ?>
              <a class="carousel-control-prev w-auto" href="#recipeCarousel" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon border rounded-circle detalles" aria-hidden="true"></span>
                <span class="sr-only detalles">Previous</span>
              </a>
              <a class="carousel-control-next w-auto" href="#recipeCarousel" role="button" data-slide="next">
                <span class="carousel-control-next-icon border  rounded-circle detalles" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
              </a>
            </div>
          </div>
        </div>
      </div>
    <?php endif; ?>
    <!-- fin carrusel de cartas Testimonio-->

    <!-- inicio de catálogo -->
    <?php if ($productos): ?>
        <div class="container my-5 wow animate__animated animate__fadeInLeft">
            <h1 class="font-weight-light text-center"><strong>products</strong></h1>
            <div class="row text-dark">
                <div class="card-deck">
                    <?php foreach ($productos as $obj): ?>
                        <div class="card text-center">
                            <a href="/Clientes/producto/<?php echo $obj['id_producto'];?> "><img class="card-img-top" src="<?php echo $obj['img']; ?>" alt="Card image cap"></a>
                            <div class="card-body">
                              <a href="/Clientes/producto/<?php echo $obj['id_producto'];?> "><h5 class="card-title textos"><strong> <?php echo $obj['nombre']; ?></strong></h5></a>
                              <p class="card-text textos"style="font-style: italic;"><?php echo $obj['descripcion_ingles']; ?></p>
                              <p class="card-text"><b><?php echo $obj['precio'] ?></b></p>
                              <div class="text-center mb-3">
                                  <?php if ($obj['padecimientos']): ?>
                                      <?php foreach ($obj['padecimientos'] as $pad): ?>
                                          <span class="badge badge-info"><?php echo $pad['nombre'] ?></span>
                                      <?php endforeach; ?>
                                  <?php endif; ?>
                              </div>
                              <?php if (session('region') == 1): ?>
                                <?php if ($obj['disp']): ?>
                                  <a class="btn botoncolor" onclick="add_cart('<?php echo $obj['id_producto']; ?>')">Añadir al carrito</a>
                                <?php else: ?>
                                    <button class="btn botoncolor" disabled>Sin disponibilidad</button>
                                <?php endif; ?>
                              <?php else:?>
                                  <a class="btn botoncolor" onclick="ver_colaboradores()">see collaborators</a>
                              <?php endif; ?>

                            </div>
                        </div>
                    <?php endforeach; ?>
          </div>
        </div>
      </div>
    <?php endif; ?>
    <!-- fin de catálogo -->

    <!-- inicio carrusel de cartas Padecimientos -->
    <?php if ($padecimientos): ?>
      <div class="container pb-3 text-center wow animate__animated animate__slideInUp ">
        <h2 class="font-weight-light pb-5"><strong>Conditions</strong></h2>
        <div class="row mx-auto my-auto">
          <div id="recipeCarousel2" class="carousel slide w-100" data-ride="carousel">
            <div class="carousel-inner" role="listbox">
              <?php $k=0; $j=0; for ($i=0; $i < 3; $i++) { ?>
                <?php if ($j == 0): ?>
                  <div class="carousel-item <?php if($k==0){echo "active";$k++;} ?>">
                    <div class="row">
                    <?php endif; ?>
                    <div class="col-md-4">
                      <div class="card mb-2">
                        <div class="card card-body">
                          <h4 class="card-title textos"><?php echo $padecimientos[$i]['nombre']; ?></h4>
                          <p class="textos" style="font-style: italic;"><?php echo $padecimientos[$i]['descripcion']; ?></p>
                        </div>
                      </div>
                    </div>
                    <?php if ($j == 2): ?>
                        </div>
                      </div>
                    <?php else: ?>
                      <?php $j++ ?>
                    <?php endif; ?>

                  <?php } ?>
                  <?php if ($j != 0): ?>
                    </div>
                  </div>
                <?php endif; ?>
          <!-- <a class="carousel-control-prev w-auto" href="#recipeCarousel2" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon bg-dark border border-dark rounded-circle" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
          </a>
          <a class="carousel-control-next w-auto" href="#recipeCarousel2" role="button" data-slide="next">
            <span class="carousel-control-next-icon bg-dark border border-dark rounded-circle" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
          </a> -->
        </div>
      </div>
    <?php endif; ?>

    <!-- fin carrusel de cartas Padecimientos -->

  <div id="modal"></div>

  <!-- Footer -->
  <?php echo view('Cliente/Footer'); ?>
  <!-- fin footer -->
    <script>

      <?php if (session('region') != 1): ?>
        function ver_colaboradores(){
          $.ajax({
            async:true,
            cache:false,
            dataType:"html",
            type: 'POST',
            url: '<?php echo base_url('Clientes/ver_colaboradores'); ?>',
            //data: {id_producto:id},
            success:  function(data){
              if(data){
                $('#modal').html(data);
                $('#ver').modal();
              }
            },
            beforeSend:function(){},
            error:function(objXMLHttpRequest){}
          });
        }
      <?php endif; ?>

        function add_cart(id) {
            $.ajax({
                async:true,
                cache:false,
                dataType:"html",
                type: 'POST',
                url: '<?php echo base_url('Clientes/agregar_carro'); ?>',
                data: {id_producto:id,cantidad:1},
                success:  function(data){
                    let datos = JSON.parse(data);
                    if(datos.bandera == 1){
                        Toast.fire({
                            icon: 'success',
                            title: datos.respuesta
                        });
                    }else if(datos.bandera == 2){
                        Toast.fire({
                            icon: 'success',
                            title: datos.respuesta
                        });
                    }else{
                        Swal.fire(
                            'Error',
                            datos.respuesta,
                            'error'
                        );
                    }
                },
                beforeSend:function(){},
                error:function(objXMLHttpRequest){}
            });
        }

    </script>
</body>
