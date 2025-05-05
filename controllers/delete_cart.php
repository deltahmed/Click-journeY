<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}



require_once "../includes/config.php";


foreach ($_SESSION as $key => $value) {
    echo $key . " => " . $value . "<br>";
    if (strpos($key, 'option_') !== false || 
        strpos($key, 'cart_') !== false || 
        strpos($key, 'travelers') !== false || 
        strpos($key, 'rooms') !== false || 
        strpos($key, 'price') !== false) {
        
        unset($_SESSION[$key]); 
    }
}

header("Location: ../cart.php");
exit;


?>