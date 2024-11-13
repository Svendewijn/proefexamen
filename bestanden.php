<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    die("Je moet ingelogd zijn om deze pagina te gebruiken.");
}

$gebruiker_id = $_SESSION['user_id'];

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

// Haal bestanden op voor de ingelogde gebruiker
$stmt = $conn->prepare("SELECT id, file_name, file_type, file_data, video_data FROM uploads WHERE gebruiker_id = ?");
$stmt->bind_param("i", $gebruiker_id);
$stmt->execute();
$result = $stmt->get_result();

// Controleer of er bestanden zijn
if ($result->num_rows > 0) {
    echo "<h1>Beschikbare Bestanden</h1>";
    while ($row = $result->fetch_assoc()) {
        // Controleer of het bestandstype een video is
        if (in_array($row['file_type'], ['video/mp4', 'video/quicktime'])) {
            // Embed de video direct
            echo "<h2>" . htmlspecialchars($row['file_name']) . "</h2>";
            echo "<video width='640' height='480' controls>
                    <source src='data:" . htmlspecialchars($row['file_type']) . ";base64," . base64_encode($row['video_data']) . "' type='" . htmlspecialchars($row['file_type']) . "'>
                    Your browser does not support the video tag.
                  </video>";
        } elseif ($row['file_type'] == 'text') {
            // Voor tekst, toon de inhoud
            echo "<h2>" . htmlspecialchars($row['file_name']) . "</h2>";
            echo "<p>" . nl2br(htmlspecialchars($row['file_data'])) . "</p>"; // Gebruik nl2br om nieuwe regels te behouden
        } else {
            // Voor andere bestandstypen, toon de bestandsnaam als een downloadlink
            echo "<h2><a href='download.php?id=" . $row['id'] . "'>" . htmlspecialchars($row['file_name']) . "</a></h2>";
        }
    }
} else {
    echo "Geen bestanden beschikbaar.";
}

$stmt->close();
$conn->close();
?>