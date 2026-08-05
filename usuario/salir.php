<?php
//salir.php
session_start();              // Iniciar la sesión
session_destroy();            // Destruye la sesión
header('Location: index.php');// Destruye la sesión
?>