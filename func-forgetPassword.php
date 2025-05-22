<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require 'PHPMailer/src/Exception.php';
    require 'PHPMailer/src/PHPMailer.php';
    require 'PHPMailer/src/SMTP.php';

    $email = $_GET['email'] ?? '';
    $newPass = rand(100000, 999999);

    $config = parse_ini_file('.env');

    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.hostinger.com';
        $mail->SMTPAuth = true;
        $mail->Username = $config['SMTP_USER'];
        $mail->Password = $config['SMTP_PASS'];
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port = 465;

        $mail->setFrom('noreply@kapeshop.store', 'KapeShop Support');
        $mail->addAddress($email);
        $mail->isHTML(true);
        $mail->Subject = 'kapeShop Password Reset';
        $mail->Body = "
            <h1>Password Reset Request</h1>
            <p>Here is your <strong>temporary password</strong>:</p>
            <h2>$newPass</h2>
            <p>Use this as your password when logging in. You can change it later from your profile settings.</p>
            <p>If you did not request this, please ignore this email.</p>
        ";

        $mail->send();
        echo $newPass; // ✅ Return to JS

    } catch (Exception $e) {
        echo "Failed to send email. Error: {$mail->ErrorInfo}";
    }

?>