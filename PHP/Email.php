<?php
/**
 * User: Jeiman
 * Date: 05-Mar-16
 * Time: 1:35 AM
 *
 * A simple email application to blast out a
 * welcome email to the user who signed
 * up to MediaWorm
 */

 require  '../vendor/autoload.php';

 function phpMailer ($email, $recipientName ,$hash) {

    $mail = new PHPMailer;

    //$mail->SMTPDebug = 3;                               // Enable verbose debug output
    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = 'tls://smtp.gmail.com:587';  // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = 'johnfaith7@gmail.com';                 // SMTP username
    $mail->Password = 'W4rl0ck9023';                           // SMTP password
    // $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
    // $mail->Port = 465;                                    // TCP port to connect to

    $mail->setFrom('hello@mediaworm.xyz', 'MediaWorm');
    $mail->addAddress($email);     // Add a recipient
    // $mail->addAddress('ellen@example.com');               // Name is optional
    $mail->addReplyTo('support@mediaworm.xyz', 'MediaWorm Support');
    // $mail->addCC('cc@example.com');
    // $mail->addBCC('bcc@example.com');

    // $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
    // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
    $mail->isHTML(true);                                  // Set email format to HTML

    $mail->Subject = 'Confirm your MediaWorm account';
    $mail->Body    = 'Hi '. $recipientName .',<br /><br />
                      Welcome to MediaWorm! Great to have you on board.<br /><br />
                      Kindly verify your account by clicking on the link below: <br /><br />
                      https://www.mediaworm.xyz/verify.php?email='.$email.'&hash='.$hash .'<br /><br />
                      If the above URL does not work try copying and pasting it into your browser. If you encounter any problem, please contact us at support@mediaworm.xyz or simply reply to this email.<br /><br />
                      If you did not create a MediaWorm account using this address, please contact us at support@mediaworm.xyz.<br /><br />
                      Adieu!<br /><br />The MediaWorm Team';
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    if(!$mail->send()) {
        echo 'Message could not be sent.';
        echo 'Mailer Error: ' . $mail->ErrorInfo;
    } else {
        echo 'Message has been sent';
    }

 }

 function sendConfirmEmail($email, $recipientName ,$hash){
    $to = $email;
    $subject = "Confirm your MediaWorm account";
    $message = "Hi $recipientName, \r\n\r\n";
    $message .= "Welcome to MediaWorm! Great to have you on board.\r\n\r\n";
    $message .= "Your email is: $email \r\n\r\n";
    $message .= "Kindly verify your account by clicking on the link below: \r\n\r\n";
    $message .= "https://www.mediaworm.xyz/verify.php?email=$email&hash=$hash \r\n\r\n";
    $message .= "If the above URL does not work try copying and pasting it into your browser. If you encounter any problem, please contact us at support@mediaworm.xyz or simply reply to this email. \r\n\r\n";
    $message .= "Adieu!\r\n\r\nThe MediaWorm Team";
    $header  = 'MIME-Version: 1.0' . "\r\n";
    $header .= 'Content-type: text/plain; charset=UTF-8' . "\r\n";
    $header .= "From:MediaWorm"."<hello@mediaworm.xyz>". "\r\n" .
        'Reply-To: MediaWorm Support <support@mediaworm.xyz>'. "\r\n" .
        'X-Mailer: PHP/' . phpversion();

    $sendmail = mail ($to,$subject,$message,$header);

    if( $sendmail == true ) {
        echo "Message sent successfully...";
    }else {
        echo "Message could not be sent...";
    }

    return $email;
}

function sendEmail($email, $recipientName){
    $to = $email;
    $subject = "Welcome to MediaWorm";
    $message = "Hi $recipientName, \r\n\r\n";
    $message .= "Welcome to MediaWorm! Great to have you on board.\r\n\r\n";
    $message .= "Your email is: $email \r\n\r\n";
    $message .= "We hope you have fun, and if there's anything you want to talk to us about don't hesitate to get in touch. In fact, you can just hit reply to this email or any others you receive from us.\r\n\r\n";
    $message .= "Adieu!\r\n\r\nThe MediaWorm Team";
    $header  = 'MIME-Version: 1.0' . "\r\n";
    $header .= 'Content-type: text/plain; charset=UTF-8' . "\r\n";
    $header .= "From:MediaWorm"."<hello@mediaworm.xyz>". "\r\n" .
        'Reply-To: MediaWorm Support <support@mediaworm.xyz>'. "\r\n" .
        'X-Mailer: PHP/' . phpversion();

    $sendmail = mail ($to,$subject,$message,$header);

    if( $sendmail == true ) {
        echo "Message sent successfully...";
    }else {
        echo "Message could not be sent...";
    }

    return $email;
}

function sendEmailHtml($email, $recipientName){
    $to = $email;
    $subject = "Welcome to MediaWorm";
    $message = "
    <html>
      <head>
        <title>Nonsensical Latin</title>
        <link href=\"https://fonts.googleapis.com/css?family=Montserrat:400,700\" rel=\"stylesheet\" type=\"text/css\">
        <style>

        body {
          font-family: 'Montserrat', sans-serif;
        }
        p {
          font-size: 14px;
          padding: 10px 0;
          font-weight: normal;
        }
        .emailWrapper {
          width: 90%;
          max-width: 700px;
          margin: 40px auto;
        }
        .logoTitle {
          position: relative;
          top: -25px;
          font-size: 20px;
        }

        .logo {
          width: 70px;
          height: 70px;
          display: inline-block;
        }
    </style>
      </head>
      <body>
        <div class=\"emailWrapper\">
          <img class=\"logo\" src=\"https://www.mediaworm.xyz/assets/img/apple-icon-192x192-precomposed.png\">
          <span class=\"logoTitle\">MediaWorm</span>
          <h1 style=\"font-size: 22px;\">Hi $recipientName,</h1>
          <h2 style=\"font-size: 17px;\">Welcome to MediaWorm. Great to have you on board!</h2>
          <p>
             We hope you have fun, and if there's anything you want to talk to us about don't hesitate to get in touch.
             In fact, you can just hit reply to this email or any others you receive from us.
             Maecenas id mauris eget tortor facilisis egestas.
             Praesent ac augue sed <a href=\"http://lipsum.com/\">enim</a> aliquam auctor.
             Pellentesque convallis tempor tortor. Nullam nec purus.</p>
             <p>Adieu!<br><br>The MediaWorm Team</p>
         </div>
      </body>
    </html>";
    $header  = 'MIME-Version: 1.0' . "\r\n";
    $header .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
    $header .= "From:MediaWorm"."<hello@mediaworm.xyz>". "\r\n" .
        'Reply-To: MediaWorm Support <support@mediaworm.xyz>'. "\r\n" .
        'X-Mailer: PHP/' . phpversion();

    $sendmail = mail ($to,$subject,$message,$header);

    if( $sendmail == true ) {
        echo "Message sent successfully...";
    }else {
        echo "Message could not be sent...";
    }

    return $email;
}

function sendEmailPassReset($emailReset, $recipientNameReset, $newPassword){
    $to = $emailReset;
    $subject = "Password Reset Request at MediaWorm";
    $message = "Hi $recipientNameReset, \r\n\r\n";
    $message .= "We see that you've forgotten your password and have requested for a new one. Kindly find it below:\r\n\r\n";
    $message .= "Your email is: $emailReset \r\n";
    $message .= "Password: $newPassword \r\n\r\n";
    $message .= "Please do ensure that you change your temporary password once you have logged in with it.\r\n\r\n";
    $message .= "If you did not request this change, please contact us at support@mediaworm.xyz or reply to this email and we will be able to further assist you.\r\n\r\n";
    $message .= "If there's anything you want to talk to us about don't hesitate to get in touch. In fact, you can just hit reply to this email or any others you receive from us.\r\n\r\n";
    $message .= "Adieu!\r\n\r\nThe MediaWorm Team";
    $header  = 'MIME-Version: 1.0' . "\r\n";
    $header .= 'Content-type: text/plain; charset=UTF-8' . "\r\n";
    $header .= "From:MediaWorm"."<hello@mediaworm.xyz>". "\r\n" .
        'Reply-To: MediaWorm Support <support@mediaworm.xyz>'. "\r\n" .
        'X-Mailer: PHP/' . phpversion();

    $sendmailReset = mail ($to,$subject,$message,$header);

    if( $sendmailReset == true ) {
        echo "Message sent successfully...";
    }else {
        echo "Message could not be sent...";
    }
    return $emailReset;
}

function sendEmailPassChange($emailPassChange, $recipientNameChange){
    $to = $emailPassChange;
    $subject = "Password change successfully at MediaWorm";
    $message = "Hi $recipientNameChange, \r\n\r\n";
    $message .= "This is a simple notification to inform you that you've recently changed your password via the Profile Settings.\r\n\r\n";
    $message .= "If you didn't perform this action, please contact us at support@mediaworm.xyz or reply to this email and we will be able to further assist you.\r\n\r\n";
    $message .= "If there's anything you want to talk to us about don't hesitate to get in touch. In fact, you can just hit reply to this email or any others you receive from us.\r\n\r\n";
    $message .= "Adieu!\r\n\r\nThe MediaWorm Team";
    $header  = 'MIME-Version: 1.0' . "\r\n";
    $header .= 'Content-type: text/plain; charset=UTF-8' . "\r\n";
    $header .= "From:MediaWorm"."<hello@mediaworm.xyz>". "\r\n" .
        'Reply-To: MediaWorm Support <support@mediaworm.xyz>'. "\r\n" .
        'X-Mailer: PHP/' . phpversion();

    $sendmailChange = mail ($to,$subject,$message,$header);

    if( $sendmailChange == true ) {
        echo "Message sent successfully...";
    }else {
        echo "Message could not be sent...";
    }
    return $emailPassChange;
}

function sendEmailChange($emailChange, $recipientName){
    $to = $emailChange;
    $subject = "Email Change at MediaWorm";
    $message = "Hi $recipientName, \r\n\r\n";
    $message .= "We noticed you've updated your email address on MediaWorm.\r\n\r\n";
    $message .= "Your new email address is: $emailChange. Kindly use this email address to login to MediaWorm. \r\n\r\n";
    $message .= "If you didn't perform this action, please contact us at support@mediaworm.xyz or reply to this email and we will be able to further assist you.\r\n\r\n";
    $message .= "If there's anything you want to talk to us about don't hesitate to get in touch. In fact, you can just hit reply to this email or any others you receive from us.\r\n\r\n";
    $message .= "Adieu!\r\n\r\nThe MediaWorm Team";
    $header  = 'MIME-Version: 1.0' . "\r\n";
    $header .= 'Content-type: text/plain; charset=UTF-8' . "\r\n";
    $header .= "From:MediaWorm"."<hello@mediaworm.xyz>". "\r\n" .
        'Reply-To: MediaWorm Support <support@mediaworm.xyz>'. "\r\n" .
        'X-Mailer: PHP/' . phpversion();

    $sendmailChange = mail ($to,$subject,$message,$header);

    if( $sendmailChange == true ) {
        echo "Message sent successfully...";
    }else {
        echo "Message could not be sent...";
    }

    return $emailChange;
}

// echo (extension_loaded('openssl')?'SSL loaded':'SSL not loaded')."\n"; 

// phpMailer('admin@mediaworm.xyz', 'MediaWorm Admin' ,'c2626d850c80ea07e7511bbae4c76f4b');
?>
