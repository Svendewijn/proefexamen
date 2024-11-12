<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Uploaden</title>
</head>
<body>
    <h2>Uploaden</h2>
    <form action="uploadprocess.php" method="post" enctype="multipart/form-data">
        <label for="text">Tekst:</label>
        <textarea name="text" id="text"></textarea><br><br>

        <label for="video_link">YouTube Link:</label>
        <input type="url" name="video_link" id="video_link" placeholder="Voer hier de YouTube-link in"><br><br>

        <label for="cv">CV:</label>
        <input type="file" name="cv" id="cv" accept=".pdf,.doc,.docx"><br><br>

        <input type="submit" value="Uploaden">
    </form>
</body>
</html>