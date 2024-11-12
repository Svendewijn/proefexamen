<?php
session_start(); // Start de sessie om toegang te krijgen tot sessievariabelen
?>

<div class="header">

    <a href="vacature.php">Bestand</a> |
    <a href="index.php">Bekijk</a> |
    <a href="index.php">Help</a> |
    
    <?php if (isset($_SESSION['user_id'])): // Controleer of de gebruiker is ingelogd ?>
        <a href="logout.php">Uitloggen</a>
    <?php else: ?>
        <a href="inlog.php">Login</a>
    <?php endif; ?>
</div>