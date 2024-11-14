<?php
session_start(); // Zorg ervoor dat de sessie is gestart

error_reporting(E_ALL ^ E_NOTICE); 

// Databaseverbinding
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "XXL_database";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Verbinding mislukt: " . $conn->connect_error);
}

// Haal vacature-ID op
$vacature_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Opslaan van een nieuwe reactie
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_comment'])) {
    // Controleer of de gebruiker is ingelogd
    if (!isset($_SESSION['user_id'])) {
        echo "<p>Je moet ingelogd zijn om een reactie achter te laten.</p>";
    } else {
        // Gebruik de gebruikersnaam uit de sessie
        $naam = $_SESSION['username']; // Haal de gebruikersnaam uit de sessie
        $reactie = $conn->real_escape_string($_POST['reactie']);

        $insert_comment_sql = "INSERT INTO comments (vacature_id, naam, reactie) VALUES ($vacature_id, '$naam', '$reactie')";

        if ($conn->query($insert_comment_sql) === TRUE) {
            header("Location: vacature_detail.php?id=" . $vacature_id);
            exit();
        } else {
            echo "<p>Fout bij het plaatsen van de reactie: " . $conn->error . "</p>";
        }
    }
}

// Haal de specifieke vacature op
$sql = "SELECT * FROM vacatureposts WHERE id = $vacature_id";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <link rel="stylesheet" href="css/vacature.css">
    <meta charset="UTF-8">
    <title>Vacature Details</title>
</head>
<body>
    <?php include("header.php");?>
    <div class="vacature-container">
    <a href="vacature.php" class="vacature-button">Terug naar Vacatures</a>
        <?php
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            echo "<div class='vacature'><h1 class='vacature-titel'>" . htmlspecialchars($row['titel']) . "</h1>";
            echo "<p>" . htmlspecialchars($row['beschrijving']) . "</p>";
            echo "<p><strong>Locatie:</strong> " . htmlspecialchars($row['locatie']) . "</p>";
            echo "<p><strong>Salaris:</strong> €" . htmlspecialchars($row['salaris']) . "</p>";
            echo "<p><em>Geplaatst op: " . $row['datum_geplaatst'] . "</em></p></div>";
        } else {
            echo "<p>404 Vacature niet gevonden.</p>";
        }
        ?>

        <!-- Reacties tonen -->
        <h3>Reacties</h3>
        <?php
        $comment_sql = "SELECT * FROM comments WHERE vacature_id = $vacature_id ORDER BY datum_geplaatst DESC";
        $comment_result = $conn->query($comment_sql);

        if ($comment_result->num_rows > 0) {
            while ($comment_row = $comment_result->fetch_assoc()) {
                echo "<div>";
                echo "<p><strong>" . htmlspecialchars($comment_row['naam']) . "</strong> zei op " . $comment_row['datum_geplaatst'] . ":</p>";
                echo "<p>" . htmlspecialchars($comment_row['reactie']) . "</p>";

                // Voeg de delete-knop toe als de gebruiker een admin is
                if (isset($_SESSION['rol']) && $_SESSION['rol'] === 'admin') {
                    echo "<form action='delete_comment.php' method='POST' style='display:inline;'>";
                    echo "<input type='hidden' name='comment_id' value='" . $comment_row['id'] . "'>";
                    echo "<input type='submit' value='Verwijder' onclick='return confirm(\"Weet je zeker dat je deze reactie wilt verwijderen?\");' class='btn'>";
                    echo "</form>";
                }

                echo "</div><hr>";
            }
        } else {
            echo "<p>Geen reacties gevonden.</p>";
        }
        ?>

        <!-- Reactieformulier -->
        <h3>Laat een reactie achter</h3>
        <form action="" method="POST">
            <textarea name="reactie" required></textarea>
            <input type="submit" name="submit_comment" value="Plaats reactie" class="btn">
        </form>
    </div>
    <?php include("footer.php"); ?>
</body>
</html>
