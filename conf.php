<?php
ini_set("display_errors", 1);
error_reporting(1);
if (!function_exists('convertYoutube')) {

    $juez_array = array("Juez1", "Juez2", "Juez3", "Juez4", "Juez5", "Juez6");
    $penalties_images = array(
        "3 Seg"        => "images/3-seg.png",
        "10 Seg"        => "images/10-seg.png",
        "5 Seg"     => "images/5-seg.png",
        "20 Seg"        => "images/20-seg.png",
        "Race Ban"      => "images/race-ban.png",
        "20 Grid"       => "images/20-grid.png",
        "NFA"       => "images/nfa.png",
        "SWAP"          => "images/swap-icon.png",
        "Race Incident" => "images/red-icon.png",
        "Warning"   => "images/orange-icon.png",
        "Victim"   => "images/victim.png",
    );

    $mysqli_connect = mysqli_connect("localhost", "root", "", "joomlasite");
    $isAjax = TRUE;






    function utf8_wrap($data)
    {
        foreach ($data as $_key => $_value) {
            $data[$_key] = utf8_encode($_value);
        }

        return $data;
    }
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

    function isRequestExists($name)
    {
        if (isset($_REQUEST[$name])) {
            if ($_REQUEST[$name] != "") {
                return $_REQUEST[$name];
            }
        }

        return FALSE;
    }

    include("DropdownHelper.php");
}


$_data          = array(
    "status"        => FALSE,
    "message"          => ""
);
