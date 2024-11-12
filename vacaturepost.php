<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>vacature</title>
</head>
<body>
<form action="vacaturepost.php" method="post">
    <label for="titel">Titel:</label>
    <input type="text" id="titel" name="titel" required>
    
    <label for="beschrijving">Beschrijving:</label>
    <textarea id="beschrijving" name="beschrijving" required></textarea>
    
    <label for="locatie">Locatie:</label>
    <input type="text" id="locatie" name="locatie" required>
    
    <label for="salaris">Salaris:</label>
    <input type="number" id="salaris" name="salaris" step="0.01">
    
    <input type="submit" value="Plaats Vacature">
</form>
</body>

<?php
// Databaseverbinding
$servername = "localhost"; // of je database server
$username = "root"; // je database gebruikersnaam
$password = ""; // je database wachtwoord
$dbname = "XXL_database"; // je database naam

$conn = new mysqli($servername, $username, $password, $dbname);

// Controleer de verbinding
if ($conn->connect_error) {
    die("Verbinding mislukt: " . $conn->connect_error);
}

// Controleer of het formulier is ingediend
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titel = $_POST['titel'];
    $beschrijving = $_POST['beschrijving'];
    $locatie = $_POST['locatie'];
    $salaris = $_POST['salaris'];

    // SQL-instructie om gegevens in te voegen
    $sql = "INSERT INTO vacatureposts (titel, beschrijving, locatie, salaris) VALUES ('$titel', '$beschrijving', '$locatie', '$salaris')";

    if ($conn->query($sql) === TRUE) {
        // Redirect naar vacature.php na succesvolle upload
        header("Location: vacature.php");
        exit(); // Zorg ervoor dat je het script stopt na de redirect
    } else {
        echo "Fout bij het plaatsen van vacature: " . $conn->error;
    }
}

$conn->close();
?>

</html>