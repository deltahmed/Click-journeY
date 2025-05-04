<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION["user_id"])) {
    header("Location: ../index.php");
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
    // Vérifier et valider les champs remplis
    if (isset($_POST["email"]) && !empty(trim($_POST["email"]))) {
        if (filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
            $fields_to_update[] = "email = :email";
            $params[':email'] = trim($_POST["email"]);
        } else {
            $_SESSION['update_error'] = "Adresse email invalide.";
            if ($_SESSION['user_role'] === 'admin') {
                    header("Location: ../admin.php");
                } else {
                    header("Location: ../profil.php");
                }
            exit;
        }
    }
    if (isset($_POST["first_name"]) && !empty(trim($_POST["first_name"]))) {
        if (preg_match("/^[a-zA-ZÀ-ÿ '-]+$/", $_POST["first_name"])) {
            $fields_to_update[] = "first_name = :first_name";
            $params[':first_name'] = trim($_POST["first_name"]);
        } else {
            $_SESSION['update_error'] = "Prénom invalide.";
            if ($_SESSION['user_role'] === 'admin') {
                    header("Location: ../admin.php");
                } else {
                    header("Location: ../profil.php");
                }
            exit;
        }
    }
    if (isset($_POST["last_name"]) && !empty(trim($_POST["last_name"]))) {
        if (preg_match("/^[a-zA-ZÀ-ÿ '-]+$/", $_POST["last_name"])) {
            $fields_to_update[] = "last_name = :last_name";
            $params[':last_name'] = trim($_POST["last_name"]);
        } else {
            $_SESSION['update_error'] = "Nom invalide.";
            if ($_SESSION['user_role'] === 'admin') {
                    header("Location: ../admin.php");
                } else {
                    header("Location: ../profil.php");
                }
            exit;
        }
    }
    if (isset($_POST["gender"]) && !empty(trim($_POST["gender"]))) {
        $allowed_genders = ['M', 'F', 'A'];
        if (in_array(trim($_POST["gender"]), $allowed_genders)) {
            $fields_to_update[] = "gender = :gender";
            $params[':gender'] = trim($_POST["gender"]);
        } else {
            $_SESSION['update_error'] = "Genre invalide.";
            if ($_SESSION['user_role'] === 'admin') {
                    header("Location: ../admin.php");
                } else {
                    header("Location: ../profil.php");
                }
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
                $_SESSION['update_error'] = "Vous devez avoir au moins 18 ans.";
                if ($_SESSION['user_role'] === 'admin') {
                    header("Location: ../admin.php");
                } else {
                    header("Location: ../profil.php");
                }
                exit;
            }
        } else {
            $_SESSION['update_error'] = "Date de naissance invalide.";
            if ($_SESSION['user_role'] === 'admin') {
                    header("Location: ../admin.php");
                } else {
                    header("Location: ../profil.php");
                }
            exit;
        }
    }
    if (isset($_POST["phone"]) && !empty(trim($_POST["phone"]))) {
        if (preg_match("/^\+?[0-9]{10,15}$/", $_POST["phone"])) {
            $fields_to_update[] = "phone_number = :phone_number";
            $params[':phone_number'] = trim($_POST["phone"]);
        } else {
            $_SESSION['update_error'] = "Numéro de téléphone invalide.";
            if ($_SESSION['user_role'] === 'admin') {
                    header("Location: ../admin.php");
                } else {
                    header("Location: ../profil.php");
                }
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
        $_SESSION['update_error'] = "Aucun champ n'a été rempli pour la mise à jour.";
        if ($_SESSION['user_role'] === 'admin') {
                    header("Location: ../admin.php");
                } else {
                    header("Location: ../profil.php");
                }
        exit;
    }
    echo $_POST["user_id"] . "<br>" . $_POST["email"] . "<br>" . $_POST["first_name"] . "<br>" . $_POST["last_name"];
    try {
        // Construire la requête SQL dynamiquement
        $sql = "UPDATE users SET " . implode(", ", $fields_to_update) . " WHERE id = :user_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);

        $_SESSION['update_error'] = "Vos informations ont été mises à jour avec succès.";
        if ($_SESSION['user_role'] === 'admin') {
                    header("Location: ../admin.php");
                } else {
                    header("Location: ../profil.php");
                }
        exit;
    } catch (PDOException $e) {
        $_SESSION['update_error'] = "Erreur : " . $e->getMessage();
        if ($_SESSION['user_role'] === 'admin') {
                    header("Location: ../admin.php");
                } else {
                    header("Location: ../profil.php");
                }
        exit;
    }
} else {
    if ($_SESSION['user_role'] === 'admin') {
                    header("Location: ../admin.php");
                } else {
                    header("Location: ../profil.php");
                }
    exit;
}
?>