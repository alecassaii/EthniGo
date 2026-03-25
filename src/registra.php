<?php
session_start();
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrati</title>
    <script src="script.js" defer></script>
</head>
<body>
<form class="form" action="registra.php" method="post">
    <p class="form-title">Crea il tuo account</p>

    <div class="input-container">
        <input placeholder="Nome" type="text" name="nome" required>
    </div>

    <div class="input-container">
        <input placeholder="Cognome" type="text" name="cognome" required>
    </div>

    <div class="input-container">
        <input placeholder="Username" type="text" name="username" required>
    </div>

    <div class="input-container">
        <input placeholder="Email" type="email" name="email" required>
    </div>

    <button class="submit" type="submit">Registrati</button>

    <p class="signup-link">
        Hai già un account? <a href="log_in.php">Accedi</a>
    </p>
</form>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $host = "localhost";
    $dbname = "EthniGo";
    $username = "studente";
    $password = "studente";

    $nome = $_POST["nome"];
    $cognome = $_POST["cognome"];
    $usr = $_POST['username'];
    $email = $_POST['email'];
    $psw = 'ABC123';    // Default password for new users

    try {
        $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("insert into Utenti(Nome, Cognome, Username, Email, Password)
                                        values(:nome, :cognome, :usr, :email, SHA(:psw));");
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':cognome', $cognome);
        $stmt->bindParam(':usr', $usr);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':psw', $psw);
        $stmt->execute();
    } catch (PDOException $e) { echo "Errore di connessione: " . $e->getMessage(); }
    echo "<script>alert('Registrazione avvenuta con successo! La tua password di default è ABC123. Cambiala al più presto.'); window.location.href='log_in.php';</script>";
    exit();
}
?>
</body>
</html>