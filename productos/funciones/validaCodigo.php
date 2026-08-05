<?php
//validacodigo.php
require "conecta.php";
$con = conecta();

//cachar variables
$codigo = $_REQUEST['codigo'];     
$id     = isset($_REQUEST['id']) ? $_REQUEST['id'] : null;

if ($id) {
    $sql = "SELECT * FROM productos WHERE eliminado = 0  AND codigo ='$codigo' AND id != '$id' ";
} else {
    // Si el id no está definido, es un alta
    $sql = "SELECT * FROM productos WHERE eliminado = 0 AND codigo = '$codigo'";
}

$res  = $con->query($sql);            //Consulta con SQL en la base de datos****

if ($res AND $res->num_rows > 0) { 
    echo '1'; // El codigo ya existe
} else {
    echo '0'; 
}
?>