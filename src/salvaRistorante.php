<?php
session_start();

header('Content-Type: application/json');
$jsonInput = file_get_contents('php://input');

$restaurant = json_decode($jsonInput, true);
if ($restaurant === null) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Invalid or missing JSON data.'
    ]);
    exit;
}

$user_email = $_SESSION['logged_user'];
$keys = include __DIR__ . '/../env.php';
$host = $keys['DB_HOST'];
$dbname = $keys['DB_NAME'];
$username = $keys['DB_USER'];
$password = $keys['DB_PASS'];
try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $conn->prepare("select ID from Utenti where Email= :email");
    $stmt->bindParam(':email', $user_email);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) { $error = "Errore di connessione: " . $e->getMessage(); }
echo "<script>console.log('ID: ".$result."');</script>";
$ID_U =
$ID_R = $restaurant['id'];
$name = $restaurant['poi']['name'] ?? 'Nome non disponibile';
$address = $restaurant['address']['freeformAddress'] ?? 'Indirizzo non disponibile';
$phone = $restaurant['poi']['phone'] ?? 'Non disponibile';
$site = $restaurant['poi']['url'] ?? null;

echo json_encode([
    'status' => 'success',
    'message' => 'Restaurant saved successfully!',
    'receivedData' => $restaurant // Optional: send it back to see it in console.log
]);