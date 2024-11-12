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
</script>


<div class="footer">
    <div class="company-links">
    <h3>Email: xxl@company.com</h3>
    <h3>Tel:555-555-555</h3>
    </div>
</div>