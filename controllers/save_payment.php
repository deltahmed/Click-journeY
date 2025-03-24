<?php
require_once "../includes/config.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $transaction_id = $_POST['transaction'] ?? null;
    $amount = $_POST['montant'] ?? null;
    $seller = $_POST['vendeur'] ?? null;
    $user_id = $_POST['user_id'] ?? null;
    $trip_id = $_POST['trip_id'] ?? null;
    $user_numbers = $_POST['user_numbers'] ?? null;

    if (!$user_id) {
        exit;
    }

    if ($transaction_id && $amount && $seller && $user_id && $trip_id) {
        $stmt = $pdo->prepare("
            INSERT INTO user_trips (user_id, id_tr, trip_id, user_numbers, amount, payement_status, transaction_date)
            VALUES (:user_id, :id_tr, :trip_id, :user_numbers, :amount, 'declined', NOW())
        ");
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindParam(':id_tr', $transaction_id, PDO::PARAM_STR);
        $stmt->bindParam(':trip_id', $trip_id, PDO::PARAM_INT);
        $stmt->bindParam(':user_numbers', $user_numbers, PDO::PARAM_INT);
        $stmt->bindParam(':amount', $amount, PDO::PARAM_STR);
        $stmt->execute()

?>