<?php
require_once "../includes/config.php";

$stage_id = isset($_GET['stage_id']) ? (int)$_GET['stage_id'] : 0;
$type = isset($_GET['type']) ? $_GET['type'] : '';

if (!$stage_id || !$type) {
    http_response_code(400);
    echo json_encode(['error' => 'Missing parameters']);
    exit;
}

$stmt = $pdo->prepare("SELECT id, title, price FROM options WHERE stage_id = :stage_id AND options_type = :type ORDER BY price ASC");
$stmt->bindParam(':stage_id', $stage_id, PDO::PARAM_INT);
$stmt->bindParam(':type', $type, PDO::PARAM_STR);
$stmt->execute();
$options = $stmt->fetchAll(PDO::FETCH_ASSOC);

header('Content-Type: application/json');
echo json_encode($options);

?>