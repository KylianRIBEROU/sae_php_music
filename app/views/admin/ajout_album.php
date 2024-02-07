<?php
// if post request 

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
// traiter la création d'album et rediriger quelque part
    $nom_album = $_POST['labelAlbum'];
    $anneeSortie = $POST['anneeSortie'];

    // get les genres et l'image, sauvegarder l'image qq part et 
    // enregistrer son lien en BD
    $nomArtiste = $_POST['artistes[]'];

    $image = $_POST['image'];

}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/static/css/ajout_album.css">
    <title>Ajout d'album</title>
</head>
<body>
    <div>
        <h1 class="titre-ajout-album">Ajouter un album</h1>
    </div>
    <form method="post" enctype="multipart/form-data">
    <div class="container">
        <div class="left-container">
            <label for="labelAlbum">Nom de l'album</label>
            <input class="input-album" type="text" name="labelAlbum" required>


            <label for="anneeSortie">Année de sortie</label>
            <select class="input-album-select" id="anneeSortie" name="anneeSortie">
            <?php
            use models\Artiste;
            for ($i = 1940; $i <= date("Y"); $i++) {
                echo '<option value="'.$i.'">'.$i.'</option>';
            }
            ?>
            </select>
            <!-- genres de l'album -->
            <label for="genres">Genres</label>
            <select id="genres" name="genres[]" multiple>
            <?php 
            use models\Genre;
            $genres = Genre::getAllGenres();
            foreach ($genres as $genre) {
                echo '<option value="'.$genre->getNomG().'">'.$genre->getNomG().'</option>';
            };
            ?>
            </select>

            <!-- artiste de l'album -->
            <label for="artistes">Artiste</label>
            <select class="select-artistes" id="artistes" name="artistes[]">
            <option value="Sélectionner un artiste">Sélectionner un artiste</option>
                <?php
                $artistes=Artiste::getAllArtistes();
                foreach ($artistes as $artiste) {
                    echo '<option value="'. $artiste->getNomA().'">'.$artiste->getNomA().'</option>';
                };
                ?>
            </select>
        </div>
        <div class="right-container">
            <!-- select images ici  --> 
            <label for="image-picker">
            <img id="image-preview" src="/static/img/add-image.png" alt="image choisie"/>
            </label>
            <input id="image-picker" type="file" accept="image/*" name="image-album">
        </div>
    </div>
        <button type="submit" class="submit-form-button" name="ajout_album">Ajouter l'album</button>
    </form>
</body>
</html>

<script src="/static\js\ajout_album.js"></script>