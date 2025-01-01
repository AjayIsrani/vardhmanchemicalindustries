<?php
  $receiving_email_address = 'praksh@vardhmanchemicalindustries.com';
  $name = $_POST['name'];
  $email = $_POST['email'];
  $subject = $_POST['subject'];
  $message = $_POST['message'];
  $subject = $_POST['subject'];
  $emailBody = "
    <!DOCTYPE html>
    <html>
    <head>
        <style>
            body {
                font-family: Arial, sans-serif;
                line-height: 1.6;
                color: #333;
            }
            .container {
                max-width: 600px;
                margin: 0 auto;
                padding: 20px;
                border: 1px solid #ddd;
                border-radius: 8px;
                background-color: #f9f9f9;
            }
            .header {
                background-color: #4CAF50;
                color: white;
                padding: 10px 15px;
                border-radius: 8px 8px 0 0;
                text-align: center;
                font-size: 20px;
            }
            .content {
                padding: 15px;
            }
            .content p {
                margin: 10px 0;
            }
            .footer {
                text-align: center;
                margin-top: 20px;
                font-size: 12px;
                color: #666;
            }
        </style>
    </head>
    <body>
        <div class='container'>
            <div class='header'>
              <p>' . $name . ' just submitted our home page form on <a href='https://vardhmanchemicalindustries.com' target='_blank'>https://vardhmanchemicalindustries.com</a>.</p>
                Website Inquiry Notification
            </div>
            <div class='content'>
                <p><strong>Name:</strong> $name</p>
                <p><strong>Email:</strong> $email</p>
                <p><strong>Subject:</strong> $subject</p>
                <p><strong>Message:</strong><br>$message</p>
                <p>Thank you,</p>
                <a style='text-decoration:none' href='https://vardhmanchemicalindustries.com' target='_blank'><strong><span class='il'>Vardhman Chemical Industries</span> Team</strong></a><br>
            </div>
            <div class='footer'>
              <p>This email was generated automatically. Please do not reply.</p>
            </div>
        </div>
    </body>
    </html>
    ";
    ini_set( 'display_errors', 1 );
    error_reporting( E_ALL );
    $from = "marketing@vardhmanchemicalindustries.com";
    $to = $receiving_email_address;
    $emailSubject = "New Inquiry from Website";
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= "From:" . $from. "\r\n";
    if(mail($to,$emailSubject,$emailBody, $headers)) {
    echo "OK";
    } else {
      echo "The email message was not sent.";
    }

?>