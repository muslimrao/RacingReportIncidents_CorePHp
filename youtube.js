var div_victim_video;
var div_guilty_video;
var done_victim_video = false;
var done_guilty_video = false;

function generate_victim_video() {
    var tag_victim_video = document.createElement('script');
    tag_victim_video.src = "https://www.youtube.com/iframe_api";
    var firstScriptTag_victim_video = document.getElementsByTagName('script')[0];
    firstScriptTag_victim_video.parentNode.insertBefore(tag_victim_video, firstScriptTag_victim_video);


    var tag_guilty_video = document.createElement('script');
    tag_guilty_video.src = "https://www.youtube.com/iframe_api";
    var firstScriptTag_guilty_video = document.getElementsByTagName('script')[0];
    firstScriptTag_guilty_video.parentNode.insertBefore(tag_guilty_video, firstScriptTag_guilty_video);

}

function onYouTubeIframeAPIReady_victim_video(video_id, start_time) {

    $(".play_victim_video").html('<div id="victim_video"></div>');
    div_victim_video = new YT.Player('victim_video', {
        height: '400',
        width: '500',
        videoId: video_id,
        playerVars: {
            /*
            autoplay: 1,
            controls: 1,
            showinfo: 1,
            rel: 0,
            iv_load_policy: 3,
            cc_load_policy: 0,
            fs: 0,
            disablekb: 1,
            loop: true,
            start: 00,
            end: 204
            */
           rel: 0,
           start: start_time,
        },
        events: {
            'onReady': onPlayerReady_victim_video,
            'onStateChange': onPlayerStateChange_victim_video
        }
    });

}

function onYouTubeIframeAPIReady_guilty_video(video_id, start_time) {

    $(".play_guilty_video").html('<div id="guilty_video"></div>');


    window.YT.ready(function () {

        div_guilty_video = new window.YT.Player('guilty_video', {
            height: '400',
            width: '500',
            videoId: video_id,
            playerVars: {
                /*
                autoplay: 1,
                controls: 1,
                showinfo: 1,
                rel: 0,
                iv_load_policy: 3,
                cc_load_policy: 0,
                fs: 0,
                disablekb: 1,
                loop: true,
                end: 204*/
                rel: 0,
                start: start_time,


            },

            events: {
                'onReady': onPlayerReady_guilty_video,
                'onStateChange': onPlayerStateChange_guilty_video
            }
        });

    })




}

function onPlayerReady_victim_video(event) {
    //event.target.playVideo();
}

function onPlayerReady_guilty_video(event) {
    //event.target.playVideo();
}



function onPlayerStateChange_victim_video(event) {
    console.log("----", event);
    if (event.data == YT.PlayerState.PLAYING && !done_victim_video) {
        setTimeout(stopVideo_victim_video, 6000);
        done_victim_video = true;
    }
}

function onPlayerStateChange_guilty_video(event) {
    console.log("----", event);
    /*if (event.data == YT.PlayerState.PLAYING && !done_guilty_video) {
        setTimeout(stopVideo_guilty_video, 6000);
        done_guilty_video = true;
    }*/
}

function stopVideo_victim_video() {
    //div_victim_video.stopVideo();
}

function stopVideo_guilty_video() {
    //div_guilty_video.stopVideo();
}



generate_victim_video();