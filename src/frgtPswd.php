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
    <link rel="stylesheet" href="../css/frgtPswd.css">
</head>
<body>
<div class="page-wrapper">
    <form class="form" action="frgtPswd.php" method="post">
		
        <p class="form-title">Inserisci la tua mail</p>

        <div class="input-container">
            <input placeholder="Email" type="email" name="email" required>
        </div>

        <button class="submit" type="submit">Procedi</button>

    </form>
</div>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $_SESSION['logged_user'] = $_POST["email"];
    header("location: psw.php");
}
?>
</body>
</html>
