<?php
session_start();
$mail_user =  $_SESSION['mail_user'];
$nom_user =  $_SESSION['nom_user'];
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require './src/Exception.php';
require './src/PHPMailer.php';
require './src/SMTP.php';
//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);
try {
    //Server settings
    // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'scommerce68@gmail.com';                     //SMTP username
    $mail->Password   = 'cdxerffadpnjklvt';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('scommerce68@gmail.com', 'Super website');
    $mail->addAddress($mail_user, $nom_user);     //Add a recipient

    //Attachments

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'vous avez emprunté un matériel';
    $mail->Body    = 'Bonjour Votre emprunt de matériel est validé.';
    $mail->send();
    echo 'Message has been sent';
    header("Refresh:3;../landing.php");
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
