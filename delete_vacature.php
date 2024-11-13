<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['rol'] !== 'admin') {
    die("Toegang geweigerd.");
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

// Verkrijg het vacature_id van de POST-gegevens
if (isset($_POST['vacature_id'])) {
    $vacature_id = intval($_POST['vacature_id']);

    // Voer de delete-query uit
    $sql = "DELETE FROM vacatureposts WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $vacature_id);

    if ($stmt->execute()) {
        echo "Vacature succesvol verwijderd.";
    } else {
        echo "Fout bij het verwijderen van de vacature: " . $conn->error;
    }

    $stmt->close();
} else {
    echo "Geen vacature ID opgegeven.";
}

$conn->close();

// Redirect terug naar de vacaturepagina
header("Location: vacature.php");
exit();
?>