<?php
include("conf.php");

$get_inci  = mysqli_query($mysqli_connect, "select * FROM `incidentes` where id = " . $_REQUEST['incident_ID']);

if (mysqli_num_rows($get_inci) > 1) {

    $_data = array(
        "status"     => "error",
        "message"   => "More than 1 record found."
    );
} else if (mysqli_num_rows($get_inci) > 0) {


    $tmp_result = mysqli_fetch_assoc($get_inci);

    $write_in_this = FALSE;
    foreach ($juez_array as $juez) {
        if ($tmp_result[$juez] == "") {
            $write_in_this = $juez;
            break;
        }
    }


    if ($_REQUEST['status'] == "SWAP") {

        mysqli_query($mysqli_connect, "insert INTO incidentes (Fecha, Categoria, Resumen, videop, Video2, Tiempo,Pista, Lap, Reportado,Afectado,Incidente,Resolucion, Juez1, Juez2, Juez3, Juez4, Juez5, Juez6, Auth) SELECT Fecha, Categoria, Resumen, videop, Video2, Tiempo,Pista, Lap, Reportado,Afectado,Incidente,Resolucion, Juez1, Juez2, Juez3, Juez4, Juez5, Juez6, Auth FROM incidentes WHERE id = " . $_REQUEST['incident_ID']);
        $last_id = mysqli_insert_id($mysqli_connect);


        mysqli_query($mysqli_connect, "update`incidentes` set Reportado = '" . $tmp_result["Afectado"] . "', Afectado = '" . $tmp_result["Reportado"] . "'  where 1=1 and id = " . $last_id);

        $_data = array(
            "status"     => "success",
            "message"   => "Swap inserted."
        );
    } else if ($_REQUEST['status'] == "NEW CRASH") {

        if ($write_in_this !== FALSE) {

            $dateTime = date("d/n/y G:i");
            mysqli_query($mysqli_connect, "insert INTO incidentes (Fecha, Categoria, Resumen, videop, Video2, Tiempo,Pista, Lap, Reportado,Afectado,Incidente,Resolucion, Juez1, Juez2, Juez3, Juez4, Juez5, Juez6, Auth) SELECT Fecha, Categoria, Resumen, videop, Video2, Tiempo,Pista, Lap, Reportado,Afectado,Incidente,Resolucion, Juez1, Juez2, Juez3, Juez4, Juez5, Juez6, Auth FROM incidentes WHERE id = " . $_REQUEST['incident_ID']);
            $last_id = mysqli_insert_id($mysqli_connect);
            $tmp_result = mysqli_fetch_assoc($get_inci);

            $newYoutubeUrl = "https://www.youtube.com/watch?v=" . $_REQUEST['newCrashData']["video_id"] . "&t=" . $_REQUEST['newCrashData']["timestamp_in_seconds"];


            mysqli_query($mysqli_connect, "update`incidentes` set Juez1 = '', Juez2 = '', Juez3 = '', Juez4 = '', Juez5 = '', Juez6 = '',     Fecha = '" . $dateTime . "',  " . $write_in_this = 'Juez1' . " = 'Victim', videop = '" . $newYoutubeUrl . "', Tiempo= '" . $_REQUEST['newCrashData']["timestamp_in_hhmmss"] . "' where  id = " . $last_id);

            $_data = array(
                "status"     => "success",
                "message"   => "New Crash inserted."
            );
        } else {
            $_data = array(
                "status"     => "error",
                "message"   => " No space is available to set status. Unable to create New Crash."
            );
        }
    } else {

        if ($write_in_this !== FALSE) {

            mysqli_query($mysqli_connect, "update`incidentes` set " . $write_in_this . " = '" . $_REQUEST['status'] . "' where id = '" . $_REQUEST['incident_ID'] . "'");
            $_data = array(
                "status"     => "success",
                "message"   => $write_in_this . " Updated - Thanks."
            );
        } else {
            $_data = array(
                "status"     => "error",
                "message"   => " No space is available to set status. Try with other incidents."
            );
        }
    }
} else {
    $_data = array(
        "status"     => "error",
        "message"   => "No inclidents found."
    );
}

echo json_encode($_data);
