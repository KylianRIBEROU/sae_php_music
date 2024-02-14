<?php

use models\Album;
use models\Artiste;
use models\Titre;
use models\favAlbum;
use models\favTitre;
use models\Playlist;

if (isset($_GET['id'] )){
    $id = $_GET['id'];
    $playlist = Playlist::getPlaylistById($id);
    if ($playlist == null){

        echo '<h1 class="text-white">Playlist non trouvé</h1>';
        exit;
    }
}
else{
    echo '<h1 class="text-white">Playlist non trouvé</h1>';
    exit;
}

$titres = Titre::getTitresByPlaylistId($playlist->getIdP());

?>

<div class="flex items-end gap-5 flex-wrap">
    <img class="rounded-md h-[200px]" src="https://api.dicebear.com/7.x/initials/svg?seed=<?php echo $playlist->getNomP(); ?>" alt="Image de la playlist">
    <div>
        <h4 class="text-white">Playlist</h4> 
        <h1 class="text-white text-7xl font-bold"><?php echo $playlist->getNomP() ?></h1>
        <div class="flex items-center gap-3">
            <h3 class="text-white"><span hx-get="/profil" hx-target="#main" class="font-bold hover:cursor-pointer hover:underline"><?php echo ucfirst(strtolower($_SESSION['username'])); ?></span> • <?php echo count($titres); ?> titre(s)</h3>
        </div>
    </div>
</div>


<div class="flex gap-8 items-center my-5">
<button class=" size-14 text-xl bg-purple text-black justify-center items-center rounded-full transition-transform hover:scale-105"><i class="fas fa-play"></i></button>
<button id="edit-button" onclick="toggleEditPlaylist()" class=" text-xl text-gray-light hover:text-white"><i class="fas fa-pen"></i></button>
<form id="editForm" hx-get="/editplaylist" hx-target="#main" class="hidden flex items-center gap-5">
    <input type="hidden" name="id" value="<?php echo $playlist->getIdP(); ?>">
    <input type="text" name="name" id="name" value="<?php echo $playlist->getNomP(); ?>" class="bg-gray text-white p-2 rounded-md border border-gray-dark hover:border-gray-light focus:ring-white focus:border-white focus:outline-none focus:ring-1 placeholder:text-gray-light focus:ring-blue-500 w-[200px]">
    <button type="submit" class=" text-xl text-gray-light hover:text-white"><i class="fas fa-check"></i></button>
</form>
<button hx-get="/deleteplaylist?id=<?php echo $playlist->getIdP(); ?>" hx-target="#main" class=" text-xl text-gray-light hover:text-white"><i class="fas fa-trash"></i></button>
</div>


<ul>
<li class=" text-white grid grid-cols-[48px_1fr_48px_48px_48px_48px] gap-3 h-10 border-b-[1px] border-gray border-solid ">
    <div class="flex justify-center items-center">#</div>
    <div class="flex items-center">Titre</div>
    <div></div>
    <div class="flex justify-center items-center"><i class="far fa-clock"></i></div>
    <div></div>
    <div></div>
</li>
<?php for ($i = 0; $i < count($titres); $i++) { ?>
    <li class="text-white grid grid-cols-[48px_1fr_48px_48px_48px_48px] gap-3 h-16 rounded-md hover:bg-gray-dark-hover group relative">
        <div class="flex justify-center items-center">
            <div class="group-hover:hidden"><?php echo $i+1; ?></div>
            <button class="text-gray-light text-xs hidden group-hover:block hover:text-white"><i class="fas fa-play"></i></button>
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
        <div class="justify-center items-center flex">
            <button hx-get="/removefromplaylist?id=<?php echo $playlist->getIdP(); ?>&idT=<?php echo $titres[$i]->getIdT(); ?>" hx-target="#main" class="text-gray-light text-xl hidden group-hover:block hover:text-white"><i class="fas fa-trash"></i></button>
        </div>
    </li>
<?php } ?>
</ul>



<script>
    form = document.getElementById('editForm');
    function toggleEditPlaylist() {
        form.classList.toggle('hidden');
    }
</script>
