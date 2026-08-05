<?php
//recibe.php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre  = htmlspecialchars($_POST['nombre']);
    $correo  = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $mensaje = htmlspecialchars($_POST['mensaje']);

    if ($correo) {
        $mail = new PHPMailer(true);

        try {
            // Configuración del servidor SMTP
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'yurimitzuki@gmail.com'; //Mi correo de Gmail
            $mail->Password = 'qoys umhb uhmq ejki'; //Contraseña o clave de aplicación
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; //Usar STARTTLS
            $mail->Port = 587;

            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
                );

            //Configuración del correo
            $mail->setFrom($correo, $nombre);
            $mail->addAddress('yurimitzuki@gmail.com', 'Destinatario'); // Dirección de destino
            $mail->Subject = 'Nuevo mensaje de contacto';
            $mail->Body = "Has recibido un mensaje de contacto:\n\nNombre: $nombre\nCorreo: $correo\nMensaje:\n$mensaje";

            //Enviar correo
            if ($mail->send()) {
                echo "<div class='mensaje'>
                <h2>¡Tu mensaje fué enviado con éxito!</h2>
                <p>Nos pondremos en contacto contigo a la brevedad</p>
                <a href='/proyecto/usuario/index.php' class='boton'>Seguir comprando</a>
                </div>";
            } else {
                echo 'Hubo un error al enviar el correo';
            }
        } catch (Exception $e) {
            echo "Error al enviar el correo: {$mail->ErrorInfo}";
        }
    } else {
        echo "Correo electrónico inválido.";
    }
} else {
    echo "Acceso no permitido.";
}
?>


<html> 
    <head> 
    <style>
    body {
        font-family:        sans-serif;
        background-color:   #D8BFD8;
        display:            flex;
        justify-content:    center;
        align-items:        center;
        height:             100vh;
        margin:             0;
    }
    .mensaje {
        text-align:         center;
        background-color:   #fff;
        padding:            30px;
        border-radius:      10px;
        box-shadow:         0 4px 6px rgba(0, 0, 0, 0.1);
        max-width:          500px;
        width:              100%;
    }
    .mensaje h2 {
        color:             #6A5ACD;
        font-size:         24px;
    }
    .mensaje p {
        color:             #333;
        font-size:         16px;
        margin:            20px 0;
    }
    .boton {
        background-color: #20B2AA;
        color:            white;
        text-decoration:  none;
        padding:          10px 20px;
        border-radius:    5px;
        font-size:        16px;
        display:          inline-block;
        transition:       background-color 0.3s;
    }
    .boton:hover {
        background-color: #006d5b;
    }
    </style>
    </head>
</html>