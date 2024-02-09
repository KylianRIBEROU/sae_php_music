<?php 
if (!isset ($_SESSION['loggedin']) || !$_SESSION['loggedin']) {
    header('Location: /login');
    exit;
}
if (!isset ($_SESSION['isadmin']) || !$_SESSION['isadmin']) {
    header('Location: /');
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel administrateur</title>
</head>
<body>
    <h1>Panel administrateur</h1>
    <div class ="choix-admin">
        <div>
            <h2>Utilisateurs</h2>
            <a href="/admin/ajout-utilisateur">Ajouter un utilisateur</a>
            <a href="/admin/utilisateurs">Gérer les utilisateurs</a>
        </div>
        <div>
            <h2>Albums</h2>
            <a href="/admin/ajout-album">Ajouter un album</a>
            <a href="/admin/albums">Gérer les albums</a>
        </div>
        <div>
            <h2>Artistes</h2>
            <a href="/admin/ajout-artiste">Ajouter un artiste</a>
            <a href="/admin/artistes">Gérer les artistes</a>
        </div>
        <div>
            <h2>Genres</h2>
            <a href="/admin/ajout-genre">Ajouter un genre</a>
            <a href="/admin/genres">Gérer les genres</a>
    </div>
</body>
</html>