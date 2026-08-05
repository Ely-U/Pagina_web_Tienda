<?php
//productos.php
session_start(); //Arrancas la sesión
require "funciones/conecta.php";
$con = conecta();

$sqlProducto = "SELECT * FROM productos WHERE eliminado = 0";
$resProducto = $con->query($sqlProducto);

if (isset($_SESSION['idCliente'])) {//Verifica si hay una sesión activa
  $isLog = true;   //Sí está logueado
  $nombreCliente = $_SESSION['nombreCliente']; 
}else{
  $isLog = false;
}
?>

<html>
  <head>
    <title>Producto</title>
    <script src="js/jquery-3.3.1.min.js"></script>
    <script>
    function agregarAlCarrito(id_producto) { //Recibe el ID del producto
    //Obtiene la cantidad que se desea agregar
    var cantidad = $('#cantidad-' + id_producto).val();
    var costo = $('button[data-costo][onclick*="' + id_producto + '"]').data('costo');

    //Validar que la cantidad sea mayor a 0
    if (cantidad > 0 && cantidad != '') {
      console.log("ID del producto:", id_producto); // Verifica si se está pasando el ID
      console.log("Cantidad:", cantidad);
      $.ajax({
        url           : '/proyecto/usuario/insertarProducto.php',//Ruta del archivo que procesa la solicitud
        type          : 'POST',                                  //Usamos POST porque los datos van a ser procesados
        dataType      : 'text',                                  //Esperamos una respuesta como texto
        data          : {                                        //Enviamos las variables id y cantidad con su respectivo valor
          id_producto: id_producto,                    //ID del producto seleccionado
          cantidad: cantidad,                          //Cantidad ingresada
          costo: costo
        },
        success: function(res) { 
          console.log(res); // Verifica la respuesta que se recibe del servidor
          if (res === '1') {  //Mensaje de éxito 
            $('#mensaje_exito' + id_producto).html('Producto agregado con éxito').show();
            setTimeout(function(){ $('#mensaje_exito' + id_producto).hide(); }, 5000);
          
          } else { //Mensaje error
            $('#mensaje_error' + id_producto).html('Error al agregar el producto').show();
            setTimeout(function(){ $('#mensaje_error' + id_producto).hide(); }, 5000);
            
          }
        },error: function() {
          $('#mensaje_sol').html('Error al agregar al carrito').show();
          setTimeout(function(){ $('#mensaje_sol').hide(); }, 5000);
        }
      });
    } 
  }
</script>


    <style>
    body {                               
      font-family:       Sans-serif;   
      height:            auto;      
      background-color:  #D8BFD8;        
    }
    .container {
      width:             100%;
      max-width:         900px; 
      text-align:        left;       
      margin:            50px auto;  
    }
    .productos {
      display:           grid;
      grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
      gap:               15px;
    }
    .producto {
      text-align:        center;
      background:        white;
      padding:           10px;
      border-radius:     10px;
      position:          relative;
    }
    .producto img {
      max-width:         100%;
      height:            100px;
    }
    .producto .cantidad{
      text-align:        center;
    }
    .producto input[type="number"] {
      padding:           5px;
      width:             50%;
      font-size:         12px;
      border-radius:     5px;
      border:            1px solid #ccc;
      margin-bottom:     10px;
    }
    .producto button {
      background-color:  #20B2AA;
      color:             white;
      padding:           8px 16px;
      border:            none;
      border-radius:     5px;
    }
    .producto a {
      color:             #6A5ACD;
      text-decoration:   none;
    }
    .producto button:hover {  /*Al pasar por encima */
      background-color:  #006d5b;
    }
    [id^="mensaje_error"],[id^="mensaje_sol"] {
      color:             red;
      font-size:         14px;
      display:           block; 
      margin-top:        10px;
      padding:           5px;
    }
    [id^="mensaje_exito"] {
      color:             green;
      font-size:         14px;
      display:           block; /*Asegura que los mensajes son visibles*/
      margin-top:        10px;
      padding:           5px;
    }
    </style>
  </head>

  <body>
  <?php include('../usuario/menu.php'); ?>
  <div class="container">
  <!-- Productos -->
  <div class="productos">
    <?php 
      while ($producto = $resProducto->fetch_assoc()) {
        $id_producto   = $producto['id']; 
        $archivo       = $producto["archivo"];  
        $nombre        = $producto["nombre"];   
        $costo         = $producto["costo"];   
        $codigo        = $producto["codigo"];  
        
        //Imagen clikeable para detalles
        echo "<div class='producto'>
        <a href='detalle.php?id=$id_producto'>    
        <img src='/proyecto/productos/fotos/$archivo'>
        <h3>$nombre</h3>
        </a>
        <p>$" . number_format($costo, 2) . "</p>
        <p>Código: $codigo</p>";

        if ($isLog) { //Verifica si el usuario esta logueado
          echo "<div class='cantidad'>
            <input type='number' id='cantidad-{$producto['id']}' placeholder='Cantidad'>
            <button type='button' class='agregarCarrito' data-costo='{$costo}' 
            onclick='agregarAlCarrito({$producto['id']})'>
            Comprar
          </button>
        </div>";
        }
        echo "<div id='mensaje_exito{$id_producto}' style='display:none;'></div>";
        echo "<div id='mensaje_error{$id_producto}' style='display:none;'></div>";
        echo "<div id='mensaje_sol{$id_producto}' style='display:none;'></div>";
        echo "</div>"; //Cierra el contenedor de producto
      }
    ?>
  </div>
  </div>
  <?php include('../usuario/pie.php'); ?>
  </body>
</html>


