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

    $body = "<!DOCTYPE html>
    <html lang='en'>
    
    <head>
        <meta charset='UTF-8'>
        <title>SmarboLab - Verify Your Email Address</title>
    </head>
    
    <body>
        <div class='wrapper' style='display: flex; justify-content: center; text-align: center; flex-direction: column; align-items: center; border-radius: 20px; background: #4ca984; padding: 30px; '>
            <p style='font-size: 23px; font-family: 'Segoe UI'; color: white;'>Welcome to SmarboLab. Please verify your email address by clicking on the verification link below.</p><a
            href='https://obrams.ddns.net/app.php?token=' . $token . ' style='background: #062d1d'; color: white; padding: 30px; width: 40px; text-align: center; font-family: 'Segoe UI'; text-decoration: none; border-radius: 20px;'>Verify</a>
        </div>
    </body>
    
    </html>";
    
    // Create a message
    $message = (new Swift_Message('SmarboLab - Verify Email'))
    ->setFrom([EMAIL => 'SmarboLab'])
    ->setTo($userEmail)
    ->setBody($body, 'text/html');
    ;

    // Send the message
    $result = $mailer->send($message);
}
