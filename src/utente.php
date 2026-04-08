<?php
session_start();
?>

<!DOCTYPE html>
<html lang="it">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Titolo</title>
    <script src="../js/script.js" defer></script>
</head>
<body>
<h1>Trova la tua città</h1>

<input id="city" type="text" placeholder="Cerca città (es: Milano)" required>
<button type="button" onclick="cityAPI()">Cerca</button>

<pre id="output" style="background: #f4f4f4; padding: 10px; border-radius: 5px;"></pre>
</body>
</html>