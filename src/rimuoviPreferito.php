<?php
session_start();
header('Content-Type: application/json');

if (empty($_SESSION['logged_user'])) {
    echo json_encode(['status' => 'error', 'message' => 'Non autenticato.']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);
$id_ristorante = $input['id'] ?? null;

if (!$id_ristorante) {
    echo json_encode(['status' => 'error', 'message' => 'ID mancante.']);
    exit;
}

$keys = include __DIR__ . '/../env.php';

try {
    $conn = new PDO("mysql:host={$keys['DB_HOST']};dbname={$keys['DB_NAME']};charset=utf8", $keys['DB_USER'], $keys['DB_PASS']);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $conn->prepare("
        DELETE p FROM Preferiti p
        JOIN Utenti u ON u.ID = p.ID_Utente
        WHERE u.Email = :email AND p.ID_Ristorante = :id
    ");
    $stmt->bindParam(':email', $_SESSION['logged_user']);
    $stmt->bindParam(':id',    $id_ristorante);
    $stmt->execute();

    echo json_encode(['status' => 'success', 'message' => 'Rimosso dai preferiti.']);
} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}