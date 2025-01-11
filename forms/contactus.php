<?php
require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer(true);

try {
    $receiving_email_address = 'praksh@vardhmanchemicalindustries.com';
    $fromName = "Vardhman Chemical Website";
    $fromEmail = "marketing@vardhmanchemicalindustries.com";
    $pass = "Marketingvc@123";

    $name = $_POST['name'];
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $querytype = $_POST['querytype'];
    $message = $_POST['message'];

    $mail->isSMTP();                                            
    $mail->Host = 'smtp.hostinger.com';                           
    $mail->SMTPAuth = true;                                     
    $mail->Username = $fromEmail;                               
    $mail->Password = $pass;                                    
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         
    $mail->Port = 587;                                          

    $mail->setFrom($fromEmail, $fromName);
    $mail->addAddress($receiving_email_address);                  

    if (isset($_FILES['attachment']) && $_FILES['attachment']['error'] === UPLOAD_ERR_OK) {
        $mail->addAttachment($_FILES['attachment']['tmp_name'], $_FILES['attachment']['name']);
    }

    $mail->isHTML(true);                                         
    $mail->Subject = "New Inquiry from Website";
    $emailBody = "
    <!DOCTYPE html>
    <html>
    <head>
        <style>
            body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
            .container { max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ddd; border-radius: 8px; background-color: #f9f9f9; }
            .header { background-color: #4CAF50; color: white; padding: 10px 15px; border-radius: 8px 8px 0 0; text-align: center; font-size: 20px; }
            .content { padding: 15px; }
            .content p { margin: 10px 0; }
            .footer { text-align: center; margin-top: 20px; font-size: 12px; color: #666; }
        </style>
    </head>
    <body>
        <div class='container'>
            <div class='header'>
                <p>$name has just submitted our home page inquiry form on <a href='https://vardhmanchemicalindustries.com' target='_blank'>vardhmanchemicalindustries.com</a> site.</p>
            </div>
            <div class='content'>
                <p><strong>Name:</strong> $name</p>
                <p><strong>Email:</strong> $email</p>
    ";

    if (!empty($subject)) {
        $emailBody .= "<p><strong>Subject:</strong> $subject</p>";
    }
    if (!empty($querytype)) {
        $emailBody .= "<p><strong>Query Type:</strong> $querytype</p>";
    }

    $emailBody .= "
                <p><strong>Message:</strong><br>$message</p>
                <p>Thank you,</p>
                <p><a style='text-decoration:none' href='https://vardhmanchemicalindustries.com' target='_blank'><strong><span class='il'>Vardhman Chemical Industries</span> Team</strong></a></p>
            </div>
            <div class='footer'>
                <p>This email was generated automatically. Please do not reply.</p>
            </div>
        </div>
    </body>
    </html>
    ";

    $mail->Body = $emailBody;

    // Send the email
    $mail->send();
    echo "OK";
} catch (Exception $e) {
    echo "The email message was not sent. Error: {$mail->ErrorInfo}";
}
?>
