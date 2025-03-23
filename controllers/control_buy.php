<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}



require_once "../includes/config.php";

function clearFormSessions() {
    foreach ($_SESSION as $key => $value) {
        if (strpos($key, 'option_') === 0) {
            unset($_SESSION[$key]); 
        }
    }
}

clearFormSessions();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    foreach ($_POST as $key => $value) {
        $id = str_replace('option_', '', $value);
        $stmt_option = $pdo->prepare("SELECT * FROM options WHERE id = :id");
        $stmt_option->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt_option->execute();
        $option = $stmt_option->fetch(PDO::FETCH_ASSOC);

        if ($option) {
            $_SESSION['option_' . $option['id']] = $option;
        }
    }

    $rooms = $_POST['rooms'];
    $travelers = $_POST['travelers'];
    $trip_id = $_POST['trip_id'];
    $_SESSION['rooms'] = $rooms;
    $_SESSION['travelers'] = $travelers;
    $_SESSION['trip_id'] = $trip_id;
    $_SESSION['forward_url'] = "buy.php";
    if (isset($_SESSION['user_id'])) {
        header("Location: ../recap.php");
    } else {
        $_SESSION['forward_url'] = "trip.php?trip=" . $_SESSION['trip_id'];
        header("Location: ../login.php");
        exit;
    }
}



?>