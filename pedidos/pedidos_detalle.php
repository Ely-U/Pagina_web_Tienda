<?php
// pedidos_detalle.php
session_start();
$nombreUser = $_SESSION['nombreUser'];
require "funciones/conecta.php";
$con = conecta();

$id_pedido = $_REQUEST['id']; //Obtenemos el ID del pedido

//Detalles del pedido. Recuerda que las p. son abreviaciones
$sql = "SELECT p.nombre, pp.cantidad, pp.precio FROM productos p JOIN pedidos_productos pp 
        ON p.id = pp.id_producto WHERE pp.id_pedido = $id_pedido";
$res = $con->query($sql);

//Obtenemos la info del pedido para mostrar la fecha y el estado
$sql_pedido = "SELECT * FROM pedidos WHERE id = $id_pedido";
$res_pedido = $con->query($sql_pedido);
$pedido = $res_pedido->fetch_array();


if (!isset($_SESSION['idUser'])) {  //Verifica si no hay sesión activa
    header('Location: ../administrador/login.php'); 
    exit();
}
?>

<html>
    <head>
        <title>Ver Detalle Pedido</title>
        <style>
        body {                              
            font-family:      Sans-serif;   
            height:           auto;
            background-color: #95c799;      
        }
        .formato {                          
            background-color: #fff;        
            text-align:       left;
            padding:          20px;
            border-radius:    10px;
            width:            600px;
            margin:           50px auto;
            flex-direction:   column;
        }
        .texto {
            margin-bottom:    10px;
            font-size:        18px;
        }
        .tabla {
            width:            100%;
            border-collapse:  collapse;  /*Como que junta la tabla, le quita espacios entre medias */
            margin-top:       20px;
        }
        .tabla th, .tabla td {
            padding:          8px;
            border:           1px solid #ddd;
            text-align:       center;
        }
        .tabla th {
            background-color: #587381;
            color:            white;
        }
        #regresar {
            text-decoration:  none;
            background-color: #FFB6C1;
            color:            white;
            padding:          5px 9px;
            border-radius:    5px;
        }
        </style>
    </head>
    <body>
        <?php include('../administrador/menu.php'); ?>
        <div class="formato">
            <h2>Detalles del Pedido #<?php echo $id_pedido; ?></h2> <!-- Número del pedido-->
            <p><strong>Fecha:</strong> <?php echo $pedido['fecha']; ?></p> <!--El strong es pa meterle negritas sin usar CSS-->
            <table class="tabla">
            <tr>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Costo por pieza</th>
                <th>Subtotal</th>
            </tr>
            <?php
            $total = 0; //Variable para poder manejar el total
            while ($producto = $res->fetch_array()) {
                $subtotal = $producto['cantidad'] * $producto['precio'];
                $total    += $subtotal;
                echo "<tr> 
                <td>{$producto['nombre']}</td>
                <td>{$producto['cantidad']}</td>
                <td>$" . number_format($producto['precio'], 2) . "</td>
                <td>$" . number_format($subtotal, 2) . "</td>
                </tr>";
            }
            ?>
            <td colspan="3"><strong>Total:</strong></td>
            <td><strong>$<?php echo number_format($total, 2); ?></strong></td>
            </table>
            <br><h3><a href="pedidos_lista.php" id="regresar">Regresar al listado</a></h3>
        </div>
    </body>
</html>
