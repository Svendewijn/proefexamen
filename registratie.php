<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registreren</title>
    <link rel="stylesheet" href="css/styling.css">
</head>
<body>
<?php include 'header.php';?>
    <div class="block-settings">
        <h2>Registreren</h2>
        <form action="registratieprocess.php" method="post">
            <label for="username">Gebruikersnaam:</label>
            <input type="text" id="username" name="username" required>

            <label for="email">E-mail:</label>
            <input type="email" id="email" name="email" required>

            <label for="password">Wachtwoord:</label>
            <input type="password" id="password" name="password" required>

            <label for="rol">Kies uw rol:</label>
            <select id="rol" name="rol" required>
                <option value="" disabled selected>Kies een rol</option>
                <option value="werkgever">Werkgever</option>
                <option value="werknemer">Werknemer</option>
            </select>

            <input type="submit" value="Registreren" class="btn">
        </form>
    </div>
</body>
</html>