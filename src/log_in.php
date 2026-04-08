<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accedi</title>
    <script src="../js/script.js" defer></script>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/log_in.css">
</head>
<body onload="err()">
<form class="form" action="login.php" method="post">

    <p class="form-title">Accedi</p>

    <div class="input-container">
        <input placeholder="Email" type="email" name="email" required>
    </div>

    <div class="input-container">
        <input placeholder="Password" type="password" name="password" id="pswd" required>

        <div style="display: flex; align-items: center; margin-top: 0; margin-left: 17px;">
            <input type="checkbox" id="showPswd" style="width:12px; height:12px; margin-right:6px;"
                   onclick="pswd.type = this.checked ? 'text' : 'password'">
            <label for="showPswd" style="font-size:12px; cursor:pointer;">Mostra password</label>
        </div>
    </div>

    <p id="log">
        <?php if (!empty($_GET['error'])) echo $_GET['error']; ?>
    </p>
    <button class="submit" type="submit">Login</button>
    <a href="frgtPswd.php">Hai dimenticato la password?</a>

    <p class="signup-link">
        Non hai un account? <a href="registra.php">Registrati</a>
    </p>

</form>
</body>
</html>
