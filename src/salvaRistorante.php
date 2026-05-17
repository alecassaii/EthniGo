<?php
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

$ID = $restaurant['id'];
$name = $restaurant['poi']['name'] ?? 'Nome non disponibile';
$address = $restaurant['address']['freeformAddress'] ?? 'Indirizzo non disponibile';
$phone = $restaurant['poi']['phone'] ?? 'Non disponibile';
$site = $restaurant['poi']['url'] ?? null;

echo json_encode([
    'status' => 'success',
    'message' => 'Restaurant saved successfully!',
    'receivedData' => $restaurant // Optional: send it back to see it in console.log
]);