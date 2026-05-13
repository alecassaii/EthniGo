<?php
$keys = include __DIR__ . '/../env.php';

$cucina = $_POST['opzioni'];
$citta = json_decode($_POST['citta-scelta'], true);
$api_key = $keys['TOMTOM_API_KEY'];
$lat = $citta['lat'];
$lon = $citta['lon'];
$category_id = $cucina;

if (empty($citta)) {
    echo "<script>
            alert('Scegli una città!!');
            window.location.href = 'utente.php';
        </script>";
}

$base_url = "https://api.tomtom.com/search/2/categorySearch/restaurant.json";

$params = [
        'key'         => $api_key,
        'lat'         => $lat,
        'lon'         => $lon,
        'categorySet' => $category_id,
        'limit'       => 20
];

$url = $base_url . "?" . http_build_query($params);
echo "<script>console.log('lat: " . $lat . ", lon: " . $lon . ", categoryID: " . $category_id . "');</script>";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 10);

$response = curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

if (curl_errno($ch)) echo 'Errore cURL: ' . curl_error($ch);
elseif ($http_code !== 200) echo 'Errore API TomTom: Codice HTTP ' . $http_code . ' - Risposta: ' . $response;
else $data = json_decode($response, true);

curl_close($ch);
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ristoranti</title>
    <script src='../js/script.js' defer></script>
</head>
<body>
<h1>Ristoranti Trovati</h1>

<?php
if (!empty($data['results'])) {
    foreach ($data['results'] as $restaurant) {
        $restaurantData = htmlspecialchars(json_encode($restaurant), ENT_QUOTES, 'UTF-8');
        $name = $restaurant['poi']['name'] ?? 'Nome non disponibile';
        $address = $restaurant['address']['freeformAddress'] ?? 'Indirizzo non disponibile';
        $phone = $restaurant['poi']['phone'] ?? 'Non disponibile';
        $url = $restaurant['poi']['url'] ?? null;

        echo "<div class='restaurant-card'>";
        echo "<h2>" . htmlspecialchars($name) . "</h2>";
        echo "<p><strong>Indirizzo:</strong> " . htmlspecialchars($address) . "</p>";
        echo "<p><strong>Telefono:</strong> " . htmlspecialchars($phone) . "</p>";

        if ($url) {
            $href = (strpos($url, 'https') === 0) ? $url : 'https://' . $url;
            echo "<p><strong>Sito Web:</strong> <a href='" . htmlspecialchars($href) . "' target='_blank'>" . htmlspecialchars($url) . "</a></p>";
        }
        echo "<button class='save-btn' data-info='$restaurantData'>Salva</button>";
        echo "</div>";
    }
} else echo "<p>Nessun ristorante trovato per questa ricerca.</p>";
?>

</body>
</html>