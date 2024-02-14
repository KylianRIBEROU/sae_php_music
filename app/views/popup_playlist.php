<?php 


if (!isset($_GET['id'])){
    exit;
}

use models\Playlist;
use models\Titre;


        
?>


<div id="modal" class="fixed top-0 bottom-0 right-0 left-0 bg-[rgba(0,0,0,0.5)] z-50 flex flex-col items-center animate-fade-in">
	<div class="modal-underlay absolute -z-10 top-0 bottom-0 left-0 right-0" onclick="closeModal()"></div>
	<div class="modal-content mt-[20vh] max-h-80 w-80 overflow-auto bg-gray-hover p-2 animate-zoom-in">
        <ul>
        <?php 
            $titre = Titre::getTitreById($_GET['id']);
            $playlists = Playlist::getPlaylistsByIdU($_SESSION["id"] );
            $c = 0;

            foreach ($playlists as $playlist) {
                $titres = Titre::getTitresByPlaylistId($playlist->getIdP());
                if (!in_array($titre, $titres)){ $c++;?>
                    
                    <li hx-get="/addtoplaylist?id=<?php echo $playlist->getIdP(); ?>&idT=<?php echo $_GET['id']; ?>" hx-target="#main" class="flex h-16 p-2 items-center cursor-pointer rounded-md  hover:bg-gray-dark-hover">
                        <img class="rounded-md h-full" src="https://api.dicebear.com/7.x/initials/svg?seed=<?php echo $playlist->getNomP(); ?>" alt="Image de la playlist">
                        <h3 class="text-white text-base ml-2"><?php echo $playlist->getNomP(); ?></h3>
                    </li>
                <?php   
                }
            }
            if ($c == 0){
                echo '<li class="text-white text-center">Aucune playlist disponible</li>';
            }
            ?>
        </ul>

    </div>

    <script>
    function closeModal() {
        document.getElementById('modal').remove()
    }
    </script>
</div>

