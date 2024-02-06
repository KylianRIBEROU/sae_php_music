

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page de connexion</title>
    <link href="../static/css/output.css" rel="stylesheet" />
</head>
<body class="bg-gray-dark">

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
            $_SESSION['username'] = $user->getNom();
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

<div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">

  <div class="sm:mx-auto sm:w-full sm:max-w-sm">
    <h2 class="mt-10 text-center text-2xl font-bold leading-9 tracking-tight text-white">Connexion</h2>
  </div>

  <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
    <form method="post" action="/login">
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
          <div class="mt-2">
            <input id="password" name="password" type="password" autocomplete="current-password" required class="bg-gray block w-full rounded-md border-0 px-3 py-1.5 text-white shadow-sm ring-1 ring-inset ring-gray-light placeholder:text-gray focus:ring-2 focus:ring-inset focus:ring-purple sm:text-sm sm:leading-6 focus:outline-none">
        </div>

        <div class="mt-8">
          <button type="submit" class="flex w-full justify-center rounded-md bg-purple px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-purple focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-purple">Se connecter</button>
        </div>
      </form>

      <p class="mt-10 text-center text-sm text-white">
        Vous n'avez pas de compte ?
        <a href="/register" class="font-semibold leading-6 text-purple">Inscrivez-vous ici</a>
      </p>
  </div>

</div>

</body>
</html>
