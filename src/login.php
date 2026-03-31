<?php
session_start();

$keys = include __DIR__ . '/../.env.php';

$error = "";
$email = $_POST['email'];
$passNoHash = $_POST['password'];
$pwd = sha1($passNoHash);

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

    if ($result && $pwd === $result['Password']) {
        $_SESSION['logged_user'] = $email;
        if ($result['Password'] === '61768db8d1a38f1c16d3e6eea812ef423c739068') {   // psw di default (ABC123)
            echo "<script>
                        alert('Cambia la password di default con una a tua scelta!');
                        window.location.href = 'psw.php';
                    </script>";
        } else header("Location: utente.php");
        exit();
    } else {
        $error = "Username o password errati.";
        header("Location: log_in.php?error=" . urlencode($error));
    }
} catch (PDOException $e) { $error = "Errore di connessione: " . $e->getMessage(); }
