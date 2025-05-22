<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . 'PHPMailer/src/Exception.php';
require __DIR__ . 'PHPMailer/src/PHPMailer.php';
require __DIR__ . 'PHPMailer/src/SMTP.php';

// Load environment variables from .env
$config = parse_ini_file('.env');

$email = $_GET['email'] ?? '';
$verificationCode = rand(100000, 999999);

$mail = new PHPMailer(true);
try {
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = $config['SMTP_USER'];
    $mail->Password = $config['SMTP_PASS'];
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    $mail->Port = 465;

    $mail->setFrom($config['SMTP_USER'], 'kapeShop Support');
    $mail->addAddress($email);
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
