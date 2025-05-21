<?php
    $idToDelete = $_POST["ID"];
    $xmlFile = "xmlFiles/prodData.xml";
    $xml = new DOMDocument();
    $xml->load($xmlFile);
    $products = $xml->getElementsByTagName("product");

    foreach ($products as $product) {
        $id = $product->getElementsByTagName("ID")[0]->nodeValue;
        if ($id == $idToDelete) {
            $product->parentNode->removeChild($product);
            $xml->save($xmlFile);
            echo "success";
            exit;
        }
    }
?>
