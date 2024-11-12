<?php
session_start(); // Start de sessie om toegang te krijgen tot sessievariabelen
?>

<div class="header">
    <a href="#home">Bestand</a> |
    <a href="#over">Bekijk</a> |
    <a href="#contact">Help</a>
    
    <?php if (isset($_SESSION['user_id'])): // Controleer of de gebruiker is ingelogd ?>
        <a href="logout.php">Uitloggen</a>
    <?php else: ?>
        <a href="inlog.php">Login</a>
    <?php endif; ?>
</div>