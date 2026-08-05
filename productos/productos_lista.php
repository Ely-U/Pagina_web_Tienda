<?php
//productos_lista.php
session_start();
$nombreUser = $_SESSION['nombreUser'];
require "funciones/conecta.php";
$con = conecta();

$sql = "SELECT * FROM productos WHERE eliminado = 0";
$res = $con->query($sql);
$num = $res->num_rows;

if (!isset($_SESSION['idUser'])) {  //Verifica si no hay sesión activa
  header('Location: ../administrador/login.php');  //Redirige al login si no hay sesión activa
  exit();
}
?>

<html>
  <head>
    <title>Modulo de productos</title>

    <script src="js/jquery-3.3.1.min.js"></script>
    <script>
    function eliminar(id, elemento) {   // función para el botón de ocultar/eliminar 
                
      if(window.confirm("¿Eliminar este producto?")){
        $.ajax({
          url        : "productos_elimina.php", // URL del script PHP que realiza la eliminación
          type       : 'POST',
          data       : { id: id },              // ID del registro a eliminar
          success    : function(res) {
            if (res == 1) {
              $(elemento).closest('.fila').remove();// Usa el ID de la fila para eliminarla
            } else {
              alert("Error al eliminar"); // Mostrar error si hubo un problema
            }
          },error: function() {
            alert('Error en la solicitud...'); 
          }// Alerta, si no falla entonces se ejecutó correctamente
        });
      }
    }
    </script>

    <style>
    body {                               
      font-family:           Sans-serif;   
      height:                auto;         /* Ventana del navegador  */           
      background-color:      #95c799;        
    }

    .container {
      width:                 100%;
      max-width:             1120px; /* Limita el ancho máximo */
      text-align:            left;       /* Alinear todo a la izquierda */
      margin:                50px auto;  /* Centra el contenedor y aplica margen superior e inferior */
    }
    #tabla {
      display:               grid; /* Organiza en filas y columnas */
      border:                3px solid #fff;
      grid-template-columns: 80px 200px 120px 200px 120px 120px 100px 90px 90px;
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
    
    <br><a href="productos_alta.php" id="newRegistro">Registrar nuevo producto</a>
      <h3>Listado de productos (<?php echo $num; ?>)</h3>
    <div id="tabla">
      <div class="nameColumna">ID</div>
      <div class="nameColumna">Nombre</div>
      <div class="nameColumna">Codigo</div>
      <div class="nameColumna">Descripcion</div>
      <div class="nameColumna">Costo</div>
      <div class="nameColumna">Stock</div>
      <div class="nameColumna">Ficha de producto</div>
      <div class="nameColumna">Editar</div>
      <div class="nameColumna">Eliminar</div>

    <!-- Lista que imprime PHP -->
      <?php
      while($row = $res->fetch_array()){
        $id             = $row["id"];
        $nombre         = $row["nombre"];
        $codigo         = $row["codigo"];
        $descripcion    = $row["descripcion"];
        $costo          = $row["costo"];
        $stock          = $row["stock"];
        echo "<div class='fila'>
          <div class='columna'>$id</div>
          <div class='columna'>$nombre</div>
          <div class='columna'>$codigo</div>
          <div class='columna'>$descripcion</div>
          <div class='columna'>$costo</div>
          <div class='columna'>$stock</div>
          <div class='columna'>
            <a href='productos_detalle.php?id=$id'>Detalle</a></div> 
          <div class='columna'>
            <a href='productos_editar.php?id=$id'>Editar</a></div>
          <div class='columna'>
            <button onclick='eliminar($id, this);'>Eliminar</button></div>
        </div>";
      }
      ?>
    </div>
    </div>
  </body>
</html>
