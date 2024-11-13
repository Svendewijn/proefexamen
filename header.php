<?php
session_start(); // Start de sessie om toegang te krijgen tot sessievariabelen
?>
    <link rel="stylesheet" href="css/styling.css">
<div class="header">
    <div class="header-contents">
    <a href="index.php">
    <img src="images/logo.png" alt="logo" width="50" height="25">
    </a>
    <div class="header-text">
        
    <a href="voorlichting.php">Voorlichting</a> &nbsp;|&nbsp;
    <a href="vacature.php">Vacatures</a> &nbsp;|&nbsp; 
    <a href="index.php">Cv's</a> &nbsp;|&nbsp; 
    <a href="index.php">Help</a> &nbsp;|&nbsp; 
    
    <?php if (isset($_SESSION['user_id'])): // Controleer of de gebruiker is ingelogd ?>
        <a href="upload.php">Upload</a> &nbsp;|&nbsp;
        <a href="logout.php">Uitloggen</a>
    <?php else: ?>
        <a href="inlog.php">Login</a>
    <?php endif; ?>
    </div>
    </div>
</div>