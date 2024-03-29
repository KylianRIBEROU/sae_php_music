<?php
use models\Album;
use models\Artiste;
use models\Titre;
use models\favTitre;

if (isset($_GET['id'] )){
    $id = $_GET['id'];
    $artiste = Artiste::getArtisteById($id);
    if ($artiste == null){
        echo '<h1 class="text-white">Artiste non trouvé</h1>';
        exit;
    }
}
else{
    echo '<h1 class="text-white">Artiste non trouvé</h1>';
    exit;
}
?>

<div class="flex items-center gap-5 flex-wrap">
    <img class="rounded-full w-[200px]" src="../static/img/<?php echo $artiste->getImageA(); ?>" alt="<?php echo $artiste->getNomA(); ?>" >
    <div>
        <h4 class="text-white">Artiste</h4>
        <h1 class="text-white text-7xl font-bold mb-2"><?php echo $artiste->getNomA(); ?></h1>
        <h3 class="text-white"><?php echo count(Album::getAlbumsByIdA($artiste->getIdA())); ?> album(s) • <?php echo count(Titre::getTitresByAuteurId($artiste->getIdA())); ?> titre(s)</h3>
    </div>
</div>


<h2 class="text-white text-2xl text-bold mt-5">Albums</h2>
<ul class="grid grid-cols-[repeat(auto-fill,minmax(180px,1fr))] gap-5 my-5">
    <?php
    $albums = Album::getAlbumsByIdA($artiste->getIdA());
    foreach ($albums as $album) {
        $titres = Titre::getTitresByAlbumId($album->getIdAlbum());
        ?>
        <li hx-get="/albums?id=<?php echo $album->getIdAlbum(); ?>" hx-target="#main" class="group  p-4 bg-gray rounded hover:bg-gray-dark-hover transition-colors cursor-pointer ">
            <div class="relative">
                <img class="rounded-md" src="../static/img/<?php echo $album->getImageAlbum(); ?>" alt="Image de l'album <?php echo $album->getTitreAlbum(); ?>">
                <button hx-get="/player?titles[]=
                <?php for ($i = 0; $i < count($titres); $i++) { 
                    if ($i != 0){
                        echo "&titles[]=";
                    }
                    $titre = Titre::getTitreById($titres[$i]->getIdT());
                    echo $titre->getIdT();
                }
                ?>" hx-target="#player" class="absolute bottom-0 right-0 m-2 size-10 bg-purple text-black text-base justify-center items-center rounded-full transition-transform hidden hover:scale-105 group-hover:flex z-50"><i class="fas fa-play"></i></button>
            </div>
            <p class="text-white text-base mt-3 font-bold"><?php echo $album->getTitreAlbum(); ?></p>
            <p class="text-gray-light text-sm"><?php echo $album->getTitreAlbum(); ?> • <?php echo $artiste->getNomA(); ?></p>
        </li>
        <?php
    }
    ?>
</ul>

<h2 class="text-white text-2xl text-bold mt-5">Titres</h2>
<ul>
    <?php $titres = Titre::getTitresByAuteurId($artiste->getIdA()); 
    for ($i = 0; $i < count($titres); $i++) { ?>
    <li class="text-white grid grid-cols-[48px_1fr_48px_48px_48px] gap-3 h-16 rounded-md hover:bg-gray-dark-hover group">
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
            <button class="text-gray-light text-lg hidden group-hover:block hover:text-white"><i class="fas fa-plus"></i></button>
        </div>
    </li>
<?php } ?>
</ul>
