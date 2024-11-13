<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instellingen</title>
    <link rel="stylesheet" href="css/styling.css">
</head>
<body>
<?php include 'header.php'; ?>

<div class="block-settings">
    <h1>Instellingen</h1>
    <button id="invertButton">Dark mode? soort van</button>
    
    <form action="instellingen.php" method="post">
        <label for="email">E-mail:</label>
        <input type="email" id="email" name="email" required>
        
        <label for="password">Nieuw Wachtwoord:</label>
        <input type="password" id="password" name="password" placeholder="Nieuw wachtwoord (laat leeg om niet te wijzigen)">
        
        <input type="submit" value="Opslaan">
    </form>
</div>

<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    die("Je moet ingelogd zijn om deze pagina te gebruiken.");
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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userId = $_SESSION['user_id'];
    $email = htmlspecialchars(trim($_POST['email']));
    $password = htmlspecialchars(trim($_POST['password']));

    // Update de e-mail
    $stmt = $conn->prepare("UPDATE gebruikers SET email = ? WHERE id = ?");
    $stmt->bind_param("si", $email, $userId);
    $stmt->execute();

    // Update het wachtwoord als het is ingevuld
    if (!empty($password)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("UPDATE gebruikers SET wachtwoord = ? WHERE id = ?");
        $stmt->bind_param("si", $hashed_password, $userId);
        $stmt->execute();
    }

    echo "Instellingen succesvol bijgewerkt!";
}

$conn->close();
?>

<script>
    const invertButton = document.getElementById('invertButton');
    
    invertButton.addEventListener('click', function() {
        document.body.classList.toggle('inverted');
    });
</script>

<?php include 'footer.php'; ?>
</body>
</html>