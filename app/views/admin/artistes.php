<?php
if (!isset ($_SESSION['loggedin']) || !$_SESSION['loggedin']) {
    header('Location: /login');
    exit;
}
if (!isset ($_SESSION['isadmin']) || !$_SESSION['isadmin']) {
    header('Location: /');
    exit;
}

use models\Artiste;
use models\Album;
use models\Genre;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['supprimer_artiste'])) {
        $artiste_id = $_POST['id'];
        $artiste = Artiste::getArtisteById($artiste_id);
        $artiste->delete();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://use.fontawesome.com/releases/v5.15.4/js/all.js"></script>
    <link rel="stylesheet" href="/static/css/artistes.css">
    <title>Artistes</title>
</head>
<body>
  <div class="container">
    <a id="retour-accueil" href="/admin"><i style="margin: 0.4em" class="fas fa-arrow-circle-left"></i>Retour</a>
    <h1>Les artistes</h1>
    <button class="ajout-artiste" onclick="window.location.href='/admin/ajout-artiste'" style="cursor: pointer;">
        <a id="ajout-artiste" href="#">Ajouter un artiste</a>
    </button>
    <?php
        $artistes = Artiste::getAllArtistes();

        foreach ($artistes as $artiste) {
            $string_genres = "";
            $genres = Genre::getGenresByIdA($artiste->getIdA());
            $cpt = 0;
            $max_length = count($genres);
            foreach ($genres as $genre) {
                $string_genres .= $genre->getNomG();
                $cpt++;
                if ($cpt < $max_length) {
                    $string_genres .= ', ';
                }
            }


            echo "<div class='artiste'>";
              echo "<div class='left-infos-artiste'>";
                echo "<img class='image-artiste' src='/static/img/" . $artiste->getImageA() . "' alt='photo artiste' class='photo-artiste'>";
                echo "<div class = 'infos-artiste'>";
                  echo "<p class='titre-artiste'><a href='/admin/artiste?id=" . $artiste->getIdA() . "'>" . $artiste->getNomA() . "</a></p>";
                  echo "<p>Nombre d'albums : " . count(Album::getAlbumsByIdA($artiste->getIdA())) . "</p>";
                  echo "<p>Genres : ". $string_genres . "</p>";
                echo "</div>";
              echo "</div>";
              echo "<div class='modifs'>";
              echo "<form method='get' action='/admin/artiste?id='" . $artiste->getIdA() . ">";
              echo "<input type='hidden' name='id' value='" . $artiste->getIdA() . "'>"; 
              echo "<button class='btn-modifier' type='submit' ><i style='margin: 4px; color: green; margin-right:2em;' class='fas fa-pencil-alt'></i></button>"; // Icône de crayon
              echo "</form>";
              
              echo "<form method='post'>";
              echo "<input type='hidden' name='id' value='" . $artiste->getIdA() . "'>"; 
              echo "<button class='btn-supprimer' type='submit' name='supprimer_artiste'><i style='margin: 4px; color: red; margin-right:2em;' class='fas fa-trash'></i></button>"; // Icône de poubelle
              echo "</form>";
              echo "</div>";
            echo "</div>";
        }
    ?>
    </div>
</body>
</html>