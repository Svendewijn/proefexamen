<?php
session_start(); // Start de sessie

if (!isset($_SESSION['user_id'])) {
    die("Je moet ingelogd zijn om deze pagina te gebruiken.");
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

// Haal vacatures op met gebruikersinformatie
$sql = "SELECT vp.*, g.gebruikersnaam, g.rol 
        FROM vacatureposts vp 
        JOIN gebruikers g ON vp.gebruiker_id = g.id 
        ORDER BY vp.datum_geplaatst DESC";
$result = $conn->query($sql);

// Haal de rol van de ingelogde gebruiker op
$rol = isset($_SESSION['rol']) ? $_SESSION['rol'] : ''; 
$user_id = $_SESSION['user_id']; // Haal de ingelogde gebruiker ID op

?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <link rel="stylesheet" href="css/vacature.css">
    <meta charset="UTF-8">
    <title>Vacatures</title>
</head>
<body>
<?php include("header.php");?>
<div class="marginleft10px">
    <h1>Vacatures</h1>
    <a href="vacaturepost.php" class="vacature-button">Plaats Vacature</a>
</div>

<?php
if ($result->num_rows > 0) {
    // Loop door de vacatures en toon ze
    while ($row = $result->fetch_assoc()) {
        echo "<div class='vacature'><a href='vacature_detail.php?id=" . $row['id'] . "'>";
        echo "<h2>" . htmlspecialchars($row['titel']) . "</h2>";
        echo "<p>" . htmlspecialchars($row['beschrijving']) . "</p>";
        echo "<p><strong>Locatie:</strong> " . htmlspecialchars($row['locatie']) . "</p>";
        echo "<p><strong>Salaris:</strong> €" . htmlspecialchars($row['salaris']) . "</p>";
        echo "<p><strong>Geplaatst door:</strong> " . htmlspecialchars($row['gebruikersnaam']) . "</p>"; // Gebruikersnaam tonen
        echo "<p><em>Geplaatst op: " . $row['datum_geplaatst'] . "</em></p>";
        echo "</a>";

        // Voeg de delete-knop toe als de gebruiker een admin is of de eigenaar van de vacature
        if ($rol === 'admin' || $row['gebruiker_id'] == $user_id) {
            echo "<form action='delete_vacature.php' method='POST' style='display:inline;'>";
            echo "<input type='hidden' name='vacature_id' value='" . $row['id'] . "'>";
            echo "<input type='submit' value='Verwijder' onclick='return confirm(\"Weet je zeker dat je deze vacature wilt verwijderen?\");'>";
            echo "</form>";
        } else {
            echo "<p>Deze gebruiker heeft geen rechten om vacatures te verwijderen.</p>"; // Debugging
        }

        echo "</div><br>";
    }
} else {
    echo "<p>Geen vacatures gevonden.</p>";
}

$conn->close();
?>

<?php include("footer.php");?>
</body>
</html>