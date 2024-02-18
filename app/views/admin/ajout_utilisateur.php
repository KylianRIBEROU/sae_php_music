<?php

$utilisateur_already_exists = "";

if (!isset ($_SESSION['loggedin']) || !$_SESSION['loggedin']) {
    header('Location: /login');
    exit;
}
if (!isset ($_SESSION['isadmin']) || !$_SESSION['isadmin']) {
    header('Location: /');
    exit;
}

use models\Utilisateur;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $pseudo = $_POST['pseudo'];

    if (Utilisateur::checkUtilisateurExiste($pseudo)) {
        $utilisateur_already_exists = "Ce nom d'utilisateur est déjà pris !";
    }
    else{
        $password = $_POST['password'];
        $admin = isset($_POST['admin']) ? true : false;
        $utilisateur = new Utilisateur(0, $pseudo, $password, $admin);
        $utilisateur->create();
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
    <script src="https://use.fontawesome.com/releases/v5.15.4/js/all.js"></script>
    <link rel="stylesheet" href="/static/css/ajout_utilisateur.css">
    <title>Ajout utilisateur</title>
</head>
<body>
    <div class="header">
        <a id="retour-accueil" href="/admin"><i style="margin: 0.4em" class="fas fa-arrow-circle-left"></i>Retour</a>
    </div>
    <div>
        <h1>Ajouter un utilisateur</h1>
    </div>
    <form method="post">
        <div class="container">
            <div class="left-container">
                <label for="nom">Pseudonyme</label>
                <input class="input-utilisateur" type="text" name="pseudo" required>
                <label for="password">Mot de passe</label>
                <input class="input-utilisateur" type="password" name="password" required>
                <label for="admin">Administrateur</label>
                <input class="input-utilisateur" type="checkbox" name="admin">
                <p class="erreur-utilisateur"><?php echo $utilisateur_already_exists; ?></p>
                <button class="submit-form-button" type="submit" name="ajout_utilisateur">Ajouter</button>
            </div>
        </div>
    </form>
</body>
</html>

