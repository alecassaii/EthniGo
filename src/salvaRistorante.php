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

    $stmt = $conn->prepare("SELECT ID FROM Utenti WHERE Email = :email");
    $stmt->bindParam(':email', $user_email);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    $ID_U = $result ? $result['ID'] : null;

} catch (PDOException $e) {
    echo json_encode([
        'status' => 'error',
        'message' => "Errore di connessione: " . $e->getMessage()
    ]);
    exit;
}

$ID_R = $restaurant['id'];
$name = $restaurant['poi']['name'] ?? 'Nome non disponibile';
$address = $restaurant['address']['freeformAddress'] ?? 'Indirizzo non disponibile';
$phone = $restaurant['poi']['phone'] ?? 'Non disponibile';
$site = $restaurant['poi']['url'] ?? null;

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $conn->prepare("INSERT INTO Preferiti (ID_Utente, ID_Ristorante, Nome_Ristorante, Indirizzo, Telefono, SitoWeb, DataAggiunta)
                                    VALUES (:ID_U, :ID_R, :name, :address, :phone, :site, NOW())");
    $stmt->bindParam(':ID_U', $ID_U);
    $stmt->bindParam(':ID_R', $ID_R);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':address', $address);
    $stmt->bindParam(':phone', $phone);
    $stmt->bindParam(':site', $site);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);


} catch (PDOException $e) { $error = "Errore di connessione: " . $e->getMessage(); }

echo json_encode([
    'status' => 'success',
    'message' => 'Restaurant saved successfully!',
    'debug_user_id' => $ID_U, // Safe way to pass data to JS for console.log!
    'receivedData' => $restaurant
]);
