<?php
if (isset($_GET['search'])){
    $_SESSION['search'] = $_GET['search'];
    if (empty($_GET['search'])){
        $_SESSION['filter'] = 'tout';
    }
}

if (isset($_GET['genre'])){
    $_SESSION['search'] = $_GET['genre'];
    $_SESSION['filter'] = 'tout';
}

if (isset($_GET['filter'])){
    $_SESSION['filter'] = $_GET['filter'];
}
else{
    if (!isset($_SESSION['filter'])){
        $_SESSION['filter'] = 'tout';
    }
}

use models\Album;
use models\Artiste;
use models\Titre;
use models\Genre;
use models\favTitre;

$albums = Album::getAllAlbums();
$artistes = Artiste::getAllArtistes();
$titres = Titre::getAllTitres();

if (isset($_SESSION['search']) && !empty($_SESSION['search'])){
    $albumsSearch = [];
    $artistesSearch = [];
    $titresSearch = [];

    foreach ($albums as $album) {
        $artisteAlbum = Artiste::getArtisteById($album->getIdA());
        $titresAlbum = Titre::getTitresByAlbumId($album->getIdAlbum());
        $genresAlbum = Genre::getGenresByIdAlbum($album->getIdAlbum());


        // si le titre de l'album contient la recherche
        if (preg_match('/' . preg_quote($_SESSION['search'], '/') . '/i', $album->getTitreAlbum())){
            if (!in_array($album, $albumsSearch)){
                array_push($albumsSearch, $album);
            }
            if (!in_array($artisteAlbum, $artistesSearch)){
                array_push($artistesSearch, $artisteAlbum);
            }
            foreach ($titresAlbum as $titreAlbum) {
                if (!in_array($titreAlbum, $titresSearch)){
                    array_push($titresSearch, $titreAlbum);
                }
            }
        }

        if (isset($genresAlbum)){
            foreach ($genresAlbum as $genre) {
                // si le genre de l'album contient la recherche
                if (preg_match('/' . preg_quote($_SESSION['search'], '/') . '/i', $genre->getNomG())){
                    if (!in_array($album, $albumsSearch)){
                        array_push($albumsSearch, $album);
                    }
                    if (!in_array($artisteAlbum, $artistesSearch)){
                        array_push($artistesSearch, $artisteAlbum);
                    }
                    foreach ($titresAlbum as $titreAlbum) {
                        if (!in_array($titreAlbum, $titresSearch)){
                            array_push($titresSearch, $titreAlbum);
                        }
                    }
                }
            }
        }

        // si l'année de sortie de l'album contient la recherche
        if (preg_match('/' . preg_quote($_SESSION['search'], '/') . '/i', $album->getAnneeSortie())){
            if (!in_array($album, $albumsSearch)){
                array_push($albumsSearch, $album);
            }
            if (!in_array($artisteAlbum, $artistesSearch)){
                array_push($artistesSearch, $artisteAlbum);
            }
            foreach ($titresAlbum as $titreAlbum) {
                if (!in_array($titreAlbum, $titresSearch)){
                    array_push($titresSearch, $titreAlbum);
                }
            }
        }
        
        // si le nom de l'artiste contient la recherche
        if (preg_match('/' . preg_quote($_SESSION['search'], '/') . '/i', $artisteAlbum->getNomA())){
            if (!in_array($album, $albumsSearch)){
                array_push($albumsSearch, $album);
            }
            if (!in_array($artisteAlbum, $artistesSearch)){
                array_push($artistesSearch, $artisteAlbum);
            }
            foreach ($titresAlbum as $titreAlbum) {
                if (!in_array($titreAlbum, $titresSearch)){
                    array_push($titresSearch, $titreAlbum);
                }
            }
        }

        // genres
    }
    


    foreach ($artistes as $artiste) {
        $albumsArtiste = Album::getAlbumsByIdA($artiste->getIdA());
        $titresArtiste = Titre::getTitresByAuteurId($artiste->getIdA());
        // si le nom de l'artiste contient la recherche
        if (preg_match('/' . preg_quote($_SESSION['search'], '/') . '/i', $artiste->getNomA())){
            if (!in_array($artiste, $artistesSearch)){
                array_push($artistesSearch, $artiste);
            }
            foreach ($albumsArtiste as $albumsArtiste) {
                if (!in_array($albumsArtiste, $albumsSearch)){
                    array_push($albumsSearch, $albumsArtiste);
                }
            }
            foreach ($titresArtiste as $titresArtiste) {
                if (!in_array($titresArtiste, $titresSearch)){
                    array_push($titresSearch, $titresArtiste);
                }
            }
        }

    }
    

    foreach ($titres as $titre) {
        if (preg_match('/' . preg_quote($_SESSION['search'], '/') . '/i', $titre->getLabelT())) {
            if (!in_array($titre, $titresSearch)){
                array_push($titresSearch, $titre);
            }
        }
    }

    $albums = $albumsSearch;
    $artistes = $artistesSearch;
    $titres = $titresSearch;

    if (count($albums) == 0 && count($artistes) == 0 && count($titres) == 0){
        ?>
        <div class=" h-full flex flex-col justify-center items-center" >
            <h2 class=" text-white text-2xl"> Aucun résultat pour « <?php echo $_SESSION['search']; ?> » </h2>
            <p class=" text-white text-xl"> Veuillez vérifier l'orthographe ou utiliser moins de mots-clés ou d'autres mots-clés. </p>
        </div>
        <?php
        exit;
    }
}

?>
<ul class="flex gap-3 mb-5">
    <?php if (isset($_SESSION['filter']) && $_SESSION['filter'] == 'tout'){ ?>
        <li class="px-3.5 py-1.5 text-black bg-white rounded-full  text-sm flex justify-center items-center text-center cursor-pointer" hx-get="/search?filter=tout" hx-target="#main">Tout</li>
    <?php } else { ?>
        <li class="px-3.5 py-1.5 text-white bg-gray rounded-full hover:bg-gray-dark-hover transition-colors text-sm flex justify-center items-center text-center cursor-pointer" hx-get="/search?filter=tout" hx-target="#main">Tout</li>
    <?php } ?>
    <?php if (isset($_SESSION['filter']) && $_SESSION['filter'] == 'albums'){ ?>
        <li class="px-3.5 py-1.5 text-black bg-white rounded-full  text-sm flex justify-center items-center text-center cursor-pointer" hx-get="/search?filter=albums" hx-target="#main">Albums</li>
    <?php } else { ?>
        <li class="px-3.5 py-1.5 text-white bg-gray rounded-full hover:bg-gray-dark-hover transition-colors text-sm flex justify-center items-center text-center cursor-pointer" hx-get="/search?filter=albums" hx-target="#main">Albums</li>
    <?php } ?>
    <?php if (isset($_SESSION['filter']) && $_SESSION['filter'] == 'artistes'){ ?>
        <li class="px-3.5 py-1.5 text-black bg-white rounded-full  text-sm flex justify-center items-center text-center cursor-pointer" hx-get="/search?filter=artistes" hx-target="#main">Artistes</li>
    <?php } else { ?>
        <li class="px-3.5 py-1.5 text-white bg-gray rounded-full hover:bg-gray-dark-hover transition-colors text-sm flex justify-center items-center text-center cursor-pointer" hx-get="/search?filter=artistes" hx-target="#main">Artistes</li>
    <?php } ?>
    <?php if (isset($_SESSION['filter']) && $_SESSION['filter'] == 'titres'){ ?>
        <li class="px-3.5 py-1.5 text-black bg-white rounded-full  text-sm flex justify-center items-center text-center cursor-pointer" hx-get="/search?filter=titres" hx-target="#main">Titres</li>
    <?php } else { ?>
        <li class="px-3.5 py-1.5 text-white bg-gray rounded-full hover:bg-gray-dark-hover transition-colors text-sm flex justify-center items-center text-center cursor-pointer" hx-get="/search?filter=titres" hx-target="#main">Titres</li>
    <?php } ?>
</ul>


<!-- <h1 class="text-white">Filtre : <?php //echo $_SESSION['filter'] ?></h1>
<h1 class="text-white">Search : <?php //echo $_SESSION['search'] ?></h1> -->



<?php if ($_SESSION['filter'] == 'tout' || $_SESSION['filter'] == 'albums') { ?>
<h2 class="text-white text-2xl text-bold">Albums</h2>
<ul class="grid grid-cols-[repeat(auto-fill,minmax(180px,1fr))] gap-5 my-5">
    <?php
    foreach ($albums as $album) {
        ?>
        <li hx-get="/albums?id=<?php echo $album->getIdAlbum(); ?>" hx-target="#main" class="group  p-4 bg-gray rounded hover:bg-gray-dark-hover transition-colors cursor-pointer ">
            <div class="relative">
                <img class="rounded-md" src="../static/img/<?php echo $album->getImageAlbum(); ?>" alt="Image de l'album <?php echo $album->getTitreAlbum(); ?>">
                <button class="absolute bottom-0 right-0 m-2 size-10 bg-purple text-black text-base justify-center items-center rounded-full transition-transform hidden hover:scale-105 group-hover:flex"><i class="fas fa-play"></i></button>
            </div>
            <p class="text-white text-base mt-3 font-bold"><?php echo $album->getTitreAlbum(); ?></p>
            <?php
            $artiste = Artiste::getArtisteById($album->getIdA());
            ?>
            <p class="text-gray-light text-sm"><?php echo $album->getTitreAlbum(); ?> • <?php echo $artiste->getNomA(); ?></p>
        </li>
        <?php
    }
    ?>
</ul>
<?php } ?>

<?php if ($_SESSION['filter'] == 'tout' || $_SESSION['filter'] == 'artistes') { ?>
<h2 class="text-white text-2xl text-bold">Artistes</h2>
<ul class="grid grid-cols-[repeat(auto-fill,minmax(180px,1fr))] gap-5 my-5">
    <?php
    foreach ($artistes as $artiste) {
        ?>
        <li hx-get="/artists?id=<?php echo $artiste->getIdA() ?>" hx-target="#main" class=" p-4 bg-gray rounded hover:bg-gray-dark-hover transition-colors cursor-pointer ">
            <img class="rounded-full" src="../static/img/default.png" alt="Image de l'artiste <?php echo $artiste->getNomA(); ?>">
            <p class="text-white text-base mt-3 font-bold"><?php echo $artiste->getNomA(); ?></p>
        </li>
        <?php
    }
    ?>
</ul>
<?php } ?>

<?php if ($_SESSION['filter'] == 'tout' || $_SESSION['filter'] == 'titres') { ?>
    <h2 class="text-white text-2xl mb-3">Titres</h2>


    <ul>
        <?php if ($_SESSION['filter'] == 'titres'){ ?>
        <li class=" text-white grid grid-cols-[48px_1fr_48px_48px_48px] gap-3 h-10 border-b-[1px] border-gray border-solid">
            <div class="flex justify-center items-center">#</div>
            <div class="flex items-center">Titre</div>
            <div></div>
            <div class="flex justify-center items-center"><i class="far fa-clock"></i></div>
            <div></div>
        </li>
        <?php } ?>
        <?php for ($i = 0; $i < count($titres); $i++) { ?>
            <li class="text-white grid grid-cols-[48px_1fr_48px_48px_48px] gap-3 h-16 rounded-md hover:bg-gray-dark-hover group">
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
            </li>
        <?php } ?>
    </ul>
<?php } ?>





