<?php
session_start();

$keys = include __DIR__ . '/../.env.php';

$error = "";
$email = $_SESSION['logged_user'];
$pwd_vecchiaNoHash = $_POST['psw_vecchia'];
$pwd_vecchia = sha1($pwd_vecchiaNoHash);
$pwd_nuova = $_POST['psw_nuova'];

$host = $keys['DB_HOST'];
$dbname = $keys['DB_NAME'];
$username = $keys['DB_USER'];
$password = $keys['DB_PASS'];

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $conn->prepare("select Password from Utenti where Email= :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result && $pwd_vecchia === $result['Password']) {
        $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("UPDATE Utenti SET Password = SHA(:pwd_nuova) WHERE Email = :email");
        $stmt->bindParam(':pwd_nuova', $pwd_nuova);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        echo "<script>
                    alert('Password cambiata con successo! Effettua il login con la nuova password.');
                    window.location.href = 'log_in.php';
                </script>";
        exit();
    } else {
        $error = "Password vecchia errata.";
        header("Location: psw.php?error=" . urlencode($error));
    }
} catch (PDOException $e) { $error = "Errore di connessione: " . $e->getMessage(); }
