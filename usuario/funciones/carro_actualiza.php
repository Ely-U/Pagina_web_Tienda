<?php
//carro_actualiza.php
session_start();
require "conecta.php";
$con = conecta(); 

$id_producto = $_POST['id'];        // ID del producto
$cantidad    = $_POST['cantidad'];  // Nueva cantidad

$id_cliente  = $_SESSION['idCliente'];// ID del cliente

$sql_pedido  = "SELECT id FROM pedidos WHERE id_cliente = $id_cliente AND status = 0";
$res_pedido  = $con->query($sql_pedido);

if ($res_pedido && $res_pedido->num_rows > 0) {  //Obtenemos ID del pedido
    $row_pedido = $res_pedido->fetch_array();
    $id_pedido  = $row_pedido['id'];

    //Actualizamos la cantidad del producto en el pedido correspondiente
    if ($cantidad > 0) { //Cantidad mayor a 0
        $sql = "UPDATE pedidos_productos SET cantidad = $cantidad WHERE id_pedido = $id_pedido 
                AND id_producto = $id_producto";
        $res = $con->query($sql);

        if ($res) {
            echo 1;  //exito
        } else {
            echo 0;  //fallo
        }
    } else {
        echo 0;  //Cantidad NO valida 
    }
} else {
    echo 0;  //No hay un pedido abierto
}
?>
