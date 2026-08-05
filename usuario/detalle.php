<?php
//detalle.php
session_start(); //Arrancas la sesión
require "funciones/conecta.php";
$con = conecta();

$id_producto = $_REQUEST['id']; //Obtener ID del producto

$sqlProducto = "SELECT * FROM productos WHERE  id = $id_producto AND eliminado = 0";
$resProducto = $con->query($sqlProducto);

if (isset($_SESSION['idCliente'])) {    //Verifica si hay una sesión activa
  $isLog = true;   //Sí está logueado
  $nombreCliente = $_SESSION['nombreCliente']; 
}else{
  $isLog = false;
}
?>

<html>
  <head>
    <title>Detalle</title>
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
            $('#mensaje_exito').html('Producto agregado con éxito').show();
            setTimeout(function(){ $('#mensaje_exito').hide(); }, 5000);
          
          } else { //Mensaje error
            $('#mensaje_error').html('Error al agregar el producto').show();
            setTimeout(function(){ $('#mensaje_error').hide(); }, 5000);
            
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
      display:           flex;
      flex-direction:    column;     
    }
    .formato {                          
      background-color:  #fff;        
      text-align:        left;        
      padding:           50px;      
      border-radius:     10px;       
      width:             500px;       
      margin:            30px auto;
      flex-direction:    column;  
      overflow:          hidden; /* Evita que los elementos salgan del cuadro */    
    }
    .texto {
      margin-bottom:     10px;
      font-size:         18px;
    }
    .texto.nombre {
      font-weight:       bold;   
      margin-bottom:     10px; 
    }
    .imagen img {
      width:             230px;
      height:            auto;
      border-radius:     10px;
      float:             right; 
      margin-left:       40px;           
    }
    .cantidad{
      margin-top:        30px;
    }
    .cantidad input[type="number"] {
      padding:           5px;
      font-size:         12px;
      border-radius:     5px;
      border:            1px solid #ccc;
      margin-bottom:     7px; 
    }
    .cantidad button {
      background-color:  #20B2AA;
      color:             white;
      padding:           8px 16px;
      border:            none;
      border-radius:     5px;
    }
    .cantidad button:hover {  /*Al pasar por encima */
      background-color:  #006d5b;
    }
    [id^="mensaje_error"],[id^="mensaje_sol"]  {
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
  <div class="formato">
    <?php 
    $producto = $resProducto->fetch_assoc();
    $archivo  = $producto["archivo"];  
    $nombre   = $producto["nombre"];   
    $costo    = $producto["costo"]; 
    $descripcion = $producto["descripcion"];   
    $codigo   = $producto["codigo"];  
    $stock    = $producto["stock"];

    echo "<div class='imagen'>
    <img src='/proyecto/productos/fotos/$archivo'>
    </div>
    <div class='texto nombre'>$nombre</div>
    <div class='texto'>Precio: $". number_format($costo, 2) ."</div>
    <div class='texto'>Descripción: $descripcion</div>
    <div class='texto'>Código: $codigo</div>
    <div class='texto'>Stock: $stock</div>";
    
    if ($isLog) { //Verifica si el usuario esta logueado
      echo "<div class='cantidad'>
        <input type='number' id='cantidad-{$producto['id']}' placeholder='Cantidad'>
        <button type='button' class='agregarCarrito' data-costo='{$costo}' 
        onclick='agregarAlCarrito({$producto['id']})'>
        Comprar
      </button>
    </div>";
    }
    echo "<div id='mensaje_exito' style='display:none;'></div>";
    echo "<div id='mensaje_error' style='display:none;'></div>";
    echo "<div id='mensaje_sol' style='display:none;'></div>";
    echo "</div>"; //Cierra el contenedor de producto
    ?>
  </div>
  <?php include('../usuario/pie.php'); ?>
  </body>
</html>
