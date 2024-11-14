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

// Verkrijg het vacature_id van de POST-gegevens
if (isset($_POST['vacature_id'])) {
    $vacature_id = intval($_POST['vacature_id']);

    // Controleer of de gebruiker een admin is of de eigenaar van de vacature
    $user_id = $_SESSION['user_id'];
    $sql = "SELECT gebruiker_id FROM vacatureposts WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $vacature_id);
    $stmt->execute();
    $stmt->bind_result($gebruiker_id);
    $stmt->fetch();
    $stmt->close();

    // Controleer of de gebruiker de vacature heeft geplaatst of admin is
    if ($gebruiker_id === $user_id || $_SESSION['rol'] === 'admin') {
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
        die("Toegang geweigerd. Je hebt geen toestemming om deze vacature te verwijderen.");
    }
} else {
    echo "Geen vacature ID opgegeven.";
}

$conn->close();

// Redirect terug naar de vacaturepagina
header("Location: vacature.php");
exit();
?>