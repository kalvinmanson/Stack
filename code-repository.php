<?php if(1 == 2) {
//Envio de email con PHP mailer
require 'drodmin/includes/phpmailer/class.phpmailer.php';

$mail = new PHPMailer;

$mail->isSMTP();
$mail->Host = $config['smtp_server'];
$mail->SMTPAuth = true;
$mail->Username = $config['smtp_user'];
$mail->Password = $config['smtp_pass'];

$mail->From = 'lider@stack.com';
$mail->FromName = 'Lider';
$mail->addAddress('kalvinmanson@gmail.com', 'Kalvin Manson');
$mail->addReplyTo('templario18@gmail.com', 'Templario');
$mail->addCC('gustav100@gmail.com');
$mail->addBCC('kalvinmanson@tupale.org');

$mail->isHTML(true);

$mail->Subject = 'Mensaje de prueba';
$mail->Body    = 'This is the HTML message body <b>in bold!</b>';
$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

if(!$mail->send()) {
   echo 'Message could not be sent.';
   echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
	echo 'Message has been sent';
}
} ?>