<?php
//empleados_detalle.php
session_start();
$nombreUser = $_SESSION['nombreUser'];
require "funciones/conecta.php";
$con = conecta();

$id = $_REQUEST['id']; //Obtener ID del empleado

$sql = "SELECT * FROM empleados WHERE id = $id AND eliminado = 0";
$res = $con->query($sql);

if (!isset($_SESSION['idUser'])) {  //Verifica si no hay sesión activa
    header('Location: login.php');  //Redirige al login si no hay sesión activa
    exit();
}
?>

<html>
    <head>
        <title>Ver Detalle de Empleado</title>
        <style>
            body {                              
                font-family:      Sans-serif;   
                height:           auto;         /* Ventana del navegador  */
                background-color: #95c799;      
            }
            .formato {                          
                background-color: #fff;        
                text-align:       left;         /* Centra el texto */
                padding:          20px;         /* Borde interno */
                border-radius:    10px;         /* Redondea las esquinas exteriores */
                width:            400px;        /* Fija un ancho específico */
                margin:           50px auto;
                flex-direction:   column;       /* Acomoda los elementos dentro de este div en columna */
            }
            .texto {
                margin-bottom:    10px;
                font-size:        18px;
            }
            .imagen img {
                width:            150px;
                height:           auto;
                border-radius:    10px;
                float:            right; 
                margin-left:      30px;        
            }
            #regresar {
            text-decoration:        none;
            background-color:       #FFB6C1;
            color:                  white;
            padding:                5px 9px; /* Espacio en el botón*/
            border-radius:          5px;
            }
        </style>
    </head>
    <body>
       <?php include("menu.php"); ?>
       <div class="formato"> 
       <h2>Detalles del empleado</h2><br>

       <?php
        $row = $res->fetch_array();  // Obtener una fila de resultados como un arreglo
        $nombre    = $row["nombre"]; //Variable $nombre = valor 'nombre' de la tabla de empleados
        $apellidos = $row["apellidos"];
        $correo    = $row["correo"];
        $rol       = $row["rol"] == 1 ? 'Gerente' : 'Ejecutivo';
        $archivo   = $row["archivo"];
        echo "<div class='fila'>
          <div class='imagen'>
            <img src='fotos/$archivo'>
          </div>
          <div class='texto'>Nombre del empleado: $nombre $apellidos</div>
          <div class='texto'>Correo: $correo</div>
          <div class='texto'>Puesto: $rol</div>
        </div>";
        ?>
        
       <br><h3><a href="empleados_lista.php" id="regresar">Regresar al listado</a></h3>
       </div>
    </body>
</html>


