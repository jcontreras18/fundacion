<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

// Configuración del servidor SMTP
$mail = new PHPMailer(true);
$mail->SMTPDebug = 0;                        // Habilitar salida de depuración detallada
$mail->isSMTP();                             // Enviar usando SMTP
$mail->Host       = 'smtp.hostinger.co';     // Servidor SMTP
$mail->SMTPAuth   = true;                    // Activar autenticación SMTP
$mail->Username   = 'julianita9803@gmail.com'; // Usuario SMTP
$mail->Password   = 'jcontreras0806';        // Contraseña SMTP
$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Habilitar cifrado TLS
$mail->Port       = 587;                     // Puerto TCP para conectar, 587 para TLS

// Correo electrónico del remitente
$mail->setFrom('gerenciaservicioti@jevsdata.com', 'Equipo JevsData');

// Construir el cuerpo del correo
if ($_POST['destiny'] == 1) {
    $emailSubject = 'Solicitud desde página web Jevsdata';
    $body = '<p>Buen día JevsData:</p>';
    $body .= '<p>Has recibido una solicitud desde tu página web:</p>';
    $body .= '<ul>';
    $body .= '<li>Correo: ' . htmlspecialchars($_POST['email']) . '</li>';
    $body .= '<li>Nombre: ' . htmlspecialchars($_POST['name']) . '</li>';
    $body .= '<li>Teléfono: ' . htmlspecialchars($_POST['phone']) . '</li>';
    $body .= '<li>Mensaje: ' . htmlspecialchars($_POST['message']) . '</li>';
    $body .= '</ul>';
    $body .= '<p>Cordialmente,</p>';
    $body .= '<p>Equipo JevsData</p>';
    $mail->addAddress('jevsdata@gmail.com', 'Equipo JevsData');
} elseif ($_POST['destiny'] == 2) {
    $emailSubject = 'Gracias por escribirnos';
    $body = '<p>Buen día ' . htmlspecialchars($_POST['name']) . ':</p>';
    $body .= '<p>Hemos recibido tu solicitud por nuestra página web.</p>';
    $body .= '<p>Pronto nos pondremos en contacto contigo.</p>';
    $body .= '<p>Gracias por elegirnos.</p>';
    $body .= '<p>Cordialmente,</p>';
    $body .= '<p>Equipo JevsData</p>';
    $mail->addAddress($_POST['email']);
}

// HTML completo del correo
$html = '
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <style>
        .title {
            font-size: 18px;
            color: #155791;
        }
    </style>
</head>
<body>
    <table class="outer">
        <tr>
            <td class="one-column">
                <table width="100%">
                    <tr>
                        <td>
                            <img src="" />
                        </td>
                    </tr>
                    <tr>
                        <td>' . $body . '</td>
                    </tr>
                    <tr>
                        <td>
                            <a href="https://www.jevsdata.com/"><img src="ftp://u923293135@149.62.37.126/domains/jevsdata.com/public_html/assets/img/LOGOJ.png" alt="Jevs Data" style="max-height:110px; width: auto;"></a>
                        </td>
                        <td>
                            <p><i>Si necesita responder a este correo, por favor remítase a <strong><a href="mailto:contact@jevsdata.com">contact@jevsdata.com</a></strong></i></p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>';

// Enviar correo electrónico
try {
    $mail->addReplyTo($_POST['email'], $_POST['name']);
    $mail->Subject = $emailSubject;
    $mail->isHTML(true);
    $mail->Body = $html;
    $mail->CharSet = 'utf-8';
    $mail->send();
    echo 'Correo enviado correctamente';
} catch (Exception $e) {
    echo "Error al enviar el correo: {$mail->ErrorInfo}";
}
?>
