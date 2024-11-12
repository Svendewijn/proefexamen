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

    // Verwerk video
    if (isset($_FILES['video']) && $_FILES['video']['error'] == 0) {
        $video_path = 'uploads/videos/' . basename($_FILES['video']['name']);
        move_uploaded_file($_FILES['video']['tmp_name'], $video_path);

        // Sla de video upload in de database op
        $stmt = $conn->prepare("INSERT INTO uploads (user_id, file_type, file_path) VALUES (?, ?, ?)");
        $file_type = 'video';
        $stmt->bind_param("iss", $user_id, $file_type, $video_path);
        $stmt->execute();
        $stmt->close();
    }

    // Verwerk CV
    if (isset($_FILES['cv']) && $_FILES['cv']['error'] == 0) {
        $cv_path = 'uploads/cvs/' . basename($_FILES['cv']['name']);
        move_uploaded_file($_FILES['cv']['tmp_name'], $cv_path);

        // Sla de CV upload in de database op
        $stmt = $conn->prepare("INSERT INTO uploads (user_id, file_type, file_path) VALUES (?, ?, ?)");
        $file_type = 'cv';
        $stmt->bind_param("iss", $user_id, $file_type, $cv_path);
        $stmt->execute();
        $stmt->close();
    }

    // Verwerk tekst
    if (!empty($text)) {
        // Sla de tekst upload in de database op
        $stmt = $conn->prepare("INSERT INTO uploads (user_id, file_type, file_path) VALUES (?, ?, ?)");
        $file_type = 'text';
        $text_path = 'uploads/texts/' . uniqid() . '.txt'; // Unieke naam voor tekstbestand
        file_put_contents($text_path, $text); // Sla de tekst op in een bestand
        $stmt->bind_param("iss", $user_id, $file_type, $text_path);
        $stmt->execute();
        $stmt->close();
    }

    echo "Bestanden succesvol geüpload!";
} else {
    echo "Ongeldige aanvraagmethode.";
}

$conn->close();
?>