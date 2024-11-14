<?php
session_start(); // Start de sessie om toegang te krijgen tot sessievariabelen
?>

<link rel="stylesheet" href="css/styling.css">
<script>
    let secretCode = 'xxl'; // De geheime code
    let input = ''; // Huidige invoer van de gebruiker
    let codeTyped = false; // Vlag om bij te houden of de code is getypt

    // Functie om de grootte van het logo te vergroten met 10%
    function enlargeLogo(event) {
        event.preventDefault(); // Voorkom dat de link wordt gevolgd
        const logo = document.getElementById('logo');
        let currentWidth = logo.width;
        let currentHeight = logo.height;

        // Vergroot de breedte en hoogte met 10%
        logo.width = currentWidth * 1.1; // Vergroot de breedte met 10%
        logo.height = currentHeight * 1.1; // Vergroot de hoogte met 10%
    }

    // Event listener voor toetsaanslagen
    document.addEventListener('keydown', function(event) {
        input += event.key; // Voeg de ingedrukte toets toe aan de invoer

        // Controleer of de invoer de geheime code bevat
        if (input.includes(secretCode)) {
            codeTyped = true; // Zet de vlag op true als de code is getypt
            input = ''; // Reset de invoer

            // Maak de link niet-klikbaar door de href te verwijderen
            const logoLink = document.getElementById('logo-link');
            logoLink.removeAttribute('href'); // Verwijder de href
            logoLink.onclick = function(event) { enlargeLogo(event); }; // Voeg een klik-event toe
        }
    });

    // Update de tekst bij het laden van de pagina
    window.onload = function() {
        // Geen tekst meer tonen
    };
</script>

<div class="header">
    <div class="header-contents">
        <a id="logo-link" href="index.php">
            <img id="logo" src="images/logo.png" alt="logo" width="50" height="25">
        </a>
        <div id="mode-text" style="margin-top: 10px; font-size: 14px; color: #555; display: none;">
            <!-- Deze tekst is nu verborgen -->
        </div>
        <div class="header-text">
            <a href="voorlichting.php">Voorlichting</a> &nbsp;|&nbsp;
            <a href="vacature.php">Vacatures</a> &nbsp;|&nbsp; 
            <a href="werknemers.php">Cv's</a> &nbsp;|&nbsp; 
            <a href="index.php">Help</a> &nbsp;|&nbsp; 
            <a href="instellingen.php">Instellingen</a> &nbsp;|&nbsp; 

            <?php if (isset($_SESSION['user_id'])): // Controleer of de gebruiker is ingelogd ?>
                <a href="upload.php">Upload</a> &nbsp;|&nbsp;
                <a href="logout.php">Uitloggen</a>
            <?php else: ?>
                <a href="inlog.php">Login</a>
            <?php endif; ?>
        </div>
    </div>
</div>