<?php
//pedidos_lista.php
session_start();
$nombreUser = $_SESSION['nombreUser'];
require "funciones/conecta.php";
$con = conecta();

$sql = "SELECT * FROM pedidos WHERE status = 1";
$res = $con->query($sql);
$num = $res->num_rows;

if (!isset($_SESSION['idUser'])) {  //Verifica si no hay sesión activa
  header('Location: ../administrador/login.php');  //Redirige al login si no hay sesión activa
  exit();
}
?>

<html>
  <head>
    <title>Modulo de pedidos</title>

    <style>
    body {                               
      font-family:           Sans-serif;   
      height:                auto;         /* Ventana del navegador  */           
      background-color:      #95c799;        
    }
    .container {
      width:                 100%;
      max-width:             600px; /* Limita el ancho máximo */
      text-align:            left;       /* Alinear todo a la izquierda */
      margin:                50px auto;  /* Centra el contenedor y aplica margen superior e inferior */
    }
    #tabla {
      display:               grid; /* Organiza en filas y columnas */
      border:                3px solid #fff;
      grid-template-columns: 80px 200px 120px 100px 100px;
      border-radius:         10px;   /* Bordes redondeados */
      overflow:              hidden; /* Ocultar contenido que sobresalga */
    }
    .fila {
      display:               contents;
    }
    .columna {
      padding:               10px;
      border:                2px solid #fff;
      text-align:            center;
      justify-content:       center;
      background-color:      #dbeddc;
    }
    .nameColumna { 
      font-weight:           bold;
      padding:               10px;
      border:                2px solid #fff;
      text-align:            center;
      background-color:      #587381;
    }
    /* Estilo para el botón de nuevo registro */
    #newRegistro {
      text-decoration:        none;
      background-color:       #6A5ACD;
      color:                  white;
      padding:                8px 12px; /* Espacio en el botón*/
      border-radius:          5px;
      float:                  right;
    }
    </style>
  </head>

  <body>
    <?php include('../administrador/menu.php'); ?>
    <div class="container">
    
    <br>
      <h3>Listado de pedidos cerrados</h3>
    <div id="tabla">
      <div class="nameColumna">ID Pedido</div>
      <div class="nameColumna">Fecha</div>
      <div class="nameColumna">Cantidad Productos</div>
      <div class="nameColumna">Costo Total</div>
      <div class="nameColumna">Ver Detalle</div>

    <!-- Lista que imprime PHP -->
      <?php
      while($row = $res->fetch_array()){
        $id_pedido   = $row["id"];
        $fecha       = $row["fecha"];

        //Obtenermos los productos asociados al pedido
        $sql_productos = "SELECT pp.cantidad, pp.precio FROM pedidos_productos pp
        WHERE pp.id_pedido = $id_pedido";
        $res_productos = $con->query($sql_productos);
        
        $total_costo = 0;
        $total_cantidad = 0;
        
        //Calculamos el total de productos y costo
        while ($producto = $res_productos->fetch_array()) {
          $total_cantidad += $producto['cantidad'];
          $total_costo += $producto['cantidad'] * $producto['precio'];
        }

        echo "<div class='fila'>
        <div class='columna'>$id_pedido</div>
        <div class='columna'>$fecha</div>
        <div class='columna'>$total_cantidad</div>
        <div class='columna'>$" . number_format($total_costo, 2) . "</div>
        <div class='columna'>
        <a href='pedidos_detalle.php?id=$id_pedido'>Detalle</a>
        </div>
        </div>";
      }
      ?>
    </div>
    </div>
  </body>
</html>
