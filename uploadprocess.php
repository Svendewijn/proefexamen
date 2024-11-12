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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Verwerk tekst
    $text = $_POST['text'] ?? null;

    // Sla de tekst op in de database
    if (!empty($text)) {
        $stmt = $conn->prepare("INSERT INTO uploads (gebruiker_id, file_type, file_data, file_name) VALUES (?, ?, ?, ?)");
        $file_type = 'text';
        $file_name = 'tekstbestand.txt'; // Geef hier een naam voor het tekstbestand
        $stmt->bind_param("isss", $gebruiker_id, $file_type, $text, $file_name);
        $stmt->execute();
        $stmt->close();
    }

    // Verwerk YouTube-link
    if (!empty($_POST['video_link'])) {
        $video_link = $_POST['video_link'];

        // Valideer de YouTube-link
        if (preg_match('/^(https?:\/\/)?(www\.)?(youtube\.com|youtu\.?be)\/.+$/', $video_link)) {
            // Sla de YouTube-link op in de database
            $stmt = $conn->prepare("INSERT INTO uploads (gebruiker_id, file_type, file_data, file_name) VALUES (?, ?, ?, ?)");
            $file_type = 'video';
            $file_name = 'video_link'; // Geef hier een naam voor de video
            $stmt->bind_param("isss", $gebruiker_id, $file_type, $video_link, $file_name);
            $stmt->execute();
            $stmt->close();
        } else {
            echo "Ongeldige YouTube-link. Zorg ervoor dat je een correcte link invoert.";
        }
    }

    // Verwerk CV
    if (isset($_FILES['cv']) && $_FILES['cv']['error'] == 0) {
        $allowed_types = ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document']; // PDF, DOC, DOCX
        $file_type = $_FILES['cv']['type'];
        $file_name = $_FILES['cv']['name']; // Gebruik de originele bestandsnaam

        // Controleer of het bestandstype geldig is
        if (in_array($file_type, $allowed_types)) {
            $cv_data = file_get_contents($_FILES['cv']['tmp_name']); // Lees de inhoud van het bestand

            // Sla de CV upload in de database op
            $stmt = $conn->prepare("INSERT INTO uploads (gebruiker_id, file_type, file_data, file_name) VALUES (?, ?, ?, ?)");
            $file_type = 'cv';
            $stmt->bind_param("isss", $gebruiker_id, $file_type, $cv_data, $file_name);
            $stmt->execute();
            $stmt->close();
        } else {
            echo "Ongeldig bestandstype voor CV. Alleen PDF, DOC en DOCX zijn toegestaan.";
        }
    }

    echo "Bestanden succesvol geüpload!";
} else {
    echo "Ongeldige aanvraagmethode.";
}

$conn->close();
?>