<img id="boemImage" src="images/boem.png" alt="Boem">
<audio id="boemSound" src="images/boem.mp3"></audio>

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

    // Button click counter
    let buttonPressCount = 0;

    function handleButtonClick() {
        buttonPressCount++;
        
        // No color change needed after 5 presses
        if (buttonPressCount === 5) {
            // Change the background image of the body
            document.body.style.backgroundImage = "url('images/blackerhacker.jpg')";
            document.body.style.backgroundSize = "cover"; // Optional: Cover the entire background
        }
    }
</script>

<div class="footer" style="position: relative;">
    <div class="company-links">
        <h3>Email: xxl@company.com</h3>
        <button id="telButton" onclick="handleButtonClick()" style="background: none; border: none; color: inherit; font-size: 1.17em; font-weight: bold;">
            Tel: 555-555-555
        </button>
        <!-- Removed the counter text -->
    </div>
    <a href="uploadregister.php" style="position: absolute; bottom: 10px; right: 10px;">
        <img src="images/short.png" alt="Upload" style="width: 10px; height: 10px;">
    </a>
</div>