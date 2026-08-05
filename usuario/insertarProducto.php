<?php
//insertarProductos.php
session_start(); //Arrancas la sesión
require "funciones/conecta.php";
$con = conecta();

//Desde el AJAX envias las variables id_producto y precio
$id_cliente   = $_SESSION['idCliente'];  //Ya tenemos el cliente porque ya arrancamos sesión
$id_producto  = $_REQUEST['id_producto']; //CACHAMOS producto y precio
$precio       = $_REQUEST['costo'];      //Acuerdate que en PRODUCTOS se llama costo
$cantidad     = $_REQUEST['cantidad'];
$fecha        = date('Y-m-d H:i:s');

//Necesitamos insertar un pedido para obtener el id_pedido
//Obtener id_pedido
/*Preguntamos si ya hay un pedido abierto para ese cliente*/
$sql  = "SELECT * FROM pedidos WHERE id_cliente = $id_cliente AND status = 0";
$res  = $con->query($sql);   

/*Revisa si ya hay un pedido abierto para ese cliente, en caso contrario
se inserta uno */
if ($res->num_rows == 0) {
    //No hay pedido abierto, insertar un nuevo pedido
    $sql       = "INSERT INTO pedidos(fecha, id_cliente) VALUES ('$fecha', $id_cliente)";
    $res       = $con->query($sql);     //Consulta con SQL en la base de datos****
    $id_pedido = $con->insert_id;       //Permite obtener el último ID insertado de mi conexión

} else {
    //Obtener el pedido abierto
    $row       = $res->fetch_assoc();
    $id_pedido = $row['id'];
}

//Obtenemos Precio
/*Hacemos una consulta a la base de datos y obtenemos el precio del 
  en el caso de ya existir debe acumularlo Y NO debe haber 2 registros con el mismo producto*/
$sql = "SELECT costo FROM productos WHERE id = $id_producto";
$res = $con->query($sql);

if ($res->num_rows > 0) {
    $row = $res->fetch_assoc();
    $precio = $row['costo']; // Aquí obtenemos el costo correctamente
} else {
    echo 'Producto no encontrado';
    exit;
}


//Antes de insertar revisamos si ya existe el producto en el pedido abierto
$sql = "SELECT * FROM pedidos_productos WHERE 
        id_producto = $id_producto AND id_pedido = $id_pedido";
$res = $con->query($sql);   

if ($res->num_rows == 0) {  //Si no existe insertamos 
    //Insertar el producto en la tabla pedidos_productos
    $sql = "INSERT INTO pedidos_productos(id_pedido, id_producto, cantidad, precio) 
            VALUES('$id_pedido', '$id_producto', '$cantidad', '$precio')";
    $res = $con->query($sql);
    
    if ($res) {
        echo '1'; //Éxito
    } else {
        echo '0';
    }

} else {   //Si YA EXISTE el producto de ese pedido, actualizamos/acumulamos
    $row  = $res->fetch_assoc();
    $idPP = $row['id'];

    $sql = "UPDATE pedidos_productos SET cantidad = cantidad + $cantidad
            WHERE id = $idPP";
    $res = $con->query($sql);

    if ($res) {
        echo '1'; //Éxito
    } else {
        echo '0';
    }
}

?>