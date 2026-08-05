<?php
//salir.php
session_start();              // Iniciar la sesión
session_destroy();            // Destruye la sesión
header('Location: login.php');// Destruye la sesión
?>