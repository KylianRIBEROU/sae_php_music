<?php

if (!isset ($_SESSION['loggedin']) || !$_SESSION['loggedin']) {
    header('Location: /login');
    exit;
}
if (!isset ($_SESSION['isadmin']) || !$_SESSION['isadmin']) {
    header('Location: /');
    exit;
}

use models\Artiste;
$artiste_exists_erreur = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nomArtiste = $_POST['labelArtiste'];
    $liste_noms_artistes = Artiste::getAllArtistes();
    $liste_noms_artistes = array_map(function($artiste) {
        return $artiste->getNomA();
    }, $liste_noms_artistes);
    
    if (in_array($nomArtiste, $liste_noms_artistes)) {
        $artiste_exists_erreur = "Cet artiste existe déjà !";
    }

    else if (strlen($nomArtiste) > 99) {
        $artiste_exists_erreur = "Nom de l'artiste trop long ( 100 caractères max. ) !";
    }
    else{

        $dossier_images = __DIR__. "/../../static/img/";
        if ($_FILES["image-artiste"]["error"] > 0 || $_FILES["image-artiste"]["name"] == "") {
            $image = "default.png";
        }
        else {
            $chemin_image = $dossier_images . basename($_FILES["image-artiste"]["name"]);
            $image = basename($_FILES["image-artiste"]["name"]);
            try {
                move_uploaded_file($_FILES["image-artiste"]["tmp_name"], $chemin_image);
            } catch (Exception $e) {
                $image = "default.png";
                var_dump($e->getMessage());
            }
        }
        $artiste = new Artiste(0, $nomArtiste, $image);
        $artiste->create();
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
    <link rel="stylesheet" href="/static/css/ajout_artiste.css">
    <script src="https://use.fontawesome.com/releases/v5.15.4/js/all.js"></script>
    <title>Ajout artiste</title>
</head>
<body>
<a id="retour-accueil" href="/admin"><i style="margin: 0.4em" class="fas fa-arrow-circle-left"></i>Retour</a>
    
    <div>
        <h1 class="titre-ajout-artiste">Créer un artiste</h1>
    </div>
    <form method="post" enctype="multipart/form-data">
    <div class="container">
        <div class="left-container">
            <label for="labelArtiste">Nom de l'artiste</label>
            <input id="input-nom-artiste" class="input-artiste" type="text" name="labelArtiste" required>
            <p id="erreur-artiste"><?php echo $artiste_exists_erreur; ?></p>
        </div>
        <div class="right-container">
            <!-- select images ici  --> 
            <label for="image-picker">
            <img id="image-preview" src="/static/img/add-image.png" alt="image choisie"/>
            </label>
            <input id="image-picker" type="file" accept="image/*" name="image-artiste">
        </div>
    </div>
        <button type="submit" class="submit-form-button" name="ajout_album">Ajouter l'artiste</button>
    </form>

</body>
</html>

<script>
    const input = document.getElementById('image-picker');
// Sélection de l'élément image
    const preview = document.getElementById('image-preview');

// Ajout d'un écouteur d'événement sur le changement de fichier
    input.addEventListener('change', function() {
    const file = this.files[0]; // Récupération du premier fichier sélectionné

    // Vérification si un fichier est sélectionné
    if (file) {
        const reader = new FileReader(); // Création d'un objet FileReader

        // Fonction de rappel appelée lorsque la lecture est terminée
        reader.onload = function() {
            preview.src = reader.result; // Mise à jour de la source de l'image avec les données de fichier
        }

        reader.readAsDataURL(file); // Lecture du contenu du fichier sous forme d'URL de données
    }
});

</script>