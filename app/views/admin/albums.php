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
use models\Artiste;
use models\Titre;
use models\Genre;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['supprimer_album'])) {
        $album_id = $_POST['album_id'];
        Album::deleteById($album_id);
    }
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://use.fontawesome.com/releases/v5.15.4/js/all.js"></script>
    <link rel="stylesheet" href="/static/css/albums.css">
    <title>Albums</title>
</head>
<body>
    <div class="container">
        <a id="retour-accueil" href="/admin"><i style="margin: 0.4em" class="fas fa-arrow-circle-left"></i>Retour</a>
        <h1>Les albums</h1>
        <button class="ajout-album" onclick="window.location.href='/admin/ajout-album'" style="cursor: pointer;">
            <a id="ajout-album" href="/admin/ajout-album">Ajouter un album</a>
        </button>
        <?php
            $albums = Album::getAllAlbums();

            foreach ($albums as $album) {
                $string_genres = "";

                $genres = Genre::getGenresByIdAlbum($album->getIdAlbum());
                $cpt = 0;
                foreach ($genres as $genre) {
                    $string_genres .= $genre->getNomG();
                    $cpt++;
                    if ($cpt < count($genres)) {
                        $string_genres .= ", ";
                    }
                };

                echo "<div class='album'>";
                  echo "<div class='left-infos-album'>";
                    echo "<img src='/static/img/" . $album->getImageAlbum() . "' alt='photo album' class='photo-album'>";
                    echo "<div class = 'infos-album'>";
                      echo "<h2>". $album->getTitreAlbum() ." - ". (Artiste::getArtisteById($album->getIdA()))->getNomA() . "</h2>";
                      echo "<p>Année de sortie : " . $album->getAnneeSortie() . "</p>";
                      echo "<p>Nombre de titres : " . count(Titre::getTitresByAlbumId($album->getIdA())) . "</p>";
                      if ($string_genres != "") {
                          echo "<p>Genres : " . $string_genres . "</p>";
                      }
                      else {
                          echo "<p>Genres : Aucun</p>";
                      }
                    echo "</div>";
                  echo "</div>"; // close left-infos-album
                  echo "<div class='modifs'>";
                    echo "<form method='get' action='/admin/update-album'>";
                    echo "<input type='hidden' name='id_album' value='" . $album->getIdAlbum() . "'>"; 
                    echo "<button class='btn-modifier' type='submit' name='update_album'><i style='margin: 4px; color: green; margin-right:2em;' class='fas fa-pencil-alt'></i></button>"; // Icône de crayon
                    echo "</form>";
                    
                    echo "<form method='post'>";
                    echo "<input type='hidden' name='album_id' value='" . $album->getIdAlbum() . "'>"; 
                    echo "<button class='btn-supprimer' type='submit' name='supprimer_album'><i style='margin: 4px; color: red; margin-right:2em;' class='fas fa-trash'></i></button>"; // Icône de poubelle
                    echo "</form>";
                  echo "</div>";
                echo "</div>";
            }

        ?>
    </div>
</body>
</html>
