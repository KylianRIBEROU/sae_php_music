<?php

use models\Artiste;
use models\Album;
use models\Genre;

$artiste_empty_erreur = "";
$genre_already_exists_erreur = "Un genre existe déjà avec ce nom !";

var_dump($_POST);
if ($_SERVER['REQUEST_METHOD'] === 'POST'){

    var_dump($_FILES);

    if (isset($_POST['ajout_album'])){

    if ($_POST["artistes"] == "Sélectionner un artiste") {
        $artiste_empty_erreur = "Veuillez sélectionner un artiste !";
    }

    else {

    $nom_album = $_POST['labelAlbum'];
    $anneeSortie = $_POST['anneeSortie'];


    // get les genres et l'image, sauvegarder l'image qq part et 
    // enregistrer son lien en BD
    $nomArtiste = $_POST['artistes'];
    $artiste = Artiste::getArtisteByNom($nomArtiste);

    $dossier_images = __DIR__. "/../../static/img/";

    if ($_FILES["image-album"]["error"] > 0 || $_FILES["image-album"]["name"] == "") {
        $image = "default.jpg";
        }
    else {
    $chemin_image = $dossier_images . basename($_FILES["image-album"]["name"]);
    $image = basename($_FILES["image-album"]["name"]);
        try {
            move_uploaded_file($_FILES["image-album"]["tmp_name"], $chemin_image);
        } catch (Exception $e) {
            echo "Erreur lors de l'upload de l'image";
            $image = "default.jpg";
            var_dump($e->getMessage());
        }
    }  


    $album = new Album(0, $nom_album, $anneeSortie, $image, $artiste->getIdA());
    $album->create();

    // get l'album avec l'id correspondant
    $album = Album::getAlbumByTitreAlbum($nom_album);

    foreach ($_POST['genres[]'] as $genre) {
        if ($genre != "" && !Genre::existsByNomG($genre)){
            $new_genre = new Genre(0, $genre);
            $new_genre->create();

            // marche pas psk idAlbum = 0, et idGenre aussi !!
            // sauf si on change le modèle, il faut  une Clef fonctionnelle
            // de chaque coté
            $genre = Genre::getGenreByNom($genre);
            $album->addGenre($genre);
        }
    }    
    
    // rediriger vers l'accueil du panel admin 
    header('Location: /admin');
    exit();
    }
}

elseif (isset($_POST['valider_nouveau_genre'])){
   
}
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/static/css/ajout_album.css">
    <script src="https://use.fontawesome.com/releases/v5.15.4/js/all.js"></script>

    <title>Ajout d'album</title>
</head>
<body>
    <div class="header">
        <a id="retour-accueil" href="/admin"><i style="margin: 0.4em" class="fas fa-arrow-circle-left"></i>Retour</a>
    </div>
    <div>
        <h1 class="titre-ajout-album">Ajouter un album</h1>
    </div>
    <form id="form-album" method="post" enctype="multipart/form-data">
    <div class="container">
        <div class="left-container">
            <label for="labelAlbum">Nom de l'album</label>
            <input class="input-album" type="text" name="labelAlbum" required>


            <label for="anneeSortie">Année de sortie</label>
            <select class="input-album-select" id="anneeSortie" name="anneeSortie">
            <?php
            for ($i = date("Y"); $i > 1939; $i--) {
                echo '<option value="'.$i.'">'.$i.'</option>';
            }
            ?>
            </select>
            <!-- genres de l'album -->
            <div class="genres">
              <label for="genres">Genres</label>
              <div class="genres-checkboxes">
                <div class="genre">
                    <!-- bouton pour ajouter un genre -->
                    <button type="button" id="ajout-genre">Ajouter un genre</button>
                </div>
                <?php 
                $genres = Genre::getAllGenres();
                foreach ($genres as $genre) {
                    echo '<div class="genre">';
                    echo '<input type="checkbox" id="'.$genre->getNomG().'" name="genres[]" value="'.$genre->getNomG().'">';
                    echo '<label for="'.$genre->getNomG().'">'.$genre->getNomG().'</label>';
                    echo '</div>';
                };
                ?>
                
                <div class="genre" style="display: none;" id="add-genre-form">
                        <label for="nouveau-genre">Nouveau genre</label>
                        <input form="form-genre" type="text" id="nouveau-genre" name="nouveau_genre" placeholder="Entrez nouveau genre..." required>
                        <button form="form-genre" id="valider-nouveau-genre" name="nouveau_genre">Valider</button>
                </div>
                <p class="erreur-genre" style="display: none;"> <?php echo $genre_already_exists_erreur?></p>
              </div>
            </div>

            <!-- artiste de l'album -->
            <label for="artistes">Artiste</label>
            <select class="select-artistes" id="artistes" name="artistes">
            <option value="Sélectionner un artiste">Sélectionner un artiste</option>
                <?php
                $artistes=Artiste::getAllArtistes();
                foreach ($artistes as $artiste) {
                    echo '<option value="'. $artiste->getNomA().'">'.$artiste->getNomA().'</option>';
                };
                ?>
            </select>
            <p class ="erreur-album"><?php echo $artiste_empty_erreur; ?></p>
        </div>
        <div class="right-container">
            <!-- select images ici  --> 
            <label for="image-picker">
            <img id="image-preview" src="/static/img/add-image.png" alt="image choisie"/>
            </label>
            <input id="image-picker" type="file" accept="image/*" name="image-album">
        </div>
    </div>
        <button form="form-album" type="submit" class="submit-form-button" name="ajout_album">Ajouter l'album</button>
    </form>
</body>
</html>

<script src="/static\js\ajout_album.js"></script>