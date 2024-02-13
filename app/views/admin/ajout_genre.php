<?php 
use models\Genre;
$genre_exists_erreur = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    $nomGenre = $_POST['labelGenre'];
    $liste_noms_genres = Genre::getAllGenres();
    $liste_noms_genres = array_map(function($genre) {
        return $genre->getNomG();
    }, $liste_noms_genres);
    
    if (in_array($nomGenre, $liste_noms_genres)) {
        $genre_exists_erreur = "Ce genre existe déjà !";
    }
    else if (strlen($nomGenre) > 99) {
        $genre_exists_erreur = "Nom du genre trop long ( 100 caractères max. ) !";
    }
    else{
        $genre = new Genre(0, $nomGenre);
        $genre->create();
        header('Location: /admin');
        exit();
    }
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/static/css/ajout_genre.css">
    <script src="https://use.fontawesome.com/releases/v5.15.4/js/all.js"></script>
    <title>Ajout genre</title>
</head>
<body>
    <div class="header">
        <a id="retour-accueil" href="/admin"><i style="margin: 0.4em" class="fas fa-arrow-circle-left"></i>Retour</a>
    </div>
    <div>
        <h1 class="titre-ajout-genre">Ajouter un genre</h1>
    </div>
    <form method="post">
        <div class="container">
            <div class="left-container">
                <label for="labelGenre">Nom du genre</label>
                <input class="input-genre" type="text" name="labelGenre" required>
                <p class="erreur-genre"><?php echo $genre_exists_erreur; ?></p>
            </div>
        </div>
        <button type="submit" class="submit-form-button" name="ajout_genre">Ajouter le genre</button>
</body>
</html>