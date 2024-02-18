<?php

if (!isset ($_SESSION['loggedin']) || !$_SESSION['loggedin']) {
    header('Location: /login');
    exit;
}
if (!isset ($_SESSION['isadmin']) || !$_SESSION['isadmin']) {
    header('Location: /');
    exit;
}

use models\Genre;

$genre_exists_erreur = "";
$id_genre = $_GET['genre_id'];



$genre = Genre::getGenreById($id_genre);
$nom_genre = $genre->getNomG();


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newNomGenre = $_POST['labelGenreNouveau'];
    $liste_noms_genres = Genre::getAllGenres();
    $liste_noms_genres = array_map(function($genre) {
        return $genre->getNomG();
    }, $liste_noms_genres);

    if ($newNomGenre == $nom_genre) {
        $genre_exists_erreur = "Le nouveau nom ne peut pas être identique à l'ancien !";
    }
    else if (in_array($newNomGenre, $liste_noms_genres)) {
        $genre_exists_erreur = "Ce genre existe déjà !";
    }
    else if (strlen($newNomGenre) > 99){
        $genre_exists_erreur = "Nom du genre trop long ( 100 caractères max. ) !";
    }
    else{
        $genre = new Genre($id_genre, $newNomGenre);
        $genre->update();
        header('Location: /admin/genres');
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
    <title>Update genre</title>
</head>
<body>
    <a id="retour-accueil" href="/admin/genres"><i style="margin: 0.4em" class="fas fa-arrow-circle-left"></i>Retour</a>
    <div>
        <h1 class="titre-ajout-genre">Modifier un genre</h1>
    </div>
    <form method="post">
        <div class="container">
            <div class="left-container">
                <label for="labelGenreActuel">Nom actuel</label>
                <input id="disabled-input" class="input-genre" type="text" name="labelGenreActuel" value = "<?php echo $nom_genre; ?>" disabled>
                <label for="labelGenreNouveau">Nouveau nom</label>
                <input class="input-genre" type="text" name="labelGenreNouveau" required>
                <p class="erreur-genre"><?php echo $genre_exists_erreur; ?></p>
            </div>
        </div>
        <button type="submit" class="submit-form-button" name="ajout_genre">Modifier le genre</button>
</body>
</html>