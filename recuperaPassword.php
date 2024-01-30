<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $token = bin2hex(random_bytes(32));
    $subject = "Reset della password";
    $message = "Clicca sul seguente link per resettare la tua password: https://buggio.altervista.org/LavoroProgetto/reset_password.php?token=$token";
    $headers = "From: tuo@email.com";

    mail($email, $subject, $message, $headers);

    echo "Un link per il reset della password è stato inviato all'indirizzo email fornito.";
} else {
    echo "Accesso non autorizzato";
}
?>
