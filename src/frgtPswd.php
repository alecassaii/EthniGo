<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cambio password</title>
</head>
<body>
<form class="form" method="post">

    <p class="form-title">Inserisci la tua mail</p>

    <div class="input-container">
        <input placeholder="Email" type="email" name="email" required>
    </div>

    <button class="submit" onclick="<?php session_start(); $_SESSION['logged_user'] = $_POST['email'] ?>">Procedi</button>

</form>
</body>
</html>