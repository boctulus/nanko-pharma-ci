<head>
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
  <link rel="stylesheet" href="/assets/css/styleIco.css">
  <script src="/assets/js/wow.min.js"></script>
  <script>
  new WOW().init();
  </script>
  <script src="https://kit.fontawesome.com/f7929717e2.js" crossorigin="anonymous"></script>
  <title>Nosotros</title>
</head>

<body>

  <!-- inicio ingles -->
  <?php if (session('region') == 3 || session('region') == 5): ?>
  <?php echo view('Cliente/Cliente_ing/Nosotros'); ?>

  <?php endif; ?>
  <!-- final ingles -->

  <!-- inicio español -->
  <?php if (session('region') < 3 || session('region') == 4): ?>
    <?php echo view('Cliente/Navbar'); ?>
    <div class="margennn margenabout">

    </div>

    <!-- inicio carrusel -->
    <div id="carouselExampleIndicators" class="text-center slide " data-ride="carousel">
      <ol class="carousel-indicators">
        <li data-target="#carouselExampleIndicators" data-slide-to="0"></li>
        <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
        <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
        <li data-target="#carouselExampleIndicators" data-slide-to="3"></li>
      </ol>
      <div class="carousel-inner" role="listbox">
        <div class="carousel-item active">
          <img class=" img-fluid" src="/assets/img/Nosotros1.jpg" alt="First slide">
        </div>
        <div class="carousel-item">
          <img class="d-block img-fluid img_about" src="/assets/img/Nosotros2.jpg" alt="Second slide">
        </div>
        <div class="carousel-item">
          <img class="d-block img-fluid img_about" src="/assets/img/Nosotros3.jpg" alt="Third slide">
        </div>
        <div class="carousel-item">
          <img class="d-block img-fluid img_about" src="/assets/img/Nosotros4.jpg" alt="fourth slide">
        </div>
      </div>
    </div>
    <!-- fin carrusel -->

    <!-- iniciode jumbotron -->
    <div class="container my-5">
      <div class="row wow animate__animated animate__slideInUp" style="margin-bottom:10px">
        <div class="col-md-12">
          <h2 class="text-center "> <strong><b>Nankö®</b> </strong></h2>
          <p class="text-justify textos">Nankö està comprometido a defender el  Derecho Humano a la Salud por medio del uso de Cannabinoides como complemento en sus tratamientos médicos habituales principalmente en enfermedades crónicas degenerativas y otras afectaciones.
            Todos nuestros productos se encuentran certificados para asegurar la salud de usted y de sus seres queridos.
            Nankö permite desarrollar un vínculo entre pacientes y  nuestro equipo de trabajo conformado por  biólogos, terapeutas e investigadores que buscan la excelencia en cada uno de los productos que ofrece.
          </p>
          <!-- <p class="text-justify textos">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Impedit rem vel
          debitis voluptates tempora unde velit itaque repudiandae corrupti quo sequi voluptas, voluptatem
          ipsam, quam nobis, magnam qui error. Fugit. Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolorem eius qui esse sed,
          accusamus veniam? Porro sunt asperiores alias corporis quo facilis nemo eius, incidunt doloremque placeat ducimus atque aut.
          Lorem ipsum dolor sit amet, consectetur adipisicing elit. Impedit rem vel
          debitis voluptates tempora unde velit itaque repudiandae corrupti quo sequi voluptas, voluptatem
          ipsam, quam nobis, magnam qui error. Fugit. Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolorem eius qui esse sed, accusamus veniam? Porro sunt asperiores alias corporis quo facilis nemo eius, incidunt doloremque placeat ducimus atque aut.
        </p> -->
      </div>
    </div>
  </div>
  <!-- fin de jumbotron -->

  <!-- inicio parallax -->
  <!-- fin parallax -->


  <!-- inicio carrusel de jumbotron -->
  <div class="container my-5">
    <div class="row wow animate__animated animate__slideInUp" style="margin-bottom:10px">
      <div class="col-md-6">
        <img src="/assets/img/MISION.jpg" alt="Image" class="img-fluid" style="max-width: 90%">
      </div>
      <div class="col-md-1"></div>
      <div class="col-md-5">
        <h2 class="text-right"><b><strong>Misión</strong></b></h2>
        <p class="text-justify textos">Ofrecer un producto de calidad en todo el proceso, desde la producción y comercialización de pomadas organicas entre otros adaptándonos a las necesidades de cada cliente.</p>
      </div>
    </div>
    <br>
    <div class="row wow animate__animated animate__slideInUp">
      <div class="col-md-5">
        <h2><b><strong>Visión</strong></b></h2>
        <p class="text-justify textos">Crecer en nuestra presencia a nivel internacional y nacional a través de la innovación, la mejora continua y la generación de valor a nuestros grupos de interés.</p>
      </div>
      <div class="col-md-1"></div>
      <div class="col-md-6">
        <img src="/assets/img/VISION.jpg" alt="Image" class="img-fluid img-rounded">
      </div>
    </div>
    <br>
  </div>
  <!-- fin de jumbotron -->
  <!-- inicio parallax -->
  <div class="bgimg-3 ">
    <div class="caption">
      <div class="container colorjumbotron borderr">
        <div class="row text-dark">
          <div class="col-md-12 wow animate__animated animate__slideInUp">
            <h1 class="icon-organic-dark-01 mt-2" style="font-size:70px;"></h1>
            <p class="text-center  textos"
            style="color:black; font-size: 2rem /* width and color */">
            <i>Nuestros productos vienen de una granja en el estado de Oregón.</i></p>
          </div>
        </div>

      </div>
    </div>
  </div>
    <!-- fin parallax -->
    <!-- inicio carrusel de jumbotron -->
    <div class="container my-5 mt-3 wow animate__animated animate__slideInUp">
        <h2 class="text-center"><b><strong>Colaboradores</strong></b></h2>
        <div class="row accordion" id="accordionExample">
            <?php $i = 0;
            foreach ($estados as $obj) : ?>
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header" id="headingOne_<?php echo $i; ?>">
                            <h2 class="mb-0">
                                <button class="btn btn-link btn-block text-left linkcolores" type="button" data-toggle="collapse" data-target="#collapse_<?php echo $i; ?>" aria-expanded="true" aria-controls="collapse_<?php echo $i; ?>">
                                    <?php echo $obj['pais']; ?>
                                </button>
                            </h2>
                        </div>

                        <div id="collapse_<?php echo $i; ?>" class="collapse" aria-labelledby="headingOne_<?php echo $i; ?>" data-parent="#accordionExample">
                            <div class="card-body">
                                <?php if (count($obj['estados']) == 0): ?>
                                    <p>Aún no hay colaboradores oficiales</p>
                                <?php else: ?>
                                    <?php //proceso de impresion de estados de 3 en 3
                                    $k=0; $bandera_div = false;
                                    for ($j = 0; $j < count($obj['estados']); $j++, $k++) {
                                        if ($k == 3) {
                                            $k = 0;
                                        }
                                        if ($k == 0) {
                                            echo "<div class=\"row mt-3\" style=\"margin-bottom:10px\">";
                                            $bandera_div = true;
                                        }
                                    ?>
                                        <div class="col-md-4">
                                            <p>
                                                <a class="btn-link" role="button" onclick="get_colaboradores('<?php echo $obj['estados'][$j]; ?>',<?php echo $i; ?>)">
                                                    <?php echo $obj['estados'][$j]; ?>
                                                </a>
                                            </p>
                                        </div>
                                    <?php
                                        if ($k == 2) {
                                            echo "</div>";
                                            $bandera_div = false;
                                        }
                                    }

                                    if ($bandera_div) { //si se abrio pero nunca se cerro el div
                                        echo "</div>";
                                    }
                                    ?>
                                    <div class="col-md-12">
                                        <div class="collapse" id="collapseExample_<?php echo $i++; ?>">
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <!-- fin de jumbotron -->


    <!-- Footer -->
    <?php echo view('Cliente/Footer'); ?>
    <!-- fin footer -->

    <script>
        function get_colaboradores(estado,pos){
            $('#collapseExample_'+pos).collapse('hide');
            $('#collapseExample_'+pos).html('');
            $.ajax({
                async:true,
                cache:false,
                dataType:"html",
                type: 'POST',
                url: '<?php echo base_url('Clientes/get_colaboradores'); ?>',
                data: {estado:estado},
                success:  function(data){
                    let datos = JSON.parse(data);
                    if(datos.bandera == 1){
                        datos.colaboradores.forEach(
                            element => {
                                $('#collapseExample_'+pos).append('<div class="card card-body"><h5 class="card-title">'+element.nombre+'</h5><p class="card-text">Teléfono: '+element.telefono+'</p><p class="card-text">Correo: '+element.correo+'</p></div>');
                            }
                        );

                        $('#collapseExample_'+pos).collapse('show');
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
  <?php endif; ?>
  <!-- final ingles -->
</body>
