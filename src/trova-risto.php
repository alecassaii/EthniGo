<?php
$cucina = $_POST['opzioni'];
$citta = json_decode($_POST['citta-scelta'], true);
if (empty($citta)) {
    echo "<script>
            alert('Scegli una città!!');
            window.location.href = 'utente.php';
        </script>";
}

$nomiCucine = [
    7315002 => "african",
    7315003 => "american",
    7315019 => "greek",
    7315025 => "italian",
    7315029 => "sudAmerica",
    7315033 => "mexican",
    7315037 => "polish",
    7315051 => "vietnam",
    7315062 => "asian",
    7315083 => "arab",
    7315100 => "egyptian"
];

$id_cucina = $cucina;
$nome_cucina = $nomiCucine[$id_cucina] ?? "Sconosciuta";

echo "Cucina: $id_cucina - $nome_cucina";
echo "<br>";
echo "Città: |" . $citta['name']." | ".$citta['lat']." | ".$citta['lon']." | ";