<?php
include("conf.php");

$TMP_where = "";
/*
if (isRequestExists('victim_racer') !== FALSE) {
    $TMP_where .= " and LOWER( Reportado ) = '" .  strtolower($_REQUEST['victim_racer']) . "' ";
}
*/

if (isRequestExists('category') !== FALSE) {
    $TMP_where .= " and LOWER( Categoria ) = '" .  strtolower($_REQUEST['category']) . "' ";
}

if (isRequestExists('track') !== FALSE) {
    $TMP_where .= " and LOWER( Pista ) = '" .  strtolower($_REQUEST['track']) . "' ";
}

if (isRequestExists('victim_racer') !== FALSE) {
    #$TMP_where .= " and LOWER( Afectado ) = '" .  strtolower($_REQUEST['victim_racer']) . "' ";
}

if (isRequestExists('guilty_racer') !== FALSE) {
    #$TMP_where .= " and LOWER( Reportado ) = '" .  strtolower($_REQUEST['guilty_racer']) . "' ";
}


$get_list  = mysqli_query($mysqli_connect, "select * FROM `incidentes` where 1=1 " . $TMP_where . " ORDER BY id DESC");

ob_start();
if (mysqli_num_rows($get_list) > 0) {
?>
    <table class="tableinci-list" cellpadding="5" cellspacing="0" style="">
        <thead class="thead-dark" style="visibility: ;">
            <tr>
                <!--<th>Lap</th>-->
                <!--<th>Resumen</th>
                <th>Cat</th>
                <th>Pista</th>-->
                <th>Afectado</th>

                <th>Reportado</th>

                <th>Incidente</th>
                <th>Resolucion</th>

                <?php
                foreach ($juez_array as $juez) {
                ?>
                    <th><?php echo $juez; ?></th>
                <?php
                }
                ?>

                <!--<th>Fecha</th>-->

            </tr>
        </thead>
        <?php
        foreach ($get_list as $gl) {
            /*
            $tmp_where_clause = "and Lap = '" . $gl["Lap"] . "' and ";

            $tmp_where_clause .= "Categoria = '" . $gl["Categoria"] . "' and ";
            $tmp_where_clause .= "Pista = '" . $gl["Pista"] . "' and ";

            #$tmp_where_clause .= "Resumen = '" . $gl["Resumen"] . "' and ";
            $tmp_where_clause .= "Incidente = '" . $gl["Incidente"] . "' and ";
            $tmp_where_clause .= "Reportado = '" . $gl["Reportado"] . "' and ";
            $tmp_where_clause .= "Afectado = '" . $gl["Afectado"] . "' and ";
            $tmp_where_clause .= "Resolucion = '" . $gl["Resolucion"] . "' and ";
            $tmp_where_clause .= "Tiempo = '" . $gl["Tiempo"] . "'";*/

            $tmp_where_clause = " and id = " . $gl["id"];


        ?>
            <tr class="inci" data-inci_id="<?php echo $gl["id"]; ?>" style="cursor:pointer;">
                <!--<td class="one-perc"><?php echo utf8_encode($gl["Lap"]); ?></td>
                <td class="one-perc"><?php echo utf8_encode($gl["Categoria"]); ?></td>
                <td class="one-perc"><?php echo utf8_encode($gl["Pista"]); ?></td>-->
                <td><?php echo utf8_encode($gl["Afectado"]); ?></td>
                <td><?php echo utf8_encode($gl["Reportado"]); ?></td>

                <!--<td class=""><?php echo utf8_encode($gl["Resumen"]); ?></td>-->
                <td class="bggray"><?php echo utf8_encode($gl["Incidente"]); ?></td>
                <td><?php echo utf8_encode($gl["Resolucion"]); ?></td>


                <?php
                foreach ($juez_array as $juez) {

                    if ($gl[$juez] != "") {

                        if (array_key_exists(ucfirst(($gl[$juez])), $penalties_images)) {
                ?>
                            <td width="1%" class="" style="padding-left: 10px;">
                                <img src="<?php echo $penalties_images[ucfirst(($gl[$juez]))]; ?>" />
                            </td>
                        <?php
                        } else {
                        ?>
                            <td width="1%" class="" style="padding-left: 10px;">
                                <?php echo  $gl[$juez]; ?>
                            </td>
                        <?php
                        }
                    } else {
                        ?>
                        <td width="1%" class="" style="padding-left: 10px;">
                            <?php echo  $gl[$juez]; ?>
                        </td>
                    <?php
                    }

                    ?>
                <?php
                }
                ?>

                <!--<td class="fitwidth"><?php echo date("Y-m-d H:i:s", strtotime($gl["Fecha"])); ?></td>-->

            </tr>

        <?php

        }
        ?>
    </table>
<?php

    $html = ob_get_contents();
    ob_clean();


    $_data = array(
        "status"     => "success",
        "message"   => array("data" =>  $html)
    );
} else {
    $_data = array(
        "status"     => "error",
        "message"   => "<div class=\"alert alert-danger\"><strong>No incidents found.</strong></div>"
    );
}


if ($isAjax) {
    echo json_encode($_data);
} else {
}
