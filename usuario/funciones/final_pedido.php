<?php
//final_pedido.php
session_start();
require "conecta.php";
$con = conecta();

$id_cliente = $_SESSION['idCliente']; //ID del cliente
$id_pedido  = $_REQUEST['id_pedido']; //ID del pedido

//Verificar si el ID del pedido es válido
if (isset($id_pedido)) {
    //Cambiar el estado del pedido a Finalizado (status = 1)
    $sql = "UPDATE pedidos SET status = 1 WHERE id_cliente = $id_cliente AND id = $id_pedido AND status = 0";
    $res = $con->query($sql);

    if ($res) {
        echo 1; //exito
    } else {
        echo 0; //error
    }
    
} else {
    echo 0; //error
}
?>
