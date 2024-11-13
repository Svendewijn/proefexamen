<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instellingen</title>
    <link rel="stylesheet" href="css/styling.css">
</head>
<body>
<?php include 'header.php'; ?>

<div class="block-settings">
    <h1>Instellingen</h1>
    <form action="#" method="post">
        <label for="username">Gebruikersnaam:</label>
        <input type="text" id="username" name="username" value="Huidige gebruikersnaam" disabled>
        
        <label for="email">E-mail:</label>
        <input type="email" id="email" name="email" value="huidige.email@example.com" disabled>
        
        <label for="password">Wachtwoord:</label>
        <input type="password" id="password" name="password" placeholder="Nieuw wachtwoord">
        
        <label for="rol">Rol:</label>
        <select id="rol" name="rol">
            <option value="werkgever">Werkgever</option>
            <option value="werknemer">Werknemer</option>
        </select>
        
        <input type="submit" value="Opslaan" disabled>
    </form>
</div>
<?php include 'footer.php'; ?>
</body>
</html>