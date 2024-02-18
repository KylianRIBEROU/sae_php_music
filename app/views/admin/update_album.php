<?php

if (!isset ($_SESSION['loggedin']) || !$_SESSION['loggedin']) {
    header('Location: /login');
    exit;
}
if (!isset ($_SESSION['isadmin']) || !$_SESSION['isadmin']) {
    header('Location: /');
    exit;
}

use models\Album;
use models\Genre;
use models\Artiste;
$album_exists_erreur = "Un album existe déjà avec ce nom !";
$genre_already_exists_erreur = "Un genre existe déjà avec ce nom !";
$id_album = $_GET['id_album'];

$album = Album::getAlbumById($id_album);

$genres_album = Genre::getGenresByIdAlbum($id_album);

$auteur = Artiste::getArtisteById($album->getIdA());

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    if (isset($_POST['ajout_album'])) {

        $nom_album = $_POST['labelAlbum'];
        $anneeSortie = intval($_POST['anneeSortie']);

        $nomArtiste = $_POST['artiste'];

        $dossier_images = __DIR__ . "/../../static/img/";

        $lien_image = $_FILES["image-album"]["name"];

        if ($_FILES["image-album"]["error"] > 0 || $lien_image == "") {
            $image = $album->getImageAlbum();
        } else {
            $chemin_image = $dossier_images . basename($lien_image);
            $image = basename($lien_image);
            try {
                move_uploaded_file($_FILES["image-album"]["tmp_name"], $chemin_image);
            } catch (Exception $e) {
                echo "Erreur lors de l'upload de l'image";
                $image = $album->getImageAlbum();
                var_dump($e->getMessage());
            }
        }

        $album->setTitreAlbum($nom_album);
        $album->setAnneeSortie($anneeSortie);
        $album->setImageAlbum($lien_image);

        if ($nomArtiste != $auteur->getNomA()) {
            $auteur = Artiste::getArtisteById($nomArtiste);
            $album->setIdA($auteur->getIdA());
        }

        $album->update();

        if (isset($_POST['genres']) || !empty($_POST['genres'])) {
            $genres = $_POST['genres'];
            foreach ($genres as $genre) {
                if ( !in_array($genre, $genres_album)) {
                    if (!Genre::existsByNomG($genre)) {
                        $new_genre = new Genre(0, $genre);
                        $new_genre->create();
                        $new_genre = Genre::getGenreByNom($genre);
                        $album->addGenre($new_genre);
                    }
                    else {
                        $new_genre = Genre::getGenreByNom($genre);
                        $album->addGenre($new_genre);
                    }

                }
            }
            foreach ($genres_album as $genre) {
                if (!in_array($genre->getNomG(), $genres)) {
                    $album->removeGenre($genre);
                }
            }
        }
        else {
            // ca veut dire que l'album n'a pas de genre donc faut lui supprimer tous ses genres
            $album->removeAllGenres();
        }

        header('Location: /admin/albums');
        exit();
    }};
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://use.fontawesome.com/releases/v5.15.4/js/all.js"></script>
    <link rel="stylesheet" href="/static/css/update_album.css">
    <title>Modifier un album</title>
</head>
<body>
    <div class="header">
        <a id="retour-accueil" href="/admin/albums"><i style="margin: 0.4em" class="fas fa-arrow-circle-left"></i>Retour</a>
    </div>
    <div>   
        <h1>Modifier un album</h1>
    </div>
        <form method="post" enctype="multipart/form-data">
        <div class="container">
            <div class="left-container">
                <label for="labelAlbum">Nom de l'album</label>
                <input class="input-album" type="text" name="labelAlbum" id="labelAlbum" value="<?php echo $album->getTitreAlbum() ?>" required>

                <label for="anneeSortie">Année de sortie</label>
                <select class="input-album-select" id="anneeSortie" name="anneeSortie">
                <?php
                for ($i = date("Y"); $i > 1939; $i--) {
                    if ($i == $album->getAnneeSortie()) {
                        echo '<option value="'.$i.'" selected>'.$i.'</option>';
                    }
                    else {
                        echo '<option value="'.$i.'">'.$i.'</option>';
                    }
                }
                ?>
                </select>

                <div class="genres">
                    <h3>Genres</h3>
                    <div class="genres-checkboxes">
                        <div class="genre">
                            <button type="button" id="ajout-genre">Ajouter un genre</button>
                        </div>
                        <?php
                        $genres = Genre::getAllGenres();
                        foreach ($genres as $genre) {
                            $checked = "";
                            if (in_array($genre, $genres_album)) {
                                $checked = "checked";
                            }
                            echo '<div class="genre">';
                            echo '<input type="checkbox" id="'.$genre->getNomG().'" name="genres[]" value="'.$genre->getNomG().'" '.$checked.'>';
                            echo '<label for="'.$genre->getNomG().'">'.$genre->getNomG().'</label>';
                            echo '</div>';
                          };
                        ?>

                    </div>
                    <p class="erreur-genre" style="display: none;"> <?php echo $genre_already_exists_erreur?></p>
                    <div class="genre" style="display: none;max-width: 400px;" id="add-genre-form">
                        <label for="nouveau-genre">Nouveau genre</label>
                        <input type="text" id="nouveau-genre" name="nouveau_genre" placeholder="Entrez nouveau genre...">
                        <a id="valider-nouveau-genre">Valider</a>
                    </div>
                </div>
            
                <label for="auteur">Auteur</label>
                <select class="select-artistes" id="artistes" name="artiste">
                <?php
                $artistes = Artiste::getAllArtistes();
                foreach ($artistes as $artiste) {
                    if ($artiste->getIdA() == $auteur->getIdA()) {
                        echo '<option value="'.$artiste->getIdA().'" selected>'.$artiste->getNomA().'</option>';
                    }
                    else {
                        echo '<option value="'.$artiste->getIdA().'">'.$artiste->getNomA().'</option>';
                    }
                };
                ?>
                </select>
            </div>
            <div class="right-container">
                <img id="image-preview" src="/static/img/<?php echo $album->getImageAlbum() ?>" alt="Image de l'album">
                <input id="image-picker" type="file" accept="image/*" name="image-album">
            </div>
        </div>
    </div>
    <button type="submit" class="submit-form-button" name="ajout_album">Modifier l'album</button>
    </form>
</body>
</html>

<script src="/static/js/update_album.js"></script>