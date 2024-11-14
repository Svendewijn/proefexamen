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
        $file_name = 'tekstbestand_' . time(); // Use a unique name for each text entry
        $file_type = 'text';

        // Check if the text already exists
        $stmt = $conn->prepare("SELECT COUNT(*) FROM uploads WHERE gebruiker_id = ? AND file_type = ? AND file_data = ?");
        $stmt->bind_param("iss", $gebruiker_id, $file_type, $text);
        $stmt->execute();
        $stmt->bind_result($count);
        $stmt->fetch();
        $stmt->close();

        if ($count == 0) { // Only insert if it doesn't exist
            $stmt = $conn->prepare("INSERT INTO uploads (gebruiker_id, file_type, file_data, file_name) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("isss", $gebruiker_id, $file_type, $text, $file_name);
            $stmt->execute();
            $stmt->close();
            echo "Tekstbestand succesvol geüpload!";
        } else {
            echo "Je hebt al een identiek tekstbestand geüpload.";
        }
    }

    // Verwerk video-upload
    if (isset($_FILES['video']) && $_FILES['video']['error'] == 0) {
        $allowed_types = ['video/mp4', 'video/quicktime'];
        $file_type = $_FILES['video']['type'];
        $file_name = $_FILES['video']['name'];

        if (in_array($file_type, $allowed_types)) {
            // Check for duplicates based on file name and type
            $stmt = $conn->prepare("SELECT COUNT(*) FROM uploads WHERE gebruiker_id = ? AND file_name = ? AND file_type = 'video'");
            $stmt->bind_param("is", $gebruiker_id, $file_name);
            $stmt->execute();
            $stmt->bind_result($count);
            $stmt->fetch();
            $stmt->close();

            if ($count == 0) { // Controleer of er al een video met dezelfde naam is
                $video_data = file_get_contents($_FILES['video']['tmp_name']);
                $stmt = $conn->prepare("INSERT INTO uploads (gebruiker_id, file_type, video_data, file_name) VALUES (?, ?, ?, ?)");
                $stmt->bind_param("isss", $gebruiker_id, $file_type, $video_data, $file_name);
                $stmt->execute();
                $stmt->close();
                echo "Video succesvol geüpload!";
            } else {
                echo "Je hebt al een video met deze naam geüpload.";
            }
        } else {
            echo "Ongeldig bestandstype voor video. Alleen MP4 en MOV zijn toegestaan.";
        }
    }

    // Verwerk CV
    if (isset($_FILES['cv']) && $_FILES['cv']['error'] == 0) {
        $allowed_types = ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];
        $file_type = $_FILES['cv']['type'];
        $file_name = $_FILES['cv']['name'];

        if (in_array($file_type, $allowed_types)) {
            // Check for duplicates based on file name and type
            $stmt = $conn->prepare("SELECT COUNT(*) FROM uploads WHERE gebruiker_id = ? AND file_name = ? AND file_type = 'cv'");
            $stmt->bind_param("is", $gebruiker_id, $file_name);
            $stmt->execute();
            $stmt->bind_result($count);
            $stmt->fetch();
            $stmt->close();

            if ($count == 0) { // Controleer of er al een CV met dezelfde naam is
                $cv_data = file_get_contents($_FILES['cv']['tmp_name']);
                $stmt = $conn->prepare("INSERT INTO uploads (gebruiker_id, file_type, file_data, file_name) VALUES (?, ?, ?, ?)");
                $file_type = 'cv';
                $stmt->bind_param("isss", $gebruiker_id, $file_type, $cv_data, $file_name);
                $stmt->execute();
                $stmt->close();
                echo "CV succesvol geüpload!";
            } else {
                echo "Je hebt al een CV met deze naam geüpload.";
            }
        } else {
            echo "Ongeldig bestandstype voor CV. Alleen PDF, DOC en DOCX zijn toegestaan.";
        }
    }
} else {
    echo "Ongeldige aanvraagmethode.";
}

$conn->close();
?>