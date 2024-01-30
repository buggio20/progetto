<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="generator" content="AlterVista - Editor HTML"/>
    <title>Reset Password</title>
    <link rel="stylesheet" href="stile.css">
</head>
<body>
    <div class="reset-password-container">
        <h2>Reimposta la tua password</h2>
        <form method="post" action="processa_reset.php">
            <input type="hidden" name="token" value="<?php echo $token; ?>">
            <div class="form-group">
                <label for="password">Nuova Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="conferma-password">Conferma Nuova Password:</label>
                <input type="password" id="conferma-password" name="conferma-password" required>
            </div>
            <div class="form-group">
                <button type="submit">Reimposta Password</button>
            </div>
        </form>
    </div>
</body>
</html>

<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$token = "0";

if (empty($token)) {
    die("Il token non è stato inviato correttamente dal form.");
}
$conn = mysqli_connect("localhost", "buggio", "buggio-MAN04", "my_buggio");
if (!$conn) {
    die("Errore di connessione al database: " . mysqli_connect_error());
}

$checkTokenQuery = "SELECT reset_token FROM Utente WHERE BINARY reset_token = ?";
$checkTokenStmt = mysqli_prepare($conn, $checkTokenQuery);

if (!$checkTokenStmt) {
    die("Errore nella preparazione della query di verifica del token: " . mysqli_error($conn));
}

mysqli_stmt_bind_param($checkTokenStmt, "s", $token);
mysqli_stmt_execute($checkTokenStmt);
mysqli_stmt_bind_result($checkTokenStmt, $storedToken);
mysqli_stmt_fetch($checkTokenStmt);
if ($token !== $storedToken) {
    die("Il token non è valido");
}
mysqli_close($conn);
?>
