<?php
//promociones_editar.php
session_start();
$nombreUser = $_SESSION['nombreUser'];
require "funciones/conecta.php";
$con = conecta();

$id = $_REQUEST['id']; //Obtener ID del producto

$sql = "SELECT * FROM promociones WHERE id = $id AND eliminado = 0";
$res = $con->query($sql);
$row = $res->fetch_array();

$nombre      = $row["nombre"]; 
$archivo     = $row["archivo"];

if (!isset($_SESSION['idUser'])) {  //Verifica si no hay sesión activa
    header('Location: ../administrador/login.php'); 
    exit();
}
?>

<html>
    <head>
        <title>Editar promociones</title>
        <script src="js/jquery-3.3.1.min.js"></script>
        
        <script>
            function alertaValidar(){
                var nombre = document.formularioEditar.nombre.value;

                var mensaje_error = $('#mensaje_error'); //Contenedero del mensaje de error Jquery

                if (nombre === ""){
                    mensaje_error.text('Faltan campos por llenar').show();

                    setTimeout(function(){       
                        mensaje_error.hide();          
                    },5000);
                }else{ 
                    document.formularioEditar.method = 'post';
                    document.formularioEditar.action = 'promociones_actualiza.php';
                    document.formularioEditar.submit();
                }
            }
        </script>
        <style>
            body {                              
                font-family:      Sans-serif;   
                background-color: #95c799;
            }
            #formato {                         
                background-color: #fff;        
                text-align:       center;       /* Centra el texto */
                padding:          25px;         /* Borde interno */
                border-radius:    10px;         /* Redondea las esquinas exteriores */
                width:            260px;        /* Ancho fijo */
                margin:           50px auto;
            }
            input[type="text"] {
                width:            100%;
                padding:          10px;
                border:           1px solid #ccc;/* Borde gris claro */
                border-radius:    5px;           /* Bordes redondeados */
                margin:           1px 0;
                font-size:        14px;
            }
            input[type="submit"] {
                background-color: #20B2AA;       /* Color del botón*/
                color:            #fff;          /* Color de letra*/
                padding:          10px;
                border:           none;
                border-radius:    5px;
                width:            100%;
                font-size:        14px;
            }
            #mensaje_error {
                color:            red;
                font-size:        14px;
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
        <?php include('../administrador/menu.php'); ?>
        <div id="formato">
        <form name="formularioEditar" method="post" enctype="multipart/form-data" action="promociones_salva.php">
            <h3>Editar promoción</h3>

            <input type="hidden" name="id" value="<?php echo $id; ?>"> <!-- Para enviar el ID del producto para la actualización-->
            
            <!-- con el pedacito de PHP visualizamos la variable de arriba-->
            <img src="fotos/<?php echo $archivo; ?>" width="100px" height="auto"><!--Mostrar la imagen actual -->

            <input type="text" name="nombre" id="nombre" placeholder="Nombre" value="<?php echo $nombre;?>"/> <br>
            <br><br>
            
            <input type="file" id="archivo" name="archivo"> <br><br> <!-- Seleccionar archivo -->
            <input onclick="alertaValidar();" type="submit" value="Actualizar"/>
  
            <br><br><div id="mensaje_error" style="display:none;"></div><br>
            <!-- Elemento para el mensaje de ERROR, inicalmente vacío y oculto (display:none)-->
            <a href="promociones_lista.php" id="regresar">Regresar al listado</a>
         
        </form>
        </div>
    </body>
</html>
