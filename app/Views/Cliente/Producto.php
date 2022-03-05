<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="apple-touch-icon" href="/assets/img/logo.png">
    <link rel="shortcut icon" type="image/x-icon" href="/assets/img/logo.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" href="/assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" href="/assets/css/index.css">
    <link rel="stylesheet" href="/assets/css/styleIco.css">

  <link href="/assets/css/simple-sidebar.css" rel="stylesheet">

    <script src="/assets/js/wow.min.js"></script>
    <script>
        new WOW().init();
    </script>
    <title>Producto</title>
    <link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet'>
    <script src="https://kit.fontawesome.com/f7929717e2.js" crossorigin="anonymous"></script>

</head>

<body>
  <!-- inicio ingles -->
  <?php if (session('region') == 3 || session('region') == 5): ?>
  <?php echo view('Cliente/Cliente_ing/Producto'); ?>

  <?php endif; ?>
  <!-- final ingles -->


  <!-- inicio español -->
  <?php if (session('region') < 3 || session('region') == 4): ?>
    <div class="d-flex" id="wrapper">
        <!-- Sidebar -->
        <div class="bg-light border-right" id="sidebar-wrapper">
            <!-- <div class="sidebar-heading">Carrito</div> -->
            <ul class="list-group list-group-flush" id="sidebar-cart">
            <?php if (session('cart')): ?>
                <?php $subtotal = 0; foreach (session('cart') as $articulo): ?>
                <li class="list-group-item list-group-item-action bg-light">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <h5 class="card-title text-center"><?php echo $articulo['nombre']; ?></h5>
                                </div>
                                <div class="col-md-5">
                                    <img src="<?php echo $articulo['img'] ?>" class="card-img-top" alt="<?php echo $articulo['nombre']; ?>">
                                </div>
                                <div class="col-md-7">
                                    <p class="card-text"><?php echo $articulo['cantidad'] ?> x <b>$<?php echo $articulo['precio']; $subtotal += $articulo['cantidad']*$articulo['precio']; ?></b></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                <?php endforeach; ?>
                <?php if (isset(session('usuario')['descuento'])): ?>
                <li class="list-group-item list-group-item-action bg-light">
                  <div class="row">
                    <div class="col-md-12 text-center">
                      <p>Descuento de colaborador: <?php echo session('usuario')['descuento']; ?>%</p>
                    </div>
                  </div>
                </li>
                <li class="list-group-item list-group-item-action bg-light">
                  <div class="row">
                    <div class="col-md-12 text-center">
                      <p>Subtotal: $<?php echo $subtotal * (1 - session('usuario')['descuento'] / 100); ?></p>
                    </div>
                  </div>
                </li>
              <?php else: ?>
                <li class="list-group-item list-group-item-action bg-light">
                  <div class="row">
                    <div class="col-md-12 text-center">

                      <p>Subtotal: $<?php echo $subtotal; ?></p>
                    </div>
                  </div>
                </li>
              <?php endif; ?>
                <li class="list-group-item list-group-item-action bg-light">
                    <a href="/Clientes/carrito"><button type="button" class="btn botoncolor btn-block">Ver Carrito</button></a>
                    <?php if (session('usuario')): ?>
                        <a href="/Clientes/finalize_purchase"><button type="button" class="btn btn-dark btn-block mt-2">Finalizar Compra</button></a>
                    <?php else: ?>
                        <a onclick="aviso_sesion()"><button type="button" class="btn btn-dark btn-block mt-2">Finalizar Compra</button></a>
                    <?php endif; ?>
                </li>

            <?php endif; ?>
            </ul>
        </div>
        <!-- /#sidebar-wrapper -->

        <div id="page-content-wrapper">
            <?php echo view('Cliente/Navbar'); ?>
            <!-- inicio producto -->
            <!-- producto -->
            <div class="container margennt mt-4" style="z-index: 1;" id="main-container">
                <!-- <h1 class="text-center">Nombre del producto</h1> -->

                <div class="container bg-white px-3 pl-5 pr-5 pt-5" style="  border-radius: 40px 40px 40px 40px;">
                    <div class="row">
                      <div class="col-md-6">
                            <?php if ($producto['img_sec']): ?>
                                <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                                    <ol class="carousel-indicators">
                                        <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                                        <?php for ($i=1; $i < count($producto['img_sec']); $i++) { ?>
                                            <li data-target="#carouselExampleIndicators" data-slide-to="<?php echo $i;?>"></li>
                                        <?php }?>
                                    </ol>
                                    <div class="carousel-inner">
                                        <div class="carousel-item active">
                                            <img src="<?php echo $producto['img'];  ?>" class="d-block w-100">
                                        </div>
                                        <?php for ($i=1; $i < count($producto['img_sec']); $i++) { ?>
                                            <div class="carousel-item">
                                                <img src="<?php echo $producto['img_sec'][$i]; ?>" class="d-block w-100">
                                            </div>
                                        <?php }?>
                                    </div>

                                    <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="sr-only">Previous</span>
                                    </a>
                                    <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="sr-only">Next</span>
                                    </a>
                                </div>
                            <?php else : ?>
                                <img src="<?php echo $producto['img']; ?>" alt="Responsive image enuin" class="d-block img-fluid" />
                            <?php endif; ?>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-12">
                                    <nav aria-label="breadcrumb">
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item"><a class="btn-link" href="/Clientes/tienda/<?php echo $producto['categoria']['id_categoria']; ?>"><?php echo $producto['categoria']['nombre']; ?></a></li>
                                            <li class="breadcrumb-item"><a class="btn-link" href="#"><?php echo $producto['nombre']; ?></a></li>
                                        </ol>
                                    </nav>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <h1><strong><?php echo $producto['nombre']; ?></strong></h1>
                                </div>
                                <div class="col-md-12">
                                  <?php if (session('region') == 1): ?>
                                    <h3 class="textos mt-3"><strong><?php echo $producto['precio']; ?></strong></h3>
                                  <?php endif; ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 text-justify">
                                    <p style="color: rgba(72,197,57); font-size: 1.4rem" class="mt-3">Disponibilidad: <?php echo $producto['stock'] ?></p>
                                    <p style="color:black; font-size: 1.3rem /* width and color */"><?php echo $producto['descripcion'] ?></p>
                                    <!-- <p class="pl-2 pr-2 text-justify textos" style="font-style: italic;">Se recomienda su uso para complementar tratamientos contra el Alzheimer, Demencia, Parálisis facial, Psoriasis, Convulsiones, Enfermedad de Huntington, Arterioesclerosis.</p> -->
                                </div>
                                <div class="col-md-12">

                                <?php if (session('region') == 1): ?>
                                    <?php if ($producto['disp']): ?>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="input-group mb-3">
                                                    <input type="number" class="form-control" placeholder="1" aria-label="Disponibility" aria-describedby="Disponibility" max="<?php echo $producto['stock']; ?>" min="1" id="cantidad">
                                                </div>
                                            </div>
                                            <div class="col-md-9">
                                                <button type="button" class="btn botoncolor btn-lg btn-block" onclick="add_cart('<?php echo $producto['id_producto']; ?>')">Agregar al carrito</button>
                                            </div>
                                        </div>
                                    <?php else: ?>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="input-group mb-3">
                                                    <input type="number" disabled class="form-control" placeholder="1" aria-label="Disponibility" aria-describedby="Disponibility">
                                                </div>
                                            </div>
                                            <div class="col-md-9">
                                                <button type="button" disabled class="btn botoncolor btn-lg btn-block">Sin Disponibilidad</button>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                <?php else:?>
                                    <a class="btn botoncolor" onclick="ver_colaboradores()">Ver Colaboradores</a>
                                <?php endif; ?>

                                </div>
                            </div>
                        </div>
                        <div class="mt-5 ml-2" style="text-align:center;">
                          <p><span><i class="icon-hecho-me-lines-01 " style="font-size:50px;" aria-hidden="true"></i></span>
                              <span class="ml-5"><i class="icon-organic-line ml-1" style="font-size:50px;" aria-hidden="true"></i></span>
                              <!-- Solo aceites -->
                              <?php if ($producto['categoria']['id_categoria'] == "MQ=="): ?>
                                <span class="ml-5"><i class="ml-1" style="font-size:50px;" aria-hidden="true"><img src="/assets/Icontienda/aceites.png" class="img-fluid mb-4" style="max-width:60px"/></i></span>
                                <span class="ml-5"><i class="ml-1" style="font-size:50px;" aria-hidden="true"><img src="/assets/Icontienda/proh.png" class="img-fluid mb-4" style="max-width:53px"/></i></span>
                              <?php endif; ?>
                              <!-- Solo aceites -->
                          </p>
                          <p class="pl-2 pr-2 text-justify textos" style="font-style: italic;">Productos orgánicos con la más alta calidad.</p>
                      </div>
                    </div>
  <!-- incio producto  -->
                    <?php if ($productos): ?>
                        <div class="container my-5 wow animate__animated animate__fadeInLeft">
                            <h1 class="font-weight-light text-center"><strong> Productos</strong></h1>
                            <div class="row text-dark">
                                <div class="card-deck pb-5">
                                    <?php foreach ($productos as $obj): ?>
                                        <div class="card text-center">
                                            <a href="/Clientes/producto/<?php echo $obj['id_producto'];?> "><img class="card-img-top" style="max-width:358px; max-height:525px; "src="<?php echo $obj['img']; ?>" alt="Card image cap"></a>
                                            <div class="card-body">
                                              <a class="btn-link" href="/Clientes/producto/<?php echo $obj['id_producto'];?> "><h5><strong> <?php echo $obj['nombre']; ?></strong></h5></a>
                                              <p class="card-text textos truncate_text"style="font-style: italic; text-overflow: ellipsis;"><?php echo $obj['descripcion']; ?></p>
                                              <p class="card-text"><b><?php echo $obj['precio'] ?></b></p>
                                              <div class="text-center mb-3">
                                                  <?php if ($obj['padecimientos']): ?>
                                                      <?php foreach ($obj['padecimientos'] as $pad): ?>
                                                          <span class="badge badge-info"><?php echo $pad['nombre'] ?></span>
                                                      <?php endforeach; ?>
                                                  <?php endif; ?>
                                              </div>
                                            </div>
                                            <?php if (session('region') == 1): ?>
                                              <?php if ($obj['disp']): ?>
                                                <a class="btn botoncolor mb-3 mr-5 ml-5" onclick="add_cart('<?php echo $obj['id_producto']; ?>')">Añadir al carrito</a>
                                              <?php else: ?>
                                                  <button class="btn botoncolor mb-3 mr-5 ml-5" disabled>Sin disponibilidad</button>
                                              <?php endif; ?>
                                            <?php else:?>
                                                <a class="btn botoncolor" onclick="ver_colaboradores()">Ver Colaboradores</a>
                                            <?php endif; ?>
                                        </div>
                                    <?php endforeach; ?>
                          </div>
                        </div>
                      </div>
                    <?php endif; ?>
            <!-- fin producto  -->

            <div id="modal"></div>

            <!-- Footer -->
            <?php echo view('Cliente/Footer'); ?>
            <!-- fin footer -->
        </div>

    </div>


    <script>
        $("#menu-toggle").click(function(e) {
            $("#navbar").toggleClass("sticky");
            $("#main-container").toggleClass("margennt");
            e.preventDefault();
            $("#wrapper").toggleClass("toggled");
        });

        var cart_articules = [];

        <?php if (session('cart')): ?>
        $(document).ready(function() {
            cart_articules = JSON.parse('<?php echo json_encode(session('cart')) ?>');
            //paint_cart();
        });
        <?php endif; ?>

        <?php if (!(session('usurio'))): ?>
            function aviso_sesion(params) {
                Swal.fire(
                'Error',
                'Inicia sesión por favor.',
                'error'
                );
            }
        <?php endif; ?>

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
            if($('#cantidad').val() == "" || ($('#cantidad').val() < 0)){
                $('#cantidad').val(1);
            }
            $.ajax({
                async:true,
                cache:false,
                dataType:"html",
                type: 'POST',
                url: '<?php echo base_url('Clientes/agregar_carro'); ?>',
                data: {id_producto:id,cantidad:$('#cantidad').val()},
                success:  function(data){
                    let datos = JSON.parse(data);
                    if(datos.bandera == 1){
                        cart_articules.push({
                            'id_producto':datos.articulo.id_producto,
                            'nombre':datos.articulo.nombre,
                            'precio':datos.articulo.precio,
                            'cantidad':datos.articulo.cantidad,
                            'img':datos.articulo.img
                        });
                        $('#sidebar-cart').html('');
                        paint_cart();
                        Toast.fire({
                            icon: 'success',
                            title: datos.respuesta
                        });
                    }else if(datos.bandera == 2){
                    cart_articules.forEach(element => { //cambio de cantidad
                        if(element.id_producto == datos.articulo.id_producto){
                        element.cantidad = datos.articulo.cantidad;
                        }
                    });
                    $('#sidebar-cart').html('');
                    paint_cart();

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

        function eliminar_cart(id){
            $.ajax({
                async:true,
                cache:false,
                dataType:"html",
                type: 'POST',
                url: '<?php echo base_url('Clientes/eliminar_carro'); ?>',
                data: {id_producto:id},
                success:  function(data){
                    let datos = JSON.parse(data);
                    if(datos.bandera == 1){

                    let cart_articules_aux = cart_articules;
                    let j=0;
                    cart_articules = [];
                    for (let i = 0; i < cart_articules_aux.length; i++) {
                        if(cart_articules_aux[i].id_producto != id){
                            cart_articules[j++] = cart_articules_aux[i];
                        }
                    }
                    $('#sidebar-cart').html('');
                    paint_cart();
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

        function paint_cart(){
            let subtotal = 0;
            cart_articules.forEach(element => {
                $("#sidebar-cart").append('<li class="list-group-item list-group-item-action bg-light"><div class="card"><div class="card-body"><div class="row"> <div class="col-md-12"><h5 class="card-title text-center">'+element.nombre+'<a role="button" onclick="eliminar_cart(\''+element.id_producto+'\')"><i class="fas fa-trash ml-1"></i></a></h5></div><div class="col-md-5"><img src="'+element.img+'" class="card-img-top" alt="'+element.nombre+'"></div><div class="col-md-7"><p class="card-text">'+element.cantidad+' x <b>$'+element.precio+'</b></p></div></div></div></div></li>');
                subtotal += parseInt(element.precio);
            });
            <?php if (isset(session('usuario')['descuento'])): ?>
                $("#sidebar-cart").append('<li class="list-group-item list-group-item-action bg-light"><div class="row"><div class="col-md-12 text-center"><p>Descuento de colaborador: <?php echo session('usuario')['descuento'];?>%</p></div></div></li> <li class="list-group-item list-group-item-action bg-light"><div class="row"><div class="col-md-12 text-center"><p>Subtotal: $'+(subtotal * <?php echo (1 - session('usuario')['descuento'] / 100); ?>)+'</p></div></div></li>');
            <?php else: ?>
                $("#sidebar-cart").append('<li class="list-group-item list-group-item-action bg-light"><div class="row"><div class="col-md-12 text-center"><p>Subtotal: $'+subtotal+'</p></div></div></li>');
            <?php endif; ?>
            <?php if (session('usuario')): ?>
                $("#sidebar-cart").append('<li class="list-group-item list-group-item-action bg-light"><a href="/Clientes/carrito"><button type="button" class="btn boton botoncolor btn-block">Ver Carrito</button></a><a href="href="/Clientes/finalize_purchase"><button type="button" class="btn btn-dark btn-block">Finalizar Compra</button></a></li>');
            <?php else: ?>
                $("#sidebar-cart").append('<li class="list-group-item list-group-item-action bg-light"><a href="/Clientes/carrito"><button type="button" class="btn boton botoncolor btn-block">Ver Carrito</button></a><a onclick="aviso_sesion()"><button type="button" class="btn btn-dark btn-block">Finalizar Compra</button></a></li>');
            <?php endif; ?>
        }



    </script>
  <?php endif; ?>
  <!-- final español -->
</body>
