<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $phone = htmlspecialchars($_POST['phone']);
    $message = htmlspecialchars($_POST['message']);

    // Validar el correo electrónico
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo 'Correo electrónico no válido.';
        exit;
    }

    $mail = new PHPMailer(true);

    try {
        // Configuración del servidor SMTP
        $mail->isSMTP();
        $mail->Host = 'smtp.hostinger.co'; // Especifica el servidor SMTP principal
        $mail->SMTPAuth = true;
        $mail->Username = 'contact@jlhomestore.com'; // Tu SMTP username
        $mail->Password = 'Lmti2018@@.'; // Tu SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Configuración de destinatarios y contenido del correo
        $mail->setFrom('contact@jlhomestore.com', 'Contacto JLHomeStore');
        $mail->addReplyTo($email, $name);

        // Comprobar destino
        if ($_POST['destiny'] == 1) {
            $emailSubject = 'Solicitud desde página web JLHomeStore';
            $body = '<td>
                        <p class="title">Buen día JLHomeStore:</p>
                        <p>Has recibido una solicitud desde tu página web.</p>
                        <p>Los datos de contacto son:</p>
                        <p>Correo: ' . $email . '</p>
                        <p>Nombre: ' . $name . '</p>
                        <p>Teléfono: ' . $phone . '</p>
                        <p>Mensaje: ' . $message . '</p>
                        <p>Cordialmente,</p>
                    </td>';
            $mail->addAddress('jlhomelinda@gmail.com', 'Equipo JLHomeStore');
        } else if ($_POST['destiny'] == 2) {
            $emailSubject = 'Gracias por escribirnos';
            $body = '<td>
                        <p class="title">Buen día ' . $name . ':</p>
                        <p>Hemos recibido tu solicitud por nuestra página web.</p>
                        <p>Pronto nos pondremos en contacto contigo.</p>
                        <p>Gracias por elegirnos.</p>
                        <p>Cordialmente,</p>
                    </td>';
            $mail->addAddress($email);
        }

        // Contenido del correo en formato HTML
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
                                        ' . $body . '
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

        $mail->isHTML(true);
        $mail->Subject = $emailSubject;
        $mail->Body = $html;
        $mail->CharSet = 'UTF-8';

        if (!$mail->send()) {
            echo 'El mensaje no pudo ser enviado. Error: ' . $mail->ErrorInfo;
        } else {
            echo 'El mensaje ha sido enviado con éxito.';
        }
    } catch (Exception $e) {
        echo "El mensaje no pudo ser enviado. Error: {$mail->ErrorInfo}";
    }
} else {
    echo 'Método de solicitud no válido.';
}
?>