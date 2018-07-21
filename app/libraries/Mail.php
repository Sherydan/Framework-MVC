<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require_once('../app/vendor/autoload.php');

class Mail {

   public function sendMail($data = []){
        
        $mail = new PHPMailer(true);                              
        try {
            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host = 'YOUR.SMTP.SERVER';                     // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = 'YOUR@EMAIL';                       // SMTP username
            $mail->Password = 'YOUR PASSWORD';                    // SMTP password
            $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 587;                                    // TCP port to connect to

            //Recipients
            $mail->setFrom('YOUR@EMAIL', 'YOUR NAME');
            $mail->addAddress('TO@EMAIL', 'HIS NAME');     // Add a recipient      // Name is optional
            $mail->addReplyTo($data['email']);
           
            //Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = $data['subject'];
            $mail->Body    = $data['message'];
            $mail->AltBody = $data['message'];

            $mail->send();
            return true;
        } catch (Exception $e) {
            return 'Message could not be sent. '. 'Mailer Error: ' . $mail->ErrorInfo;
            
        } 
   }

   
}


?>