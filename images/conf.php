<?php
$mysqli_connect = mysqli_connect("localhost", "dev-db-usr", "K34ABpxT-1jU5_rz", "webissues");


function convertYoutube($string, $only_id = FALSE)
{
    $youtube_addr = "//www.youtube.com/embed/";
    if ($only_id) {
        $youtube_addr = "";
    }

    return preg_replace(
        "/\s*[a-zA-Z\/\/:\.]*youtu(be.com\/watch\?v=|.be\/)([a-zA-Z0-9\-_]+)([a-zA-Z0-9\/\*\-\_\?\&\;\%\=\.]*)/i",
        $youtube_addr . "$2",
        $string
    );
}


$_data          = array(
    "status"        => FALSE,
    "message"          => ""
);
