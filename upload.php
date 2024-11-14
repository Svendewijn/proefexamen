<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bestanden Uploaden</title>
    <link rel="stylesheet" href="css/styling.css">
</head>
<body>
<?php include 'header.php';?>
    <div class="block-settings">
        <h1>Upload Bestanden</h1>
        <form action="uploadprocess.php" method="post" enctype="multipart/form-data">
            <label for="text">Tekstbestand:</label>
            <textarea name="text" id="text" rows="4" cols="50"></textarea>

            <label for="video">Upload Video (MP4, MOV):</label>
            <input type="file" name="video" id="video" accept=".mp4,.mov">

            <label for="cv">Upload CV (PDF, DOC, DOCX):</label>
            <input type="file" name="cv" id="cv">

            <input type="submit" value="Upload Bestanden" class="btn">
        </form>
    </div>
</body>
</html>