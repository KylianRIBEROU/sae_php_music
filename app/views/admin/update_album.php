<?php

use models\Album;
use models\Genre;
use models\Artiste;
$album_exists_erreur = "Un album existe déjà avec ce nom !";
$id_album = $_GET['id_album'];

$album = Album::getAlbumById($id_album);

$genres_album = Genre::getGenresByIdAlbum($id_album);

$auteur = Artiste::getArtisteById($album->getIdA());



?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://use.fontawesome.com/releases/v5.15.4/js/all.js"></script>
    <link rel="stylesheet" href="/static/css/update_album.css">
    <title>Document</title>
</head>
<body>
    <div class="container">
        <a id="retour-accueil" href="/admin/albums"><i style="margin: 0.4em" class="fas fa-arrow-circle-left"></i>Retour</a>
        <h1>Modifier un album</h1>
        <p>TODO</p>
</div>
</body>
</html>