<?php
session_start(); // Start de sessie

// Verbind met de database
$servername = "localhost";
$username = "root"; // Of je eigen gebruikersnaam
$password = ""; // Of je eigen wachtwoord
$dbname = "XXL_database"; // Vervang dit door de naam van je database

$conn = new mysqli($servername, $username, $password, $dbname);

// Controleer de verbinding
if ($conn->connect_error) {
    die("Verbinding mislukt: " . $conn->connect_error);
}

// Zorg ervoor dat de gebruiker is ingelogd
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect naar de inlogpagina
    exit();
}

// Haal gebruikersgegevens op
$user_id = $_SESSION['user_id'];
$sql = "SELECT gebruikersnaam FROM gebruikers WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Haal uploads op voor de ingelogde gebruiker
$sql_uploads = "SELECT file_type, file_data FROM uploads WHERE gebruiker_id = ?"; // Gebruik gebruiker_id in plaats van user_id
$stmt_uploads = $conn->prepare($sql_uploads);
$stmt_uploads->bind_param("i", $user_id);
$stmt_uploads->execute();
$result_uploads = $stmt_uploads->get_result();

$stmt->close();
$stmt_uploads->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profiel</title>
    <link rel="stylesheet" href="css/styling.css"> <!-- Zorg ervoor dat het pad correct is -->
</head>
<body>
<?php include 'header.php'; ?> <!-- Include de header -->

<h1>Profiel van <?php echo htmlspecialchars($user['gebruikersnaam']); ?></h1>

<h2>Uploads</h2>
<?php if ($result_uploads->num_rows > 0): ?>
    <ul>
        <?php while ($upload = $result_uploads->fetch_assoc()): ?>
            <li>
                <?php if ($upload['file_type'] == 'video'): ?>
                    <h3>Video:</h3>
                    <iframe width="560" height="315" src="<?php echo htmlspecialchars($upload['file_data']); ?>" frameborder="0" allowfullscreen></iframe>
                <?php elseif ($upload['file_type'] == 'cv'): ?>
                    <h3>CV:</h3>
                    <a href="<?php echo htmlspecialchars($upload['file_data']); ?>" download><?php echo htmlspecialchars(basename($upload['file_data'])); ?></a>
                <?php elseif ($upload['file_type'] == 'text' || pathinfo($upload['file_data'], PATHINFO_EXTENSION) == 'docx'): ?>
                    <h3>Document:</h3>
                    <a href="<?php echo htmlspecialchars($upload['file_data']); ?>" download><?php echo htmlspecialchars(basename($upload['file_data'])); ?></a>
                <?php else: ?>
                    <h3>Onbekend bestandstype:</h3>
                    <p><?php echo htmlspecialchars($upload['file_data']); ?></p>
                <?php endif; ?>
            </li>
        <?php endwhile; ?>
    </ul>
<?php else: ?>
    <p>Geen uploads beschikbaar.</p>
<?php endif; ?>

<?php include 'footer.php'; ?> <!-- Include de footer -->
</body>
</html>