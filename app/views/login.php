<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page de connexion</title>
</head>
<body>
<?php 
use models\Utilisateur;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // on récupère les données du formulaire
    $username = $_POST['username'];
    $password = $_POST['password'];
    // on vérifie si l'utilisateur existe
    $user = Utilisateur::checkUtilisateurExiste($username);
    if ($user) {
        if (Utilisateur::checkCredentials($user->getNom(), $password)) {
            session_start();
            $_SESSION['id'] = $user->getIdU();
            $_SESSION['loggedin'] = true;
            // on redirige l'utilisateur vers la page d'accueil
            header('Location: /');
            exit;
        }
    }
    // si l'utilisateur n'existe pas ou si le mot de passe est incorrect, on affiche un message d'erreur
    echo '<p>Identifiant ou mot de passe incorrect.</p>';
}

?>
<div>
    <h2>Connexion</h2>
    <form action="/login" method="post">
        <label for="username">Nom d'utilisateur :</label>
        <input type="text" id="username" name="username" required>

        <label for="password">Mot de passe :</label>
        <input type="password" id="password" name="password" required>

        <button type="submit">Se connecter</button>
    </form>
    <p>Vous n'avez pas de compte ? <a href="/register">Inscrivez-vous ici</a>.</p>
</div>
</body>
</html>
