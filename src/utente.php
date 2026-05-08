<?php
session_start();
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EthniGo — Cerca ristoranti</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/utente.css">
    <script src="../js/script.js" defer></script>
</head>
<body>

<div class="page-wrapper">

    <!-- Header -->
    <div class="page-header">
        <span class="hero-badge">Guida dei sapori</span>
        <h1>Cerca la tua <em>città</em></h1>
        <p>Trova la tua posizione e scegli il tipo di cucina che ti ispira.</p>
    </div>

    <!-- Search card -->
    <div class="search-card">
        <form action="trova-risto.php" method="post">

            <input type="hidden" name="citta-scelta" id="hidden-city">
            <!-- Step 1: città -->
            <div>
                <p class="step-label">Dove sei?</p>
                <div class="city-group">
                    <input id="city" type="text" placeholder="Cerca città (es: Milano)">
                    <button class="btn-cerca" id="button" type="button" onclick="cityAPI()">Cerca</button>
                </div>
                <pre id="output"></pre>
            </div>

            <!-- Separatore -->
            <div class="step-divider">Poi scegli</div>

            <!-- Step 2: tipo cucina -->
            <div>
                <p class="step-label">Che cucina cerchi?</p>
                <div class="select-wrapper">
                    <select name="opzioni" required>
                        <option value="" disabled selected hidden>Seleziona un'opzione</option>
                        <option value="7315002">Africano</option>
                        <option value="7315003">Americano</option>
                        <option value="7315019">Greco</option>
                        <option value="7315025">Italiano</option>
                        <option value="7315029">Sud Americano</option>
                        <option value="7315033">Messicano</option>
                        <option value="7315037">Polacco</option>
                        <option value="7315051">Vietnamita</option>
                        <option value="7315062">Asiatico</option>
                        <option value="7315083">Arabo</option>
                        <option value="7315100">Egiziano</option>
                    </select>
                </div>
            </div>

            <!-- Submit -->
            <button class="submit" id="button-sbmt" type="submit" onkeydown="return event.key !== 'Enter';">
                Scopri i ristoranti
            </button>

        </form>
    </div>

</div>

<script>
    var input = document.getElementById("city");
    input.addEventListener("keypress", function(event) {
        if (event.key === "Enter") {
            event.preventDefault();
            document.getElementById("button").click();
        }
    });
</script>

</body>
</html>