<?php
//productos_salva.php
require "funciones/conecta.php";
$con = conecta(); // en la variable 'con' trae los datos de conexión

// Cachar variables de productos_alta.php
$nombre          = $_REQUEST['nombre']; // 'REQUEST cacha lo enviado por POST o GET
$codigo          = $_REQUEST['codigo'];
$descripcion     = $_REQUEST['descripcion'];
$costo           = $_REQUEST['costo'];
$stock           = $_REQUEST['stock'];

$archivo_n     = $_FILES['archivo']['name'];      //Nombre real del archivo
$archivo_tmp   = $_FILES['archivo']['tmp_name'];  //Nombre/ruta temporal del archivo

// Separar el nombre del archivo para obtener la extensión
$arreglo      = explode(".", $archivo_n);         //Separa el nombre para obtener la extensión
$len          = count($arreglo);                  //Número de elementos
$pos          = $len-1;                           //Posición a buscar
$ext          = $arreglo[$pos];                   //Extensión

// Creamos una carpeta para guardar los archivos que subimos y le damos nombre
$directorio   = 'fotos/';                            // Carpeta donde se guardan los archivos
$archivo_enc  = md5_file($archivo_tmp) . '.' . $ext; // Nombre del archivo encriptado con extensión

// Mover el archivo a la carpeta correspondiente
move_uploaded_file($archivo_tmp, $directorio . $archivo_enc);
//(nombre del archivo, direccion, nuevmo nombre)

// Inserción en la base de datos
$sql = "INSERT INTO productos 
        (nombre, codigo, descripcion, costo, stock, archivo_n, archivo) 
        VALUES ('$nombre', '$codigo', '$descripcion', '$costo', '$stock', '$archivo_n', '$archivo_enc')";

$res = $con->query($sql); // Ejecuta la consulta

header("Location: productos_lista.php"); // Redirecciona
?>