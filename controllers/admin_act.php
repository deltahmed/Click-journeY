
<?php
session_start();
require_once "../includes/config.php";

if ($_SESSION['user_role'] !== 'admin') {
    http_response_code(403);
    exit;
}

$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
$action = $_POST['action'] ?? '';

if (!$id || !$action) {
    http_response_code(400);
    exit;
}

switch ($action) {
    case 'promote':
        $stmt = $pdo->prepare("UPDATE users SET role = 'vip' WHERE id = ? AND role = 'user'");
        $stmt->execute([$id]);
        echo 'ok';
        break;
    case 'demote':
        $stmt = $pdo->prepare("UPDATE users SET role = 'user' WHERE id = ? AND role = 'vip'");
        $stmt->execute([$id]);
        echo 'ok';
        break;
    case 'delete':
        // On ne supprime pas les admins
        $stmt = $pdo->prepare("DELETE FROM users WHERE id = ? AND role != 'admin'");
        $stmt->execute([$id]);
        echo 'ok';
        break;
    default:
        http_response_code(400);
        exit;
}
?>