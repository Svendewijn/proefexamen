<?php
session_start();

// Databaseverbinding
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "XXL_database";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Verbinding mislukt: " . $conn->connect_error);
}

// Controleer of de gebruiker een admin is
if (isset($_SESSION['rol']) && $_SESSION['rol'] === 'admin') {
    if (isset($_POST['comment_id'])) {
        $comment_id = (int)$_POST['comment_id'];

        // Verwijder de reactie uit de database
        $delete_sql = "DELETE FROM comments WHERE id = $comment_id";

        if ($conn->query($delete_sql) === TRUE) {
            header("Location: " . $_SERVER['HTTP_REFERER']); // Terug naar de vorige pagina
            exit();
        } else {
            echo "Fout bij het verwijderen van de reactie: " . $conn->error;
        }
    }
} else {
    echo "Je hebt geen toestemming om deze actie uit te voeren.";
}

$conn->close();
?>