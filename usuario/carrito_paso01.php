<?php
//carrito_paso01.php
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

if (!isset($_SESSION['idCliente'])) {  //Verifica si no hay sesión activa
  header('Location: index.php');  //Redirige al login si no hay sesión activa
  exit();
}
?>

<html>
  <head>
    <title>Carrito paso 1</title>

    <script src="js/jquery-3.3.1.min.js"></script>
    <script>
    function eliminar(id, elemento) {   // función para el botón de ocultar/eliminar 
                
      if(window.confirm("¿Eliminar del carrito?")){
        $.ajax({
          url        : "/proyecto/usuario/funciones/carro_elimina.php",
          type       : 'POST',
          data       : { id: id },              // ID del registro a eliminar
          success    : function(res) {
            if (res == 1) {
              $(elemento).closest('.fila').remove();// Usa el ID de la fila para eliminarla

              actualizarTotal(); //ACTUALIZAMOS TOTAL AL ELIMINAR
            } else {
              // Mostrar error si hubo un problema
              $('#mensaje_error').html('Error al eliminar').show();
              setTimeout(function(){ $('#mensaje_error').hide(); }, 5000);
            }
          },error: function() {
            $('#mensaje_sol').html('Error en la solicitud').show();
            setTimeout(function(){ $('#mensaje_error').hide(); }, 5000);
          }
        });
      }
    }
    
    
    // Evento onBlur para cambiar la cantidad
    $(document).on('blur', '.cantidad', function() {
      let id       = $(this).data('id');
      let cantidad = $(this).val();
      let costo    = $(this).data('costo');
      
      actualizarCantidad(id, cantidad, costo); //LLAMAMOS AL AJAX
    });
    
    function actualizarCantidad(id, cantidad, costo) {
      $.ajax({
        url    : "/proyecto/usuario/funciones/carro_actualiza.php",
        type   : 'POST',
        data   : { id: id, cantidad: cantidad },
        success: function(res) {
          if (res == 1) {
            let subtotal = cantidad * costo;
            $('#subtotal_' + id).text('$' + subtotal.toFixed(2));

            actualizarTotal(); //ACTUALIZAMOS TOTAL AL CAMBIAR
          } else {
            $('#mensaje_error').html('Error al actualizar la cantidad').show();
            setTimeout(function(){ $('#mensaje_error').hide(); }, 5000);
          }
        }, error: function() {
          $('#mensaje_sol').html('Error en la solicitud').show();
          setTimeout(function(){ $('#mensaje_error').hide(); }, 5000);
        }
      });
    }
    
    //Función para actualizar el total
    function actualizarTotal() {
      let total = 0;
      $('.subtotal').each(function() {
        let subtotal = parseFloat($(this).text().replace('$', '').trim());
        total += isNaN(subtotal) ? 0 : subtotal;
      });
      $('#totalCarrito').text('$' + total.toFixed(2));
    }
    $(document).ready(function() {
      actualizarTotal(); //QUE ACTUALICE INMEDIATAMENTE
    });
    </script>


    <style>
    body {                               
      font-family:           Sans-serif;   
      height:                auto;         /* Ventana del navegador  */           
      background-color:      #D8BFD8;        
    }

    .container {
      width:                 100%;
      max-width:             950px;     /* Limita el ancho máximo */
      text-align:            left;       /* Alinear todo a la izquierda */
      margin:                50px auto;  /* Centra el contenedor y aplica margen superior e inferior */
    }
    #tabla {
      display:               grid; /* Organiza en filas y columnas */
      border:                4px solid #6A5ACD;
      grid-template-columns: 200px 200px 200px 200px 150px;
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
    .columna button {
      background-color:      #D87093;
      color:                 white;
      padding:               8px 16px;
      border:                none;
      border-radius:         5px;
      font-weight:           bold;
    }
    .columna button:hover {  /*Al pasar por encima */
      background-color:      #6A5ACD;
    }
    #continuar { /*Para el botón de continuar*/      
      padding:               10px 20px;         
      background-color:      #20B2AA;
      color:                 white;              
      text-decoration:       none;      
      border-radius:         5px;        
    }
    #continuar:hover {
      background-color:      #5a4abf;   
    }
    [id^="mensaje_error"],[id^="mensaje_sol"] {
      color:             red;
      font-size:         18px;
      display:           block; 
      margin-top:        10px;
      padding:           5px;
    }
    </style>
  </head>

  <body>
    <?php include('../usuario/menu.php'); ?>
    <div class="container">
    
    <h3>Pedido 1/2</h3>
    
    <?php if ($res->num_rows > 0): ?>
    <!-- Si hay productos en el carrito, muestra la tabla -->

    <div id="tabla">
      <div class="nameColumna">Producto</div>
      <div class="nameColumna">Cantidad</div>
      <div class="nameColumna">Costo Unitario</div>
      <div class="nameColumna">Subtotal</div>
      <div class="nameColumna"></div>

    <!-- Lista de productos en el carrito -->
      <?php
      while($row = $res->fetch_array()){
        $id       = $row['id'];
        $nombre   = $row['nombre'];
        $cantidad = $row['cantidad'];
        $costo    = $row['costo'];
        $subtotal = $cantidad * $costo;

        echo "<div class='fila'>
        <div class='columna'>$nombre</div>
        <div class='columna'>
          <input type='number' class='cantidad' value='$cantidad' data-id='$id' data-costo='$costo'>
        </div>
        <div class='columna costo'>$" . number_format($costo, 2) . "</div>
        <div class='columna subtotal' id='subtotal_$id'>$" . number_format($subtotal, 2) . "</div>
        <div class='columna'>
          <button onclick='eliminar($id, this);'>Eliminar</button>
        </div>
      </div>";
      }//Termina el while, así que podemos poner el total
      echo "<div class='fila'>
        <div class='columna' style='text-align:right; font-weight: bold;'>Total:</div>
        <div class='columna'></div>
        <div class='columna'></div>
        <div class='columna' id='totalCarrito' style='font-weight: bold;'>$0.00</div>
        <div class='columna'></div>
      </div>";
      ?>
    </div>
    <br>
    <div id='mensaje_error' style='display:none;'></div>
    <div id='mensaje_sol' style='display:none;'></div>
    <h4><a href="carrito_paso02.php" id="continuar">Continuar</a></h4>

    <?php else: ?>
    <!-- Si no hay productos en el carrito así que muestra un mensaje -->
    <div style="text-align: center; margin-top: 20px;">
      <p style="font-size: 24px; color: #008080; font-weight: bold;">Tu carrito está vacío</p>
      <a href="productos.php" style="text-decoration: none; color: #6A5ACD; font-size: 20px;">¡Revisa nuestros productos!</a>
    </div>
    <?php endif; ?>
    </div>
    <?php include('../usuario/pie.php'); ?>
  </body>
</html>
