<?php
session_start();
session_destroy(); // Vernietig de sessie
header("Location: index.php"); // Redirect naar de inlogpagina
exit();
?>