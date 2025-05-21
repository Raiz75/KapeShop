<?php
session_start();
$data = json_decode(file_get_contents("php://input"), true);

// Validate input
if (!isset($data['email']) || !isset($data['id']) || !isset($data['quantity'])) {
    http_response_code(400);
    echo "Invalid input.";
    exit;
}

$email = $data['email'];
$itemId = $data['id'];
$newQuantity = (int)$data['quantity'];

// Load userData.xml
$userFile = 'xmlFiles/userData.xml';
$userXml = new DOMDocument();
$userXml->preserveWhiteSpace = false;
$userXml->formatOutput = true;

if (!$userXml->load($userFile)) {
    http_response_code(500);
    echo "Failed to load user XML.";
    exit;
}

// Load prodData.xml
$prodFile = 'xmlFiles/prodData.xml';
$prodXml = new DOMDocument();
$prodXml->preserveWhiteSpace = false;
$prodXml->formatOutput = true;

if (!$prodXml->load($prodFile)) {
    http_response_code(500);
    echo "Failed to load product XML.";
    exit;
}

// Get product stock from prodData.xml
$stockAvailable = null;
$products = $prodXml->getElementsByTagName("product");
foreach ($products as $product) {
    $idNode = $product->getElementsByTagName("ID")[0];
    if ($idNode && $idNode->nodeValue == $itemId) {
        $stockAvailable = (int)$product->getElementsByTagName("stock")[0]->nodeValue;
        break;
    }
}

if ($stockAvailable === null) {
    http_response_code(404);
    echo "Product not found.";
    exit;
}

if ($newQuantity > $stockAvailable) {
    http_response_code(400);
    echo "error:insufficient_stock";
    exit;
}

// Search for the matching user and item by prodCartId
$users = $userXml->getElementsByTagName("user");
$updated = false;

foreach ($users as $user) {
    $userEmail = $user->getElementsByTagName("email")[0]->nodeValue;
    if ($userEmail === $email) {
        $items = $user->getElementsByTagName("item");
        foreach ($items as $itemNode) {
            $prodCartIdNode = $itemNode->getElementsByTagName("prodCartId")[0];
            if ($prodCartIdNode && $prodCartIdNode->nodeValue == $itemId) {
                $quantityNode = $itemNode->getElementsByTagName("prodCartQuan")[0];
                if ($quantityNode) {
                    $quantityNode->nodeValue = $newQuantity;
                    $updated = true;
                    break 2;
                }
            }
        }
    }
}

if ($updated) {
    $userXml->save($userFile);
    echo "success";
} else {
    http_response_code(404);
    echo "Item or user not found.";
}
?>
