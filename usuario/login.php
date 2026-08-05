<?php
session_start();
if (isset($_SESSION['idCliente'])) {//Verifica si hay una sesión activa
    header('Location: index.php');  //Redirige a la página de bienvenida si ya está logueado
    exit();

    $nombreCliente = $_SESSION['nombreCliente']; 
}
?>

<html>
    <head>
        <title>Login de empleados</title>
        <script src="js/jquery-3.3.1.min.js"></script>
        <script>
            function alertaValidar(){
                var correo = document.formulario01.correo.value;   //Nombre de usuario
                var pass = document.formulario01.pass.value;
                var mensaje_error = $('#mensaje_error'); //Contenedor del mensaje de error Jquery

                if (correo === ""|| pass === ""){
                    mensaje_error.text('Faltan campos por llenar').show();

                    setTimeout(function(){       
                        mensaje_error.hide();            //Ocultar el mensaje después de un tiempo
                    },5000);
                }else{
                    buscar();  //Llama a la función para verificar
                }
            }
            function buscar() {
                var correo = $('#correo').val();
                var pass = $('#pass').val();

                if (correo && pass) {    //Si la variable correo y pass....
                    $.ajax({
                    url          : 'funciones/validaCliente.php',  // Ruta del archivo PHP que verifica si el empleado existe
                    type         : 'POST',               //GET para recuperar datos, POST si van a ser procesados
                    dataType     : 'text',              //Dato que esperas recibir del servidor, 'text' indica que solo esperas texto plano
                    data         : {correo: correo, pass: pass},    //Enviando una variable correo con su respecivo valor
                    success      : function(res) {
                        if (res === '1') { 
                            window.location.href = "index.php"; // Redirige a bienvenido.php si existe
                        }else{
                            $('#mensaje_error').html('El usuario no existe').show();
                            setTimeout(function(){ $('#mensaje_error').html('');}, 5000); 
                        }
                    },error: function() {
                        $('#mensaje_error').html('Error al validar al usuario').show();
                        setTimeout(function(){ $('#mensaje_error').hide(); }, 5000);
                       alert('Error al validar al usuario');} 
                    });
                }
            }
        </script>

        <style>
            body {                             
                font-family:      Sans-serif;   
                display:          flex;
                justify-content:  center;       /* Justifica el contenido  */
                align-items:      center;       /* Centra verticalmente  */
                height:           auto;         /* Ventana del navegador  */
                background-color: #D8BFD8;   
            }
            #formato {                          
                background-color: #fff;        
                text-align:       center;       /* Centra el texto */
                padding:          40px;         /* Borde interno */
                border-radius:    10px;         /* Redondea las esquinas exteriores */
                width:            260px;        /* Ancho fijo */
            }
            input[type="text"],                 /* Selecciona todos los elementos de tipo "texto" */
            input[type="password"] {
                width:            100%;
                padding:          10px;
                border:           1px solid #ccc;/* Borde gris claro */
                border-radius:    5px;           /* Bordes redondeados */
            }
            input[type="submit"] {
                background-color: #20B2AA;       /* Color del botón*/
                color:            #fff;          /* Color de letra*/
                padding:          10px;
                border:           none;
                border-radius:    5px;
            }
            #mensaje_error {
                color:            red;
                font-size:        15px;
            }
        </style>
    </head>

    <body>
        <div id="formato">
        <form name="formulario01" method="post">
            <h4>Usuario iniciar Sesión</h4>
            <input type="text" name="correo" id="correo" placeholder="Usuario"/> <br><br> 
            <input type="password" name="pass" id="pass" placeholder="Contraseña"/> <br>
            <br>
            <input onclick="alertaValidar(); return false;" type="submit" value="Login"/>
            <br><br><div id="mensaje_error" style="display:none;"></div>   
        </form>
        </div>
    </body>
</html>



