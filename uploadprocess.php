<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    die("Je moet ingelogd zijn om deze pagina te gebruiken.");
}

$user_id = $_SESSION['user_id'];

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
    $text = $_POST['text'];

    // Sla de tekst op in de database
    if (!empty($text)) {
        $stmt = $conn->prepare("INSERT INTO uploads (user_id, file_type, file_data) VALUES (?, ?, ?)");
        $file_type = 'text';
        $stmt->bind_param("iss", $user_id, $file_type, $text);
        $stmt->execute();
        $stmt->close();
    }

    // Verwerk YouTube-link
    if (!empty($_POST['video_link'])) {
        $video_link = $_POST['video_link'];

        // Valideer de YouTube-link
        if (preg_match('/^(https?:\/\/)?(www\.)?(youtube\.com|youtu\.?be)\/.+$/', $video_link)) {
            // Sla de YouTube-link op in de database
            $stmt = $conn->prepare("INSERT INTO uploads (user_id, file_type, file_data) VALUES (?, ?, ?)");
            $file_type = 'video';
            $stmt->bind_param("iss", $user_id, $file_type, $video_link);
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

        // Controleer of het bestandstype geldig is
        if (in_array($file_type, $allowed_types)) {
            $cv_data = file_get_contents($_FILES['cv']['tmp_name']); // Lees de inhoud van het bestand

            // Sla de CV upload in de database op
            $stmt = $conn->prepare("INSERT INTO uploads (user_id, file_type, file_data) VALUES (?, ?, ?)");
            $file_type = 'cv';
            $stmt->bind_param("iss", $user_id, $file_type, $cv_data);
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