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

// Verkrijg het ID van het bestand dat gedownload moet worden
$file_id = $_GET['id'] ?? null;

if ($file_id) {
    // Haal het bestand op uit de database
    $stmt = $conn->prepare("SELECT file_name, file_data, file_type FROM uploads WHERE id = ? AND gebruiker_id = ?");
    $stmt->bind_param("ii", $file_id, $gebruiker_id);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($file_name, $file_data, $file_type);
        $stmt->fetch();

        // Stel de headers in voor het downloaden
        header('Content-Description: File Transfer');
        header('Content-Type: ' . $file_type);
        header('Content-Disposition: attachment; filename="' . basename($file_name) . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header(' Pragma: public');
        header('Content-Length: ' . strlen($file_data));
        header('Connection: close');

        // Stuur het bestand naar de browser
        echo $file_data;
        exit;
    } else {
        echo "Bestand niet gevonden.";
    }

    $stmt->close();
} else {
    echo "Geen bestand opgegeven.";
}

$conn->close();
?>