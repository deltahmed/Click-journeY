<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
header('Content-Type: application/json');
if (!isset($_SESSION["user_id"])) {
    echo json_encode(['success' => false, 'message' => 'Non autorisé.']);
    exit;
}
require_once "../includes/config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_SESSION['user_role'] === 'admin') {
        $user_id = $_POST["user_id"];
    } else {
        $user_id = $_SESSION["user_id"];
    }

    $fields_to_update = [];
    $params = [':user_id' => $user_id];

    if (isset($_POST["first_name"]) && !empty(trim($_POST["first_name"]))) {
        if (preg_match("/^[a-zA-ZÀ-ÿ '-]+$/", $_POST["first_name"])) {
            $fields_to_update[] = "first_name = :first_name";
            $params[':first_name'] = trim($_POST["first_name"]);
        } else {
            echo json_encode(['success' => false, 'message' => "Prénom invalide."]);
            exit;
        }
    }
    if (isset($_POST["last_name"]) && !empty(trim($_POST["last_name"]))) {
        if (preg_match("/^[a-zA-ZÀ-ÿ '-]+$/", $_POST["last_name"])) {
            $fields_to_update[] = "last_name = :last_name";
            $params[':last_name'] = trim($_POST["last_name"]);
        } else {
            echo json_encode(['success' => false, 'message' => "Nom invalide."]);
            exit;
        }
    }
    if (isset($_POST["gender"]) && !empty(trim($_POST["gender"]))) {
        $allowed_genders = ['M', 'F', 'A'];
        if (in_array(trim($_POST["gender"]), $allowed_genders)) {
            $fields_to_update[] = "gender = :gender";
            $params[':gender'] = trim($_POST["gender"]);
        } else {
            echo json_encode(['success' => false, 'message' => "Genre invalide."]);
            exit;
        }
    }
    if (isset($_POST["birth_date"]) && !empty(trim($_POST["birth_date"]))) {
        $birth_date = trim($_POST["birth_date"]);
        $date = DateTime::createFromFormat('Y-m-d', $birth_date);

        if ($date && $date->format('Y-m-d') === $birth_date) {
            $today = new DateTime();
            $age = $today->diff($date)->y;

            if ($age >= 18) {
                $fields_to_update[] = "birth_date = :birth_date";
                $params[':birth_date'] = $birth_date;
            } else {
                echo json_encode(['success' => false, 'message' => "Vous devez avoir au moins 18 ans."]);
                exit;
            }
        } else {
            echo json_encode(['success' => false, 'message' => "Date de naissance invalide."]);
            exit;
        }
    }
    if (isset($_POST["phone"]) && !empty(trim($_POST["phone"]))) {
        if (preg_match("/^\+?[0-9]{10,15}$/", $_POST["phone"])) {
            $fields_to_update[] = "phone_number = :phone_number";
            $params[':phone_number'] = trim($_POST["phone"]);
        } else {
            echo json_encode(['success' => false, 'message' => "Numéro de téléphone invalide."]);
            exit;
        }
    }
    if (isset($_POST["address"]) && !empty(trim($_POST["address"]))) {
        $fields_to_update[] = "address = :address";
        $params[':address'] = trim($_POST["address"]);
    }
    if (isset($_POST["postal_code"]) && !empty(trim($_POST["postal_code"]))) {
        $fields_to_update[] = "postal_code = :postal_code";
        $params[':postal_code'] = trim($_POST["postal_code"]);
    }
    if (isset($_POST["city"]) && !empty(trim($_POST["city"]))) {
        $fields_to_update[] = "city = :city";
        $params[':city'] = trim($_POST["city"]);
    }
    if (isset($_POST["issues"]) && !empty(trim($_POST["issues"]))) {
        $fields_to_update[] = "comment = :comment";
        $params[':comment'] = trim($_POST["issues"]);
    }

    if (empty($fields_to_update)) {
        echo json_encode(['success' => false, 'message' => "Aucun champ n'a été rempli pour la mise à jour."]);
        exit;
    }

    try {
        $sql = "UPDATE users SET " . implode(", ", $fields_to_update) . " WHERE id = :user_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);

        echo json_encode(['success' => true, 'message' => "Vos informations ont été mises à jour avec succès."]);
        exit;
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => "Erreur : " . $e->getMessage()]);
        exit;
    }
} else {
    echo json_encode(['success' => false, 'message' => "Méthode non autorisée."]);
    exit;
}
?>