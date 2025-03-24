<?php
require_once "../includes/config.php";


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $transaction_id = $_POST['transaction'] ?? null;
    $amount = $_POST['montant'] ?? null;
    $seller = $_POST['vendeur'] ?? null;
    $user_id = $_POST['user_id'] ?? null;
    $un_id = $_POST['un_id'] ?? null;
    $trip_id = $_POST['trip_id'] ?? null;
    $user_numbers = $_POST['user_numbers'] ?? null;


    
    if(!verifyUnId($pdo, $user_id, $un_id)){
        http_response_code(403);
        exit;
    }

    if (!$transaction_id || !$amount || !$seller || !$user_id || !$trip_id || !$user_numbers) {
        http_response_code(404);
        exit;
    }

    try {

        $pdo->beginTransaction();


        $stmt = $pdo->prepare("
            INSERT INTO user_trips (user_id, id_tr, trip_id, user_numbers, amount, payement_status, transaction_date)
            VALUES (:user_id, :id_tr, :trip_id, :user_numbers, :amount, 'pending', NOW())
        ");
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindParam(':id_tr', $transaction_id, PDO::PARAM_STR);
        $stmt->bindParam(':trip_id', $trip_id, PDO::PARAM_INT);
        $stmt->bindParam(':user_numbers', $user_numbers, PDO::PARAM_INT);
        $stmt->bindParam(':amount', $amount, PDO::PARAM_STR);
        $stmt->execute();


        $user_trip_id = $pdo->lastInsertId();


        foreach ($_POST as $key => $value) {
            if (strpos($key, 'option_') === 0) {
                $option_id = str_replace('option_', '', $value);

    
                $stmt_option = $pdo->prepare("SELECT * FROM options WHERE id = :id");
                $stmt_option->bindParam(':id', $option_id, PDO::PARAM_INT);
                $stmt_option->execute();
                $option = $stmt_option->fetch(PDO::FETCH_ASSOC);

                if ($option) {

                    $stmt_insert_option = $pdo->prepare("
                        INSERT INTO options_user_trips (user_trip_id, option_id)
                        VALUES (:user_trip_id, :option_id)
                    ");
                    $stmt_insert_option->bindParam(':user_trip_id', $user_trip_id, PDO::PARAM_INT);
                    $stmt_insert_option->bindParam(':option_id', $option_id, PDO::PARAM_INT);
                    $stmt_insert_option->execute();
                } else {
                    error_log("Option introuvable : option_id=$option_id");
                }
            }
        }


        $pdo->commit();
        http_response_code(204);
    } catch (Exception $e) {

        $pdo->rollBack();
        error_log("Erreur lors de l'enregistrement : " . $e->getMessage());
        http_response_code(500); 
        exit;
    }
}
?>