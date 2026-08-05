<?php
//validaCorreo.php
require "conecta.php";
$con = conecta();

//cachar variables
$correo = $_REQUEST['correo'];        //Recibimos los datos de Correo
$id     = isset($_REQUEST['id']) ? $_REQUEST['id'] : null;
// Obtener el id del empleado (lo usamos al actualizar)

// Si el id está definido, es una actualización
//Consultamos si el correo existe y que el id sea diferente (para que no considere a su propio correo)
if ($id) {
    $sql = "SELECT * FROM empleados WHERE eliminado = 0  AND correo ='$correo' AND id != '$id' ";
} else {
    // Si el id no está definido, es un alta
    $sql = "SELECT * FROM empleados WHERE eliminado = 0 AND correo = '$correo'";
}

$res  = $con->query($sql);            //Consulta con SQL en la base de datos****

if ($res AND $res->num_rows > 0) { 
    echo '1'; // El correo ya existe
} else {
    echo '0'; 
}

// $con : Permite interactuar con la base de datos
// ->   :   Operador de acceso a php, métodos o propiedades
// query($sql) : Ejecuta la consulta SQL (" $sql = "SELECT * FROM empleados ...")
// $res : Almacena el resultado de consulta
// $res->num_rows : Obtener el número de filas devueltas por la consulta
?>