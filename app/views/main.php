<?php
if (!isset($_SESSION["loggedin"]) || !$_SESSION["loggedin"]){
    exit;
}
?>

<h1 class="text-white mb-2">Parcourir tout</h1>

<ul class="grid grid-cols-[repeat(auto-fill,minmax(150px,1fr))] gap-5">
    <?php 

    
    function randomColor() {
        $tabColor = array('rgb(220, 20, 140)','rgb(0, 100, 80)','rgb(132, 0, 231)','rgb(30, 50, 100)','rgb(232, 17, 91)','rgb(186, 93, 7)','rgb(20, 138, 8)','rgb(32, 47, 114)','rgb(225, 17, 140)','rgb(13, 115, 236)','rgb(142, 102, 172)','rgb(230, 30, 50)','rgb(176, 98, 57)','rgb(119, 119, 119)','rgb(71, 125, 149)','rgb(232, 17, 91)','rgb(39, 133, 106)');
        return $tabColor[rand(0, count($tabColor) - 1)];
    }

        use models\Genre;
        $genres = Genre::getAllGenres();
        foreach ($genres as $genre) {
            echo '<li style="background-color : '. randomColor() .'" class="text-white text-center flex items-center justify-center rounded h-[150px] cursor-pointer" hx-get="/search?genre='.$genre->getNomG().'" hx-target="#main" > ';
            echo '<p class="text-xl font-bold">'.$genre->getNomG().'</p>';
            echo '</li>';
        }
    ?>
</ul>