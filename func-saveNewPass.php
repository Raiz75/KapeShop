<?php
$email = $_POST['email'];
$newPassword = $_POST['password'];

$xmlFile = 'xmlFiles/userData.xml';
$xml = new DOMDocument();
$xml->preserveWhiteSpace = false;
$xml->formatOutput = true;
$xml->load($xmlFile);

$users = $xml->getElementsByTagName("user");

for ($i = 0; $i < $users->length; $i++) {
    $user = $users->item($i);
    $emailNode = $user->getElementsByTagName("email")->item(0);
    
    if ($emailNode && $emailNode->nodeValue === $email) {
        $passwordNode = $user->getElementsByTagName("password")->item(0);
        if ($passwordNode) {
            $passwordNode->nodeValue = $newPassword;
            $updated = true;
            $xml->save($xmlFile);
            break;
        }
    }
}
?>