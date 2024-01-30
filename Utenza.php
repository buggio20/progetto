<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="generator" content="AlterVista - Editor HTML"/>
    <title>Gestione Utenti</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
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

        button {
            background-color: #4caf50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;
        }

        button:hover {
            background-color: #45a049;
        }

        form {
            max-width: 600px;
            margin: 20px auto;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #f5f5f5;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        input {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            box-sizing: border-box;
        }

        h2 {
            color: #333;
        }
        input:invalid {
            border: 1px solid #ff0000;
        }

        input:focus:invalid {
            outline: none;
        }

        input:valid {
            border: 1px solid #00ff00;
        }

        input:focus:valid {
            outline: none;
        }
    </style>
</head>
<body>

<?php
$conn = mysqli_connect("localhost", "buggio", "buggio-MAN04", "my_buggio");

if (!$conn) {
    die("Connessione al database non riuscita: " . mysqli_connect_error());
}

function cleanInput($input) {
    $input = trim($input);
    $input = stripslashes($input);
    $input = htmlspecialchars($input);
    return $input;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = cleanInput($_POST["username"]);
    $password = cleanInput($_POST["password"]);

    $token = uniqid();
    $insertQuery = "INSERT INTO Utente (Username, Password, token) VALUES ('$username', '$password', '$token')";
    $result = mysqli_query($conn, $insertQuery);

    if ($result) {
        echo "Utente inserito con successo!";
    } else {
        echo "Errore nell'inserimento utente: " . mysqli_error($conn);
    }
}

$query = "SELECT * FROM Utente";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Errore nella query: " . mysqli_error($conn));
}

$columns = [];
while ($fieldInfo = mysqli_fetch_field($result)) {
    $columns[] = $fieldInfo->name;
}

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

<form method="post" onsubmit="return validaPassword()">
    <h2>Inserisci nuovo utente</h2>
    <label for="username">Username:</label>
    <input type="text" id="username" name="username" required>

    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required>

    <button type="submit">Inserisci Utente</button>
    <button onclick="window.location.href='Prodotto.php'" type="button">Vai ai prodotti</button>
</form>

<script>
    function validaPassword() {
        var username = document.getElementById("username").value;
        var password = document.getElementById("password").value;

        if (username.trim() === "") {
            alert("Inserisci un username valido.");
            return false;
        }

        if (password.length < 8) {
            alert("La password deve essere lunga almeno 8 caratteri.");
            return false;
        }

        return true;
    }
</script>

</body>
</html>
