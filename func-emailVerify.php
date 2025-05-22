<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require 'PHPMailer/src/Exception.php';
    require 'PHPMailer/src/PHPMailer.php';
    require 'PHPMailer/src/SMTP.php';

    $email = $_GET['email'] ?? '';
    $verificationCode = rand(100000, 999999);

    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.hostinger.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'raizeningalla@gmail.com';
        $mail->Password = 'dyva pkub kjun udyk';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port = 465;

        $mail->setFrom('raizeningalla@gmail.com', 'KapeShop Support');
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