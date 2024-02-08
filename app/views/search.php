<ul class="flex gap-3 mb-5">
    <?php 
    if (isset($_GET['filter']) && in_array($_GET['filter'],array('albums','titres','artistes'))){
        echo '<li class="px-3.5 py-1.5 text-white bg-gray rounded-full hover:bg-gray-dark-hover transition-colors text-sm flex justify-center items-center text-center cursor-pointer" hx-get="/search?filter=tout" hx-target="#main">Tout</li>';
    }
    else{

        echo '<li class="px-3.5 py-1.5 text-black bg-white rounded-full  text-sm flex justify-center items-center text-center cursor-pointer" hx-get="/search?filter=tout" hx-target="#main">Tout</li>';
    }

    if (isset($_GET['filter']) && $_GET['filter'] == 'albums'){
        echo '<li class="px-3.5 py-1.5 text-black bg-white rounded-full  text-sm flex justify-center items-center text-center cursor-pointer" hx-get="/search?filter=albums" hx-target="#main">Albums</li>';
    }
    else{
        echo '<li class="px-3.5 py-1.5 text-white bg-gray rounded-full hover:bg-gray-dark-hover transition-colors text-sm flex justify-center items-center text-center cursor-pointer" hx-get="/search?filter=albums" hx-target="#main">Albums</li>';
    }

    if (isset($_GET['filter']) && $_GET['filter'] == 'artistes'){
        echo '<li class="px-3.5 py-1.5 text-black bg-white rounded-full  text-sm flex justify-center items-center text-center cursor-pointer" hx-get="/search?filter=artistes" hx-target="#main">Artistes</li>';
    }
    else{
        echo '<li class="px-3.5 py-1.5 text-white bg-gray rounded-full hover:bg-gray-dark-hover transition-colors text-sm flex justify-center items-center text-center cursor-pointer" hx-get="/search?filter=artistes" hx-target="#main">Artistes</li>';
    }

    if (isset($_GET['filter']) && $_GET['filter'] == 'titres'){
        echo '<li class="px-3.5 py-1.5 text-black bg-white rounded-full  text-sm flex justify-center items-center text-center cursor-pointer" hx-get="/search?filter=titres" hx-target="#main">Titres</li>';
    }
    else{
        echo '<li class="px-3.5 py-1.5 text-white bg-gray rounded-full hover:bg-gray-dark-hover transition-colors text-sm flex justify-center items-center text-center cursor-pointer" hx-get="/search?filter=titres" hx-target="#main">Titres</li>';
    }
    ?>
</ul>

<?php

use models\Album;
use models\Artiste;
use models\Titre;
use models\Genre;
use models\Detient;

$albums = Album::getAllAlbums();
$artistes = Artiste::getAllArtistes();
$titre = Titre::getAllTitres();
$genres = Genre::getAllGenres();

$albumsSearch = [];

if (isset($_GET['search'])){
    $search = $_GET['search'];
    echo '<p class="text-white">Résultats pour : '.$search.'</p>';
    foreach ($albums as $album) {
        if (str_contains($album->getTitreAlbum(), $search)) {
            if (!in_array($album, $albumsSearch)){
                array_push($albumsSearch, $album);
            }

        }
        if (str_contains($album->getAnneeSortie(), $search)) {
            if (!in_array($album, $albumsSearch)){
                array_push($albumsSearch, $album);
            }
        }
        $artiste = Artiste::getArtisteById($album->getIdA());
        if (str_contains($artiste->getNomA(), $search)) {
            if (!in_array($album, $albumsSearch)){
                array_push($albumsSearch, $album);
            }
        }
    }
}

// if (isset($_GET['genre'])){
//     $genre = $_GET['genre'];
//     echo '<p class="text-white">Résultats pour : '.$genre.'</p>';
// }

if (count($albumsSearch) > 0){
    $albums = $albumsSearch;
}
else{
    echo '<h2> Aucun résultat pour « '. $search .' » </h2>';
    echo "<p> Veuillez vérifier l'orthographe ou utiliser moins de mots-clés ou d'autres mots-clés. </p>";
    exit;    
}

?>



<?php
if (isset($_GET['filter']) && $_GET['filter'] == 'albums' || !isset($_GET['filter']) || $_GET['filter'] == 'tout'){
?>

<h2 class="text-white text-2xl text-bold">Albums</h2>
<ul class="grid grid-cols-[repeat(auto-fill,minmax(180px,1fr))] gap-5 my-5">
    <?php
    foreach ($albums as $album) {
        echo '<li class="group  p-4 bg-gray rounded hover:bg-gray-dark-hover transition-colors cursor-pointer ">';
            echo '<div class="relative">';
                echo '<img class="rounded-md" src="../static/img/'. $album->getImageAlbum() .'" alt="Image de l\'album '.$album->getTitreAlbum().'">';
                echo '<button class="absolute bottom-0 right-0 m-2 size-10 bg-purple text-black text-base justify-center items-center rounded-full transition-transform hidden hover:scale-105 group-hover:flex"><i class="fas fa-play"></i></button>';
            echo '</div>';
            echo '<p class="text-white text-base mt-3 font-bold">' . $album->getTitreAlbum() . '</p>';
            $artiste = Artiste::getArtisteById($album->getIdA());
            echo '<p class="text-gray-light text-sm">' . $album->getTitreAlbum() . ' • '. $artiste->getNomA() .'</p>';
            
            

        echo '</li>';
    }
    ?>
</ul>
<?php 
}
?>


<?php 
if (isset($_GET['filter']) && $_GET['filter'] == 'artistes' || !isset($_GET['filter']) || $_GET['filter'] == 'tout'){
?>

<h2 class="text-white text-2xl text-bold">Artistes</h2>
<ul class="grid grid-cols-[repeat(auto-fill,minmax(180px,1fr))] gap-5 my-5">
    <?php
    foreach ($artistes as $artiste) {
        echo '<li class=" p-4 bg-gray rounded hover:bg-gray-dark-hover transition-colors cursor-pointer ">';
            echo '<img class="rounded-full" src="../static/img/default.png" alt="Image de l\'artiste '.$artiste->getNomA().'">';
            echo '<p class="text-white text-base mt-3 font-bold">' . $artiste->getNomA() . '</p>';
        echo '</li>';
    }
    ?>
</ul>
<?php 
}
?>




<?php
if (isset($_GET['filter']) && $_GET['filter'] == 'titres' || !isset($_GET['filter']) || $_GET['filter'] == 'tout'){
?>
<h2 class="text-white text-2xl">Titres</h2>

<ul>
    <?php
    // foreach ($titres as $titre) {
    //     echo '<li>' . $titre->getLabelT() . '</li>';
    // }
    ?>
</ul> 

<?php 
}
?>



