<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EthniGo — Ristoranti trouvati</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/trova-risto.css">
    <link rel="icon" type="image/x-icon" href="../res/favicon.ico">
    <script src='../js/script.js' defer></script>
</head>
<body>

<?php
function cutName($fullName) { return explode(',', $fullName)[0]; }

$keys = include __DIR__ . '/../env.php';

$cucina   = $_POST['opzioni'];
$citta    = json_decode($_POST['citta-scelta'], true);
$api_key  = $keys['TOMTOM_API_KEY'];
$lat      = $citta['lat'];
$lon      = $citta['lon'];
$category_id = $cucina;
$cityName = trim(cutName($citta['name'] ?? ''));

if (empty($citta)) {
    echo "<script>alert('Scegli una città!!'); window.location.href = 'utente.php';</script>";
    exit;
}

$base_url = "https://api.tomtom.com/search/2/categorySearch/restaurant.json";
$params   = [
        'key'         => $api_key,
        'lat'         => $lat,
        'lon'         => $lon,
        'categorySet' => $category_id,
        'limit'       => 20
];
$url = $base_url . "?" . http_build_query($params);
echo "<script>console.log('nome: ".$cityName." | lat: ".$lat." | lon: ".$lon." | categoryID: ".$category_id." | URL: ".$url."');</script>";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 10);

$response  = curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

$data = [];
if (curl_errno($ch)) echo 'Errore cURL: ' . curl_error($ch);
elseif ($http_code !== 200) echo 'Errore API TomTom: Codice HTTP ' . $http_code;
else $data = json_decode($response, true);

curl_close($ch);

$filteredResults = [];
if (!empty($data['results'])) {
    foreach ($data['results'] as $restaurant) {
        $address = $restaurant['address']['freeformAddress'] ?? '';

        $cityNameClean = str_replace("'", "", $cityName);
        $addressClean = str_replace("'", "", $address);

        $parts = explode(',', $addressClean);
        $lastPart = trim(end($parts));

        if (stripos($lastPart, $cityNameClean) !== false) $filteredResults[] = $restaurant;
    }
}

$count = count($filteredResults);
?>

<div class="page-wrapper">

    <div class="page-header">
        <div class="page-header-text">
            <span class="hero-badge">Guida dei sapori</span>
            <h1>Ristoranti <em>trovati</em></h1>
            <a href="utente.php" class="back-link">← Nuova ricerca</a>
            <p class="back-link"> | </p>
            <a href="preferiti.php" class="back-link">Preferiti</a>
        </div>
        <span class="result-count"><strong><?= $count ?></strong> risultati</span>
    </div>

    <?php if ($count > 0): ?>

        <div class="results-grid">
            <?php foreach ($filteredResults as $restaurant):
                $restaurantData = htmlspecialchars(json_encode($restaurant), ENT_QUOTES, 'UTF-8');
                $name = $restaurant['poi']['name'] ?? 'Nome non disponibile';
                $address = $restaurant['address']['freeformAddress'] ?? 'Indirizzo non disponibile';
                $phone = $restaurant['poi']['phone'] ?? 'Non disponibile';
                $site = $restaurant['poi']['url'] ?? null;
                ?>
                <div class="restaurant-card">

                    <h2><?= htmlspecialchars($name) ?></h2>

                    <div class="card-info">
                        <p class="info-address">
                            <strong>Indirizzo</strong><?= htmlspecialchars($address) ?>
                        </p>
                        <p class="info-phone">
                            <strong>Telefono</strong><?= htmlspecialchars($phone) ?>
                        </p>
                        <?php if ($site):
                            $href = (strpos($site, 'https') === 0) ? $site : 'https://' . $site;
                            ?>
                            <p class="info-web">
                                <strong>Sito</strong>
                                <a href="<?= htmlspecialchars($href) ?>" target="_blank"><?= htmlspecialchars($site) ?></a>
                            </p>
                        <?php endif; ?>
                    </div>

                    <div class="card-footer">
                        <button class="save-btn" data-info="<?= $restaurantData ?>">Salva</button>
                    </div>

                </div>
            <?php endforeach; ?>
        </div>

    <?php else: ?>
        <div class="no-results">
            <p>Nessun ristorante trovato per questa ricerca.</p>
        </div>
    <?php endif; ?>

</div>

</body>
</html>