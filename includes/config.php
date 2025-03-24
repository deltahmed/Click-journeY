<?php
$host = 'localhost'; 
$dbname = 'clickjourney'; 
$username = 'root'; 
$password = ''; 

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

function verifyUnId($pdo, $user_id, $un_id) {
    $query = "SELECT un_id FROM users WHERE id = :user_id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
    $db_un_id = $stmt->fetchColumn();
    return $db_un_id == $un_id;
}


?>
