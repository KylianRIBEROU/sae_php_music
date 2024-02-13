<?php
use models\Album;
use models\Artiste;
use models\Titre;
use models\Genre;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['supprimer_artiste'])) {
        $id_artiste = $_POST['id'];
        $artiste = Artiste::getArtisteById($id_artiste);
        $artiste->delete();

        header('Location: /admin');
        exit;
    }

    if (isset($_POST['update_artiste'])) {
        $id_artiste = $_POST['id'];
        $nom_artiste = $_POST['nomArtiste'];
        $image_artiste = $_FILES['imageArtiste']['name'];

        $dossier_images = __DIR__ . "/../../static/img/";

        if ($_FILES['imageArtiste']['error'] > 0 || $image_artiste == "") {
            $image_artiste = $artiste->getImageA();
        } else {
            $chemin_image = $dossier_images . basename($image_artiste);
            try {
                move_uploaded_file($_FILES['imageArtiste']['tmp_name'], $chemin_image);
            } catch (Exception $e) {
                echo "Erreur lors de l'upload de l'image";
                $image_artiste = $artiste->getImageA();
                var_dump($e->getMessage());
            }
        }
        $artiste = Artiste::getArtisteById($id_artiste);

        $artiste->setNomA($nom_artiste);
        $artiste->setImageA($image_artiste);
        $artiste->update();

        header('Location: /admin/artiste?id=' . $id_artiste);
        exit;
    }
}
else {
    if (isset($_GET['id'] )) {
        $id = $_GET['id'];
        $artiste = Artiste::getArtisteById($id);
        if ($artiste == null) {
            header('Location: /admin');
            exit;
        }
        $albums = Album::getAlbumsByIdA($id);

        $genres = Genre::getGenresByIdA($id);
    }
    else {
        header('Location: /admin');
        exit;
    }
} 
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="/static/css/detail_artiste.css" rel="stylesheet">
    <script src="https://use.fontawesome.com/releases/v5.15.4/js/all.js"></script>
    <title>Artiste</title>
</head>
<body>
    <div class="header">
        <a id="retour-accueil" href="/admin/artistes"><i style="margin: 0.4em" class="fas fa-arrow-circle-left"></i>Retour</a>
    </div>
    <div class="header-artiste">
          <h2><?php echo $artiste->getNomA() ?></h2>
    </div>
    <form method="post" enctype="multipart/form-data">
      <div class="infos-artiste">
        <div class="left-container">
        <div class="conteneur-image-artiste">
            <input class="inputfile" type="file" name="imageArtiste" id="image-picker" accept="image/*">
            <img id="image-preview" src="/static/img/<?php echo $artiste->getImageA() ?>" alt="photo artiste" class="photo-artiste">
            <label for="image-picker" class="label-image">Modifier l'image</label>

        </div>
        <div class="infos">
            <input class="input-nom-artiste" type="text" name="nomArtiste" id="nomArtiste" value="<?php echo $artiste->getNomA(); ?>" required>
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
        <input type="hidden" name="id" value="<?php echo $artiste->getIdA() ?>">
        <button class="bouton" type="submit" name="supprimer_artiste">Supprimer l'artiste</button>
      </div>
      <div class="update-artiste">
        <button class="bouton" type="submit" name="update_artiste">Enregistrer les modifications</button>
    </form>
      <div class="albums">
        <div class="header-albums">
          <h2>Albums de <?php echo $artiste->getNomA() ?></h2>
        </div>
        <div class="albums">
            <?php
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
                      echo "<h2>". $album->getTitreAlbum(). "</h2>";
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
      </div>
</body>
</html>

<script>
    let imagePicker = document.getElementById('image-picker');
    let imagePreview = document.getElementById('image-preview');
    let labelImage = document.querySelector('.label-image');

    imagePicker.addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.addEventListener('load', function() {
                imagePreview.setAttribute('src', this.result);
            });
            reader.readAsDataURL(file);

            labelImage.textContent = file.name;
        }
    });
</script>   