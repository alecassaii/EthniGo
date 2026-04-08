<?php
session_start();
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cambio password</title>
    <script src="../js/script.js" defer></script>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/psw.css">
</head>
<body onload="err()">

<form class="form" action="cambiaPswd.php" method="post">

    <p class="form-title">Modifica password</p>

    <div class="input-container">
        <input placeholder="Password attuale" type="password" name="psw_vecchia" id="pswd_vecchia" required>
    </div>

    <div class="input-container">
        <input placeholder="Nuova password" type="password" name="psw_nuova" id="pswd_nuova" required>

        <div style="display: flex; align-items: center; margin-top: 0; margin-left: 17px;">
            <input type="checkbox" id="showPswd" style="width:12px; height:12px; margin-right:6px;"
                   onclick="togglePasswords()">
            <script>
                function togglePasswords() {
                    let show = document.getElementById('showPswd').checked;
                    document.getElementById('pswd_vecchia').type = show ? 'text' : 'password';
                    document.getElementById('pswd_nuova').type = show ? 'text' : 'password';
                }
            </script>
            <label for="showPswd" style="font-size:12px; cursor:pointer;">Mostra password</label>
        </div>
    </div>
    <p id="log">
        <?php if (!empty($_GET['error'])) echo $_GET['error']; ?>
    </p>
    <button class="submit" type="submit">Cambia</button>

</form>
</body>
</html>