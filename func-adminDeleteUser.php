<?php
    $emailToDelete = $_POST["email"];
    $xmlFile = "xmlFiles/userData.xml"; // adjust path if needed
    $xml = new DOMDocument();
    $xml->load($xmlFile);
    
    $accounts = $xml->getElementsByTagName("user"); 

    foreach ($accounts as $account) {
        $email = $account->getElementsByTagName("email")[0]->nodeValue;
        if ($email == $emailToDelete) {
            $account->parentNode->removeChild($account);
            $xml->save($xmlFile);
            exit;
        }
    }
?>
