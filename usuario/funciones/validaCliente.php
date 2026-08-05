<?php
// validaCliente.php
session_start();  //
require "conecta.php";
$con = conecta();

$correo = $_REQUEST['correo'];
$pass   = $_REQUEST['pass']; 

$sql = "SELECT * FROM clientes WHERE eliminado = 0 AND correo = '$correo' AND pass='$pass'";
$res = $con->query($sql);     //Consulta con SQL en la base de datos****
$num = $res->num_rows;

if ($num == 1) {
    $row       = $res->fetch_array();
    $id        = $row["id"];
    $nombre    = $row["nombre"].'  '.$row["apellidos"];
    $correo    = $row["correo"];
    
    //Creamos varables de sesión y les asignamos lo que jalamos de las variables
    $_SESSION['idCliente']         = $id;    //El ID
    $_SESSION['nombreCliente']     = $nombre;//El nombre
    $_SESSION['correoCliente']     = $correo;//El correo
}

echo $num;
?>