<?php
session_start();
$email = $_SESSION['user']; // Email from session
$newPassword = $_POST['password'];

$xmlFile = 'xmlFiles/userData.xml';
if (!file_exists($xmlFile)) {
    http_response_code(500);
    echo "User data file not found.";
    exit;
}

$xml = new DOMDocument();
$xml->preserveWhiteSpace = false;
$xml->formatOutput = true;
$xml->load($xmlFile);

$users = $xml->getElementsByTagName("user");
$found = false;

foreach ($users as $user) {
    $emailNode = $user->getElementsByTagName("email")->item(0);
    if ($emailNode && $emailNode->nodeValue === $email) {
        $passwordNode = $user->getElementsByTagName("password")->item(0);
        if ($passwordNode) {
            $passwordNode->nodeValue = $newPassword;
            $found = true;
            break;
        }
    }
}

if ($found) {
    $xml->save($xmlFile);
    echo "Password changed successfully.";
}
?>