<?php
//contacto_formulario.php
session_start(); //Arrancas la sesión
require "funciones/conecta.php";
$con = conecta();
?>

<html>
  <head>
    <title>Contacto</title>

    <style>
      body {
        font-family:        Sans-serif;
        background-color:   #D8BFD8;
      }
      .container {
        max-width:          400px;
        margin:             50px auto;
        padding:            20px;
        background-color:   white;
        border-radius:      10px;
      }
      h2 {
        text-align:         left;
        margin-bottom:      10px;
      }
      input[type="text"],input[type="email"],textarea {
        width:              100%;
        padding:            10px;
        margin-bottom:      10px;
        border-radius:      5px;
        border:             1px solid #ccc;
        font-size:          16px;
      }
      textarea {
        resize:             vertical;
        min-height:         150px;
      }
      button {
        background-color:   #20b2aa;
        color:              white;
        padding:            10px 20px;
        border:             none;
        border-radius:      5px;
        width:              100%;
        font-size:          16px;
      }
      button:hover {
        background-color: #006d5b;
      }
    </style>
  </head>

  <body>
  <?php include('../usuario/menu.php'); ?>

    <div class="container">
      <h2>Contáctanos</h2>
    <!--Todo debe tener atributo NAME para que recoja los datos bien -->
    <form action="../recibe.php" method="POST">

      <input type="text" id="nombre" name="nombre" placeholder="Nombre" required>
      <input type="text" id="apellidos" name="apellidos" placeholder="Apellidos" required>
      <!--Usamos la función de mail para enviar el correo-->
      <input type="email" id="email" name="email" placeholder="Correo electrónico" required>
      <textarea id="mensaje" name="mensaje" placeholder="Escribe tu mensaje aquí" required></textarea>
      
      <button type="submit">Enviar</button>
    </form>
    <div id="responseMessage"></div>
    </div>
    <?php include('../usuario/pie.php'); ?>
  </body>
</html>
