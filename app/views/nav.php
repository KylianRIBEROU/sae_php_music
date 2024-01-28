<a hx-get="/main" hx-target="#main" class="select text-gray-light hover:text-white transition-colors font-bold cursor-pointer text-base flex items-center"><i class="fas fa-home m-4 text-xl"></i><span>Accueil</span></a></li>
<h2 class="text-gray-light font-bold text-base flex items-center"><i class="fas fa-stream m-4 text-xl"></i>Playlists</h2>
<ul class="">
    <li hx-get="/playlists" hx-target="#main" class="select flex h-16 p-2 items-center cursor-pointer rounded-md hover:bg-gray-hover">
        <img class="rounded-md h-full" src="../static/img/liked-songs-300.png" alt="">
        <h3 class="text-white text-base ml-2">Titre likés</h3>
    </li>



    <?php
    for ($i = 0; $i < 15; $i++) {
        ?>
        <li hx-get="/playlists" hx-target="#main" class="select flex h-16 p-2 items-center cursor-pointer rounded-md hover:bg-gray-hover">
            <img class="rounded-md h-full" src="../static/img/220px-Ryan-adams-orion.jpg" alt="">
            <h3 class="text-white text-base ml-2">Oryon</h3>
        </li>
        <?php
    }
    ?>

</ul>
<h2 class="text-gray-light font-bold text-base flex items-center"><i class="fas fa-stream m-4 text-xl"></i>Albums</h2>
<ul>

    
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