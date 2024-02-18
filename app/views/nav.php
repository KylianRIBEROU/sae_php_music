<?php
if (!isset($_SESSION["loggedin"]) || !$_SESSION["loggedin"]){
    exit;
}

use models\favAlbum;
use models\Album;
use models\Playlist;
?>


<a hx-get="/main" hx-target="#main" class="select text-gray-light hover:text-white transition-colors font-bold cursor-pointer text-base flex items-center"><i class="fas fa-home m-4 text-xl"></i><span>Accueil</span></a></li>
<h2 class="text-gray-light font-bold text-base flex items-center justify-between"><div class="flex items-center"><i class="fas fa-stream m-4 text-xl"></i>Playlists</div><button hx-get="/createplaylist" hx-target="#main" class=" text-xl font-thin hover:text-white"><i class="fas fa-plus"></i></button></h2>
<ul class="">
    <li hx-get="/titrefav" hx-target="#main" class="select flex h-16 p-2 items-center cursor-pointer rounded-md hover:bg-gray-hover">
        <img class="rounded-md h-full" src="../static/img/liked-songs-300.png" alt="">
        <h3 class="text-white text-base ml-2">Titre likés</h3>
    </li>
    <?php 
        $playlists = Playlist::getPlaylistsByIdU($_SESSION["id"]);
        foreach ($playlists as $playlist) {
            ?>
            <li hx-get="/playlists?id=<?php echo $playlist->getIdP(); ?>" hx-target="#main" class="select flex h-16 p-2 items-center cursor-pointer rounded-md hover:bg-gray-hover">
                <img class="rounded-md h-full" src="https://api.dicebear.com/7.x/initials/svg?seed=<?php echo $playlist->getNomP(); ?>" alt="Image de la playlist">
                <h3 class="text-white text-base ml-2"><?php echo $playlist->getNomP(); ?></h3>
            </li>
            <?php
        }
    ?>
</ul>
<h2 class="text-gray-light font-bold text-base flex items-center"><i class="fas fa-stream m-4 text-xl"></i>Albums</h2>
<ul>
    <?php


        $favAlbums = favAlbum::getFavAlbumsByIdU($_SESSION["id"]);

        foreach ($favAlbums as $favAlbum) {
            $album = Album::getAlbumById($favAlbum->getIdAlbum());
            ?>
            <li hx-get="/albums?id=<?php echo $album->getIdAlbum(); ?>" hx-target="#main" class="select flex h-16 p-2 items-center cursor-pointer rounded-md hover:bg-gray-hover">
                <img class="rounded-md h-full" src="../static/img/<?php echo $album->getImageAlbum(); ?>" alt="">
                <h3 class="text-white text-base ml-2"><?php echo $album->getTitreAlbum(); ?></h3>
            </li>
            <?php
        }
    ?>
</ul>

<script>

var nav = document.getElementById("nav");
var btns = nav.getElementsByClassName("select");
for (var i = 0; i < btns.length; i++) {
    btns[i].addEventListener("click", function() {
        var current = document.getElementsByClassName("bg-gray");
        if (current.length > 0) {
            current[0].className = current[0].className.replace(" bg-gray", "");
        }
        if (this.nodeName == "LI") {
            this.className += " bg-gray";
        }
    });
}
</script>