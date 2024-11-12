<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welkom</title>
    <link rel="stylesheet" href="css/styling.css">
    <style>
        /* Verberg de afbeelding standaard */
        #boemImage {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }
    </style>
</head>
<body>
<?php include 'header.php';?>
    <div class="welkom">
        <h1>Welkom</h1>
        <p>
            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod 
            tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, 
            quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. 
            Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. 
            Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
        </p>
        <img id="boemImage" src="images/boem.png" alt="Boem">
        <audio id="boemSound" src="images/boem.mp3"></audio>
    </div>
    <?php include 'footer.php';?>

    <script>
        const boemImage = document.getElementById('boemImage');
        const boemSound = document.getElementById('boemSound');
        let typedSequence = '';
        const targetSequence = 'boem';

        document.addEventListener('keydown', function(event) {
            // Voeg de ingedrukte toets toe aan de sequence
            typedSequence += event.key;

            // Controleer of de sequence overeenkomt met de doelsequence
            if (typedSequence === targetSequence) {
                // Toont de afbeelding
                boemImage.style.display = 'block';
                // Speel het geluid af
                boemSound.play();
                
                // Verberg de afbeelding na 2 seconden
                setTimeout(function() {
                    boemImage.style.display = 'none';
                }, 2000);

                // Reset de sequence
                typedSequence = '';
            }

            // Reset de sequence als deze niet overeenkomt met de doelsequence
            if (!targetSequence.startsWith(typedSequence)) {
                typedSequence = '';
            }
        });
    </script>
</body>
</html>