<?php
session_start();
$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['email']) || !isset($data['deletedIds']) || !is_array($data['deletedIds'])) {
    http_response_code(400);
    echo "Invalid input.";
    exit;
}

$xmlFile = 'xmlFiles/userData.xml';
$xml = new DOMDocument();
$xml->preserveWhiteSpace = false;
$xml->formatOutput = true;

if (!$xml->load($xmlFile)) {
    http_response_code(500);
    echo "Failed to load XML file.";
    exit;
}

$email = $data['email'];
$deletedIds = $data['deletedIds'];

$users = $xml->getElementsByTagName("user");

foreach ($users as $user) {
    $userEmail = $user->getElementsByTagName("email")[0]->nodeValue;
    if ($userEmail === $email) {
        $cartNode = $user->getElementsByTagName("cart")[0];
        $items = $cartNode->getElementsByTagName("item");

        // Loop backwards to safely remove nodes
        for ($i = $items->length - 1; $i >= 0; $i--) {
            $item = $items->item($i);
            $idNode = $item->getElementsByTagName("prodCartId")[0];
            if ($idNode && in_array($idNode->nodeValue, $deletedIds)) {
                $cartNode->removeChild($item);
            }
        }
        break;
    }
}

$xml->save($xmlFile);
echo "Selected items deleted.";
?>