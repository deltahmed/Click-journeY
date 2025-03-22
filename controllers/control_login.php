<?php
session_start();
require_once "../includes/config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);

    if (empty($email) || empty($password)) {
        echo "All fields are required.";
        exit;
    }

    try {
        $stmt = $pdo->prepare("SELECT id, email, password, role FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user["password"])) {
            $_SESSION["user_id"] = $user["id"];
            $_SESSION["user_email"] = $user["email"];
            $_SESSION["user_role"] = $user["role"];

            header("Location: ../login_success.php");  // Redirection après 2 secondes
        } else {
            echo "Invalid email or password.";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
