<?php


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

// Instantiation and passing `true` enables exceptions
//Server settings
$mail = new PHPMailer(true);
$mail->SMTPDebug = 0;                      // Enable verbose debug output
$mail->isSMTP();                                            // Send using SMTP
$mail->Host       = 'smtp.hostinger.co';                    // Set the SMTP server to send through
$mail->SMTPAuth   = true;                                   // Enable SMTP authentication
$mail->Username   = 'julianita9803@gmail.com';                     // SMTP username
$mail->Password   = 'jcontreras0806';                               // SMTP password
$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
$mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

//Recipients
$mail->setFrom('julianita9803@hotmail.com', 'Equipo JevsData');

// Attachments
// $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
//$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
if($_POST['destiny'] == 1){
    $emailSubject = 'Solicitud desde página web Jevsdata';
    $body = '<td>
    <p class="title">Buen día JevsData:</p>
    <p>Has recibido una solicitud desde tu página web.</p>
    <p>Los datos de contacto son:</p>
    <p>Correo: ' .$_POST['email'] . '</p>
    <p>Nombre: ' .$_POST['name'] . '</p>
    <p>Telefono: ' .$_POST['phone'] . '</p>
    <p>Mensaje: ' .$_POST['message'] . '</p>
    <p>Cordialmente,</p>

    </td>';
    $mail->addAddress('jevsdata@gmail.com', 'Equipo JevsData');
}
else if($_POST['destiny'] == 2){
    $emailSubject = 'Gracias por escribirnos';
    $body = '<td>
    <p class="title">Buen día '.$_POST['name'] .':</p>
    <p>Hemos recibido tu solicitud por nuestra página web.</p>
    <p>Pronto nos pondremos en contacto contigo.</p>
    <p>Gracias por elegirnos.</p>
    <p>Cordialmente,</p>
    </td>';
    $mail->addAddress($_POST['email']);
}

$html = '<!DOCTYPE html>
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
                        ' . $body .'
                    </tr>
                    <tr>
                        <td>
                        <a href="https://www.jevsdata.com/"><img src="ftp://u923293135@149.62.37.126/domains/jevsdata.com/public_html/assets/img/LOGOJ.png" alt="Jevs Data" style="max-height:110px; width: auto;"></a>
                        </td>
                        <td>
                            <p><i>Si necesita responder a este correo, por favor remítase a <strong><a
                            href="mailto:contact@jevsdata.com">contact@jevsdata.com</a></strong></i>
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>';

/* $ip = $_SERVER["REMOTE_ADDR"];
$captcha = $_POST['grecaptcha-response'];
$secretKey = '6LfhNB4hAAAAAMd5ezWAKUfmYsKFnJrEGpNuTXhK';

$errors = array();

$response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret={$secretKey}&response={$recaptchaResponse}&remoteip={$ip}");

$atributos = json_decode($response, TRUE);

if (!$atributos['success']) {
    $errors[] = 'Verifica el captcha';
} */

if ($mail->addReplyTo($_POST['email'], $_POST['name'])) {
  $mail->Subject = $emailSubject;
  $mail->isHTML(true);
  $mail->Body = $html;
  $mail->CharSet = 'utf8';
  if (!$mail->send()) {
    return -1;
  } else {
    return 1;
  }
}
/* header("Location: https://www.jevsdata.com/");  */

