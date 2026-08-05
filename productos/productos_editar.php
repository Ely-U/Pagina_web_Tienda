<?php
//productos_editar.php
session_start();
$nombreUser = $_SESSION['nombreUser'];
require "funciones/conecta.php";
$con = conecta();

$id = $_REQUEST['id']; //Obtener ID del producto

$sql = "SELECT * FROM productos WHERE id = $id AND eliminado = 0";
$res = $con->query($sql);
$row = $res->fetch_array();

$nombre      = $row["nombre"]; 
$codigo      = $row["codigo"];
$descripcion = $row["descripcion"];
$costo       = $row["costo"];
$stock       = $row["stock"];
$archivo     = $row["archivo"];

if (!isset($_SESSION['idUser'])) {  //Verifica si no hay sesión activa
    header('Location: ../administrador/login.php'); 
    exit();
}
?>

<html>
    <head>
        <title>Editar productos</title>
        <script src="js/jquery-3.3.1.min.js"></script>
        
        <script>
            function alertaValidar(){
                var nombre = document.formularioEditar.nombre.value;
                var codigo = document.formularioEditar.codigo.value;
                var descripcion = document.formularioEditar.descripcion.value;
                var costo = document.formularioEditar.costo.value;
                var stock = document.formularioEditar.stock.value;

                var mensaje_error = $('#mensaje_error'); //Contenedero del mensaje de error Jquery

                if (nombre === ""||codigo === ""||descripcion === ""||costo === "0"|| stock === "0"){
                    mensaje_error.text('Faltan campos por llenar').show();

                    setTimeout(function(){       
                        mensaje_error.hide();          
                    },5000);
                }else{ 
                    document.formularioEditar.method = 'post';
                    document.formularioEditar.action = 'productos_actualiza.php';
                    document.formularioEditar.submit();
                }
            }
            function sale() {
                var id = $('input[name="id"]').val();  // Obtener el ID del producto actual
                var codigo = $('#codigo').val();

                if (codigo) {    //Si la variable codigo....
                    $.ajax({
                    url          : 'funciones/validacodigo.php',  // Ruta del archivo PHP que verifica el codigo
                    type         : 'GET',                         //GET para recuperar datos, POST si van a ser procesados
                    dataType     : 'text',                        //Dato que esperas recibir del servidor, 'text' indica que solo esperas texto plano
                    data         : {codigo: codigo, id: id},      //Enviando una variable codigo con su respecivo valor
                    success      : function(res) {
                        if (res === '1') { 
                            $('#mensaje_error').html('El codigo ' + codigo + ' ya existe').show();

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
            input[type="text"],input[type="number"]{
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
        <form name="formularioEditar" method="post" enctype="multipart/form-data" action="productos_salva.php">
            <h3>Edición de productos</h3>

            <input type="hidden" name="id" value="<?php echo $id; ?>"> <!-- Para enviar el ID del producto para la actualización-->
            
            <!-- con el pedacito de PHP visualizamos la variable de arriba-->
            <img src="fotos/<?php echo $archivo; ?>" width="100px" height="auto"><!--Mostrar la imagen actual -->

            <input type="text" name="nombre" id="nombre" placeholder="Nombre" value="<?php echo $nombre;?>"/> <br>
            <input onblur="sale();" type="text" name="codigo" id="codigo" placeholder="Codigo" value="<?php echo $codigo;?>"/> <br>
            <input type="text" name="descripcion" id="descripcion" placeholder="Descripcion" value="<?php echo $descripcion;?>"/> <br>
            <input type="number" name="costo" id="costo" placeholder="Costo" value="<?php echo $costo;?>"/> <br>
            <input type="number" name="stock" id="stock" placeholder="Stock" value="<?php echo $stock;?>"/> <br>
            <br><br>
            
            <input type="file" id="archivo" name="archivo"> <br><br> <!-- Seleccionar archivo -->
            <input onclick="alertaValidar(); return false;" type="submit" value="Actualizar"/>
  
            <br><br><div id="mensaje_error" style="display:none;"></div><br>
            <!-- Elemento para el mensaje de ERROR, inicalmente vacío y oculto (display:none)-->
            <a href="productos_lista.php" id="regresar">Regresar al listado</a>
         
        </form>
        </div>
    </body>
</html>
