<?php
//carro_elimina.php
session_start();
require "conecta.php";
$con = conecta();

$id_cliente  = $_SESSION['idCliente']; //ID del cliente
$id_producto = $_POST['id'];

//Obtener el id_pedido del cliente cuyo estado es 'activo' (status = 0)
$sql_pedido = "SELECT id FROM pedidos WHERE id_cliente = $id_cliente AND status = 0";
$res_pedido = $con->query($sql_pedido);   //Obtenemos el ID del pedido abierto
if ($res_pedido && $res_pedido->num_rows > 0) { //SI HAY UN PEDIDO ACTIVO ENTONCES...
    $row_pedido = $res_pedido->fetch_array();
    $id_pedido = $row_pedido['id'];

    //Elimina el producto del carrito (pedidos_productos)
    $sql = "DELETE FROM pedidos_productos WHERE id_pedido = $id_pedido AND id_producto = $id_producto";
    $res = $con->query($sql);

    if ($res) {
        echo 1; //exito
    } else {
        echo 0; //error
    }
} else {
    echo 0; //No hay un pedido activo
}
?>
