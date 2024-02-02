<div class="h-full flex p-2 items-center gap-5">
    <img src="" class="rounded-md h-full" alt="Current title image" id="track-img">
    <div>
        <h1 class="text-white text-xl font-bold" id="track-name">No sound</h1>
        <h2 class="text-gray-light text-base font-bold" id="track-artist" >No artist</h2>
    </div>
    <div>
        <button class="text-white text-2xl"><i class="far fa-heart"></i></button>
    </div>

</div>

<div class="">
    <div class="flex justify-center items-center p-2 gap-5">
        <button class="text-gray-light text-xl hover:text-white transition-colors" onclick="shuffleTrack()"><i class="fas fa-random"></i></button>
        <button class="text-gray-light text-xl hover:text-white transition-colors" onclick="prevTrack()"><i class="fas fa-step-backward"></i></button>
        <button class="text-white text-3xl" onclick="playpauseTrack()" id="playpause-track"><i class="fas fa-play-circle"></i></button>
        <button class="text-gray-light text-xl hover:text-white transition-colors" onclick="nextTrack()"><i class="fas fa-step-forward"></i></button>   
        <button class="text-gray-light text-xl hover:text-white transition-colors" onclick="repeatTrack()"><i class="fas fa-redo"></i></button>
    </div>
    <div class="flex justify-center gap-5">
        <div id="current-time" class="text-white">00:00</div>
        <input type="range" min="1" max="100" value="0"  class="accent-purple w-2/4" id="seek-slider" onchange="seekTo()">
        <div id="total-duration" class="text-white">00:00</div>
    </div>

</div> 


<div class="flex items-center justify-end p-2 gap-5">
    <button class="text-white text-2xl" id="volume-btn" onclick="mute()"><i class="fas fa-volume-up"></i></button>
    <input type="range" min="0" max="100" value="50" id="volume-slider" class="accent-purple" onchange="setVolume()">
</div>
<script src="../static/js/player.js" ></script>
<script>
    (async () => {
        try {
            const response = await fetch('../api/track.php', {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json'
                }
            });
            const data = await response.json();
            console.log(data);
            track_list = data['track_list'];
            track_index = data['track_index'];
            
            console.log('before')
            loadTrack(track_index);
            // seek_slider.value = data['seek_slider'];
            console.log(data['seek_slider'])
            // await seekTo();
            
        } catch (error) {
            console.error('Error:', error);
        }
    })();
    
</script>