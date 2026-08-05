<?php
// promociones_actualiza.php
require "funciones/conecta.php";
$con = conecta(); 

$nombre          = $_REQUEST['nombre']; 

$archivo_n  = $_FILES['archivo']['name'];      //Nombre real del archivo
$archivo_tmp= $_FILES['archivo']['tmp_name'];  //Nombre/ruta temporal del archivo
$ext        = pathinfo($archivo_n, PATHINFO_EXTENSION); // Obtener la extensión del archivo

$id         = $_REQUEST['id'];    //Obtenemos el ID del producto que se está editando

$sql = "UPDATE promociones SET nombre='$nombre' WHERE id='$id' AND eliminado = 0";

// Verificar si se subió una nueva foto
if (!empty($archivo_n)) {
    $directorio   = 'fotos/';                            // Carpeta donde se guardan los archivos
    $archivo_enc  = md5_file($archivo_tmp) . '.' . $ext; // Nombre del archivo encriptado con extensión
    move_uploaded_file($archivo_tmp, $directorio . $archivo_enc);

    // Actualizar el nombre del archivo en la base de datos
    $sql_update_imagen = "UPDATE promociones SET archivo='$archivo_enc' WHERE id='$id' AND eliminado = 0";
    $con->query($sql_update_imagen);
}
$res = $con->query($sql);

header("Location: promociones_lista.php");
?>