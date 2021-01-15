


String.prototype.toHHMMSS = function () {
    var sec_num = parseInt(this, 10); // don't forget the second param
    var hours = Math.floor(sec_num / 3600);
    var minutes = Math.floor((sec_num - (hours * 3600)) / 60);
    var seconds = sec_num - (hours * 3600) - (minutes * 60);

    if (hours < 10) { hours = "0" + hours; }
    if (minutes < 10) { minutes = "0" + minutes; }
    if (seconds < 10) { seconds = "0" + seconds; }
    return hours + ':' + minutes + ':' + seconds;
}

function _waiting_screen(mode1, mode2) {
    if (mode2 == null) {

    }

    if ((mode1 == "show") || (mode1 == "in")) {



        $.blockUI({
            css: {
                border: 'none',
                padding: '15px',
                backgroundColor: '#000',
                '-webkit-border-radius': '10px',
                '-moz-border-radius': '10px',
                opacity: .5,
                color: '#fff'
            }
        });



        $(".waiting_screen").show();
    }
    else if (mode1 == "hide") {
        $('.blockOverlay').attr('title', 'Click to unblock').click($.unblockUI);

        $('.blockOverlay').click();

        $(".waiting_screen").fadeOut("slow");
    }

}

function convert_youtube_start_time(start_time) {
    var hms = start_time; // your input string
    var a = hms.split(':'); // split it at the colons
    // minutes are worth 60 seconds. Hours are worth 60 minutes.
    var seconds = (+a[0]) * 60 * 60 + (+a[1]) * 60 + (+a[2]);
    return seconds
}

function set_reports(status) {

    if ($(".play_victim_video #victim_video > img").length > 0) {
        alert("There is no video.");
        return
    }
    else {
        if (div_victim_video.getPlayerState() == 1 || div_victim_video.getPlayerState() == 2) {

        }
        else {
            alert("Play the video or Pause somewhere to lock timestamp");
            return;
        }
    }

    var incident_ID = $("input[name='incident_ID'").val();
    var newCrashData = {}

    if (status == "!") {
        status = "Race Incident";
    }
    else if (status == "!!") {
        status = "Warning";
    }

    if (status == "NEW CRASH") {

        if (div_victim_video.getPlayerState() == 1 || div_victim_video.getPlayerState() == 2) {
            newCrashData = {
                "timestamp_in_seconds": div_victim_video.getCurrentTime(),
                "timestamp_in_hhmmss": div_victim_video.getCurrentTime().toString().toHHMMSS(),
                "video_id": div_victim_video.getVideoData().video_id
            }

            ajax_set_juez(incident_ID, status, newCrashData);
        }
        else {
            alert("Play the video or Pause somewhere to lock timestamp");
        }

    }
    else {

        ajax_set_juez(incident_ID, status)
    }

}


function ajax_set_juez(incident_ID, status, newCrashData) {
    if (newCrashData == null || newCrashData == 'undefined') {
        newCrashData = false;
    }

    _waiting_screen("show");

    $.ajax({
        type: "POST",
        url: 'index.php?option=com_reportincidents&task=set_juez&format=raw',
        //url: "ajax_set_juez.php",
        data: {
            "incident_ID": (incident_ID),
            "status": status,
            "newCrashData": newCrashData
        },
        success: function (response) {

            _waiting_screen("hide");

            if (response == "") {
                alert("Response Error (Set Penalties): Contact Administrator");
            }

            var data = JSON.parse(response);


            if (data.status == "error") {
                alert(data.message);
            } else {

                alert(data.message);

                ajax_incidents_list(false, null);

                ajax_get_juez(incident_ID, false);
            }
        },
        error: function (response) {

        }

    });
}


function ajax_incidents_list(click_first_item, select_field) {

    if (select_field != null) {
        if (select_field.attr("name") == "category" || select_field.attr("track") == "category") {
            $("select[name='victim_racer'], select[name='select_guilty_racer']").val('');
        }
    }


    var category = $("select[name='category']").val();
    var track = $("select[name='track']").val();
    var victim_racer = $("select[name='victim_racer']").val();
    var guilty_racer = $("select[name='select_guilty_racer']").val();





    _waiting_screen("show");

    $.ajax({
        type: "POST",
        //async: false,
        url: 'index.php?option=com_reportincidents&task=incidents_list&format=raw',
        //url: "ajax_incidents_list.php",
        data: "category=" + category + "&track=" + track + "&victim_racer=" + victim_racer + "&guilty_racer=" + guilty_racer, // + "&victim_racer=" + victim_racer,
        success: function (response) {

            _waiting_screen("hide");

            if (response == "") {
                alert("Response Error (Incident List): Contact Administrator");
            }

            var data = JSON.parse(response);

            if (data.status == "error") {
                $(".incident_list").html(data.message);
                $("input[name='incident_ID']").val('');
                $(".play_victim_video, .play_guilty_video").html('<div id="victim_video"><img src="images/video-placeholder.png" /></div>');
                $(".juez_images").html('');

                $(".show_guilty_dropdown").html('<select name="select_guilty_racer" data-type="g"><option value="">Select a racer video</option></select>');
                $(".show_victim_dropdown").html('<select name="victim_racer" data-type="g"><option value="">Select a racer video</option></select>');


                $(".no_guilty_video_found #guilty_video_racer").hide();
            } else {
                console.log(data);

                $(".incident_list").html(data.message.data);



                $(".incident_list tr[data-inci_id='" + $("input[name='incident_ID'").val() + "']").addClass("opened");
                if (click_first_item) {
                    $(".tableinci-list tr").eq(1).click();
                }
                else {

                }

            }
        },
        error: function (response) {

        }

    });
}

function ajax_get_videos(incident_id) {

    _waiting_screen("show");

    $(".no_guilty_video_found").hide();
    $("#incident_tags").val('');


    $.ajax({
        type: "POST",
        //async: false,
        url: 'index.php?option=com_reportincidents&task=get_videos&format=raw',
        //url: "ajax_get_videos.php",

        data: "incident_id=" + incident_id,
        success: function (response) {


            _waiting_screen("hide");
            if (response == "") {
                alert("Response Error (Victim Video): Contact Administrator");
            }

            var data = JSON.parse(response);

            if (data.status == "error") {

                $(".play_victim_video").html(data.message);

            } else {

                $(".span_victim_name").text(data.message.data.Afectado);
                $(".span_guilty_name").text(data.message.data.Reportado);



                $(".type_of_incident").html(data.message.data.Incidente);
                $(".summary_of_incident").html(data.message.data.Resumen);
                $(".lap").html(data.message.data.Lap);
                $(".fetcha").html(data.message.data.Fecha);

                $(".show_guilty_dropdown").html(data.message.data.guilty_dropdown);
                $(".show_victim_dropdown").html(data.message.data.victim_dropdown);

                onYouTubeIframeAPIReady_victim_video(
                    data.message.data.victim_video_ID,
                    convert_youtube_start_time(data.message.data.victim_video_STARTTIME)
                );

                if ($("select[name='select_guilty_racer'] option").length > 1) {
                    var _realName = "";
                    $('select[name=select_guilty_racer] option').each(function () {

                        if (this.value.toLowerCase() === data.message.data.Reportado.toLowerCase()) {
                            _realName = this.value;
                        }
                    });

                    $('select[name=select_guilty_racer]').val(_realName);


                    if (_realName == "") {
                        $(".no_guilty_video_found .html").text("Guilty video not found for: " + data.message.data.Reportado);
                        $(".no_guilty_video_found").show();
                    }

                    $("select[name='select_guilty_racer']").find('option').get(0).remove();

                }
                else {
                    $(".no_guilty_video_found .html").text("Guilty videos not found");
                    $(".no_guilty_video_found").show();
                }


                $("select[name='select_guilty_racer'").change();
                ajax_get_juez(incident_id, false);
                $("html, body").animate({ scrollTop: 0 }, "slow");


            }
        },
        error: function (response) {

            alert('223342');
        }

    });
}


function ajax_get_guilty_video(incident_id) {

    _waiting_screen("show");

    $.ajax({
        type: "POST",
        //async: false,
        url: 'index.php?option=com_reportincidents&task=get_guilty_video&format=raw',
        //url: "ajax_get_guilty_video.php",
        data: "incident_id=" + incident_id + "&guilty_racer=" + $("select[name='select_guilty_racer'").val(),
        success: function (response) {

            _waiting_screen("hide");

            if (response == "") {
                alert("Response Error (Guilty Video) : Contact Administrator");
            }

            var data = JSON.parse(response);

            if (data.status == "error") {

                $(".play_guilty_video").html(data.message);


            } else {



                onYouTubeIframeAPIReady_guilty_video(
                    data.message.data.guilty_video_ID,

                );

            }
        },
        error: function (response) {

            alert('223342');
        }

    });
}



function ajax_get_juez(incident_id, showWaitingScreen) {

    if (showWaitingScreen) {
        _waiting_screen("show");
    }

    $.ajax({
        type: "POST",
        //async: false,
        url: 'index.php?option=com_reportincidents&task=get_juez&format=raw',
        //url: "ajax_get_juez.php",
        data: "incident_id=" + incident_id,
        success: function (response) {

            if (showWaitingScreen) {
                _waiting_screen("hide");
            }

            if (response == "") {
                alert("Response Error (Get Penalties): Contact Administrator");
            }

            var data = JSON.parse(response);

            $(".juez_images").html(data.message.data.juez_images);

        },
        error: function (response) {

            alert('223342');
        }

    });
}



function ajax_set_resolucion(incident_id, Resolucion, showWaitingScreen) {

    if (showWaitingScreen == null || showWaitingScreen == "undefined") {
        showWaitingScreen = true;
    }

    if (showWaitingScreen) {
        _waiting_screen("show");
    }

    $.ajax({
        type: "POST",
        //async: false,
        url: 'index.php?option=com_reportincidents&task=set_resolucion&format=raw',
        //url: "ajax_set_resolucion.php",
        data: "incident_id=" + incident_id + "&Resolucion=" + Resolucion,
        success: function (response) {

            if (showWaitingScreen) {
                _waiting_screen("hide");
            }

            if (response == "") {
                alert("Response Error (Updation of Resolucion): Contact Administrator");
            }

            var data = JSON.parse(response);

            alert(data.message);



            ajax_incidents_list(false, null);

        },
        error: function (response) {

            alert('223342');
        }

    });
}


if (typeof availableTags == "undefined") {
    var availableTags = [];
}





$(document).ready(function () {



    $("#incident_tags").autocomplete({
        source: availableTags

    });

    $("input[name='submit_resolucion']").click(function () {

        var incident_ID = $("input[name='incident_ID']").val();
        if (incident_ID == "") {
            alert("Incident not loaded.");
        }
        else {

            var incident_Tags = $("#incident_tags").val();
            if (incident_Tags == "") {
                alert("Resolucion cannot be empty.");
            }
            else {
                ajax_set_resolucion(incident_ID, incident_Tags, true);
            }
        }

    })

    $(document).on("click", ".inci:not(.opened)", function () {

        $(".incident_list tr").removeClass("opened");
        $(this).addClass("opened");

        var incident_ID = $(this).data("inci_id");

        $("input[name='incident_ID']").val(incident_ID);
        ajax_get_videos(incident_ID);

    })


    $(document).on("change", "select[name='category'], select[name='track']", function () {

        ajax_incidents_list(true, $(this));

    });


    $(document).on("change", "select[name='select_guilty_racer']", function () {

        var incident_ID = $("input[name='incident_ID']").val();
        ajax_get_guilty_video(incident_ID);

    });













});


