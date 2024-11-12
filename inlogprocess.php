<?php
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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verzamel en saniteer de invoergegevens
    $username = htmlspecialchars(trim($_POST['username']));
    $password = htmlspecialchars(trim($_POST['password']));

    // SQL-query om de gebruiker op te halen
    $sql = "SELECT wachtwoord FROM gebruikers WHERE gebruikersnaam = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    // Controleer of de gebruiker bestaat
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($hashed_password);
        $stmt->fetch();

        // Controleer het wachtwoord
        if (password_verify($password, $hashed_password)) {
            echo "Inloggen succesvol! Welkom, " . $username . ".";
            // Hier kun je sessies starten of doorverwijzen naar een andere pagina
        } else {
            echo "Ongeldige gebruikersnaam of wachtwoord.";
        }
    } else {
        echo "Ongeldige gebruikersnaam of wachtwoord.";
    }

    // Sluit de statement en de verbinding
    $stmt->close();
} else {
    echo "Ongeldige aanvraagmethode.";
}

$conn->close();
?>