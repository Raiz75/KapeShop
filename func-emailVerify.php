<?php
    use phpmailer\phpmailer\phpmailer;
    use phpmailer\phpmailer\Exception;

    require 'phpmailer/src/Exception.php';
    require 'phpmailer/src/PHPMailer.php';
    require 'phpmailer/src/SMTP.php';

    $email = $_GET['email'] ?? '';
    $verificationCode = rand(100000, 999999);

    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.hostinger.com';          // Hostinger SMTP server
        $mail->SMTPAuth = true;
        $mail->Username = 'noreply@kapeshop.store';  // Your Hostinger email
        $mail->Password = 'Kapeshop@2025';           // Your email password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port = 465;

        $mail->setFrom('noreply@kapeshop.store', 'KapeShop Support');
        $mail->addAddress($email);
        $mail->isHTML(true);
        $mail->Subject = 'KapeShop Account Verification';
        $mail->Body = "
            <h1>Welcome to KapeShop!</h1>
            <p>Here is your verification code:</p>
            <h1>$verificationCode</h1>
            <p>If you didn't request this, please ignore this email.</p>
        ";

        $mail->send();
        echo $verificationCode;

    } catch (Exception $e) {
        echo "Failed to send email. Error: {$mail->ErrorInfo}";
    }
?>
