<?php 
use models\Album;
use models\Artiste;
use models\Titre;
use models\favTitre;

$titres = favTitre::GetFavTitresByIdU($_SESSION["id"]);

?>



<div class="flex items-end gap-5 flex-wrap">
    <img class="rounded-md h-[200px]" src="../static/img/liked-songs-300.png" alt="Titres likés">
    <div>
        <h4 class="text-white">Playlist</h4>
        <h1 class="text-white text-7xl font-bold">Titres likés</h1>
        <div class="flex items-center gap-3">
            <h3 class="text-white"><span hx-get="/profil" hx-target="#main" class="font-bold hover:cursor-pointer hover:underline"><?php echo ucfirst(strtolower($_SESSION['username'])); ?></span> • <?php echo count($titres); ?> titre(s)</h3>
        </div>
    </div>
</div>


<div class="flex gap-8 items-center my-5">
<button class=" size-14 text-xl bg-purple text-black justify-center items-center rounded-full transition-transform hover:scale-105"><i class="fas fa-play"></i></button>
</div>


<ul>
<li class=" text-white grid grid-cols-[48px_1fr_48px_48px_48px] gap-3 h-10 border-b-[1px] border-gray border-solid">
    <div class="flex justify-center items-center">#</div>
    <div class="flex items-center">Titre</div>
    <div></div>
    <div class="flex justify-center items-center"><i class="far fa-clock"></i></div>
    <div></div>
</li>
<?php for ($i = 0; $i < count($titres); $i++) { 
    $titre = Titre::getTitreById($titres[$i]->getIdT()) ?>

    <li class="text-white grid grid-cols-[48px_1fr_48px_48px_48px] gap-3 h-16 rounded-md hover:bg-gray-dark-hover group">
        <div class="flex justify-center items-center">
            <div class="group-hover:hidden"><?php echo $i+1; ?></div>
            <button hx-get="/player?titles[]=<?php echo $titre->getIdT() ?>" hx-target="#player" class="text-gray-light text-xs hidden group-hover:block hover:text-white"><i class="fas fa-play"></i></button>
        </div>
        <div class="flex items-center">
            <?php echo $titre->getLabelT(); ?>
        </div>
        <div class="justify-center items-center flex">
            <?php 
                $favTitre = favTitre::getFavTitre($_SESSION["id"], $titre->getIdT());
                if ($favTitre == null){ ?>
                    <button hx-get="/favtitre?id=<?php echo $titre->getIdT(); ?>" hx-swap="outerHTML" class="text-white text-xl hidden group-hover:block"><i class="far fa-heart"></i></button>
                <?php 
                }
                else{ ?>
                    <button hx-get="/favtitre?id=<?php echo $titre->getIdT(); ?>" hx-swap="outerHTML" class="text-purple text-xl"><i class="fas fa-heart"></i></button>
                <?php 
                }
            ?>
        </div>
        <div class="flex justify-center items-center">
            <?php echo $titre->getDuree(); ?>
        </div>
        <div class="justify-center items-center flex">
            <button id="AddTitleToPlaylistButton" hx-get="/popup_playlist?id=<?php echo $titres[$i]->getIdT(); ?>" hx-target="#main" hx-swap="beforeend" class="text-gray-light text-lg hidden group-hover:block hover:text-white"><i class="fas fa-plus"></i></button>
        </div>
    </li>
<?php } ?>
</ul>

