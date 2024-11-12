<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bestanden Uploaden</title>
</head>
<body>
    <h1>Upload Bestanden</h1>
    <form action="uploadprocess.php" method="post" enctype="multipart/form-data">
        <label for="text">Tekstbestand:</label>
        <textarea name="text" id="text" rows="4" cols="50"></textarea><br>

        <label for="video_link">YouTube Link:</label>
        <input type="text" name="video_link" id="video_link"><br>

        <label for="cv">Upload CV (PDF, DOC, DOCX):</label>
        <input type="file" name="cv" id="cv"><br>

        <input type="submit" value="Upload Bestanden">
    </form>
</body>
</html>