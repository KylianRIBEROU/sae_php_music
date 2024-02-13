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
</div>