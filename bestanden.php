<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    die("Je moet ingelogd zijn om deze pagina te gebruiken.");
}

echo "Script wordt uitgevoerd"; // Debugging line

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
$stmt = $conn->prepare("SELECT id, file_name, file_type, video_data FROM uploads WHERE gebruiker_id = ?");
$stmt->bind_param("i", $gebruiker_id);
$stmt->execute();
$result = $stmt->get_result();

// Controleer of er bestanden zijn
if ($result->num_rows > 0) {
    echo "<h1>Beschikbare Bestanden</h1>";
    while ($row = $result->fetch_assoc()) {
        echo "<h2>" . htmlspecialchars($row['file_name']) . "</h2>";
        echo "<p>Bestandstype: " . htmlspecialchars($row['file_type']) . "</p>"; // Debugging line

        // Check if the file type is a video
        if (in_array($row['file_type'], ['video/mp4', 'video/quicktime'])) {
            // Embed the video directly
            echo "<video width='640' height='480' controls>
                    <source src='data:" . htmlspecialchars($row['file_type']) . ";base64," . base64_encode($row['video_data']) . "' type='" . htmlspecialchars($row['file_type']) . "'>
                    Your browser does not support the video tag.
                  </video>";
        } else {
            // Voeg een downloadlink toe voor andere bestandstypen
            echo "<a href='download.php?id=" . $row['id'] . "'>Download " . htmlspecialchars($row['file_name']) . "</a>";
        }
    }
} else {
    echo "Geen bestanden beschikbaar.";
}

$stmt->close();
$conn->close();
?>