<?php

use models\Album;
use models\Artiste;
use models\Titre;
use models\favAlbum;
use models\favTitre;

if (isset($_GET['id'] )){
    $id = $_GET['id'];
    $album = Album::getAlbumById($id);
    if ($album == null){

        echo '<h1 class="text-white">Album non trouvé</h1>';
        exit;
    }
}
else{
    echo '<h1 class="text-white">Album non trouvé</h1>';
    exit;
}

$titres = Titre::getTitresByAlbumId($album->getIdAlbum());
$artiste = Artiste::getArtisteById($album->getIdA());

?>

<div class="flex items-end gap-5 flex-wrap">
    <img class="rounded-md" src="../static/img/<?php echo $album->getImageAlbum(); ?>" alt="<?php echo $album->getTitreAlbum(); ?>" class="w-1/2">
    <div>
        <h4 class="text-white">Album</h4>
        <h1 class="text-white text-7xl font-bold"><?php echo $album->getTitreAlbum(); ?></h1>
        <div class="flex items-center gap-3">
            <img class="rounded-full h-10" src="../static/img/default.png" alt="Image de l'artiste <?php echo $artiste->getNomA(); ?>">
            <h3 class="text-white"><span hx-get="/artists?id=<?php echo $artiste->getIdA(); ?>" hx-target="#main" class="font-bold hover:cursor-pointer hover:underline"><?php echo $artiste->getNomA(); ?></span> • <?php echo $album->getAnneeSortie(); ?> • <?php echo count($titres); ?> titre(s)</h3>
        </div>
    </div>
</div>
<div class="flex gap-8 items-center my-5">
<button hx-get="/player?titles[]=
<?php for ($i = 0; $i < count($titres); $i++) { 
    if ($i != 0){
        echo "&titles[]=";
    }
    $titre = Titre::getTitreById($titres[$i]->getIdT());
    echo $titre->getIdT();
}
?>" hx-target="#player" class=" size-14 text-xl bg-purple text-black justify-center items-center rounded-full transition-transform hover:scale-105"><i class="fas fa-play"></i></button>
</div>

<?php 
    $favAlbum = favAlbum::getFavAlbum($_SESSION["id"], $album->getIdAlbum());
    if ($favAlbum == null){ ?>
        <button hx-get="/favalbum?id=<?php echo $album->getIdAlbum(); ?>" hx-target="#main" class="text-white text-3xl"><i class="far fa-heart"></i></button>
    <?php 
    }
    else{ ?>
        <button hx-get="/favalbum?id=<?php echo $album->getIdAlbum(); ?>" hx-target="#main" class="text-purple text-3xl"><i class="fas fa-heart"></i></button>
    <?php 
    } 
?>
</div>


<ul>
<li class=" text-white grid grid-cols-[48px_1fr_48px_48px_48px] gap-3 h-10 border-b-[1px] border-gray border-solid">
    <div class="flex justify-center items-center">#</div>
    <div class="flex items-center">Titre</div>
    <div></div>
    <div class="flex justify-center items-center"><i class="far fa-clock"></i></div>
    <div></div>
</li>
<?php for ($i = 0; $i < count($titres); $i++) { ?>
    <li class="text-white grid grid-cols-[48px_1fr_48px_48px_48px] gap-3 h-16 rounded-md hover:bg-gray-dark-hover group relative ">
        <div class="flex justify-center items-center">
            <div class="group-hover:hidden"><?php echo $i+1; ?></div>
            <button hx-get="/player?titles[]=<?php echo $titres[$i]->getIdT() ?>" hx-target="#player" class="text-gray-light text-xs hidden group-hover:block hover:text-white"><i class="fas fa-play"></i></button>
        </div>
        <div class="flex items-center">
            <?php echo $titres[$i]->getLabelT(); ?>
        </div>
        <div class="justify-center items-center flex">
            <?php 
                $favTitre = favTitre::getFavTitre($_SESSION["id"], $titres[$i]->getIdT());
                if ($favTitre == null){ ?>
                    <button hx-get="/favtitre?id=<?php echo $titres[$i]->getIdT(); ?>" hx-swap="outerHTML" class="text-gray-light text-xl hidden group-hover:block hover:text-white"><i class="far fa-heart"></i></button>
                <?php 
                }
                else{ ?>
                    <button hx-get="/favtitre?id=<?php echo $titres[$i]->getIdT(); ?>" hx-swap="outerHTML" class="text-purple text-xl"><i class="fas fa-heart"></i></button>
                <?php 
                }
            ?>
        </div>
        <div class="flex justify-center items-center">
            <?php echo $titres[$i]->getDuree(); ?>
        </div>
        <div class="justify-center items-center flex">
            <button id="AddTitleToPlaylistButton" hx-get="/popup_playlist?id=<?php echo $titres[$i]->getIdT(); ?>" hx-target="#main" hx-swap="beforeend" class="text-gray-light text-lg hidden group-hover:block hover:text-white"><i class="fas fa-plus"></i></button>
        </div>
    </li>
<?php } ?>
</ul>

