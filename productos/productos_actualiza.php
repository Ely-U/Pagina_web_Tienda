<?php
// productos_actualiza.php
require "funciones/conecta.php";
$con = conecta(); 

$nombre          = $_REQUEST['nombre']; //Cachar las variables de productos_editar.php
$codigo          = $_REQUEST['codigo'];
$descripcion     = $_REQUEST['descripcion'];
$costo           = $_REQUEST['costo'];
$stock           = $_REQUEST['stock'];

$archivo_n  = $_FILES['archivo']['name'];      //Nombre real del archivo
$archivo_tmp= $_FILES['archivo']['tmp_name'];  //Nombre/ruta temporal del archivo
$ext        = pathinfo($archivo_n, PATHINFO_EXTENSION); // Obtener la extensión del archivo

$id         = $_REQUEST['id'];    //Obtenemos el ID del producto que se está editando

$sql = "UPDATE productos SET nombre='$nombre', codigo='$codigo', descripcion='$descripcion', costo='$costo', stock='$stock'
        WHERE id='$id' AND eliminado = 0";

// Verificar si se subió una nueva foto
if (!empty($archivo_n)) {
    $directorio   = 'fotos/';                            // Carpeta donde se guardan los archivos
    $archivo_enc  = md5_file($archivo_tmp) . '.' . $ext; // Nombre del archivo encriptado con extensión
    move_uploaded_file($archivo_tmp, $directorio . $archivo_enc);

    // Actualizar el nombre del archivo en la base de datos
    $sql_update_imagen = "UPDATE productos SET archivo='$archivo_enc', archivo_n='$archivo_n' WHERE id='$id' AND eliminado = 0";
    $con->query($sql_update_imagen);
}
$res = $con->query($sql);

header("Location: productos_lista.php");
?>