<?php
// empleados_actualiza.php
require "funciones/conecta.php";
$con = conecta(); 

$nombre     = $_REQUEST['nombre']; //Cachar las variables de empleados_editar.php
$apellidos  = $_REQUEST['apellidos'];
$correo     = $_REQUEST['correo'];
$pass       = $_REQUEST['pass'];
$rol        = $_REQUEST['rol'];

$archivo_n  = $_FILES['archivo']['name'];      //Nombre real del archivo
$archivo_tmp= $_FILES['archivo']['tmp_name'];  //Nombre/ruta temporal del archivo
$ext        = pathinfo($archivo_n, PATHINFO_EXTENSION); // Obtener la extensión del archivo

$id         = $_REQUEST['id'];    //Obtenemos el ID del empleado que se está editando

//Comprobar si se ha proporcionado una nueva contraseña
if (!empty($pass)) {
    $passEnc = md5($pass); // Encriptamos si hay una nueva contraseña
    $sql = "UPDATE empleados 
            SET nombre='$nombre', apellidos='$apellidos', correo='$correo', pass='$passEnc', rol='$rol'
            WHERE id='$id' AND eliminado = 0";
} else {
    //Si no se proporciona una nueva contraseña, actualizamos sin cambiar la contraseña
    $sql = "UPDATE empleados 
            SET nombre='$nombre', apellidos='$apellidos', correo='$correo', rol='$rol'
            WHERE id='$id' AND eliminado = 0";
}

// Verificar si se subió una nueva foto
if (!empty($archivo_n)) {
    $directorio   = 'fotos/';                            // Carpeta donde se guardan los archivos
    $archivo_enc  = md5_file($archivo_tmp) . '.' . $ext; // Nombre del archivo encriptado con extensión
    move_uploaded_file($archivo_tmp, $directorio . $archivo_enc);

    // Actualizar el nombre del archivo en la base de datos
    $sql_update_imagen = "UPDATE empleados SET archivo='$archivo_enc', archivo_n='$archivo_n' WHERE id='$id' AND eliminado = 0";
    $con->query($sql_update_imagen);
}
$res = $con->query($sql);

header("Location: empleados_lista.php");
?>