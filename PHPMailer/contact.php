<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';


require 'vendor/autoload.php';

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
        $mail->Username = 'jlhomelinda@gmail.com';
        $mail->Password = 'Lmti2018';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

                
        // Cargar las credenciales desde variables de entorno
        $mail->Username = getenv('SMTP_USERNAME'); // Ejemplo de variable de entorno
        $mail->Password = getenv('SMTP_PASSWORD'); // Ejemplo de variable de entorno

        // Destinatarios
        $mail->setFrom($email, $name);
        $mail->addAddress('jlhomelinda@gmail.com', 'Destinatario');

        // Contenido del correo
        $mail->isHTML(true);
        $mail->Subject = 'Nuevo mensaje de contacto';
        $mail->Body    = "<h2>Nuevo mensaje de contacto</h2>
                          <p><b>Nombre:</b> $name</p>
                          <p><b>Correo:</b> $email</p>
                          <p><b>Teléfono:</b> $phone</p>
                          <p><b>Mensaje:</b><br>$message</p>";
        $mail->AltBody = "Nombre: $name\nCorreo: $email\nTeléfono: $phone\nMensaje:\n$message";

        $mail->send();
        echo 'El mensaje ha sido enviado con éxito.';
    } catch (Exception $e) {
        echo "El mensaje no pudo ser enviado. Error: {$mail->ErrorInfo}";
    }
} else {
    echo 'Método de solicitud no válido.';
}
?>

