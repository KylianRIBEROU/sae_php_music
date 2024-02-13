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
<button hx-get="/deleteplaylist?id=<?php echo $playlist->getIdP(); ?>" hx-target="#main" class=" text-xl text-gray-light hover:text-white"><i class="fas fa-trash"></i></button>
</div>


<script>
    editButton = document.getElementById('edit-button');
    isEditing = false;

    function toggleEditPlaylist() {
        isEditing = !isEditing;
        if (isEditing) {
            form = document.createElement('form');
            form.setAttribute('hx-get', '/editplaylist');
            form.setAttribute('hx-target', '#main');
            form.innerHTML = '<input type="hidden" name="id" value="<?php echo $playlist->getIdP(); ?>">'

            form.id = 'edit-form';
            form.classList.add('flex', 'gap-5', 'items-center');

            button = document.createElement('button');
            button.innerHTML = '<i class="fas fa-check"></i>';
            button.classList.add('text-xl', 'text-gray-light', 'hover:text-white');
            button.id = 'submit-button';
            button.type = 'submit';


            input = document.createElement('input');
            input.value = '<?php echo $playlist->getNomP(); ?>';
            input.classList.add('bg-gray', 'text-white', 'p-2', 'rounded-md', 'border', 'border-gray-dark', 'hover:border-gray-light', 'focus:ring-white', 'focus:border-white', 'focus:outline-none', 'focus:ring-1', 'placeholder:text-gray-light', 'focus:ring-blue-500', 'w-[200px]');
            input.id = 'name';
            input.name = 'name';
            form.appendChild(input);
            form.appendChild(button);
            editButton.insertAdjacentElement('afterend', form);
        } else {
            document.getElementById('edit-form').remove();
        }
    }


</script>