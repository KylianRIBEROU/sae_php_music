<?php 
use models\Genre;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['supprimer_genre'])) {
        $genre_id = $_POST['genre_id'];
        Genre::deleteById($genre_id);
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://use.fontawesome.com/releases/v5.15.4/js/all.js"></script>
    <link rel="stylesheet" href="/static/css/genres.css">
    <title>Genres</title>
</head>
<body>
    <div class="container">
        <a id="retour-accueil" href="/admin"><i style="margin: 0.4em" class="fas fa-arrow-circle-left"></i>Retour</a>
        <h1>Les genres</h1>
        <div class="genres"></div>
        <button class="ajout-genre" onclick="window.location.href='/admin/ajout-genre'" style="cursor: pointer;">
            <a id="ajout-genre" href="#">Ajouter un genre</a>
        </button>
        <?php
            $genres = Genre::getAllGenres();

            foreach ($genres as $genre) {
                echo "<div class='genre'>";
                echo "<p class='titre-genre'>" . $genre->getNomG() . "</p>";
                echo "<div class='modifs'>";
                echo "<form method='get' action='/admin/update-genre'>";
                echo "<input type='hidden' name='genre_id' value='" . $genre->getIdG() . "'>"; 
                echo "<button class='btn-modifier' type='submit' name='update_genre'><i style='margin: 4px; color: green; margin-right:2em;' class='fas fa-pencil-alt'></i></button>"; // Icône de crayon
                echo "</form>";
                
                echo "<form method='post'>";
                echo "<button class='btn-supprimer' type='submit' name='supprimer_genre'><i style='margin: 4px; color: red; margin-right:2em;' class='fas fa-trash'></i></button>"; // Icône de poubelle
                echo "</form>";
                echo "</div>";
                echo "</div>";
            }

        ?>
    </div>

</body>
</html>