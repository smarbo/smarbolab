<?php

require_once 'vendor/autoload.php';
require_once 'config/constants.php';

// Create the Transport
$transport = (new Swift_SmtpTransport('smtp.gmail.com', 465, 'ssl'))
  ->setUsername(EMAIL)
  ->setPassword(PASSWORD)   
;

// Create the Mailer using your created Transport
$mailer = new Swift_Mailer($transport);

function sendVerificationEmail($userEmail, $token){
    global $mailer;

    $body = '<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><title>SmarboLab - Verify Your Email Address</title></head><body><div class="wrapper"><p>Welcome to SmarboLab. Please verify your email address by clicking on the verification link below.</p><a href="https://obrams.ddns.net/app.php?token=' . $token . '">Verify</a></div></body></html>';
    
    // Create a message
    $message = (new Swift_Message('SmarboLab - Verify Email'))
    ->setFrom([EMAIL => 'SmarboLab'])
    ->setTo($userEmail)
    ->setBody($body, 'text/html');
    ;

    // Send the message
    $result = $mailer->send($message);
}
