<?php 
include('smtp/PHPMailerAutoload.php');

echo smtp_mailer('trialmepleasevk@gmail.com','subject','msg');

function smtp_mailer($to,$subject,$msg){
   $mail = new PHPMailer();
   $mail->isSMTP();
   $mail->SMTPDebug = 3;
   $mail->Host = 'smtp.gmail.com';
   $mail->Port = 587;
   $mail->SMTPAuth = true;
   $mail->SMTPSecure = 'tls';
   $mail->Username = 'trialmepleasevk@gmail.com';
   $mail->Password = 'ibqk qrom nerx lfbn';
   $mail->setFrom('trialmepleasevk@gmail.com', 'Your Name');
   $mail->AddAddress($to);
   $mail->Subject = 'Checking if PHPMailer works';
   $mail->Body = 'This is just a plain text message body';
   //$mail->addAttachment('attachment.txt');
   if (!$mail->send()) {
       echo 'Mailer Error: ' . $mail->ErrorInfo;
   } else {
       echo 'The email message was sent.';
   }
}

?>