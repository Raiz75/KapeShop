<?php
if (!isset($_POST['newProduct'])) {
    echo "error:no_data";
    exit;
}

$newProductXml = $_POST['newProduct'];
$xmlFile = 'xmlFiles/prodData.xml';

// Load existing XML
$xml = new DOMDocument();
$xml->preserveWhiteSpace = false;
$xml->formatOutput = true;
$xml->load($xmlFile);

// Parse new product XML string
$newProductDOM = new DOMDocument();
$newProductDOM->loadXML($newProductXml);
$newProductName = $newProductDOM->getElementsByTagName("name")[0]->nodeValue;

// Check for duplicate name
$existingProducts = $xml->getElementsByTagName("product");
foreach ($existingProducts as $product) {
    $existingName = $product->getElementsByTagName("name")[0]->nodeValue;
    if (strcasecmp(trim($existingName), trim($newProductName)) === 0) {
        echo "error:duplicate_name";
        exit;
    }
}

// Append new product
$inventory = $xml->getElementsByTagName("inventory")[0];
$fragment = $xml->createDocumentFragment();
$fragment->appendXML($newProductXml);
$inventory->appendChild($fragment);

// Update incrementID
$incrementIDNode = $xml->getElementsByTagName("incrementID")[0];
$currentID = intval($incrementIDNode->nodeValue);
$incrementIDNode->nodeValue = $currentID + 1;

$xml->save($xmlFile);
echo "success";
?>