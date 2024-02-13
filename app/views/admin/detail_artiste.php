<?php
use models\Album;
use models\Artiste;
use models\Titre;
use models\Genre;

if (isset($_GET['id'] )){
    $id = $_GET['id'];
    $artiste = Artiste::getArtisteById($id);
    var_dump($artiste);
    if ($artiste == null){
        echo '<h1 class="text-white">Artiste non trouvé</h1>';
        exit;
    }

    $albums = Album::getAlbumsByIdA($id);

    $genres = Genre::getGenresByIdA($id);
}
else{
    echo '<h1 class="text-white">Artiste non trouvé</h1>';
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="/static/css/output.css" rel="stylesheet">
    <title>Artiste</title>
</head>
<body>
    <div class="header">
        <a id="retour-accueil" href="/admin"><i style="margin: 0.4em" class="fas fa-arrow-circle-left"></i>Retour</a>
    </div>
    <form method="post" enctype="multipart/form-data">
      <div class="infos-artiste">
        <label for ="image-artiste">
            <img id="image-preview" src="/static/img/<?php echo $artiste->getImageA(); ?>" alt="image de l'artiste"/>
        </label>
        <div class="infos">
            <input type="text" name="nomArtiste" id="nomArtiste" value="<?php echo $artiste->getNomA(); ?>" required>
            <p>Genres : 
            <?php
                $cpt = count($genres);
                $i = 0;
                foreach ($genres as $genre) {
                    echo $genre->getNomG();
                    $i++;
                    if ($i < $cpt) {
                        echo ', ';
                    }
                }
                ?></p>
            <p>Nombre d'albums : <?php echo count($albums) ?></p>
        </div>
      </div>
      <div class="update-artiste">
        <button type="submit" name="updateartiste">Enregistrer les modifications</button>
    </form>
      <div class="albums">
        <h2>Albums</h2>
        <div class="albums-list">
            <?php
            foreach ($albums as $album){
                echo '<div class="album">';
                echo '<img src="/static/img/'.$album->getImageAlbum().'" alt="image de l\'album">';
                echo '<p>'.$album->getTitreAlbum().'</p>';
                echo '<a href="/admin/update_album?id='.$album->getIdAlbum().'">Modifier</a>';
                echo '<a href="/admin/delete_album?id='.$album->getIdAlbum().'">Supprimer</a>';
                echo '</div>';
            }
            ?>
        </div>
      </div>
</body>
</html>