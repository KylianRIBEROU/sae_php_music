<div class="h-full flex p-2 items-center gap-5">
    <img src="../static/img/default.png" class="rounded-md h-full" alt="Current title image">
    <div>
        <h1 class="text-white text-xl font-bold">Oryon</h1>
        <h2 class="text-gray-light text-base font-bold">Ryan Adams</h2>
    </div>
    <div>
        <button class="text-white text-2xl"><i class="far fa-heart"></i></button>
    </div>

</div>

<div class="">
    <div class="flex justify-center items-center p-2 gap-5">
        <button class="text-gray-light text-xl hover:text-white transition-colors"><i class="fas fa-step-backward"></i></button>
        <button class="text-white text-3xl"><i class="fas fa-play-circle"></i></button>
        <button class="text-gray-light text-xl hover:text-white transition-colors"><i class="fas fa-step-forward"></i></button>   
    </div>
    <div class="flex justify-center gap-5">
        <div id="current-time" class="text-white">00:00</div>
        <input type="range" min="1" max="100" value="0" class="accent-purple w-2/4">
        <div id="total-duration" class="text-white">00:00</div>
    </div>

</div> 


<div class="flex items-center justify-end p-2 gap-5">
    <button class="text-white text-2xl"><i class="fas fa-volume-up"></i></button>
    <input type="range" min="0" max="100" value="50" id="soundSlider" class="accent-purple">
</div>