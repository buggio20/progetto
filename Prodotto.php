<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Gestione Prodotti</title>
    <style>
       <a href="Prodotto.php">ciao</a>
       body {
    font-family: Arial, sans-serif;
    background-color: #f5f5f5;
    margin: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}

.container {
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    padding: 20px;
    width: 80%;
    margin: 20px auto;
}

h3 {
    color: #333;
}

table {
    border-collapse: collapse;
    width: 100%;
    margin-top: 20px;
}

th, td {
    border: 1px solid #dddddd;
    text-align: left;
    padding: 8px;
}

th {
    background-color: #f2f2f2;
}

form {
    margin-top: 20px;
}

label {
    display: block;
    margin-bottom: 5px;
    color: #333;
}

input[type="text"],
textarea {
    width: 100%;
    padding: 8px;
    box-sizing: border-box;
    margin-bottom: 10px;
}

input[type="submit"] {
    background-color: #4caf50;
    color: #fff;
    padding: 10px 15px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

input[type="submit"]:hover {
    background-color: #45a049;
}

    </style>
</head>
<body>
<?php
$conn = mysqli_connect("localhost", "buggio", "buggio-MAN04", "my_buggio");

if (!$conn) {
    die("Connessione al database non riuscita: " . mysqli_connect_error());
}

function aggiungiProdotto($conn, $nomeOggetto, $descrizione, $tipoProdottoId) {

    mysqli_query($conn, "SET time_zone = 'Europe/Rome'");

    $query = "INSERT INTO Prodotto (NomeOggetto, Descrizione, DataInserimento, TipoProdottoId) 
              VALUES ('$nomeOggetto', '$descrizione', CONVERT_TZ(UTC_TIMESTAMP(), '+00:00', @@session.time_zone), '$tipoProdottoId')";

    if (mysqli_query($conn, $query)) {
        echo "Prodotto aggiunto con successo.";
    } else {
        echo "Errore nell'aggiunta del prodotto: " . mysqli_error($conn);
    }
}


function modificaProdotto($conn, $prodottoId, $nomeOggetto, $descrizione, $tipoProdottoId) {
    $query = "UPDATE Prodotto 
              SET NomeOggetto='$nomeOggetto', Descrizione='$descrizione', TipoProdottoId='$tipoProdottoId' 
              WHERE Id='$prodottoId'";

    if (mysqli_query($conn, $query)) {
        echo "Prodotto modificato con successo.";
    } else {
        echo "Errore nella modifica del prodotto: " . mysqli_error($conn);
    }
}

function eliminaProdotto($conn, $prodottoId) {
    $query = "DELETE FROM Prodotto WHERE Id='$prodottoId'";

    if (mysqli_query($conn, $query)) {
        echo "Prodotto eliminato con successo.";
    } else {
        echo "Errore nell'eliminazione del prodotto: " . mysqli_error($conn);
    }
}


if (isset($_POST['aggiungi'])) {
    aggiungiProdotto($conn, $_POST['nomeOggetto'], $_POST['descrizione'], $_POST['tipoProdottoId']);
} elseif (isset($_POST['modifica'])) {
    modificaProdotto($conn, $_POST['prodottoId'], $_POST['nomeOggetto'], $_POST['descrizione'], $_POST['tipoProdottoId']);
} elseif (isset($_POST['elimina'])) {
    eliminaProdotto($conn, $_POST['prodottoId']);
}

$query = "SELECT Id, NomeOggetto, Descrizione, DATE_FORMAT(CONVERT_TZ(DataInserimento, @@session.time_zone, 'Europe/Rome'), '%d/%m/%Y %H:%i:%s') AS DataInserimento, TipoProdottoId FROM Prodotto";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Errore nella query: " . mysqli_error($conn));
}

$columns = ['Id', 'NomeOggetto', 'Descrizione', 'DataInserimento', 'TipoProdottoId'];

echo "<table border='1'>";
echo "<thead><tr>";
foreach ($columns as $column) {
    echo "<th>$column</th>";
}
echo "</tr></thead>";
echo "<tbody>";

while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>";
    foreach ($columns as $column) {
        echo "<td>{$row[$column]}</td>";
    }
    echo "</tr>";
}
echo "</tbody></table>";
mysqli_close($conn);
?>
<form method="post" action="">
    <h3>Aggiungi/Modifica Prodotto</h3>
    <label for="nomeOggetto">Nome Oggetto:</label>
    <input type="text" name="nomeOggetto" required>
    <br>
    <label for="descrizione">Descrizione:</label>
    <textarea name="descrizione" required></textarea>
    <br>
    <label for="tipoProdottoId">Tipo Prodotto ID:</label>
    <input type="text" name="tipoProdottoId" required>
    <br>
    <input type="submit" name="aggiungi" value="Aggiungi">
    <input type="submit" name="modifica" value="Modifica">
</form>
<form method="post" action="">
    <h3>Elimina Prodotto</h3>
    <label for="prodottoId">ID Prodotto da Eliminare:</label>
    <input type="text" name="prodottoId" required>
    <br>
    <input type="submit" name="elimina" value="Elimina">
</form>
</body>
</html>
