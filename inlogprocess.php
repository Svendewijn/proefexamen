<?php
// Start de sessie
session_start();

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
    $sql = "SELECT id, wachtwoord FROM gebruikers WHERE gebruikersnaam = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    // Controleer of de gebruiker bestaat
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($user_id, $hashed_password);
        $stmt->fetch();

        // Controleer het wachtwoord
        if (password_verify($password, $hashed_password)) {
            // Sla de gebruikersinformatie op in de sessie
            $_SESSION['user_id'] = $user_id; // Sla de gebruikers-ID op in de sessie
            $_SESSION['username'] = $username; // Sla de gebruikersnaam op in de sessie

            // Redirect naar de oorspronkelijke pagina of naar een standaardpagina
            $redirect_url = isset($_SESSION['redirect_after_login']) ? $_SESSION['redirect_after_login'] : 'index.php';
            unset($_SESSION['redirect_after_login']); // Verwijder de redirect sessievariabele
            header("Location: $redirect_url");
            exit();
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