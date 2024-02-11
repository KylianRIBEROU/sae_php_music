<div class="h-full flex p-2 items-center gap-5">
    <img src="../static/img/default.png" class="rounded-md h-full" alt="Current title image" id="track-img">
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
        <button class="text-gray-light text-xl hover:text-white transition-colors" onclick="shuffleTrack()" id="shuffle-track"><i class="fas fa-random"></i></button>
        <button class="text-gray-light text-xl hover:text-white transition-colors" onclick="prevTrack()" id="prev-track"><i class="fas fa-step-backward"></i></button>
        <button class="text-white text-3xl" onclick="playpauseTrack()" id="playpause-track"><i class="fas fa-play-circle"></i></button>
        <button class="text-gray-light text-xl hover:text-white transition-colors" onclick="nextTrack()" id="next-track"><i class="fas fa-step-forward"></i></button>   
        <button class="text-gray-light text-xl hover:text-white transition-colors" onclick="repeatTrack()" id="repeat-track"><i class="fas fa-redo"></i></button>
    </div>
    <div class="flex justify-center gap-5">
        <div id="current-time" class="text-white">00:00</div>
        <input type="range" min="0" max="100" value="0"  class="accent-purple w-2/4" id="seek-slider" onchange="seekTo()">
        <div id="total-duration" class="text-white">00:00</div>
    </div>

</div> 


<div class="flex items-center justify-end p-2 gap-5">
    <button class="text-white text-2xl" id="volume-btn" onclick="mute()"><i class="fas fa-volume-up"></i></button>
    <input type="range" min="0" max="100" value="50" id="volume-slider" class="accent-purple" onchange="setVolume()">
</div>
<script src="../static/js/player.js" ></script>
<script>
    // if (localStorage.getItem('track_list') != null) {
    //     try {
    //         track_list = JSON.parse(localStorage.getItem('track_list'));
    //     } catch (error) {
    //         console.error('Error parsing track list:', error);
    //     }
    // }
    // if (localStorage.getItem('track_index') != null) {
    //     track_index = localStorage.getItem('track_index');
    // }
    // loadTrack(track_index);
    // if (localStorage.getItem('seek_slider') != null) {        
    //     seekToTime(parseInt(localStorage.getItem('seek_slider')));;
    // }
    
    fetch('../api/track.php', {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        console.log(data)
        if (Object.keys(data).length > 1) {
            console.log('Track list found');
            track_list = data['track_list'];
            track_index = data['track_index'];
            loadTrack(track_index);
            seekToTime(parseInt(data['seek_slider']));
        }
        else {
            console.error('No track list found');
            console.log("Creating default track list");
            track_list = [
                {
                name: "Spectre",
                artist: "Alan Walker",
                image: "../static/img/ncs.jpg",
                path: "../static/sound/Alan Walker - Spectre [COPYRIGHTED NCS Release].mp3"
                },
                {
                    name: "Faded",
                    artist: "Alan Walker",
                    image: "../static/img/ncs.jpg",
                    path: "../static/sound/Alan Walker - Fade [COPYRIGHTED NCS Release].mp3"
                },
            ];
            track_index = 0;
            loadTrack(track_index);
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
</script>