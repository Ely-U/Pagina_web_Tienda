<?php
//carrito_paso02.php
session_start(); //Arrancas la sesión
require "funciones/conecta.php";
$con = conecta();

$id_cliente = $_SESSION['idCliente'];

// Consulta para obtener los productos del carrito del cliente
/* Se le asigna un alias a ambas listas p->productos y pp->pedidos_productos;
Ahora obtenermos los datos que necesitamos el id, nombre, cantidad ( del producto en el carrito) y el costo;
(JOIN) Hacemos una unión con la tabla pedidos_productos, el id del producto debe coincidir con el id_producto;
(SELECT) Ubica el pedido con el id del cliente y con status 0 (pedidos o activos)
*/
$sql = "SELECT p.id, p.nombre, pp.cantidad, p.costo 
        FROM productos p JOIN pedidos_productos pp ON p.id = pp.id_producto 
        WHERE pp.id_pedido IN (SELECT id FROM pedidos WHERE id_cliente = $id_cliente AND status = 0)";
$res = $con->query($sql);

//Obtener el ID del pedido activo
$query = "SELECT id FROM pedidos WHERE id_cliente = $id_cliente AND status = 0";
$result = $con->query($query);

//Verificar primero si hay un pedido abierto, si no nos sale un mensaje feo :(
if ($result && $row = $result->fetch_assoc()) {
  $id_pedido = $row['id'];   //Obtiene el ID del pedido ACTIVO
} else {
  $id_pedido = null;         //No hay pedido activo entonces no se hace nada
}


if (!isset($_SESSION['idCliente'])) {  //Verifica si no hay sesión activa
  header('Location: index.php');  //Redirige al login si no hay sesión activa
  exit();
}
?>

<html>
  <head>
    <title>Carrito paso 2</title>

    <script src="js/jquery-3.3.1.min.js"></script>
    <script>
    function finalizar() {
      var id_pedido = document.getElementById('finalizar').getAttribute('data-id-pedido');
                
      if(window.confirm("¿Deseas finalizar el pedido?")){
        $.ajax({
          url        : "/proyecto/usuario/funciones/final_pedido.php",
          type       : 'POST',
          data       : { id_pedido: id_pedido },         
          success    : function(res) {
            if (res == 1) {
              console.log(res);
              //Pantalla de la finalización
              $('#mensaje_exitoi').html('¡Pedido finalizado con éxito!').show();
              $('#mensaje_exito').html('Muchas gracias por su compra!').show();
              setTimeout(function(){ $('#mensaje_exito').hide(); }, 5000); 
            } else {
              // Mostrar error si hubo un problema
              $('#mensaje_error').html('Error al finalizar el pedido' + res).show();
              setTimeout(function(){ $('#mensaje_error').hide(); }, 5000);
            }
          },error: function() { // Alerta, si no falla entonces se ejecutó correctamente
            $('#mensaje_sol').html('Error en la solicitud').show();
            setTimeout(function(){ $('#mensaje_sol').hide(); }, 5000);
          }
        });
      }
    }
    </script>

    <style>
    body {                               
      font-family:           Sans-serif;   
      height:                auto;         /* Ventana del navegador  */           
      background-color:      #D8BFD8;        
    }
    .container {
      width:                 100%;
      max-width:             800px;     /* Limita el ancho máximo */
      text-align:            left;       /* Alinear todo a la izquierda */
      margin:                50px auto;  /* Centra el contenedor y aplica margen superior e inferior */
    }
    #tabla {
      display:               grid; /* Organiza en filas y columnas */
      border:                4px solid #6A5ACD;
      grid-template-columns: 200px 200px 200px 200px;
      border-radius:         10px;   /* Bordes redondeados */
      overflow:              hidden; /* Ocultar contenido que sobresalga */
    }
    .fila {
      display:               contents;
    }
    .columna {
      padding:               10px;
      border:                2px solid #6A5ACD;
      text-align:            center;
      justify-content:       center;
      background-color:      #dbeddc;
    }
    .nameColumna { 
      font-weight:           bold;
      padding:               10px;
      border:                2px solid #6A5ACD;
      text-align:            center;
      background-color:      #E6E6FA;
    }
    #finalizar { /*Para el botón de finalizar*/      
      padding:               10px 20px;         
      background-color:      #20B2AA;
      color:                 white;              
      text-decoration:       none;      
      border-radius:         5px;     
      font-weight:           bold;
      border:                none;
      font-size:             17px;   
    }
    #finalizar:hover {
      background-color:      #5a4abf;   
    }
    #regresar {
      text-decoration:       none;
      background-color:      #D87093;
      color:                 white;
      padding:               10px 20px;
      border-radius:         5px;
      position:              absolute;
      top:                   100px; /*Lo cuenta desde lo más alto*/
      right:                 380px;
    }
    [id^="mensaje_error"],[id^="mensaje_sol"] {
      color:             red;
      font-size:         18px;
      display:           block; 
      margin-top:        10px;
      padding:           5px;
    }
    [id^="mensaje_exito"] {
      color:             #008080;
      font-size:         15px;
      display:           block; /*Asegura que los mensajes son visibles*/
      margin-top:        10px;
      padding:           5px;
      font-weight:       bold;
    }
    [id^="mensaje_exitoi"] {
      font-size:        50px;
      margin-bottom:    10px;
      color:            #6A5ACD;
      display:          block;
      font-weight:      bold;
    }
    
    </style>
  </head>

  <body>
    <?php include('../usuario/menu.php'); ?>
    <div class="container">
    
      <h3>Pedido 2/2</h3>
      <h4><a href="carrito_paso01.php" id="regresar">Regresar</a></h4>
    <div id="tabla">
      <div class="nameColumna">Producto</div>
      <div class="nameColumna">Cantidad</div>
      <div class="nameColumna">Costo Unitario</div>
      <div class="nameColumna">Subtotal</div>

    <!-- Lista de productos en el carrito -->
      <?php
      $total = 0;  //Declaramos la variable del Total

      while($row = $res->fetch_array()){
        $id       = $row['id'];
        $nombre   = $row['nombre'];
        $cantidad = $row['cantidad'];
        $costo    = $row['costo'];
        $subtotal = $cantidad * $costo;
        $total    += $subtotal; //Hacemos la suma del Total

        echo "<div class='fila'> 
        <div class='columna'>$nombre</div>
        <div class='columna'>$cantidad</div>
        <div class='columna'>$" . number_format($costo, 2) . "</div>
        <div class='columna'>$" . number_format($subtotal, 2) . "</div>
        </div>";
      }
      echo "<div class='fila'>
      <div class='columna' style='text-align:right; font-weight: bold;'>Total:</div>
      <div class='columna'></div>
      <div class='columna'></div>
      <div class='columna' id='totalCarrito' style='font-weight: bold;'>$" . number_format($total, 2) . "</div>
      </div>";
      ?>
    </div>
    <div id='mensaje_exitoi' style='display:none;'></div>
    <div id='mensaje_exito' style='display:none;'></div>
    <div id='mensaje_error' style='display:none;'></div>
    <div id='mensaje_sol' style='display:none;'></div>
    <br>
    <?php
    echo "<button id='finalizar' data-id-pedido='$id_pedido' onclick='finalizar()'>Finalizar</button>";
    ?>
    </div>
    <?php include('../usuario/pie.php'); ?>
  </body>
</html>
