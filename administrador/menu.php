<html>
    <head>
        <title>Menú principal</title>

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
                max-width:        100%;       /* Asegura que el contenedor no exceda el tamaño */
                box-sizing:       border-box; /* Incluye padding en el cálculo del ancho */
                border-radius:    10px;
            }
            .mensaje {                          
                font-size:        18px;
                color:            #587381;
                font-weight:      bold;
            }
            .links {
                display:          flex;
                gap:              6px;
                flex-wrap:        wrap;
            }
            .links a {
                text-decoration:  none;
                color:            #008080;
                padding:          5px 10px;
                border-radius:    5px;
                font-weight:      bold;
            }
            .links a:hover {
                background-color: #95c799;
                color:            white;
            }
        </style>
    </head>

    <body>
        <div class="cuerpo">
            <div class="mensaje">
                Bienvenido <?php echo $nombreUser;?>
            </div>
        <div class="links">
            <a href="/proyecto/administrador/bienvenido.php">Inicio</a>   
            <a href="/proyecto/administrador/empleados_lista.php">Empleados</a>
            <a href="/proyecto/productos/productos_lista.php">Productos</a>
            <a href="/proyecto/promociones/promociones_lista.php">Promociones</a>
            <a href="/proyecto/pedidos/pedidos_lista.php">Pedidos</a>
            <a href="/proyecto/administrador/salir.php">Cerrar sesión</a>
        </div>
        </div>
    </body>
</html>
