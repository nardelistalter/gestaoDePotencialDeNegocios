<?php
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require 'vendor/autoload.php';
include 'suport.php';

    // Instantiation and passing `true` enables exceptions
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->CharSet    = 'UTF-8';
        $mail->SMTPDebug  = 0;                                      // Enable verbose debug output
        $mail->isSMTP();                                            // Set mailer to use SMTP
        $mail->Host       = 'smtp.gmail.com';                       // Specify main and backup SMTP servers
        $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
        $mail->Username   = $email;                                 // SMTP username
        $mail->Password   = $password;                              // SMTP password
        $mail->SMTPSecure = 'TLS';                                  // Enable TLS encryption, `ssl` also accepted
        $mail->Port       = 587;                                    // TCP port to connect to

        //Recipients
        $mail->setFrom($email, $system);
        $mail->addAddress($email_to, '');   // Add a recipient

        // Content
        $mail->isHTML(true);                                        // Set email format to HTML
        $mail->Subject = $subject;
        $mail->Body    = $corpo;
        $mail->AltBody = 'NULL';

        $mail->send();
        
        //echo 'E-MAIL ENVIADO COM SUCESSO!';
        echo "<script language='javascript' type='text/javascript'>
            alert('Abra seu e-mail e realize o procedimento de alteração da sua senha!');
            window.location.href='../index.php';
        </script>";
        die();

    } catch (Exception $e) {
        echo "ERRO AO ENVIAR E-MAIL!: {$mail->ErrorInfo}";
    }
?>