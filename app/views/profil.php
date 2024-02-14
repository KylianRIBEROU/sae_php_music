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
        header('HX-Redirect: /logout');
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


<div class="grid grid-cols-[500px_1fr] gap-10">
    <div>
        <h2 class="text-white font-bold text-xl">Informations personnelles</h2>
        <p class="text-gray-light">Consultez et gérez les informations personnelles associées à votre compte utilisateur.</p>
    </div>
    <div>
        <img class="h-20 w-20 rounded-full" src="https://api.dicebear.com/7.x/adventurer-neutral/svg?seed=<?php echo $_SESSION['username'] ?>" alt="profile image">
        <p class="mt-2 text-white"> Nom d'utilisateur : <?= ucfirst(strtolower($_SESSION['username'])); ?> </p>
    </div>

    <div>
        <h2 class="text-white font-bold text-xl">Modifier le mot de passe</h2>
        <p class="text-gray-light">Mettez à jour votre mot de passe associé à votre compte.</p>
    </div>
    <div>
        <form hx-post="/profil" hx-target="#main">
            <div class="flex flex-col gap-3">
                <label class="text-white" for="currentpassword">Mot de passe actuel</label>
                <input class="  bg-gray block w-full rounded-md border-0 px-3 py-1.5 text-white shadow-sm ring-1 ring-inset ring-gray-light placeholder:text-gray focus:ring-2 focus:ring-inset focus:ring-purple sm:text-sm sm:leading-6 focus:outline-none" type="password" name="currentpassword" required>

                
                <label class="text-white" for="newpassword">Nouveau mot de passe</label>
                <input class="bg-gray block w-full rounded-md border-0 px-3 py-1.5 text-white shadow-sm ring-1 ring-inset ring-gray-light placeholder:text-gray focus:ring-2 focus:ring-inset focus:ring-purple sm:text-sm sm:leading-6 focus:outline-none" type="password" name="newpassword" required>

                <label class="text-white" for="newpasswordconfirm">Confirmer le nouveau mot de passe</label>
                <input class="bg-gray block w-full rounded-md border-0 px-3 py-1.5 text-white shadow-sm ring-1 ring-inset ring-gray-light placeholder:text-gray focus:ring-2 focus:ring-inset focus:ring-purple sm:text-sm sm:leading-6 focus:outline-none" type="password" name="newpasswordconfirm" required>
                
                <button class="flex w-60 justify-center rounded-md bg-purple px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-purple focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-purple" type="submit">Modifier mon mot de passe</button>
            </div>
        </form>
        <p><?php echo $msg_erreur_motdepasse ?></p>
        <p><?php echo $msg_confirmation_suppression ?></p>
    </div>

    <div>
        <h2 class="text-white font-bold text-xl">Supprimer le compte</h2>
        <p class="text-gray-light">Permet de supprimer définitivement votre compte utilisateur, effaçant toutes les données associées. Veuillez procéder avec prudence car cette action est irréversible.</p>
    </div>
    <div>
        <form hx-post="/profil" hx-target="#main">
            <button class="flex w-60 justify-center rounded-md bg-purple px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-purple focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-purple" type="submit" name="deleteaccount">Supprimer mon compte</button>
        </form>
    </div>
</div>