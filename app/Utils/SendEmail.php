<?php
namespace App\Utils;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use Brevo\Client\Api\AccountApi;
use App\Utils\GuzzHttp;

class SendEmail{
public static function sendMail($emailUser){
    $mail = new PHPMailer(true);
    
try {
    //Server settings
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = $_ENV['EMAIL_HOST'];                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = $_ENV['EMAIL_USER'];                     //SMTP username
    $mail->Password   = $_ENV['EMAIL_PASSWORD'];                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption
    $mail->Port       = $_ENV['EMAIL_PORT'];                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom($emailUser, 'Mailer');
    $mail->addAddress($emailUser, 'teste');     //Add a recipient
    /*
    $mail->addAddress('ellen@example.com');               //Name is optional
    $mail->addReplyTo('info@example.com', 'Information');
    $mail->addCC('cc@example.com');
    $mail->addBCC('bcc@example.com');
    */
    /*Attachments
    $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
    $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name
    */

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Here is the subject';
    $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
    echo 'Message has been sent';
    return $emailUser;
} catch (Exception $e) {
   // error_log("SMTP Debug Output: {$mail->Debugoutput}");
   // echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}

}

}