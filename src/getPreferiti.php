<?php
session_start();
header('Content-Type: application/json');

$keys = include __DIR__ . '/../env.php';
$conn = new PDO("mysql:host={$keys['DB_HOST']};dbname={$keys['DB_NAME']};charset=utf8", $keys['DB_USER'], $keys['DB_PASS']);

$stmt = $conn->prepare("
    SELECT p.ID_Ristorante 
    FROM Preferiti p 
    JOIN Utenti u ON u.ID = p.ID_Utente 
    WHERE u.Email = :email
");
$stmt->bindParam(':email', $_SESSION['logged_user']);
$stmt->execute();

$ids = $stmt->fetchAll(PDO::FETCH_COLUMN);
echo json_encode($ids);