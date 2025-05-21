<?php
session_start();
$userEmail = $_SESSION['user'];

$prodCartId = $_POST['prodCartID'];  
$prodCartName = $_POST['prodCartName'];
$prodCartPrice = $_POST['prodCartPrice'];
$prodCartQuan = (int)$_POST['prodCartQuan'];
$prodCartImg = $_POST['prodCartImg'];

// Load product stock from prodData.xml
$productDoc = new DOMDocument();
$productDoc->load("xmlFiles/prodData.xml");

$products = $productDoc->getElementsByTagName("product");
$productStock = null;

foreach ($products as $product) {
    $id = $product->getElementsByTagName("ID")[0]->nodeValue;
    if ($id == $prodCartId) {
        $productStock = (int)$product->getElementsByTagName("stock")[0]->nodeValue;
        break;
    }
}

if ($productStock === null) {
    echo "error:product_not_found";
    exit;
}

// Load user data
$userFile = "xmlFiles/userData.xml";
$doc = new DOMDocument();
$doc->preserveWhiteSpace = false;
$doc->formatOutput = true;
$doc->load($userFile);

$users = $doc->getElementsByTagName("user");
foreach ($users as $user) {
    $email = $user->getElementsByTagName("email")->item(0)->nodeValue;
    if ($email === $userEmail) {
        $cart = $user->getElementsByTagName("cart")->item(0);
        $items = $cart->getElementsByTagName("item");
        $foundItem = false;
        $existingQty = 0;

        foreach ($items as $item) {
            $idNode = $item->getElementsByTagName("prodCartId")->item(0);
            $idValue = $idNode ? trim($idNode->nodeValue) : null;

            if ($idValue === trim($prodCartId)) {
                $quanNode = $item->getElementsByTagName("prodCartQuan")->item(0);
                $existingQty = (int)$quanNode->nodeValue;

                // Check if total exceeds stock
                if ($existingQty + $prodCartQuan > $productStock) {
                    echo "error:insufficient_stock";
                    exit;
                }

                // Update quantity
                $quanNode->nodeValue = $existingQty + $prodCartQuan;
                $foundItem = true;
                break;
            }
        }

        if (!$foundItem) {
            if ($prodCartQuan > $productStock) {
                echo "error:insufficient_stock";
                exit;
            }

            // Add new item to cart
            $newItem = $doc->createElement("item");
            $newItem->appendChild($doc->createElement("prodCartId", $prodCartId));
            $newItem->appendChild($doc->createElement("prodCartName", $prodCartName));
            $newItem->appendChild($doc->createElement("prodCartPrice", $prodCartPrice));
            $newItem->appendChild($doc->createElement("prodCartQuan", $prodCartQuan));
            $newItem->appendChild($doc->createElement("prodCartImg", $prodCartImg));
            $cart->appendChild($newItem);
        }

        $doc->save($userFile);
        echo "success";
        break;
    }
}
?>
