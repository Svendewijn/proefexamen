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

// Haal vacatures op
$sql = "SELECT * FROM vacatureposts ORDER BY datum_geplaatst DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Vacatures</title>
</head>
<body>
    <h1>Vacatures</h1>

    <?php
    if ($result->num_rows > 0) {
        // Loop door de vacatures en toon ze
        while ($row = $result->fetch_assoc()) {
            echo "<div>";
            echo "<h2><a href='vacature_detail.php?id=" . $row['id'] . "'>" . htmlspecialchars($row['titel']) . "</a></h2>";
            echo "<p>" . htmlspecialchars($row['beschrijving']) . "</p>";
            echo "<p><strong>Locatie:</strong> " . htmlspecialchars($row['locatie']) . "</p>";
            echo "<p><strong>Salaris:</strong> €" . htmlspecialchars($row['salaris']) . "</p>";
            echo "<p><em>Geplaatst op: " . $row['datum_geplaatst'] . "</em></p>";
            echo "</div>";
            echo "<hr>";
        }
    } else {
        echo "<p>Geen vacatures gevonden.</p>";
    }

    $conn->close();
    ?>

    
</body>
</html>
