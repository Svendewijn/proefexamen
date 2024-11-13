<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Werknemers</title>
    <link rel="stylesheet" href="css/styling.css">
</head>
<body>
<?php include 'header.php'; ?>

<h1>Lijst van Werknemers met CV's</h1>

<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    die("Je moet ingelogd zijn om deze pagina te gebruiken.");
}

// Databaseconfiguratie
$host = 'localhost';
$db = 'XXL_database';
$user = 'root'; // of jouw gebruikersnaam
$pass = ''; // of jouw wachtwoord

// Maak verbinding met de database
$conn = new mysqli($host, $user, $pass, $db);

// Controleer de verbinding
if ($conn->connect_error) {
    die("Verbinding mislukt: " . $conn->connect_error);
}

// Haal gebruikers op die een CV hebben geüpload
$sql = "SELECT g.id, g.gebruikersnaam, g.email 
        FROM gebruikers g 
        JOIN uploads u ON g.id = u.gebruiker_id 
        WHERE u.file_type = 'cv' 
        ORDER BY g.gebruikersnaam ASC";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table>";
    echo "<tr><th>Gebruikersnaam</th><th>Email</th><th>Acties</th></tr>";
    
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['gebruikersnaam']) . "</td>";
        echo "<td>" . htmlspecialchars($row['email']) . "</td>";
        echo "<td><a href='profiel.php?id=" . $row['id'] . "' class='btn'>Bekijk Profiel</a></td>";
        echo "</tr>";
    }
    
    echo "</table>";
} else {
    echo "Geen werknemers met CV's gevonden.";
}

$conn->close();
?>

<?php include 'footer.php'; ?>
</body>
</html>