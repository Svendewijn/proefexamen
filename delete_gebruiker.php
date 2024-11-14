<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    die("Toegang geweigerd."); // Zorg ervoor dat de gebruiker is ingelogd
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

// Verkrijg het gebruiker_id van de GET-gegevens
if (isset($_GET['id'])) {
    $gebruiker_id = intval($_GET['id']);

    // Controleer of de ingelogde gebruiker het account wil verwijderen
    if ($gebruiker_id === $_SESSION['user_id']) {
        // Voer de delete-query uit om alle uploads van deze gebruiker te verwijderen
        $sql = "DELETE FROM uploads WHERE gebruiker_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $gebruiker_id);

        if ($stmt->execute()) {
            echo "Alle uploads zijn succesvol verwijderd.";
            // Optioneel: Redirect naar een andere pagina na het verwijderen
            header("Location: werknemers.php"); // Redirect naar de werknemerspagina
            exit();
        } else {
            echo "Fout bij het verwijderen van de uploads: " . $conn->error;
        }

        $stmt->close();
    } else {
        die("Toegang geweigerd. Je kunt alleen je eigen uploads verwijderen.");
    }
} else {
    echo "Geen gebruiker ID opgegeven.";
}

$conn->close();
?>