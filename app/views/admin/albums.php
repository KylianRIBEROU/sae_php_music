<?php 
use models\Album;
use models\Artiste;

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
        <div class="albums"></div>
        <button class="ajout-album" onclick="window.location.href='/admin/ajout-album'" style="cursor: pointer;">
            <a id="ajout-album" href="/admin/ajout-album">Ajouter un album</a>
        </button>
        <?php
            $albums = Album::getAllAlbums();

            foreach ($albums as $album) {
                echo "<div class='album'>";
                echo "<img src='/static/img/" . $album->getImageAlbum() . "' alt='photo album' class='photo-album'>";
                echo "<p class='titre-album'>" . $album->getTitreAlbum() ." - ". (Artiste::getArtisteById($album->getIdA()))->getNomA() . "</p>";
                echo "<div class='modifs'>";
                echo "<form method='get' action='/admin/update-album'>";
                echo "<input type='hidden' name='album_id' value='" . $album->getIdAlbum() . "'>"; 
                echo "<button class='btn-modifier' type='submit' name='update_album'><i style='margin: 4px; color: green; margin-right:2em;' class='fas fa-pencil-alt'></i></button>"; // Icône de crayon
                echo "</form>";
                
                echo "<form method='post'>";
                echo "<button class='btn-supprimer' type='submit' name='supprimer_album'><i style='margin: 4px; color: red; margin-right:2em;' class='fas fa-trash'></i></button>"; // Icône de poubelle
                echo "</form>";
                echo "</div>";
                echo "</div>";
            }

        ?>
    </div>

</body>
</html>
