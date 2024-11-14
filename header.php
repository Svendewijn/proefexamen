<?php
session_start(); // Start de sessie om toegang te krijgen tot sessievariabelen
?>

<link rel="stylesheet" href="css/styling.css">
<script>
    let secretCode = 'xxl';
    let input = '';
    let codeTyped = false;

    function enlargeLogo(event) {
        event.preventDefault();
        const logo = document.getElementById('logo');
        let currentWidth = logo.width;
        let currentHeight = logo.height;

        logo.width = currentWidth * 1.1;
        logo.height = currentHeight * 1.1;
    }

    document.addEventListener('keydown', function(event) {
        input += event.key;

        if (input.includes(secretCode)) {
            codeTyped = true;
            input = '';

            const logoLink = document.getElementById('logo-link');
            logoLink.removeAttribute('href');
            logoLink.onclick = function(event) { enlargeLogo(event); };
        }
    });

    // Update de tekst bij het laden van de pagina
    window.onload = function() {
        // Geen tekst meer tonen
    };

    const potgoudImageSrc = 'images/potgoud.jpg';
    const potgoudImageWidth = '200px';
    const potgoudImageHeight = '200px';
    let typedSequence = '';
    const targetSequence = 'grotepotgoud';

    document.addEventListener('keydown', function(event) {
        typedSequence += event.key;

        // Controleer of de sequence overeenkomt met de doelsequence
        if (typedSequence === targetSequence) {
            const clonePotgoud = setInterval(() => {
                const potgoudImage = document.createElement('img');
                potgoudImage.src = potgoudImageSrc;
                potgoudImage.style.position = 'absolute';
                potgoudImage.style.width = potgoudImageWidth;
                potgoudImage.style.height = potgoudImageHeight;
                potgoudImage.style.left = `${mouseX}px`;
                potgoudImage.style.top = `${mouseY}px`;
                document.body.appendChild(potgoudImage);
            }, 25);


            window.cloneIntervalId = clonePotgoud;
        }

        if (!targetSequence.startsWith(typedSequence)) {
            typedSequence = '';
        }
    });

    let mouseX, mouseY;
    document.addEventListener('mousemove', (event) => {
        mouseX = event.clientX;
        mouseY = event.clientY;
    });
</script>


<div class="header">
    <div class="header-contents">
        <a id="logo-link" href="index.php">
            <img id="logo" src="images/logo.png" alt="logo" width="50" height="25">
        </a>
        <div id="mode-text" style="margin-top: 10px; font-size: 14px; color: #555; display: none;">
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