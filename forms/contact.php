<?php
  $receiving_email_address = 'praksh@vardhmanchemicalindustries.com';
  $name = $_POST['name'];
  $email = $_POST['email'];
  $subject = $_POST['subject'];
  $message = $_POST['message'];
  $subject = $_POST['subject'];
  $submissionTime = new DateTime();
  $formattedTime = $submissionTime->format('D, M j, Y g:i A (T)');
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
            Website Inquiry Notification
        </div>
        <div class='content'>
            <p><strong>Submitted By:</strong> $name</p>
            <p><strong>Email:</strong> $email</p>
            <p><strong>Subject:</strong> $subject</p>
            <p><strong>Message:</strong><br>$message</p>
            <p><strong>Submitted On:</strong> $formattedTime</p>
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
    $subject = $subject;
    // $message = 'Name : ' . $name . '
    // Contact Mail : ' . $email . '
    // Subject : ' . $subject . '
    // Message : ' . $message;
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= "From:" . $from. "\r\n";
    // $message .= "<div><p>' . $name . ' just submitted our home page form on <a href='https://vardhmanchemicalindustries.com' target='_blank'>https://vardhmanchemicalindustries.com</a>.</p>
    //                 <p>Here''s what they had to say:</p>
    //                 <strong>Name : </strong><pre style='margin:0;white-space:pre-wrap'>' . $name . '</pre>
    //                 <hr>
    //                 <strong>Contact Mail : </strong><pre style='margin:0;white-space:pre-wrap'>' . $email . '</pre>
    //                 <hr>
    //                 <strong>Subject :</strong><pre style='margin:0;white-space:pre-wrap'>' . $subject . '</pre>
    //                 <hr>
    //                 <strong>Message : </strong><pre style='margin:0;white-space:pre-wrap'>' . $message . '</pre>
    //                 <hr>
    //           <p style='text-align:center'>Submitted at '. $formattedTime .'</p>
    //       <br>
    //     <p>Our Team,</p>
    //     <a style='text-decoration:none' href='https://vardhmanchemicalindustries.com' target='_blank'><strong><span class='il'>Vardhman Chemical Industries</span> Team</strong></a>
    //    </div>";
    if(mail($to,$subject,$emailBody, $headers)) {
    echo "OK";
    } else {
      echo "The email message was not sent.";
    }

?>