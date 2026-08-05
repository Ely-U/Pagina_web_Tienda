<?php
session_start(); //Arrancas la sesión
$nombreUser = $_SESSION['nombreUser']; 
/*Creamos una variable de sesión y le asignamos lo que tiene la variable 
 nombre user*/

if (!isset($_SESSION['idUser'])) {  //Verifica si no hay sesión activa
  header('Location: login.php');    //Redirige al login si no hay sesión activa
  exit();
}
?>
<html>
    <head>
        <title>Sistema de administración</title>
    </head>
    <body>
    <?php include('menu.php');?>

        <br>Bienvenido <?php echo $nombreUser;?> al sistema de administración
    </body>
</html>




