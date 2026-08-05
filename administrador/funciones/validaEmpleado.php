<?php
// validaEmpleado.php
session_start();  //
require "conecta.php";
$con = conecta();

$correo = $_REQUEST['correo'];
$pass   = md5($_REQUEST['pass']); //Encriptamos la contraseña que recibe

$sql = "SELECT * FROM empleados WHERE eliminado = 0 AND correo = '$correo' AND pass='$pass'";
$res = $con->query($sql);     //Consulta con SQL en la base de datos****
$num = $res->num_rows;

if ($num == 1) {
    $row       = $res->fetch_array();
    $id        = $row["id"];
    $nombre    = $row["nombre"].'  '.$row["apellidos"];
    $correo    = $row["correo"];
    
    //Creamos varables de sesión y les asignamos lo que jalamos de las variables
    $_SESSION['idUser']         = $id; 
    $_SESSION['nombreUser']     = $nombre; 
    $_SESSION['correoUser']     = $correo; 
}

echo $num;
?>