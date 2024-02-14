<?php 

if (!isset ($_SESSION['loggedin']) || !$_SESSION['loggedin']) {
    header('Location: /login');
    exit;
}

if (!isset ($_SESSION['isadmin']) || !$_SESSION['isadmin']) {
    header('Location: /');
    exit;
}

use models\Utilisateur;

$utilisateurs = Utilisateur::getAllUtilisateurs();

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/static/css/utilisateurs.css">
    <script src="https://use.fontawesome.com/releases/v5.15.4/js/all.js"></script>
    <title>Utilisateurs</title>
</head>
<body>
    <div class="container">
        <a id="retour-accueil" href="/admin"><i style="margin: 0.4em" class="fas fa-arrow-circle-left"></i>Retour</a>
        <h1>Les utilisateurs</h1>
        <button class="ajout-utilisateur" onclick="window.location.href='/admin/ajout-utilisateur'" style="cursor: pointer;">
            <a id="ajout-utilisateur" href="/admin/ajout-utilisateur">Ajouter un utilisateur</a>
        </button>
        <?php
            foreach ($utilisateurs as $utilisateur) {
                echo "<div class='utilisateur'>";
                    echo "<div class='infos-utilisateur'>";
                        echo "<h2 class='nom-utilisateur'>" . $utilisateur->getNom() . "</h2>";
                        if ($utilisateur->getAdmin() == 1){
                            echo "<p class='admin'>Administrateur</p>";
                        }
                        else {
                            echo "<p class='admin'>Non administrateur</p>";
                        }
                    echo "</div>";
                    echo "<div class='actions-utilisateur'>";
                        echo "<form action='/admin/utilisateurs' method='post'>";
                            echo "<input type='hidden' name='utilisateur_id' value='" . $utilisateur->getIdU() . "'>";
                            echo "<button type='submit' name='supprimer_utilisateur' class='supprimer-utilisateur'><i class='fas fa-trash-alt'></i></button>";
                        echo "</form>";
                    echo "</div>";
                echo "</div>";
            }
        ?>
    </div>
</body>
</html>