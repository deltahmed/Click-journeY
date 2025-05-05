<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}



require_once "../includes/config.php";

function clearFormSessions($trip_id) {
    foreach ($_SESSION as $key => $value) {
        if (strpos($key, $trip_id . 'option_') === 0) {
            unset($_SESSION[$key]); 
        }
    }
}



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $trip_id = $_POST['trip_id'];

    clearFormSessions($trip_id);

    $js_price = $_POST['total_price'] ?? null;
    if ($js_price) {
        $_SESSION['total_price'] = $js_price;
    } else {
        $_SESSION['total_price'] = 0;
    }


    foreach ($_POST as $key => $value) {

        if (strpos($value, $trip_id . 'option_') === 0) {
            $id = str_replace($trip_id . 'option_', '', $value);
            $stmt_option = $pdo->prepare("SELECT * FROM options WHERE id = :id");
            $stmt_option->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt_option->execute();
            $option = $stmt_option->fetch(PDO::FETCH_ASSOC);
            echo $option['id'];
            if ($option) {
                $_SESSION[$trip_id . 'option_' . $option['id']] = $option;
            }
        }
    }

    $rooms = $_POST['rooms'];
    $travelers = $_POST['travelers'];
    
    $_SESSION['rooms' . $trip_id] = $rooms;
    $_SESSION['travelers' . $trip_id] = $travelers;
    $_SESSION['price' . $trip_id] = $js_price;
    $_SESSION['trip_id'] = $trip_id;
    $_SESSION['forward_url'] = "buy.php";

    
    $stmt_trips = $pdo->prepare("SELECT * FROM trips WHERE id = :id");
    $stmt_trips->bindParam(':id', $trip_id, PDO::PARAM_INT);
    $stmt_trips->execute();
    $trip = $stmt_trips->fetch(PDO::FETCH_ASSOC);
    $_SESSION['cart_' . $trip_id] = $trip;


    if (isset($_SESSION['user_id'])) {
        header("Location: ../recap.php");
    } else {
        $_SESSION['forward_url'] = "trip.php?trip=" . $_SESSION['trip_id'];
        header("Location: ../login.php");
        exit;
    }
} else {
    header("Location: ../index.php");
    exit;
}

if (!isset($_SESSION["user_id"])) {
    header("Location: ../index.php");
    exit;
}
if (!isset($_SESSION["un_id"])) {
    header("Location: ../index.php");
    exit;
}



?>