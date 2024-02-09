<?php
use models\Utilisateur;

if (!isset ($_SESSION['loggedin']) || !$_SESSION['loggedin']) {
    header('Location: /login');
    exit;
}

$title = "Profil de " . ucfirst($_SESSION['username']);
$msg_erreur_motdepasse = "";
$msg_confirmation_suppression = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['deleteaccount'])) {
        $user = Utilisateur::getUtilisateurById($_SESSION['id']);
        $user->delete();
        header('Location: /logout');
        exit;
    }

    if (isset($_POST['currentpassword'])){
        $currentpassword = $_POST['currentpassword'];
        $newpassword = $_POST['newpassword'];
        $newpasswordconfirm = $_POST['newpasswordconfirm'];

        if (Utilisateur::checkCredentials($_SESSION['username'], $currentpassword)) {
            if ($newpassword === $newpasswordconfirm) {
                $user = Utilisateur::getUtilisateurById($_SESSION['id']);
                $user->setPassword($newpassword);
                $user->update();
                $msg_confirmation_suppression = "Mot de passe modifié avec succès.";
            }
            else {
                $msg_erreur_motdepasse = "Les mots de passe ne correspondent pas.";
            }
        }
        else {
            $msg_erreur_motdepasse = "Mot de passe actuel incorrect.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
</head>
<body>
    <a href="/accueil">Retour à l'accueil</a>
    <h1><?= $title ?></h1>
    <p>Vous êtes connecté en tant que <?= $_SESSION['username'] ?></p>

    <div class="delete-account">
      <form method = "post">
          <button type="submit" name="deleteaccount">Supprimer mon compte</button>
      </form>
    </div>

    <div class="personal-info">
        <style> /** TEMPORAIRE, A ENLEVER */
            img {
                max-width: 100px;
                max-height: 100px;
            }
        </style>
      <img class="h-12 w-12 rounded-full" src="https://api.dicebear.com/7.x/adventurer-neutral/svg?seed=<?php echo $_SESSION['username'] ?>" alt="profile image">
      <p> Nom d'utilisateur : <?= $_SESSION['username'] ?> </p>
    </div>

    <div class="update-password">
        <form method="post">
            <label for="currentpassword">Mot de passe actuel</label>
            <input type="password" name="currentpassword" required>
            
            <label for="newpassword">Nouveau mot de passe</label>
            <input type="password" name="newpassword" required>

            <label for="newpasswordconfirm">Confirmer le nouveau mot de passe</label>
            <input type="password" name="newpasswordconfirm" required>
            
            <button type="submit">Modifier mon mot de passe</button>
        </form>
        <p><?php echo $msg_erreur_motdepasse ?></p>
        <p><?php echo $msg_confirmation_suppression ?></p>
    </div>
</body>
</html>