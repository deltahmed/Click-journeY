<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}



require_once "../includes/config.php";

if (isset($_GET['trip_id'])) {
    $trip_id = $_GET['trip_id'];
    foreach ($_SESSION as $key => $value) {
        if (strpos($key, $trip_id . 'option_') === 0) {
            unset($_SESSION[$key]);
        }
            
        }
        if (isset($_SESSION['cart_' . $trip_id])) {
            unset($_SESSION['cart_' . $trip_id]);
        }
        if (isset($_SESSION['rooms' . $trip_id])) {
            unset($_SESSION['rooms' . $trip_id]);
        }
        if (isset($_SESSION['travelers' . $trip_id])) {
            unset($_SESSION['travelers' . $trip_id]);
        }
        if (isset($_SESSION['price' . $trip_id])) {
            unset($_SESSION['price' . $trip_id]);
        }
} else {
    foreach ($_SESSION as $key => $value) {
        if (strpos($key, 'option_') !== false || 
            strpos($key, 'cart_') !== false || 
            strpos($key, 'travelers') !== false || 
            strpos($key, 'rooms') !== false || 
            strpos($key, 'price') !== false) {
            
            unset($_SESSION[$key]); 
        }
    }
}



header("Location: ../cart.php");
exit;


?>