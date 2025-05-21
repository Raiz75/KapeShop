<?php
session_start();  // Start the session

if (isset($_POST['email'])) {
    $email = $_POST['email'];
    
    $_SESSION['user'] = $email;
    
    echo "success";
} else {
    echo "error";
}
?>