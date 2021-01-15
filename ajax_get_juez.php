<?php
include("conf.php");

$get_victim_video  = mysqli_query($mysqli_connect, "select * FROM `incidentes` where id = '" . $_REQUEST['incident_id'] . "' ");
if (mysqli_num_rows($get_victim_video) > 0) {


    $get_victim_video   = mysqli_fetch_assoc($get_victim_video);
    $get_victim_video   = utf8_wrap($get_victim_video);

    $html_remarks = "";

    ob_start();

?>
    <table width="100%" style="display:flex">
        <tr>
            <?php
            foreach ($juez_array as $ja) {

                if ($get_victim_video[$ja] != "") {

                    if (array_key_exists($get_victim_video[$ja], $penalties_images)) {
            ?>
                        <td width="1%" class="" style="padding-left: 10px;">
                            <img src="<?php echo $penalties_images[$get_victim_video[$ja]]; ?>" />
                        </td>
            <?php
                    }
                }
            }
            ?>
        </tr>
    </table>
<?php
    $html_remarks = ob_get_contents();
    ob_clean();


    $get_victim_video['juez_images']        = $html_remarks;

    $_data = array(
        "status"     => "success",
        "message"   => array("data" =>  $get_victim_video)
    );
} else {
    $_data = array(
        "status"     => "success",
        "message"   => array("data" =>  array("juez_images" => ""))
    );
}
echo json_encode($_data);
