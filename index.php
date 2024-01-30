<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = $_POST['alfanumerico'];
    $password = $_POST['password'];
    $servername = "localhost";
    $username_db = "buggio";
    $password_db = "buggio-MAN04";
    $dbname = "my_buggio";

    $conn = new mysqli($servername, $username_db, $password_db, $dbname);


    if ($conn->connect_error) {
        die("Errore di connessione al database: " . $conn->connect_error);
    }

 
    $query = "SELECT * FROM Utente WHERE Username=? AND Password=?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $username, $password);


    $result = $stmt->execute();

    if (!$result) {
        die("Errore nella query: " . $stmt->error);
    }

 
    $stmt->store_result();

    if ($stmt->num_rows > 0) {

        header("Location: Utenza.php");
        exit();
    } else {
        $errore = "Credenziali non valide. Riprova.";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="generator" content="AlterVista - Editor HTML"/>
    <title>Project</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .login-container {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            width: 300px;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            color: #333;
        }

        input {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            background-color: #4caf50;
            color: #fff;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }

        a {
            text-decoration: none;
            color: #333;
        }

        a:hover {
            color: #4caf50;
        }

        p {
            margin: 0;
            color: red;
            text-align: center;
        }
    </style>

    <script>
        function validatePassword() {
            var password = document.getElementById("password").value;

            if (password.length < 8) {
                alert("La password deve essere lunga almeno 8 caratteri.");
                return false;
            }
            if (!/[A-Z]/.test(password)) {
                alert("La password deve contenere almeno una lettera maiuscola.");
                return false;
            }

            if (!/[!@#$%^&*(),.?":{}|<>]/.test(password)) {
                alert("La password deve contenere almeno un carattere speciale.");
                return false;
            }
            return true; 
        }
    </script>
</head>
<body>

<div class="login-container">
    <h2>Login</h2>
    <?php if (isset($errore)) { ?>
        <p style="color: red;"><?php echo $errore; ?></p>
    <?php } ?>
    <form method="post" action="" onsubmit="return validatePassword();">
        <!-- Aggiungi action="" per inviare il form alla stessa pagina -->
        <div class="form-group">
            <label for="alfanumerico">Username:</label>
            <input type="text" id="alfanumerico" name="alfanumerico" pattern="[a-zA-Z0-9]+" required>
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
        </div>
        <div class="form-group">
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" required>
        </div>
        <div class="form-group">
            <label for="cognome">Cognome:</label>
            <input type="text" id="cognome" name="cognome" required>
        </div>
        <div class="form-group">
            <label for="data">Data di nascita:</label>
            <input type="date" id="data" name="data" required>
        </div> 
        <div class="form-group">
            <button type="submit">Login</button> <br>
            <a href="recuperaPassword.html">password dimenticata?</a>
        </div>
    </form>
</div>

</body>
</html>
