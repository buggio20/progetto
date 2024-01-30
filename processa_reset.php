<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_POST['token'])) {
        echo "Il token non è stato inviato correttamente dal form. Contatta l'amministratore.";
        exit();
  }
    $token = $_POST['token'];
    $newPassword = $_POST['password'];
    $confirmPassword = $_POST['conferma-password'];
    if ($newPassword !== $confirmPassword) {
        echo "Le password non corrispondono. Riprova.";
        exit();
    }
    $dbStoredToken = "il_tuo_token_salvato_nel_database";
if ($token != $storedToken) {
    echo "Il token non è valido. Contatta l'amministratore.";
    exit();
}
    echo "Password aggiornata con successo!";
} else {
    echo "Accesso non autorizzato.";
}
?>

