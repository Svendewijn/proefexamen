<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profiel</title>
    <link rel="stylesheet" href="css/styling.css">
</head>
<body>
<?php include 'header.php'; ?>

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

// Haal de gebruiker ID op uit de URL
if (isset($_GET['id'])) {
    $userId = intval($_GET['id']); // Zorg ervoor dat de ID een integer is

    // Haal gebruikersgegevens op
    $stmtUser  = $conn->prepare("SELECT gebruikersnaam, email FROM gebruikers WHERE id = ?");
    $stmtUser ->bind_param("i", $userId);
    $stmtUser ->execute();
    $resultUser  = $stmtUser ->get_result();

    if ($resultUser ->num_rows > 0) {
        $user = $resultUser ->fetch_assoc();
        echo "<h2>" . htmlspecialchars($user['gebruikersnaam']) . "'s Profiel</h2>";
        echo "<p>Email: " . htmlspecialchars($user['email']) . "</p>";
    } else {
        echo "Geen gebruiker gevonden.";
    }

    // Haal bestanden op voor de geselecteerde gebruiker
    $stmtFiles = $conn->prepare("SELECT id, file_name, file_type, file_data, video_data FROM uploads WHERE gebruiker_id = ?");
    $stmtFiles->bind_param("i", $userId);
    $stmtFiles->execute();
    $resultFiles = $stmtFiles->get_result();

    // Controleer of er bestanden zijn
    if ($resultFiles->num_rows > 0) {
        while ($row = $resultFiles->fetch_assoc()) {
            // Debug: Print de gegevens van het bestand
            // var_dump($row); // Uncomment deze regel voor debugging

            // Controleer of het bestandstype een video is
            if (in_array($row['file_type'], ['video/mp4', 'video/quicktime'])) {
                // Embed de video direct
                echo "<video width='640' height='480' controls>
                        <source src='data:" . htmlspecialchars($row['file_type']) . ";base64," . base64_encode($row['video_data']) . "' type='" . htmlspecialchars($row['file_type']) . "'>
                        Your browser does not support the video tag.
                    </video>";
            } elseif ($row['file_type'] == 'text') {
                // Voor tekst, toon alleen de inhoud zonder bestandsnaam
                echo "<p>" . nl2br(htmlspecialchars($row['file_data'])) . "</p>"; // Gebruik nl2br om nieuwe regels te behouden
            } else {
                // Voor andere bestandstypen, toon de bestandsnaam als een downloadlink
                echo "<h2><a href='download.php?id=" . $row['id'] . "'>" . htmlspecialchars($row['file_name']) . "</a></h2>";
            }
        }
    } else {
        echo "Geen bestanden beschikbaar voor deze gebruiker.";
    }

    $stmtUser ->close();
    $stmtFiles->close();
} else {
    echo "Geen gebruiker ID opgegeven.";
}

$conn->close();
?>

<?php include 'footer.php'; ?>
</body>
</html>