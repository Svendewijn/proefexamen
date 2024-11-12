<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    // Sla de huidige pagina op in de sessie, zodat we de gebruiker kunnen terugsturen na inloggen
    $_SESSION['redirect_after_login'] = $_SERVER['REQUEST_URI'];
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Uploaden</title>
</head>
<body>
    <h2>Uploaden</h2>
    <form action="upload_process.php" method="post" enctype="multipart/form-data">
        <label for="text">Tekst:</label>
        <textarea name="text" id="text"></textarea><br><br>

        <label for="video">Video:</label>
        <input type="file" name="video" id="video" accept="video/*"><br><br>

        <label for="cv">CV:</label>
        <input type="file" name="cv" id="cv" accept=".pdf,.doc,.docx"><br><br>

        <input type="submit" value="Uploaden">
    </form>
</body>
</html>