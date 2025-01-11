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
    $country = $_POST['country'];
    $state = $_POST['state'];
    $category = $_POST['category'];
    $product = $_POST['product'];
    $message = $_POST['message'];
    $pageName = !empty($subject) ? "our home page" : (!empty($querytype) ? "our contact us page" : (!empty($country) ? "our export page" :(!empty($state) ? "our domestic page" : "")));
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
    <head></head>
    <body style='font-family: Arial, sans-serif; line-height: 1.6; color: #333;'>
        <div style='max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ddd; border-radius: 8px; background-color: #f9f9f9; '>
            <div style='background-color: #4CAF50; color: white; padding: 10px 15px; border-radius: 8px 8px 0 0; text-align: center; font-size: 20px;'>
                <p>$name has just submitted $pageName inquiry form on <a href='https://vardhmanchemicalindustries.com' target='_blank' style='color: rgba(3, 15, 39, 1);'>vardhmanchemicalindustries.com</a> site.</p>
            </div>
            <div style='padding: 15px;'>
                <p style='margin: 10px 0;'><strong>Name:</strong> $name</p>
                <p style='margin: 10px 0;'><strong>Email:</strong> $email</p>
    ";

    if (!empty($subject)) {
        $emailBody .= "<p style='margin: 10px 0;'><strong>Subject:</strong> $subject</p>";
    }
    if (!empty($querytype)) {
        $emailBody .= "<p style='margin: 10px 0;'><strong>Query Type:</strong> $querytype</p>";
    }
    if (!empty($country)) {
        $emailBody .= "<p style='margin: 10px 0;'><strong>Country:</strong> $country</p>";
    }
    if (!empty($state)) {
        $emailBody .= "<p style='margin: 10px 0;'><strong>State:</strong> $state</p>";
    }
    if (!empty($category)) {
        $emailBody .= "<p style='margin: 10px 0;'><strong>Category:</strong> $category</p>";
    }
    if (!empty($product)) {
        $emailBody .= "<p style='margin: 10px 0;'><strong>Product:</strong> $product</p>";
    }

    $emailBody .= "
                <p style='margin: 10px 0;'><strong>Message:</strong><br>$message</p>
                <p style='margin: 10px 0;'>Thank you,</p>
                <p style='margin: 10px 0;'><a style='color: rgba(3, 15, 39, 1);text-decoration:none' href='https://vardhmanchemicalindustries.com' target='_blank'><strong><span class='il'>Vardhman Chemical Industries</span> Team</strong></a></p>
            </div>
            <div style='text-align: center; margin-top: 20px; font-size: 12px; color: #666;'>
                <p style='margin: 10px 0;'>This email was generated automatically. Please do not reply.</p>
            </div>
        </div>
    </body>
    </html>
    ";

    $mail->Body = $emailBody;

    $mail->send();
    echo "OK";
} catch (Exception $e) {
    echo "The email message was not sent. Error: {$mail->ErrorInfo}";
}
?>
