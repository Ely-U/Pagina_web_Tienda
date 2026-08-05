<?php
if (!isset($_SESSION['idCliente'])) {  //Verifica si hay sesión activa
    $userLog = false;                  //Si NO esta
} else {
    $userLog = true;
    $nombreCliente = $_SESSION['nombreCliente']; 
}

$logo="/proyecto/usuario/logo.png";
?>

<html>
<head>
    <title>Menú</title>
    <style>
        .cuerpo {                             
            font-family:      Sans-serif;   
            display:          flex;
            justify-content:  space-between;     
            align-items:      center;      
            height:           auto;        
            background-color: #E6E6FA; 
            padding:          10px 20px;
            border:           1px solid #ddd;
            max-width:        100%;     
            box-sizing:       border-box; 
            border-radius:    10px;
        }
        .mensaje {                          
            font-size:        18px;
            color:            #483D8B;
            font-weight:      bold;
            flex:             1; /*Ocupa el espacio restante en el contenedor*/
            display:          flex;
            align-items:      center; /*Centra verticalmente*/
            text-align:       center; /*Texto esté centrado*/
        }
        .links {
            display:          flex;
            gap:              6px;
            flex-wrap:        wrap;
        }
        .links a {
            text-decoration:  none;
            color:            #6A5ACD;
            padding:          5px 10px;
            border-radius:    5px;
            font-weight:      bold;
        }
        .links a:hover {
            background-color: #D87093;
            color:            white;
        }
        .mensaje img { /*CSS para el logo del cliente*/
            width:            45px;   /*Reduce el ancho*/
            height:           45px;   /*Reduce la altura*/

        }
    </style>
</head>
<body>
    <header class="cuerpo">
        <div class="mensaje" id="mensaje">
        <img src="<?php echo $logo; ?>">
            <?php if ($userLog): ?>
                Bienvenido, <?php echo $nombreCliente; ?>
            <?php else: ?>
                Bienvenido
            <?php endif; ?>
        </div>
        <div class="links" id="menuLinks">
            <!-- Links dinámicos se insertarán aquí -->
            <?php if ($userLog): ?>
                <a href="/proyecto/usuario/index.php">Home</a>
                <a href="/proyecto/usuario/productos.php">Productos</a>
                <a href="/proyecto/usuario/contacto_formulario.php">Contacto</a>
                <a href="/proyecto/usuario/carrito_paso01.php">Carrito</a>
                <a href="/proyecto/usuario/salir.php">Salir</a>
            <?php else: ?>
                <a href="/proyecto/usuario/index.php">Home</a>
                <a href="/proyecto/usuario/productos.php">Productos</a>
                <a href="/proyecto/usuario/contacto_formulario.php">Contacto</a>
                <a href="/proyecto/usuario/login.php">Login</a>
            <?php endif; ?>
        </div>
    </header>
</body>
</html>
