
function loadPlayer(){
    let track_list = [];
    let track_index = 0;

    let player = document.getElementById("player");

    let curr_track = document.createElement('audio');
    player.appendChild(curr_track);

    let isPlaying = false;


    let muted = false

    let track_name = document.getElementById("track-name");
    let track_artist = document.getElementById("track-artist");
    let track_img = document.getElementById("track-img");


    let curr_time = document.getElementById("current-time");
    let total_duration = document.getElementById("total-duration");
    let updateTimer; 
    let updateApi;


    //buttons
    let next_btn = document.getElementById("next-track");
    let prev_btn = document.getElementById("prev-track");
    let shuffle_btn = document.getElementById("shuffle-track");
    let repeat_btn = document.getElementById("repeat-track");
    let playpause_btn = document.getElementById("playpause-track");
    let volume_btn = document.getElementById("volume-btn");

    //slider
    let seek_slider = document.getElementById("seek-slider");
    let volume_slider = document.getElementById("volume-slider");

    function setTrackList(tracks){
        track_list = tracks;
    }

    function setTrackIndex(index){
        track_index = index;
    }

    function apiCall(){
        fetch('/api/track.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                track_index: track_index,
                track_list: track_list,
                seek_slider: seek_slider.value,
            })
        })
        .then(response => {
            if (response.ok) {
                console.log('Tracks information sent successfully.');
            } else {
                console.log('Failed to send tracks information.');
            }
        })
        .catch(error => {
            console.log('Error occurred while sending tracks information:', error);
        });
    }

    // function localSave(){
        
    //     localStorage.setItem('track_list', JSON.stringify([...track_list]));
    //     localStorage.setItem('track_index', track_index);

    //     localStorage.setItem('seek_slider', parseFloat(seek_slider.value));
    //     console.log(parseFloat(seek_slider.value));


    //     console.log('Saving to local storage');
    // }


    // Reset Values
    function resetValues() {
        curr_time.textContent = "00:00";
        total_duration.textContent = "00:00";
        seek_slider.value = 0;
    }

    function loadTrack(track_index) {
        if (track_list.length == 0){
            console.log('No tracks to play');
            deactivateButtons();
            return;
        }

        deactivateButtons();
        setVolume();
        clearInterval(updateTimer);
        resetValues();
    
        // Load a new track
        curr_track.src = track_list[track_index].path;
        curr_track.load();

        track_name.textContent = track_list[track_index].name;
        track_artist.textContent = track_list[track_index].artist;
        track_img.src = track_list[track_index].image;
        

        updateTimer = setInterval(seekUpdate, 1000);
        updateApi = setInterval(apiCall, 10000);

        if (track_list.length == 1){
            curr_track.addEventListener("ended", pauseTrack);
        }
        else{
            curr_track.addEventListener("ended", nextTrack);
        }

        activateButtons();
    }

    function playpauseTrack() {
        if (!isPlaying) playTrack();
        else pauseTrack();
    }

    function playTrack() {
        curr_track.play();
        isPlaying = true;
        // Replace icon with the pause icon
        playpause_btn.firstElementChild.innerHTML = '<i class="fas fa-pause-circle"></i>';
    }

    function pauseTrack() {
        curr_track.pause();
        isPlaying = false;
        // Replace icon with the play icon
        playpause_btn.firstElementChild.innerHTML = '<i class="fas fa-play-circle"></i>';;
    }

    function setVolume() {
        if (!muted){
            curr_track.volume = volume_slider.value / 100;
            if (volume_slider.value == 0 ){
                setTimeout(()=>{volume_btn.firstElementChild.innerHTML = '<i class="fas fa-volume-mute"></i>'}, 50);
            }
            else if (volume_slider.value <= 50){
                setTimeout(()=>{volume_btn.firstElementChild.innerHTML = '<i class="fas fa-volume-down"></i>'}, 50);
            }
            else{
                setTimeout(()=>{volume_btn.firstElementChild.innerHTML = '<i class="fas fa-volume-up"></i>'},50);
            }
        }
    }

    function mute(){
        if (muted){
            muted = false;
            setVolume();
        }
        else{

            muted = true;
            curr_track.volume = 0;
            volume_btn.firstElementChild.innerHTML = '<i class="fas fa-volume-mute"></i>';
        }
    }

    function seekTo() {
        let seekto = curr_track.duration * (seek_slider.value / 100);
        curr_track.currentTime = seekto;
        apiCall();
    }

    async function seekToTime(seek_value){
        // Wait until seekto is a finite number
        const seekto_1 = await new Promise((resolve, reject) => {
            // Function to continuously check and resolve the promise
            const checkSeekTo = () => {
                // Calculate the seek position
                let seekto = curr_track.duration * (seek_value / 100);

                // Check if seekto is a finite number
                if (isFinite(seekto)) {
                    // Resolve the promise with the finite value of seekto
                    resolve(seekto);
                } else {
                    // If seekto is not finite, wait for a short interval and check again
                    setTimeout(checkSeekTo, 10);
                }
            };
            // Start checking for seekto
            checkSeekTo();
        });
        // Set the currentTime of the media element
        curr_track.currentTime = seekto_1;
    }

    function seekUpdate() {
        let seekPosition = 0;
        //Check if the current track duration is a legible number
        if (!isNaN(curr_track.duration)) {
        seekPosition = curr_track.currentTime * (100 / curr_track.duration);
        seek_slider.value = seekPosition;
    
        // Calculate the time left and the total duration
        let currentMinutes = Math.floor(curr_track.currentTime / 60);
        let currentSeconds = Math.floor(curr_track.currentTime - currentMinutes * 60);
        let durationMinutes = Math.floor(curr_track.duration / 60);
        let durationSeconds = Math.floor(curr_track.duration - durationMinutes * 60);
    
        // Adding a zero to the single digit time values
        if (currentSeconds < 10) { currentSeconds = "0" + currentSeconds; }
        if (durationSeconds < 10) { durationSeconds = "0" + durationSeconds; }
        if (currentMinutes < 10) { currentMinutes = "0" + currentMinutes; }
        if (durationMinutes < 10) { durationMinutes = "0" + durationMinutes; }
    
        curr_time.textContent = currentMinutes + ":" + currentSeconds;
        total_duration.textContent = durationMinutes + ":" + durationSeconds;
        }
    }

    function nextTrack() {
        if (track_index < track_list.length - 1)
        track_index += 1;
        else track_index = 0;
        loadTrack(track_index);
        playTrack();
        apiCall();
    }
    
    function prevTrack() {
        if (track_index > 0)
        track_index -= 1;
        else track_index = track_list.length-1;
        loadTrack(track_index);
        playTrack();
        apiCall();
    }

    function shuffleTrack() {
        track_index = Math.floor(Math.random() * track_list.length);
        loadTrack(track_index);
        playTrack();
        apiCall();
        
    }

    function repeatTrack() {
        loadTrack(track_index);
        playTrack();
        apiCall();
    }

    function deactivateButtons() {
        playpause_btn.disabled = true;
        volume_btn.disabled = true;
        next_btn.disabled = true;
        prev_btn.disabled = true;
        shuffle_btn.disabled = true;
        repeat_btn.disabled = true;
        //sliders
        seek_slider.disabled = true;
        volume_slider.disabled = true;
    }

    function activateButtons() {
        playpause_btn.disabled = false;
        volume_btn.disabled = false;
        next_btn.disabled = false;
        prev_btn.disabled = false;
        shuffle_btn.disabled = false;
        repeat_btn.disabled = false;
        //sliders
        seek_slider.disabled = false;
        volume_slider.disabled = false;
    }

    deactivateButtons();

    return {track_index, track_list, curr_track, isPlaying, muted, track_name, track_artist, track_img, curr_time, total_duration, updateTimer, updateApi, next_btn, prev_btn, shuffle_btn, repeat_btn, playpause_btn, volume_btn, seek_slider, volume_slider, apiCall, resetValues, loadTrack, playpauseTrack, playTrack, pauseTrack, setVolume, mute, seekTo, seekToTime, seekUpdate, nextTrack, prevTrack, shuffleTrack, repeatTrack, deactivateButtons, activateButtons, setTrackList, setTrackIndex};
}

window.player = loadPlayer();
