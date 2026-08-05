<?php
//productos_elimina.php
require "funciones/conecta.php";
$con = conecta();

$id = $_POST['id']; //cachar variables

//$sql = "DELETE FROM productos WHERE id = $id";  Instruccion para borrar
$sql = "UPDATE productos SET eliminado = 1 WHERE id = $id";
$res = $con->query($sql);

if ($res) { //Comprobación de la eliminación en consola
    echo 1; // exito
} else {
    echo 0; // error
}
?>


