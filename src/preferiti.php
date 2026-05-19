<?php
session_start();

if (empty($_SESSION['logged_user'])) {
    header("location: log_in.php");
    exit;
}

$keys    = include __DIR__ . '/../env.php';
$conn    = new PDO("mysql:host={$keys['DB_HOST']};dbname={$keys['DB_NAME']};charset=utf8", $keys['DB_USER'], $keys['DB_PASS']);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$stmt = $conn->prepare("
    SELECT p.ID_Ristorante, p.Nome_Ristorante, p.Indirizzo, p.Telefono, p.SitoWeb, p.DataAggiunta
    FROM Preferiti p
    JOIN Utenti u ON u.ID = p.ID_Utente
    WHERE u.Email = :email
    ORDER BY p.DataAggiunta DESC
");
$stmt->bindParam(':email', $_SESSION['logged_user']);
$stmt->execute();
$preferiti = $stmt->fetchAll(PDO::FETCH_ASSOC);
$count = count($preferiti);
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EthniGo — I miei preferiti</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/preferiti.css">
    <link rel="icon" type="image/x-icon" href="../res/favicon.ico">
    <script src="../js/script.js" defer></script>
</head>
<body>

<div class="page-wrapper">

    <!-- Header -->
    <div class="page-header">
        <div class="page-header-text">
            <span class="hero-badge">La tua collezione</span>
            <h1>I miei <em>preferiti</em></h1>
            <a href="utente.php" class="back-link">← Nuova ricerca</a>
        </div>
        <span class="result-count"><strong><?= $count ?></strong> salvati</span>
    </div>

    <?php if ($count > 0): ?>

        <div class="results-grid">
            <?php foreach ($preferiti as $r): ?>
                <div class="restaurant-card" data-id="<?= htmlspecialchars($r['ID_Ristorante']) ?>">

                    <div class="card-top">
                        <h2><?= htmlspecialchars($r['Nome_Ristorante']) ?></h2>
                        <button
                            class="delete-btn"
                            data-id="<?= htmlspecialchars($r['ID_Ristorante']) ?>"
                            title="Rimuovi dai preferiti"
                            aria-label="Rimuovi <?= htmlspecialchars($r['Nome_Ristorante']) ?> dai preferiti">
                            <!-- Cestino SVG inline -->
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                 stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="3 6 5 6 21 6"/>
                                <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/>
                                <path d="M10 11v6M14 11v6"/>
                                <path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/>
                            </svg>
                        </button>
                    </div>

                    <div class="card-info">
                        <p class="info-address">
                            <strong>Indirizzo</strong><?= htmlspecialchars($r['Indirizzo']) ?>
                        </p>
                        <p class="info-phone">
                            <strong>Telefono</strong><?= htmlspecialchars($r['Telefono']) ?>
                        </p>
                        <?php if (!empty($r['SitoWeb'])):
                            $href = (strpos($r['SitoWeb'], 'https') === 0) ? $r['SitoWeb'] : 'https://' . $r['SitoWeb'];
                            ?>
                            <p class="info-web">
                                <strong>Sito</strong>
                                <a href="<?= htmlspecialchars($href) ?>" target="_blank"><?= htmlspecialchars($r['SitoWeb']) ?></a>
                            </p>
                        <?php endif; ?>
                    </div>

                    <div class="card-footer">
                <span class="saved-date">
                    Salvato il <?= date('d/m/Y', strtotime($r['DataAggiunta'])) ?>
                </span>
                    </div>

                </div>
            <?php endforeach; ?>
        </div>

    <?php else: ?>
        <div class="no-results">
            <p>Non hai ancora salvato nessun ristorante.</p>
            <a href="utente.php" class="btn-cerca-link">Inizia a esplorare</a>
        </div>
    <?php endif; ?>

</div>

</body>
</html>