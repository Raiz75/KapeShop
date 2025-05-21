<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require 'PHPMailer/src/Exception.php';
    require 'PHPMailer/src/PHPMailer.php';
    require 'PHPMailer/src/SMTP.php';

    $email = $_GET['email'] ?? ''; // Get the email from JS
    $verificationCode = rand(100000, 999999);

    $mail = new PHPMailer(true);
    // try {
    //     $mail->isSMTP();
    //     $mail->Host = 'smtp.gmail.com';
    //     $mail->SMTPAuth = true;
    //     $mail->Username = 'raizeningalla@gmail.com';
    //     $mail->Password = 'dyva pkub kjun udyk'; // App password
    //     $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    //     $mail->Port = 465;

        $mail->isSMTP();
$mail->Host = 'smtp.hostinger.com';
$mail->SMTPAuth = true;
$mail->Username = 'raizeningalla@gmail.com';
$mail->Password = 'dyva pkub kjun udyk';
$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
$mail->Port = 465;

        $mail->setFrom('raizeningalla@gmail.com', 'kapeShop Support');
        $mail->addAddress($email); // ✅ Set the recipient
        $mail->isHTML(true);
        $mail->Subject = 'kapeShop Account Verification';
        $mail->Body = "
            <h1>Welcome to kapeShop!</h1>
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