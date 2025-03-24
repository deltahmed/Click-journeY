<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (isset($_SESSION["user_id"])) {
    header("Location: ../index.php");
    exit;
}
require_once "../includes/config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);
    $confirm_password = trim($_POST["confirm_password"]);
    $first_name = trim($_POST["first_name"]);
    $last_name = trim($_POST["last_name"]);
    $gender = trim($_POST["gender"]) ?? 'A';;
    $birth_date = trim($_POST["birth_date"]);
    $phone_number = trim($_POST["phone"]);
    $address = trim($_POST["address"]);
    $postal_code = trim($_POST["postal_code"]);
    $city = trim($_POST["city"]);
    $comment = trim($_POST["issues"]);
    $role = "user";

    if (empty($email) || empty($password) || empty($confirm_password)) {
        $_SESSION['sign_in_up_error'] = "Veuillez remplir toutes les informations";
        header("Location: ../signup.php");
        exit;
    }

    $birth_date_timestamp = strtotime($birth_date);
    $age = (int)((time() - $birth_date_timestamp) / (365.25 * 24 * 60 * 60)); // Calcul de l'âge
    if ($age < 18) {
        $_SESSION['sign_in_up_error'] = "Vous devez avoir au moins 18 ans pour vous inscrire.";
        header("Location: ../signup.php");
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['sign_in_up_error'] = "Inscrire une email valide";
        header("Location: ../signup.php");
        exit;
    }

    if ($password !== $confirm_password) {
        echo "Passwords do not match.";
        exit;
    }
    $password_errors = [];
    if (strlen($password) < 8) {
        $password_errors[] = "Le mot de passe doit contenir au moins 8 caractères.";
    }
    if (!preg_match('/[A-Z]/', $password)) {
        $password_errors[] = "Le mot de passe doit contenir au moins une lettre majuscule.";
    }
    if (!preg_match('/[a-z]/', $password)) {
        $password_errors[] = "Le mot de passe doit contenir au moins une lettre minuscule.";
    }
    if (!preg_match('/[0-9]/', $password)) {
        $password_errors[] = "Le mot de passe doit contenir au moins un chiffre.";
    }
    if (!preg_match('/[\W_]/', $password)) {
        $password_errors[] = "Le mot de passe doit contenir au moins un caractère spécial.";
    }

    if (!empty($password_errors)) {
        $_SESSION['sign_in_up_error'] = implode(" <br> ", $password_errors);
        header("Location: ../signup.php");
        exit;
    }

    if ($password !== $confirm_password) {
        $_SESSION['sign_in_up_error'] = "Les mots de passe ne correspondent pas.";
        header("Location: ../signup.php");
        exit;
    }

    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    try {
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);

        if ($stmt->rowCount() > 0) {
            $_SESSION['sign_in_up_error'] = "Email déja utilisé.";
            header("Location: ../signup.php");
            exit;
        }
        $un_id = uniqid();
        $stmt = $pdo->prepare("INSERT INTO users (un_id, email, password, role, first_name, last_name, gender, birth_date, phone_number, address, postal_code, city, comment) 
                               VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$un_id,$email, $hashed_password, $role, $first_name, $last_name, $gender, $birth_date, $phone_number, $address, $postal_code, $city, $comment]);

        header("Location: ../public/signup_success.php");
    } catch (PDOException $e) {
        $_SESSION['sign_in_up_error'] = "Error: " . $e->getMessage();
        header("Location: ../signup.php");
    }
}
?>
