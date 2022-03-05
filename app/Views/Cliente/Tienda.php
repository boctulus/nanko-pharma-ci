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
  <link href="/assets/css/simple-sidebar.css" rel="stylesheet">
  <script src="/assets/js/wow.min.js"></script>
  <script>
  new WOW().init();
  </script>
  <script src="https://kit.fontawesome.com/f7929717e2.js" crossorigin="anonymous"></script>
  <title>Tienda</title>
</head>

<body>
  <!-- inicio ingles -->
  <?php if (session('region') == 3 || session('region') == 5): ?>
  <?php echo view('Cliente/Cliente_ing/Tienda'); ?>

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
                        <h5 class="card-title text-center">
                          <?php echo $articulo['nombre']; ?>
                          <a role="button" onclick="eliminar_cart('<?php echo $articulo['id_producto']; ?>')">
                            <i class="fas fa-trash ml-1"></i>
                          </a>
                        </h5>

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
                <a href="/Clientes/carrito"><button type="button" class="btn btn-block  botoncolor" style="color:white;">Ver Carrito</button></a>
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
      <!-- conntainer -->
      <div class="container margennt" style="z-index: 1;" id="main-container">
        <!--row inicial-->
        <div class="row">
          <!-- Inicio lista categorias -->
          <div class="col-lg-3 woow animate__animated animate__fadeInTopLeft">
            <a><img src="/assets/img/logon.png" class="img-fluid my-4 ml-5 img_tienda" alt="" style="max-width:50%;"/> </a>
            <div class="list-group">
              <a href="/Clientes/tienda/" class="list-group-item btn-store border-down d-flex justify-content-center"  style="text-decoration: none; font-Size:25px; background-color:#0000;">Todos</a>

              <?php if ($categorias) : ?>
                <?php foreach ($categorias as $obj) : ?>
                  <?php if ($obj['id_categoria'] == 'MQ==') : ?>
                   <a href="/Clientes/tienda/<?php echo $obj['id_categoria']; ?>" class="list-group-item btn-store border-down d-flex justify-content-start"  style="text-decoration: none; font-Size:25px; background-color:#00000;"><i class="mr-4 img-list-group" style="font-size:4px;"><img src="/assets/Icontienda/gotero.svg" class="img-fluid" style="max-width:30px"/></i><?php echo $obj['nombre']; ?></a>
                  <?php endif; ?>
                  <?php if ($obj['id_categoria'] == 'Mg==') : ?>
                  <a href="/Clientes/tienda/<?php echo $obj['id_categoria']; ?>" class="list-group-item btn-store border-down d-flex justify-content-start"  style="text-decoration: none; font-Size:25px; background-color:#00000;"><i class="mr-4 img-list-group" style="font-size:4px;"><img src="/assets/Icontienda/010-oil.svg" class="img-fluid" style="max-width:30px"/></i><?php echo $obj['nombre']; ?></a>
                  <?php endif; ?>
                  <?php if ($obj['id_categoria'] == 'Mw==') : ?>
                  <a href="/Clientes/tienda/<?php echo $obj['id_categoria']; ?>" class="list-group-item btn-store border-down d-flex justify-content-start"  style="text-decoration: none; font-Size:25px; background-color:#00000;"><i class="mr-4 img-list-group" style="font-size:4px;"><img src="/assets/Icontienda/paw.png" class="img-fluid" style="max-width:30px"/></i><?php echo $obj['nombre']; ?></a>
                  <?php endif; ?>
                  <?php if ($obj['id_categoria'] == 'NA==') : ?>
                  <a href="/Clientes/tienda/<?php echo $obj['id_categoria']; ?>" class="list-group-item btn-store border-down d-flex justify-content-start"  style="text-decoration: none; font-Size:25px; background-color:#00000;"><i class="mr-4 img-list-group" style="font-size:4px;"><img src="/assets/Icontienda/gel.png" class="img-fluid" style="max-width:30px"/></i><?php echo $obj['nombre']; ?></a>
                  <?php endif; ?>
                  <?php if ($obj['id_categoria'] == 'NQ==') : ?>
                  <a href="/Clientes/tienda/<?php echo $obj['id_categoria']; ?>" class="list-group-item btn-store border-down d-flex justify-content-start"  style="text-decoration: none; font-Size:25px; background-color:#00000;"><i class="mr-4 img-list-group" style="font-size:4px;"><img src="/assets/Icontienda/suministros.png" class="img-fluid" style="max-width:30px"/></i><?php echo $obj['nombre']; ?></a>
                  <?php endif; ?>
                  <?php if ($obj['id_categoria'] == 'Ng==') : ?>
                  <a href="/Clientes/tienda/<?php echo $obj['id_categoria']; ?>" class="list-group-item btn-store border-down d-flex justify-content-start"  style="text-decoration: none; font-Size:25px; background-color:#00000;"><i class="mr-4 img-list-group " style="font-size:4px;"><img src="/assets/Icontienda/cosmeticos.png" class="img-fluid " style="max-width:30px"/></i><?php echo $obj['nombre']; ?></a>
                  <?php endif; ?>
                <?php endforeach; ?>
              <?php endif; ?>
            </div>
          </div>
          <!-- Inicio lista categorias -->

          <!-- inicio doble columna -->
          <div class="col-lg-9">

            <!-- Inicio carrusel -->
            <div id="carouselExampleIndicators" class="carousel slide my-4 wow animate__animated animate__fadeInBottomRight" data-ride="carousel">
              <ol class="carousel-indicators">
                <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
              </ol>
              <div class="carousel-inner" role="listbox">
                <div class="carousel-item active">
                  <img class="d-block img-fluid" src="/assets/img/Tcarrusel1.jpg" alt="First slide">
                </div>
                <div class="carousel-item">
                  <img class="d-block img-fluid" src="/assets/img/Tcarrusel2.jpg" alt="Second slide">
                </div>
                <div class="carousel-item">
                  <img class="d-block img-fluid" src="/assets/img/Tcarrusel3.jpg" alt="Third slide">
                </div>
              </div>
              <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon detalles rounded-circle" aria-hidden="true"></span>
                <span class="sr-only detalles">Previous</span>
              </a>
              <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                <span class="carousel-control-next-icon detalles rounded-circle" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
              </a>
            </div>
            <!-- final carrusel -->

            <!-- row inicio tarjetas productos -->
            <div class="row wow animate__animated animate__fadeInBottomLeft">
              <?php foreach ($productos as $obj) : ?>
                <div class="col-lg-4 col-md-6 mb-4">
                  <div class="card text-center h-100">
                    <a href="/Clientes/producto/<?php echo $obj['id_producto']; ?>"><img class="card-img-top" style="max-width:358px; max-height:525px;" src="<?php echo $obj['img'] ?>" alt=""></a>
                    <div class="card-body">
                      <h4 class="card-title">
                        <a class="btn-link" href="/Clientes/producto/<?php echo $obj['id_producto']; ?>"><strong><?php echo $obj['nombre']; ?></strong></a>
                      </h4>
                      <h5>
                        <a class="btn-link" href="/Clientes/tienda/<?php echo $obj['categoria']['id_categoria'] ?>"><?php echo $obj['categoria']['nombre']; ?></a>
                      </h5>
                      <p class="card-text truncate_text" style="font-style: italic; text-overflow: ellipsis;"><?php echo $obj['descripcion']; ?></p>
                      <?php if (session('region') == 1): ?>
                        <h5><strong><?php echo $obj['precio']; ?></strong></h5>
                      <?php endif; ?>

                        <!-- padecimientos -->
                      <div class="text-center mb-3">
                          <?php if ($obj['padecimientos']): ?>
                              <?php foreach ($obj['padecimientos'] as $pad): ?>
                                  <span class="badge badge-info"><?php echo $pad['nombre'] ?></span>
                              <?php endforeach; ?>
                          <?php endif; ?>
                      </div>
                        <!-- fin de padecimientos -->
                    </div>
                    <!-- <div class="card-footer">
                  </div> -->
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
              </div>
            <?php endforeach; ?>
          </div>
          <!--row final tarjetas productos -->
          <div class="row">
            <div class="col-md-12">
              <?php if ($pager) : ?>
                <?php $pagi_path = 'Clientes/tienda/' . $categoria . '/'; ?>
                <?php $pager->setPath($pagi_path); ?>
                <?= $pager->links() ?>
              <?php endif ?>
            </div>
          </div>
        </div>
        <!-- final doble columna -->
      </div>
      <!-- row final -->
    </div>
    <!-- /.container -->
    <div id="modal"></div>

    <!-- Footer -->
    <?php echo view('Cliente/Footer'); ?>
    <!-- fin footer -->
  </div>

</div>
<!-- Menu Toggle Script -->
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

<?php if (!(session('usurio'))): ?>
  function aviso_sesion(params) {
    Swal.fire(
      'Error',
      'Inicia sesión por favor.',
      'error'
    );
  }
<?php endif; ?>

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
      $("#sidebar-cart").append('<li class="list-group-item list-group-item-action bg-light"><a href="/Clientes/carrito"><button type="button" class="btn boton botoncolor btn-block">Ver Carrito</button></a><a href="/Clientes/finalize_purchase"><button type="button" class="btn btn-dark btn-block">Finalizar Compra</button></a></li>');
  <?php else: ?>
      $("#sidebar-cart").append('<li class="list-group-item list-group-item-action bg-light"><a href="/Clientes/carrito"><button type="button" class="btn boton botoncolor btn-block">Ver Carrito</button></a><a onclick="aviso_sesion()"><button type="button" class="btn btn-dark btn-block">Finalizar Compra</button></a></li>');
  <?php endif; ?>
}

</script>
<?php endif; ?>
<!-- final español -->
</body>
