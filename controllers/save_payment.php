<?php
require_once "../includes/config.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $transaction_id = $_POST['transaction'] ?? null;
    $amount = $_POST['montant'] ?? null;
    $seller = $_POST['vendeur'] ?? null;
    $user_id = $_POST['user_id'] ?? null;
    $trip_id = $_POST['trip_id'] ?? null;
    $user_numbers = $_POST['user_numbers'] ?? null;

    // Vérification des données obligatoires
    if (!$transaction_id || !$amount || !$seller || !$user_id || !$trip_id || !$user_numbers) {
        http_response_code(400); // Bad Request
        error_log("Données manquantes : transaction_id=$transaction_id, amount=$amount, seller=$seller, user_id=$user_id, trip_id=$trip_id, user_numbers=$user_numbers");
        exit;
    }

    try {
        // Démarrer une transaction
        $pdo->beginTransaction();

        // Insérer les informations du voyage dans `user_trips`
        $stmt = $pdo->prepare("
            INSERT INTO user_trips (user_id, id_tr, trip_id, user_numbers, amount, payement_status, transaction_date)
            VALUES (:user_id, :id_tr, :trip_id, :user_numbers, :amount, 'declined', NOW())
        ");
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindParam(':id_tr', $transaction_id, PDO::PARAM_STR);
        $stmt->bindParam(':trip_id', $trip_id, PDO::PARAM_INT);
        $stmt->bindParam(':user_numbers', $user_numbers, PDO::PARAM_INT);
        $stmt->bindParam(':amount', $amount, PDO::PARAM_STR);
        $stmt->execute();

        // Récupérer l'ID du voyage utilisateur inséré
        $user_trip_id = $pdo->lastInsertId();

        // Insérer les options sélectionnées dans `user_options`
        foreach ($_POST as $key => $value) {
            if (strpos($key, 'option_') === 0) {
                $option_id = str_replace('option_', '', $value);

                // Vérifier si l'option existe dans la table `options`
                $stmt_option = $pdo->prepare("SELECT * FROM options WHERE id = :id");
                $stmt_option->bindParam(':id', $option_id, PDO::PARAM_INT);
                $stmt_option->execute();
                $option = $stmt_option->fetch(PDO::FETCH_ASSOC);

                if ($option) {
                    // Insérer l'option dans `user_options`
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

        // Valider la transaction
        $pdo->commit();
        http_response_code(204); // No Content
    } catch (Exception $e) {
        // Annuler la transaction en cas d'erreur
        $pdo->rollBack();
        error_log("Erreur lors de l'enregistrement : " . $e->getMessage());
        http_response_code(500); // Internal Server Error
        exit;
    }
}
?>