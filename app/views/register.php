<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page d'inscription</title>
</head>
<body>
<?php
use models\Utilisateur;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // on récupère les données du formulaire
    $username = $_POST['username'];
    $password = $_POST['password_1'];
    $confirm_password = $_POST['password_2'];
    $user = Utilisateur::checkUtilisateurExiste($username);
    if ($user) {
            echo '<p>Ce nom d\'utilisateur est déjà pris !</p>';
            exit;
    }
    else {
        if ($password != $confirm_password) {
            echo '<p>Les mots de passe ne correspondent pas !</p>';
            exit;
        }
        else {
            // on crée un nouvel utilisateur, pas admin par défaut
            $user = new Utilisateur(0, $username, $password, 0);
            $user->create();
            session_start();
            $_SESSION['id'] = $user->getIdU();
            $_SESSION['isadmin'] = $user->getAdmin();
            $_SESSION['loggedin'] = true;
            header('Location: /');
            exit;
    }
    }
}
?>
  <div class="header">
        <h1>Inscription</h1>
  </div>
  <form method="post" action="/register">
        <!-- <?php include('errors.php'); ?> -->
        <div class="input-group">
          <label>Nom d'utilisateur</label>
          <input type="text" name="username" required>
        </div>
        <div class="input-group">
          <label>Mot de passe</label>
          <input type="password" name="password_1" required>
        </div>
        <div class="input-group">
          <label>Confirmer le mot de passe</label>
          <input type="password" name="password_2" required>
        </div>
        <div class="input-group">
          <button type="submit" class="btn" name="reg_user">S'inscrire</button>
        </div>
        <p>
        Vous avez déjà un compte ?<a href="/login">Connectez-vous !</a>
        </p>
  </form>
</body>
</html>
