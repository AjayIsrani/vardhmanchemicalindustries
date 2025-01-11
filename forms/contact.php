<?php
  $receiving_email_address = 'praksh@vardhmanchemicalindustries.com';
  $name = $_POST['name'];
  $email = $_POST['email'];
  $subject = $_POST['subject'];
  $querytype = $_POST['querytype'];
  $message = $_POST['message'];

  ini_set( 'display_errors', 1 );
  error_reporting( E_ALL );
  $fromName = "Vardhman Chemical Website"; 
  $fromEmail = "marketing@vardhmanchemicalindustries.com"; 
  $from = "$fromName <$fromEmail>";
  $to = $receiving_email_address;
  $emailSubject = "New Inquiry from Website";
  if (isset($_FILES['attachment']) && $_FILES['attachment']['error'] === UPLOAD_ERR_OK) {
    $boundary = md5(uniqid(time()));

    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "From: $from" . "\r\n";
    $headers .= "Content-Type: multipart/mixed; boundary=\"$boundary\"" . "\r\n";

    $emailBody = "--$boundary\r\n";
    $emailBody .= "Content-Type: text/html; charset=UTF-8\r\n";
    $emailBody .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
    $emailBody .= "
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
              <p>$name has just submitted our home page inquiry form on <a href='https://vardhmanchemicalindustries.com' target='_blank'>vardhmanchemicalindustries.com</a> site.</p>
            </div>
            <div class='content'>
                <p><strong>Name:</strong> $name</p>
                <p><strong>Email:</strong> $email</p>
                <p><strong>Query Type:</strong> $querytype</p>
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
    
    $fileTmpPath = $_FILES['attachment']['tmp_name'];
    $fileName = $_FILES['attachment']['name'];
    $fileType = $_FILES['attachment']['type'];
    $fileData = file_get_contents($fileTmpPath);
    $encodedFile = chunk_split(base64_encode($fileData));

    $emailBody .= "--$boundary\r\n";
    $emailBody .= "Content-Type: $fileType; name=\"$fileName\"\r\n";
    $emailBody .= "Content-Disposition: attachment; filename=\"$fileName\"\r\n";
    $emailBody .= "Content-Transfer-Encoding: base64\r\n\r\n";
    $emailBody .= "$encodedFile\r\n";
    $emailBody .= "--$boundary--";

} else {
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
$headers .= "From:" . $from. "\r\n";
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
              <p>$name has just submitted inquiry form on <a href='https://vardhmanchemicalindustries.com' target='_blank'>vardhmanchemicalindustries.com</a> site.</p>
            </div>
            <div class='content'>
                <p><strong>Name:</strong> $name</p>
                <p><strong>Email:</strong> $email</p>";
if (!empty($subject)) {
    $emailBody .= "<p><strong>Subject:</strong> $subject</p>";
}
if (!empty($querytype)) {
    $emailBody .= "<p><strong>Query Type:</strong> $querytype</p>";
}
$emailBody .= "
                <p><strong>Subject:</strong> $subject</p>
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
}
    if(mail($to,$emailSubject,$emailBody, $headers)) {
    echo "OK";
    } else {
      echo "The email message was not sent.";
    }

?>