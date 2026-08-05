<?php
//empleados_editar.php
session_start();
$nombreUser = $_SESSION['nombreUser'];
require "funciones/conecta.php";
$con = conecta();

$id = $_REQUEST['id']; //Obtener ID del empleado

$sql = "SELECT * FROM empleados WHERE id = $id AND eliminado = 0";
$res = $con->query($sql);
$row = $res->fetch_array();

$nombre    = $row["nombre"]; //Le damos a las variables el valor de la base de datos
$apellidos = $row["apellidos"];
$correo    = $row["correo"];
$pass      = $row['pass'];
$rol       = $row["rol"];
$archivo   = $row["archivo"];

if (!isset($_SESSION['idUser'])) {  //Verifica si no hay sesión activa
    header('Location: login.php');  //Redirige al login si no hay sesión activa
    exit();
}
?>

<html>
    <head>
        <title>Editar empleados</title>
        <script src="js/jquery-3.3.1.min.js"></script>
        
        <script>
            function alertaValidar(){
                var nombre = document.formularioEditar.nombre.value
                var apellidos = document.formularioEditar.apellidos.value
                var correo = document.formularioEditar.correo.value;
                var rol = document.formularioEditar.rol.value;
                var mensaje_error = $('#mensaje_error'); //Contenedero del mensaje de error Jquery

                if (nombre === ""||apellidos === ""||correo === ""|| rol === "0"){
                    mensaje_error.text('Faltan campos por llenar').show();

                    setTimeout(function(){       
                        mensaje_error.hide();            //Ocultar el mensaje después de un tiempo
                    },5000);
                }else{ // Si no hay errores, proceder a enviar el formulario
                    document.formularioEditar.method = 'post';
                    document.formularioEditar.action = 'empleados_actualiza.php';
                    document.formularioEditar.submit();
                }
            }
            function sale() {
                var id = $('input[name="id"]').val();  // Obtener el ID del empleado actual
                var correo = $('#correo').val();

                if (correo) {    //Si la variable correo....
                    $.ajax({
                    url          : 'funciones/validaCorreo.php',  // Ruta del archivo PHP que verifica el correo
                    type         : 'GET',                         //GET para recuperar datos, POST si van a ser procesados
                    dataType     : 'text',                        //Dato que esperas recibir del servidor, 'text' indica que solo esperas texto plano
                    data         : {correo: correo, id: id},      //Enviando una variable correo con su respecivo valor
                    success      : function(res) {
                        if (res === '1') { 
                            $('#mensaje_error').html('El correo ' + correo + ' ya existe').show();

                            $('#correo').val('');    //Limpia el campo de correo
                            setTimeout(function(){ $('#mensaje_error').html('');}, 5000); 
                        }else{
                            $('#mensaje_error').hide(); 
                        }
                    },error: function() {
                        alert('Error al validar correo');}
                    });
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
            input[type="text"]{
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
        <?php include("menu.php"); ?>
        <div id="formato">
        <form name="formularioEditar" method="post" enctype="multipart/form-data" action="empleados_salva.php">
            <h3>Edición de empleados</h3>

            <input type="hidden" name="id" value="<?php echo $id; ?>"> <!-- Para enviar el ID del empleado para la actualización-->
            
            <!-- con el pedacito de PHP visualizamos la variable de arriba-->
            <img src="fotos/<?php echo $archivo; ?>" width="100px" height="auto"><!--Mostrar la imagen actual -->
            <input type="text" name="nombre" id="nombre"  placeholder="Escribe tu nombre" value="<?php echo $nombre;?>"/> <br>
            <input type="text" name="apellidos" id="apellidos" placeholder="Escribe tus apellidos" value="<?php echo $apellidos;?>"/> <br>
            <input onblur="sale();" type="text" name="correo" id="correo" placeholder="Escribe tu correo" value="<?php echo $correo;?>"/> <br> 
            <input type="text" name="pass" id="pass" placeholder="Contraseña"/> <br>
            
            <select name="rol" id="rol">
                <option value="1"<?php if($rol ==1) echo 'selected';?>>Gerente</option>
                <option value="2"<?php if($rol ==2) echo 'selected';?>>Ejecutivo</option>
            </select>
            <br><br>
            
            <input type="file" id="archivo" name="archivo"> <br><br> <!-- Seleccionar archivo -->
            <input onclick="alertaValidar(); return false;" type="submit" value="Actualizar"/>
  
            <br><br><div id="mensaje_error" style="display:none;"></div><br>
            <!-- Elemento para el mensaje de ERROR, inicalmente vacío y oculto (display:none)-->
            <a href="empleados_lista.php" id="regresar">Regresar al listado</a>
         
        </form>
        </div>
    </body>
</html>
