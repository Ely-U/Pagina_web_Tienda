<?php
// validaProducto.php
session_start();  //
require "conecta.php";
$con = conecta();

$codigo = $_REQUEST['codigo'];

$sql = "SELECT * FROM productos WHERE eliminado = 0 AND codigo = '$codigo'";
$res = $con->query($sql);     //Consulta con SQL en la base de datos****
$num = $res->num_rows;

if ($num == 1) {
    $row       = $res->fetch_array();
    $id        = $row["id"];
    $nombre    = $row["nombre"];
    $codigo    = $row["codigo"];
    
    //Creamos varables de sesión y les asignamos lo que jalamos de las variables
    $_SESSION['idUser']         = $id; 
    $_SESSION['nombreUser']     = $nombre; 
    $_SESSION['codigoUser']     = $codigo; 
}

echo $num;
?>