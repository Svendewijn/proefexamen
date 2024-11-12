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

// Haal bestanden op voor de ingelogde gebruiker
$stmt = $conn->prepare("SELECT id, file_name, file_type FROM uploads WHERE gebruiker_id = ?");
$stmt->bind_param("i", $gebruiker_id);
$stmt->execute();
$result = $stmt->get_result();

// Controleer of er bestanden zijn
if ($result->num_rows > 0) {
    echo "<h1>Beschikbare Bestanden</h1>";
    echo "<table border='1'>
            <tr>
                <th>Bestandsnaam</th>
                <th>Bestandstype</th>
                <th>Acties</th>
            </tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . htmlspecialchars($row['file_name']) . "</td>
                <td>" . htmlspecialchars($row['file_type']) . "</td>
                <td>
                    <a href='download.php?id=" . $row['id'] . "'>Download</a>
                </td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "Geen bestanden beschikbaar.";
}

$stmt->close();
$conn->close();
?>