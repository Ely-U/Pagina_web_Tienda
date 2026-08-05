<?php
session_start();
$nombreUser = $_SESSION['nombreUser']; 

if (!isset($_SESSION['idUser'])) {  //Verifica si no hay sesión activa
    header('Location: ../administrador/login.php');  //Redirige al login si no hay sesión activa
    exit();

    $nombreUser = $_SESSION['nombreUser'];
}
?>

<html>
    <head>
        <title>Alta de productos</title>
        <script src="js/jquery-3.3.1.min.js"></script>
        <script>
            function alertaValidar(){
                var nombre = document.formulario01.nombre.value;
                var codigo = document.formulario01.codigo.value;
                var descripcion = document.formulario01.descripcion.value;
                var costo = document.formulario01.costo.value;
                var stock = document.formulario01.stock.value;
                var archivo = document.formulario01.archivo.value;
                // Accedemos de abajo hacia arriba para guardar los datos en una variable
                var mensaje_error = $('#mensaje_error'); //Contenedero del mensaje de error Jquery

                if (nombre === ""||codigo === ""||descripcion === ""|| costo === "0" || stock === "0" || archivo === ""){
                    mensaje_error.text('Faltan campos por llenar').show();

                    setTimeout(function(){       
                        mensaje_error.hide();            //Ocultar el mensaje después de un tiempo
                    },5000);
                }else{
                    document.formulario01.method = 'post';
                    document.formulario01.action = 'productos_salva.php';
                    document.formulario01.submit();
                }
            }
            function sale() {
                var codigo = $('#codigo').val();

                if (codigo) {    //Si la variable codigo....
                    $.ajax({
                    url          : 'funciones/validaCodigo.php',  // Ruta del archivo PHP que verifica el codigo
                    type         : 'GET',               //GET para recuperar datos, POST si van a ser procesados
                    dataType     : 'text',              //Dato que esperas recibir del servidor, 'text' indica que solo esperas texto plano
                    data         : {codigo: codigo},   //Enviando una variable codigo con su respecivo valor
                    success      : function(res) {
                        if (res === '1') { 
                            $('#mensaje_error').html('El codigo codigo ' + codigo + ' ya existe').show();

                            $('#codigo').val('');    //Limpia el campo de codigo
                            setTimeout(function(){ $('#mensaje_error').html('');}, 5000); 
                        }else{
                            $('#mensaje_error').hide(); 
                        }
                    },error: function() {
                        alert('Error al validar codigo');}
                    });
                }
            }
        </script>

        <style>
            body {                              /*TODO el contenido visible en la página web  */
                font-family:      Sans-serif;   
                background-color: #95c799;  
            }
            #formato {                          /* Cuerpo del forms*/
                background-color: #fff;        
                text-align:       center;       /* Centra el texto */
                padding:          25px;         /* Borde interno */
                border-radius:    10px;         /* Redondea las esquinas exteriores */
                width:            260px;        /* Ancho fijo */
                margin:           50px auto;
            }
            input[type="text"], input[type="number"]{
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
        <div id="formato"> <!-- enctype="multipart/form-data"necesario para subir el archivo-->
        <form name="formulario01" method="post" enctype="multipart/form-data" action="productos_salva.php">
            <h3>Registro de productos</h3>
            
            <input type="text" name="nombre" id="nombre" placeholder="Nombre"/> <br>
            <input onblur="sale();" type="text" name="codigo" id="codigo" placeholder="Codigo"/> <br>
            <input type="text" name="descripcion" id="descripcion" placeholder="Descripcion"/> <br>
            <input type="number" name="costo" id="costo" placeholder="Costo"/> <br>
            <input type="number" name="stock" id="stock" placeholder="Stock"/> <br>
            <br><br>
            <input type="file" id="archivo" name="archivo"> <br><br> <!-- Seleccionar archivo -->
            <input onclick="alertaValidar(); return false;" type="submit" value="Enviar"/>
            
            <br><br><div id="mensaje_error" style="display:none;"></div>
            <!-- Elemento para el mensaje de ERROR, inicalmente vacío y oculto (display:none)-->
            <h4><a href="productos_lista.php" id="regresar">Regresar al listado</a></h4>
        </form>
        </div>
    </body>
</html>
