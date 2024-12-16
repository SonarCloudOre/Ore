<?php

require 'vendor/autoload.php';
 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;


/**
 * Send an email
 * @param recipient is the email adress which will receive the e-mail
 * @param subject is the subject of the e-mail
 * @param message is the message of the e-mail
 * @param attachment is the potential attachment of the e-mail (image,document,etc) 
 */
function sendMail($recipient,$subject,$message,$attachment = null){
    $res = false;
    $mail = new PHPMailer(true);

    $mail->isSMTP();
    $mail->Mailer = "smtp";
    $mail->CharSet = "UTF-8";

    try{
        $mail->Host = 'ssl0.ovh.net';  //gmail SMTP server
        $mail->SMTPAuth = true;
        //to view proper logging details for success and error messages
        $mail->Username = 'siteweb@jardinore.org';   //email
        $mail->Password =  '3L4p35zsUFaE6x';   //16 character obtained from app password created
        $mail->Port = 465;                    //SMTP port
        $mail->SMTPSecure = "ssl";
    
        $mail->SMTPOptions = array(
            'ssl' => array(
                     'verify_peer' => false,
                     'verify_peer_name' => false,
                     'allow_self_signed' => true
                 )
             );   

        $mail->setFrom('siteweb@jardinore.org', 'Association ORE');


        $mail->addAddress($recipient);
         

        $mail->Subject = $subject;
        $mail->Body = $message;
        $mail->Body .= "\n\nCeci est un message automatique merci de ne pas y répondre ! ASSOCIATION ORE - association.ore@gmail.com - 03 80 48 23 96";
    
        if($attachment != null){
            $mail->addAttachment($_SERVER["DOCUMENT_ROOT"].urldecode($attachment));
        }     

        
        $res = $mail->send();
        

    }catch(Exception $e){
        $res = $e;
    }
    return $res;
}
?>