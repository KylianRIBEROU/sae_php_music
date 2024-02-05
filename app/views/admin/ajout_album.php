<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/static/css/ajout_album.css">
    <title>ajout d'album</title>
</head>
<body>
    <div>
        <h1>Ajouter un album</h1>
    </div>
    <form method="post" enctype="multipart/form-data">
    <div class="container">
        <div class="left-container">
            <label for="labelAlbum">Nom de l'album :</label><br>
            <input type="text" name="labelAlbum" required>

            <label for="dateAlbum">Année de sortie :</label><br>
            <input type="number" name="dateAlbum" min="1940" max="<?php echo date("Y") ?>" required>

            <!-- genres de l'album -->
            <label for="genres">Genres:</label><br>
            <select id="genres" name="genres[]" multiple>
            <?php 
              use models\Genre;
              $genres = Genre::getAllGenres();
                foreach ($genres as $genre) {
                    echo '<option value="'.$genre->getNom().'">'.$genre->getNom().'</option>';
                }
            ?>
            </select><br>
        </div>
        <div class="right-container">
                <!-- select images ici  --> 
                <p> ici on mettra les images</p>
        </div>
    </div>
        <button type="submit" class="btn" name="ajout_album">Ajouter l'album</button>
    </form>
    
</body>
</html>