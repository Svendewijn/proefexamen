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

// Check what types of files have already been uploaded by the user
$stmt = $conn->prepare("SELECT DISTINCT file_type FROM uploads WHERE gebruiker_id = ?");
$stmt->bind_param("i", $gebruiker_id);
$stmt->execute();
$result = $stmt->get_result();

$uploaded_types = [];
while ($row = $result->fetch_assoc()) {
    $uploaded_types[] = $row['file_type'];
}
$stmt->close();

// Determine which file types are allowed for upload
$allowed_types = ['text', 'video', 'cv'];
$remaining_uploads = array_diff($allowed_types, $uploaded_types);

// Check if the user can upload any files
if (count($uploaded_types) >= 2) {
    echo "Je hebt al meer bestandstypen geüpload. Geen nieuwe uploads toegestaan.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Verwerk tekst
    if (in_array('text', $remaining_uploads) && isset($_POST['text'])) {
        $text = $_POST['text'];
        $file_name = 'tekstbestand_' . time(); // Use a unique name for each text entry
        $file_type = 'text';

        // Insert the text file
        $stmt = $conn->prepare("INSERT INTO uploads (gebruiker_id, file_type, file_data, file_name) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("isss", $gebruiker_id, $file_type, $text, $file_name);
        $stmt->execute();
        $stmt->close();
        echo "Tekstbestand succesvol geüpload!";
    }

    // Verwerk video-upload
    if (in_array('video', $remaining_uploads) && isset($_FILES['video']) && $_FILES['video']['error'] == 0) {
        $allowed_types = ['video/mp4', 'video/quicktime'];
        $file_type = $_FILES['video']['type'];
        $file_name = $_FILES['video']['name'];

        if (in_array($file_type, $allowed_types)) {
            // Insert the video file
            $video_data = file_get_contents($_FILES['video']['tmp_name']);
            $stmt = $conn->prepare("INSERT INTO uploads (gebruiker_id, file_type, video_data, file_name) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("isss", $gebruiker_id, $file_type, $video_data, $file_name);
            $stmt->execute();
            $stmt->close();
            echo "Video succesvol geüpload!";
        } else {
            echo "Ongeldig bestandstype voor video. Alleen MP4 en MOV zijn toegestaan.";
        }
    }

    // Verwerk CV
    if (in_array('cv', $remaining_uploads) && isset($_FILES['cv']) && $_FILES['cv']['error'] == 0) {
        $allowed_types = ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];
        $file_type = $_FILES['cv']['type'];
        $file_name = $_FILES['cv']['name'];

        if (in_array($file_type, $allowed_types)) {
            // Insert the CV file
            $cv_data = file_get_contents($_FILES['cv']['tmp_name']);
            $stmt = $conn->prepare("INSERT INTO uploads (gebruiker_id, file_type, file_data, file_name) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("isss", $gebruiker_id, $file_type, $cv_data, $file_name);
            $stmt->execute();
            $stmt->close();
            echo "CV succesvol geüpload!";
        } else {
            echo "Ongeldig bestandstype voor CV. Alleen PDF, DOC en DOCX zijn toegestaan.";
        }
    }
} else {
    echo "Ongeldige aanvraagmethode.";
}

$conn->close();
?>