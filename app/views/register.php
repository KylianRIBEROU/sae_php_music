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
            $_SESSION['loggedin'] = true;
            header('Location: /');
            exit;
    }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page d'inscription</title>
    <link href="../static/css/output.css" rel="stylesheet" /> 
</head>
<body class="bg-gray-dark">

  <!-- <div class="header">
        <h1>Inscription</h1>
  </div>

        <?php // include('errors.php'); ?>
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
        </p> -->


<div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-sm">
      <h2 class="mt-10 text-center text-2xl font-bold leading-9 tracking-tight text-white">Inscription</h2>
    </div>

    <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
      <form method="post" action="/register">
            <div>
            <label for="username" class="block text-sm font-medium leading-6 text-white">Nom d'utilisateur</label>
            <div class="mt-2 mb-2">
              <input id="username" name="username" type="text" required class="bg-gray block w-full rounded-md border-0 py-1.5 px-3 text-white shadow-sm ring-1 ring-inset ring-gray-light placeholder:text-gray focus:ring-2 focus:ring-inset focus:ring-purple sm:text-sm sm:leading-6 focus:outline-none">
            </div>
         </div>

          <div>
            <div class="flex items-center justify-between">
              <label for="password" class="block text-sm font-medium leading-6 text-white">Mot de passe</label>
            </div>
            <div class="mt-2 mb-2">
              <input id="password_1" name="password_1" type="password" autocomplete="current-password" required class="bg-gray block w-full rounded-md border-0 px-3 py-1.5 text-white shadow-sm ring-1 ring-inset ring-gray-light placeholder:text-gray focus:ring-2 focus:ring-inset focus:ring-purple sm:text-sm sm:leading-6 focus:outline-none">
          </div>

          <div>
            <div class="flex items-center justify-between">
              <label for="password" class="block text-sm font-medium leading-6 text-white">Confirmer le mot de passe</label>
            </div>
            <div class="mt-2">
              <input id="password_1" name="password_1" type="password" autocomplete="current-password" required class="bg-gray block w-full rounded-md border-0 px-3 py-1.5 text-white shadow-sm ring-1 ring-inset ring-gray-light placeholder:text-gray focus:ring-2 focus:ring-inset focus:ring-purple sm:text-sm sm:leading-6 focus:outline-none">
          </div>

          <div class="mt-8">
            <button type="submit" class="flex w-full justify-center rounded-md bg-purple px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-purple focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-purple">S'enregistrer</button>
          </div>
        </form>

        <p class="mt-10 text-center text-sm text-white">
          Vous avez déjà un compte ?
          <a href="/login" class="font-semibold leading-6 text-purple">Connectez-vous ici</a>
        </p>
    </div>
</div>

</body>
</html>
