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
    $email = htmlspecialchars(trim($_POST['email']));
    $password = htmlspecialchars(trim($_POST['password']));
    
    // Rol ophalen uit de dropdown
    $rol = htmlspecialchars(trim($_POST['rol']));

    // Wachtwoord hashen voor veiligheid
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // SQL-query om gegevens in te voegen in de tabel 'gebruikers'
    $sql = "INSERT INTO gebruikers (gebruikersnaam, email, wachtwoord, rol) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $username, $email, $hashed_password, $rol);

    // Voer de query uit en controleer of het gelukt is
    if ($stmt->execute()) {
        echo "Registratie succesvol!";
    } else {
        echo "Fout bij registratie: " . $stmt->error;
    }

    // Sluit de statement en de verbinding
    $stmt->close();
} else {
    echo "Ongeldige aanvraagmethode.";
}

$conn->close();
?>