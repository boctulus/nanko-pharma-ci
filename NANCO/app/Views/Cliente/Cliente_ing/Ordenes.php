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
  <link rel="stylesheet" href="/assets/css/styleIco.css">
  <script src="/assets/js/wow.min.js"></script>
  <script>
  new WOW().init();
  </script>
  <script src="https://kit.fontawesome.com/f7929717e2.js" crossorigin="anonymous"></script>

  <title>Mis pedidos</title>
</head>

<body>
  <?php echo view('Cliente/Navbar'); ?>

  <!-- inicio ingles -->
  <?php if (session('region') == 3 || session('region') == 5): ?>
    <h1>Pagina en ingles</h1>


  <?php endif; ?>
  <!-- final ingles -->

  <!-- inicio español -->
  <?php if (session('region') < 3 || session('region') == 4): ?>


    <!-- Dosis form inicio -->
    <div class="margennd">
    </div>
    <div class="container-fluid h-100 d-inline-block">
      <div class="container botonavcolor py-3 px-3 wow animate__animated animate__fadeInRight" style="  border-radius: 10px 10px 10px 10px;">
        <h1 class="text-center"><strong>Mis Pedidos</strong></h1>
        <div class="row">
          <div class="col-md-12 mt-2">
            <?php if ($ordenes) : ?>
              <table class="table table-bordered round_table colorletra text-center">
                <thead>
                  <tr class="bg-succes colortabla">
                    <!-- <th scope="col" style="color:#fAfAfA">#</th> -->
                    <th scope="col" style="color:#fAfAfA">Fecha</th>
                    <th scope="col" style="color:#fAfAfA">Precio</th>
                    <th scope="col" style="color:#fAfAfA">Estado</th>
                    <th scope="col" style="color:#fAfAfA">Opciones</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($ordenes as $obj) : ?>
                    <tr>
                      <td><?php echo $obj['fecha']; ?></td>
                      <td><?php echo $obj['precio']; ?></td>
                      <td><?php echo $obj['estado']; ?></td>
                      <td>
                        <?php if ($obj['estado'] == "Pedida"): ?>
                          <a role="button" onclick="eliminar('<?php echo $obj['id_orden']; ?>')"><i class="fa fa-trash"></i></a>
                        <?php endif; ?>
                        <a role="button" onclick="ver_productos('<?php echo $obj['id_orden']; ?>')"><i class="fa fa-eye"></i></a>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            <?php else : ?>
              <p>Aún no hay Ordenes por mostrar</p>
            <?php endif; ?>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <?php if ($pager) : ?>
              <?php $pagi_path = 'Clientes/ordenes/'; ?>
              <?php $pager->setPath($pagi_path); ?>
              <?= $pager->links() ?>
            <?php endif ?>
          </div>
        </div>
      </div>
    </div>

  <?php endif; ?>
  <!-- final español -->

  <!-- Footer -->
  <?php echo view('Cliente/Footer'); ?>
  <!-- fin footer -->

  <div id="modal"></div>

  <script>
  function ver_productos(id) {
    $.ajax({
      async: true,
      cache: false,
      headers: {'X-Requested-With': 'XMLHttpRequest'},
      dataType: "html",
      type: 'POST',
      url: '<?php echo base_url('Clientes/ver_productos'); ?>',
      data: {
        id_orden: id
      },
      success: function(data) {
        if (data) {
          $('#modal').html(data);
          $('#ver').modal();
        }
      },
      beforeSend: function() {},
      error: function(objXMLHttpRequest) {}
    });
  }

  function eliminar(id) {
    $.ajax({
      async: true,
      cache: false,
      dataType: "html",
      type: 'POST',
      url: '<?php echo base_url('Clientes/eliminar_orden'); ?>',
      data: {
        id_orden: id
      },
      success: function(data) {
        if (data) {
          $('#modal').html(data);
          $('#ver').modal();
        }
      },
      beforeSend: function() {},
      error: function(objXMLHttpRequest) {}
    });
  }
  </script>
</body>
