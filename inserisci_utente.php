<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$conn = mysqli_connect("localhost", "buggio", "buggio-MAN04", "my_buggio");

if (!$conn) {
    die("Connessione al database non riuscita: " . mysqli_connect_error());
} else {
    echo "Connessione al database riuscita!\n";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    echo "Dati del form ricevuti:\n";
    var_dump($_POST);

    $username = mysqli_real_escape_string($conn, $_POST["username"]);
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
    $token = uniqid();
    $email = mysqli_real_escape_string($conn, $_POST["email"]);

    echo "Dati prima dell'inserimento:\n";
    echo "Username: $username\n";
    echo "Password: $password\n";
    echo "Token: $token\n";
    echo "Email: $email\n";

    $insertQuery = "INSERT INTO Utente (Username, Password, token, Email) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $insertQuery);

    if ($stmt === false) {
        die("Errore nella preparazione dello statement: " . mysqli_error($conn));
    }

 
    mysqli_stmt_bind_param($stmt, "ssss", $username, $password, $token, $email);

    
    echo "Query SQL generata:\n";
    echo $insertQuery;

    $result = mysqli_stmt_execute($stmt);

    echo "Query eseguita con successo?\n";
    var_dump($result);

    echo "Numero di righe interessate:\n";
    echo mysqli_stmt_affected_rows($stmt);

    echo "Errori nello statement:\n";
    echo mysqli_stmt_error($stmt);

    mysqli_stmt_close($stmt);

    echo "Utente inserito con successo!";
}

mysqli_close($conn);
?>
