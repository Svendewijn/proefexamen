<?php
session_start(); // Start de sessie

// Controleer of de gebruiker is ingelogd
if (!isset($_SESSION['user_id'])) {
    header("Location: inlog.php"); // Redirect naar de inlogpagina als de gebruiker niet is ingelogd
    exit();
}

error_reporting(E_ALL ^ E_NOTICE);  

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
    $gebruiker_id = $_SESSION['user_id']; // Haal de user_id uit de sessie

    // SQL-instructie om gegevens in te voegen
    $sql = "INSERT INTO vacatureposts (titel, beschrijving, locatie, salaris, gebruiker_id) VALUES ('$titel', '$beschrijving', '$locatie', '$salaris', '$gebruiker_id')";

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

<!DOCTYPE html>
<html lang="nl">
<head>
    <link rel="stylesheet" href="css/vacature.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>vacature</title>
</head>
<body>
<?php include("header.php");?>
<center>
    <div class="vacatureForm">
        <form action="vacaturepost.php" method="post">
            <h2>Vacature aanmaken</h2>
            <label for="titel">Titel:</label>
            <br>
            <input type="text" id="titel" name="titel" required>
            <br>
            <label for="beschrijving">Beschrijving:</label>
            <br>
            <textarea id="beschrijving" name="beschrijving" class="beschrijving" placeholder="Iets over uw bedrijf en/of contactgegevens" required></textarea>
            <br>
            <label for="locatie">Locatie:</label>
            <br>
            <input type="text" id="locatie" name="locatie" required>
            <br>
            <label for="salaris">Salaris:</label>
            <br>
            <input type="number" id="salaris" name="salaris" step="0.01">
            <br>
            <input type="submit" class="submitVacature" value="Plaats Vacature">
        </form>
    </div>
</center>
<?php include("footer.php");?>
</body>
</html>