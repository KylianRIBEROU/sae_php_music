<?php

use models\Album;
use models\Artiste;
use models\Titre;

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
            <h3 class="text-white"><span class="font-bold"><?php echo $artiste->getNomA(); ?></span> • <?php echo $album->getAnneeSortie(); ?> • <?php echo count($titres); ?> titre(s)</h3>
        </div>
    </div>
</div>
<div class="flex gap-8 items-center my-5">
<button class=" size-14 text-xl bg-purple text-black justify-center items-center rounded-full transition-transform hover:scale-105"><i class="fas fa-play"></i></button>
<button class="text-white text-3xl"><i class="far fa-heart"></i></button>
</div>


<ul>
<li class=" text-white grid grid-cols-[48px_1fr_48px_48px_48px] gap-3 h-10">
    <div class="flex justify-center items-center">#</div>
    <div class="flex items-center">Titre</div>
    <div></div>
    <div class="flex justify-center items-center"><i class="far fa-clock"></i></div>
    <div></div>
</li>
<?php for ($i = 0; $i < count($titres); $i++) { ?>
    <li class="text-white grid grid-cols-[48px_1fr_48px_48px_48px] gap-3 h-16 rounded-md hover:bg-gray-dark-hover group">
        <div class="flex justify-center items-center">
            <div class="group-hover:hidden"><?php echo $i+1; ?></div>
            <div class="text-white text-xs hidden group-hover:block"><i class="fas fa-play"></i></div>
        </div>
        <div class="flex items-center">
            <?php echo $titres[$i]->getLabelT(); ?>
        </div>
        <div class="justify-center items-center flex">
            <button class="text-white text-xl hidden group-hover:block"><i class="far fa-heart"></i></button>
        </div>
        <div class="flex justify-center items-center">
            <?php echo $titres[$i]->getDuree(); ?>
        </div>
        <div class="justify-center items-center flex">
            <button class="text-white text-lg hidden group-hover:block"><i class="fas fa-ellipsis-h"></i></button>
        </div>
    </li>
<?php } ?>
</ul>