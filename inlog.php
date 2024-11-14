<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inloggen</title>
    <link rel="stylesheet" href="css/styling.css">
</head>
<body>
<?php include 'header.php';?>
    <div class="block-settings">
        <h2>Inloggen</h2>
        <form action="inlogprocess.php" method="post">
            <label for="username">Gebruikersnaam:</label>
            <input type="text" id="username" name="username" required>

            <label for="password">Wachtwoord:</label>
            <input type="password" id="password" name="password" required>

            <input type="submit" value="Inloggen" class="btn">
        </form>

        <p>Heb je nog geen account? <a href="registratie.php">Registreer hier</a>.</p>
    </div>
</body>
</html>