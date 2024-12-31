<?php
  $receiving_email_address = 'praksh@vardhmanchemicalindustries.com';
  $name = $_POST['name'];
  $email = $_POST['email'];
  $subject = $_POST['subject'];
  $message = $_POST['message'];
  $phoneno = $_POST['phone'];
  
  ini_set( 'display_errors', 1 );
    error_reporting( E_ALL );
    $from = "marketing@vardhmanchemicalindustries.com";
    $to = $receiving_email_address;
    $subject = $subject;
    $message = 'Name : ' . $name . '
    Contact Mail : ' . $email . '
    Contact No : ' . $phoneno . '
    Message : ' . $message;
    $headers = "From:" . $from;
    if(mail($to,$subject,$message, $headers)) {
    echo "The email message was sent.";
    } else {
      echo "The email message was not sent.";
    }

?>