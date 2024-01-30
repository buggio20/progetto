<?php

$servername = "localhost";
$username = "buggio";
$password = "buggio-MAN04";
$dbname = "my_buggio";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connessione al database fallita: " . $conn->connect_error);
}


$sql = "INSERT INTO Utente (username, password) VALUES ('Andrea', 'password123')";

if ($conn->query($sql) === TRUE) {
    echo "Nuovo utente inserito con successo";
} else {
    echo "Errore durante l'inserimento dell'utente: " . $conn->error;
}


$query = "SELECT * FROM Utente";
$result = $conn->query($query);

$conn->close();

?>
