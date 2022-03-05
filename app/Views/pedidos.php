<html>
  <head></head>
  <body>
    <?php var_dump($data); ?>
    <?= form_open_multipart('Pedidos/pedido_nuevo') ?>
      <h1>Dirección</h1>
      Provincia: <input type="text" name="province" value="Jalisco"><br/>
      Ciudad: <input type="text" name="city" value="Guadalajara"><br/>
      Nombre: <input type="text" name="name" value="Jorge Fernández"><br/>
      Codigo Postal: <input type="text" name="zip" value="44100"><br/>
      Pais: <input type="text" name="country" value="MX"><br/>
      Direccion 1: <input type="text" name="address1" value="Av. Lázaro Cárdenas #234"><br/>
      Empresa: <input type="text" name="company" value="INC corp"><br/>
      Direccion 2: <input type="text" name="address2" value="Americana"><br/>
      Telefono: <input type="text" name="phone" value="5555555555"><br/>
      Correo: <input type="text" name="email" value="ejemplo@skydropx.com"><br/>
      Referencias: <input type="text" name="references" value="Frente a tienda de abarrotes"><br/>
      <input type="submit" value="Enviar" />
    </form>
  </body>
</html>
