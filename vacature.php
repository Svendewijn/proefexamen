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
    <link rel="stylesheet" href="css/vacature.css">
    <meta charset="UTF-8">
    <title>Vacatures</title>
</head>
<body>
    <div class="marginleft10px">
        <h1>Vacatures</h1>
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
            echo "<p><em>Geplaatst op: " . $row['datum_geplaatst'] . "</em></p>";
            echo "</a></div>";
            echo "<br>";
        }
    } else {
        echo "<p>Geen vacatures gevonden.</p>";
    }

    $conn->close();
    ?>

    
</body>
</html>
