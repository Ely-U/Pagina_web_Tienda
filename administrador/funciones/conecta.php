<?php
//funciones/conecta.php
define("HOST",'localhost'); //define crea las constantes 
define("BD",'proyecto'); //base de datos 'proyecto'
define("USER_BD",'root');
define("PASS_BD",'');

function conecta () {
    $con = new mysqli(HOST, USER_BD, PASS_BD, BD);
    /* asignar una variable y que retorne todo lo que hay en esa conexión
        retorna conexión exitosa o marca error */
    // 'mysqli' establece la conexión  la base de datos 
    //  () 
    return $con;
}
?>
