<?php
include("conf.php");


if ($_REQUEST['type'] == "v") {

    #$get_video  = mysqli_query($mysqli_connect, "select * FROM `parc_ferme` where Piloto = '" . $_REQUEST['victim_racer'] . "' AND Categoria = '" . $_REQUEST['category'] . "' AND Pista = '" . $_REQUEST['track'] . "'");
    $get_victim_video  = mysqli_query($mysqli_connect, "select * FROM `incidentes` where Reportado = '" . $_REQUEST['victim_racer'] . "' AND Categoria = '" . $_REQUEST['category'] . "' AND Pista = '" . $_REQUEST['track'] . "'");
    if (mysqli_num_rows($get_victim_video) > 1) {

        $_data = array(
            "status"     => "error",
            "message"   => "More than 1 video found."
        );
    } else  if (mysqli_num_rows($get_victim_video) > 0) {


        $get_victim_video                                  = mysqli_fetch_assoc($get_victim_video);
        /*
        $get_victim_video['victim_video_ID']               = convertYoutube($get_victim_video["videop"], TRUE);
        $get_victim_video['victim_video_STARTTIME']        = $get_victim_video["Tiempo"];
        $get_victim_video['guilty_video_ID']               = "";
        $get_victim_video['guilty_video_STARTTIME']        = "";
        */

        $get_guilty_video  = mysqli_query($mysqli_connect, "select * FROM `parc_ferme` where Piloto = '" . $get_victim_video['Afectado'] . "' AND Categoria = '" . $_REQUEST['category'] . "' AND Pista = '" . $_REQUEST['track'] . "'");
        if ( mysqli_num_rows($get_guilty_video) > 0 )
        {
            $get_guilty_video                       = mysqli_fetch_assoc($get_guilty_video);
            $get_victim_video['guilty_video_ID']    = convertYoutube( $get_guilty_video["Youtube1"], TRUE);
        }


        $_data = array(
            "status"     => "success",
            "message"   => array("data" =>  $get_victim_video)
        );
    } else {
        $_data = array(
            "status"     => "error",
            "message"   => '<img src="images/video-placeholder.png" />'
        );
    }
} else if ($_REQUEST['type'] == "g") {

  
    $get_video  = mysqli_query($mysqli_connect, "select * FROM `parc_ferme` where Piloto = '" . $_REQUEST['guilty_racer'] . "' AND Categoria = '" . $_REQUEST['category'] . "' AND Pista = '" . $_REQUEST['track'] . "'");
    if (mysqli_num_rows($get_video) > 1) {

        $_data = array(
            "status"     => "error",
            "message"   => "More than 1 video found."
        );
    } else  if (mysqli_num_rows($get_video) > 0) {


        $get_video          = mysqli_fetch_assoc($get_video);
        $get_video['videop_embed']      = convertYoutube($get_video["Youtube1"]);
        $_data = array(
            "status"     => "success",
            "message"   => array("data" =>  $get_video)
        );
    } else {
        $_data = array(
            "status"     => "error",
            "message"   => "No video found."
        );
    }
}

echo json_encode($_data);
