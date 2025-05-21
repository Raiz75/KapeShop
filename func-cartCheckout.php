<?php
session_start();
$data = json_decode(file_get_contents("php://input"), true);
$email = $data['email'];
$checkedOutItems = $data['checkedOutItems'];

// Load userData.xml and remove checked-out items
$userDoc = new DOMDocument();
$userDoc->preserveWhiteSpace = false;
$userDoc->formatOutput = true;
$userDoc->load("xmlFiles/userData.xml");
$users = $userDoc->getElementsByTagName("user");
foreach ($users as $user) {
    $userEmail = $user->getElementsByTagName("email")[0]->nodeValue;
    if ($userEmail === $email) {
        $items = $user->getElementsByTagName("item");
        foreach ($checkedOutItems as $checkoutItem) {
            for ($i = $items->length - 1; $i >= 0; $i--) {
                $item = $items->item($i);
                $name = $item->getElementsByTagName("prodCartName")[0]->nodeValue;
                $price = $item->getElementsByTagName("prodCartPrice")[0]->nodeValue;
                $quantity = $item->getElementsByTagName("prodCartQuan")[0]->nodeValue;
                if ($name === $checkoutItem['name'] && $price == $checkoutItem['price']) {
                    $item->parentNode->removeChild($item); // Remove from userData
                    break;
                }
            }
        }
        break;
    }
}
$userDoc->save("xmlFiles/userData.xml");



// Append to salesHistory.xml
$historyFile = "xmlFiles/salesHistory.xml";
$historyDoc = new DOMDocument();
$historyDoc->preserveWhiteSpace = false;
$historyDoc->formatOutput = true;
if (file_exists($historyFile)) {
    $historyDoc->load($historyFile);
} else {
    $root = $historyDoc->createElement("history");
    $historyDoc->appendChild($root);
}
$root = $historyDoc->getElementsByTagName("history")[0];
$currentDate = date("m/d/Y");
foreach ($checkedOutItems as $item) {
    $itemNode = $historyDoc->createElement("item");
    $emailNode = $historyDoc->createElement("email", $email);
    $nameNode = $historyDoc->createElement("prodName", $item["name"]);
    $priceNode = $historyDoc->createElement("price", $item["price"]);
    $quanNode = $historyDoc->createElement("quantity", $item["quantity"]);
    $dateNode = $historyDoc->createElement("date", $currentDate);
    $itemNode->appendChild($emailNode);
    $itemNode->appendChild($nameNode);
    $itemNode->appendChild($priceNode);
    $itemNode->appendChild($quanNode);
    $itemNode->appendChild($dateNode);
    $root->appendChild($itemNode);
}
$historyDoc->save($historyFile);





// Update prodData.xml (inventory)
$inventoryFile = "xmlFiles/prodData.xml";
$inventoryDoc = new DOMDocument();
$inventoryDoc->preserveWhiteSpace = false;
$inventoryDoc->formatOutput = true;
$inventoryDoc->load($inventoryFile);
$products = $inventoryDoc->getElementsByTagName("product");
foreach ($checkedOutItems as $item) {
    $boughtId = $item["id"];
    $boughtQuantity = (int)$item["quantity"];
    foreach ($products as $product) {
        $prodId = $product->getElementsByTagName("ID")[0]->nodeValue;
        if ($prodId === $boughtId) {
            $stockNode = $product->getElementsByTagName("stock")[0];
            $soldNode = $product->getElementsByTagName("soldCount")[0];
            $currentStock = (int)$stockNode->nodeValue;
            $currentSold = (int)$soldNode->nodeValue;
            $stockNode->nodeValue = max(0, $currentStock - $boughtQuantity);
            $soldNode->nodeValue = $currentSold + $boughtQuantity;
            break;
        }
    }
}
$inventoryDoc->save($inventoryFile);
?>