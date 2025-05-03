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

    if (empty($email) || empty($password)) {
        $_SESSION['sign_in_up_error'] = "L'email ou le mot de passe sont incorrecte";
        header("Location: ../login.php");
        exit;
    }

    try {
        $stmt = $pdo->prepare("SELECT id, un_id, email, password, role FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);


        if ($user && password_verify($password, $user["password"])) {
            $_SESSION["user_id"] = $user["id"];
            
            $_SESSION["user_email"] = $user["email"];
            $_SESSION["user_role"] = $user["role"];
            $un_id = uniqid();
            $un_id = password_hash($password, PASSWORD_BCRYPT);
            $updateStmt = $pdo->prepare("UPDATE users SET last_login = NOW(), un_id = ? WHERE id = ?");
            $updateStmt->execute([$un_id, $user["id"]]);
            $_SESSION["un_id"] = $un_id;

            header("Location: ../public/login_success.php");  
        } else {
            $_SESSION['sign_in_up_error'] = "L'email ou le mot de passe sont incorrecte";
            header("Location: ../login.php");
        }
    } catch (PDOException $e) {
        $_SESSION['sign_in_up_error'] = "Error: " . $e->getMessage();
        header("Location: ../login.php");
    }
}
?>

