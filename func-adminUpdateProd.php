<?php
    $updatedProductXml = $_POST['updatedProductXml'];
    $targetID = $_POST['ID'];

    $file = 'xmlFiles/prodData.xml';
    $xml = new DOMDocument();
    $xml->load($file);
    $products = $xml->getElementsByTagName("product");

    foreach ($products as $product) {
        $id = $product->getElementsByTagName("ID")[0]->nodeValue;
        if ($id === $targetID) {
            $oldNode = $product;
            $newDoc = new DOMDocument();
            $newDoc->loadXML($updatedProductXml);
            $newNode = $xml->importNode($newDoc->documentElement, true);

            $oldNode->parentNode->replaceChild($newNode, $oldNode);
            $xml->save($file);
            echo "success";
            exit;
        }
    }
    echo "Product ID not found.";
?>
