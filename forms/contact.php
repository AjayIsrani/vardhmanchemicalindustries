<?php
  $receiving_email_address = 'praksh@vardhmanchemicalindustries.com';
  $name = $_POST['name'];
  $email = $_POST['email'];
  $subject = $_POST['subject'];
  $message = $_POST['message'];
  $subject = $_POST['subject'];
  
  ini_set( 'display_errors', 1 );
    error_reporting( E_ALL );
    $from = "marketing@vardhmanchemicalindustries.com";
    $to = $receiving_email_address;
    $subject = $subject;
    $message = 'Name : ' . $name . '
    Contact Mail : ' . $email . '
    Subject : ' . $subject . '
    Message : ' . $message;
    $headers = "From:" . $from;
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
    $message = '<div><p>' . $name . ' just submitted our home page form on <a href="https://vardhmanchemicalindustries.com" target="_blank">https://vardhmanchemicalindustries.com</a>.</p>
                    <p>Here''s what they had to say:</p>
                    <strong>Name : </strong><pre style="margin:0;white-space:pre-wrap">' . $name . '</pre>
                    <hr>
                    <strong>Contact Mail : </strong><pre style="margin:0;white-space:pre-wrap">' . $email . '</pre>
                    <hr>
                    <strong>Subject :</strong><pre style="margin:0;white-space:pre-wrap">' . $subject . '</pre>
                    <hr>
                    <strong>Message : </strong><pre style="margin:0;white-space:pre-wrap">' . $message . '</pre>
                    <hr>
              <p style="text-align:center">Submitted at '. new DateTime('NOW', new DateTimeZone('UTC')) .'</p>
          <br>
        <p>Our Team,</p>
        <a style="text-decoration:none" href="https://vardhmanchemicalindustries.com" target="_blank"><strong><span class="il">Vardhman Chemical Industries</span> Team</strong></a>
       </div>'
    if(mail($to,$subject,$message, $headers)) {
    echo "OK";
    } else {
      echo "The email message was not sent.";
    }

?>