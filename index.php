<?php
include("conf.php");
?>

<head>
    <!--<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="site.js?t=" <?php echo strtotime("now"); ?>></script>
    <script src="youtube.js?t=" <?php echo strtotime("now"); ?>></script>
    <script src="blockui.js"></script>



    <script>
        var availableTags = [];
        <?php
        foreach ($penalties_images as $juez_key => $juez_image) {
        ?>
            availableTags.push('<?php echo $juez_key; ?>');
        <?php
        }
        ?>
    </script>

    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
    <link rel="stylesheet" href="style.css?t=<?php echo strtotime("now"); ?>">
    <link rel="stylesheet" href="alerts.css?t=<?php echo strtotime("now"); ?>">



</head>

<body class="bodyinci">



    <table width="100%" border="0" cellpadding="0" cellspacing="0" class="tableinci">

        <!--
        <tr>
            <td>
                <?php
                $fetch_categories       = mysqli_query($mysqli_connect, "select DISTINCT(Categoria) FROM `incidentes`");
                ?>
                <select name="category" class="form-control">
                    <option value="">Select Category</option>
                    <?php
                    foreach ($fetch_categories as $category) {
                    ?>
                        <option value="<?php echo $category["Categoria"]; ?>"><?php echo $category["Categoria"]; ?></option>
                    <?php
                    }
                    ?>
                </select>
                <br>

            </td>

            <td></td>
            <td><select name="track" class="form-control">
                    <option value="">Select Track</option>
                    <?php
                    $fetch_tracks            = mysqli_query($mysqli_connect, "select DISTINCT(Pista) FROM `incidentes`");
                    foreach ($fetch_tracks as $track) {
                    ?>
                        <option value="<?php echo $track["Pista"]; ?>"><?php echo $track["Pista"]; ?></option>
                    <?php
                    }
                    ?>
                </select>
                <br>

            </td>
        </tr>
        
        <tr>
            <td height="10" colspan="3"></td>
        </tr>
           
        <tr>
            <td colspan="">
                <h1 class="">Victim</h1>
            </td>
            <td colspan="">

            </td>
            <td colspan="">
                <h1 class="">Guilty</h1>
            </td>

        </tr>
        <tr>
            <td height="10" colspan="3"></td>
        </tr>
     -->

        <tr>
            <td width="45%">


                <div class="show_victim_dropdown" style="display: none;">
                    <select name="victim_racer" data-type="v" class="form-control">
                        <option value="">Select a racer video</option>

                    </select>

                </div>

                <br>

            </td>

            <td width="10%"></td>
            <td width="45%">

                <?php
                $fetch_guilty_racer       = mysqli_query($mysqli_connect, "select  DISTINCT(Reportado) from incidentes where Reportado IN (select DISTINCT(Piloto) FROM `parc_ferme`)");
                ?>

                <div class="show_guilty_dropdown">
                    <select name="select_guilty_racer" data-type="g">
                        <option value="">Select a racer video</option>

                    </select>
                </div>


            </td>
        </tr>

        <tr>
            <td height="10" colspan="3"></td>
        </tr>

        <tr style="background-color: black;">
            <td width="45%" align="center">

                <div class="play_victim_video">
                    <div id="victim_video">
                        <img src="images/video-placeholder.png" />
                    </div>
                </div>

            </td>

            <td width="10%" align="center">



                <table border="1" style="text-align: center; font-weight:bold; cursor:pointer; background-color:black;" cellpadding="10">

                    <tr>
                        <td onclick="set_reports('3 Seg')"><img src="images/3-seg.png" /></td>
                        <td onclick="set_reports('10 Seg')"><img src="images/10-seg.png" /></td>
                    </tr>

                    <tr>
                        <td onclick="set_reports('5 Seg')"><img src="images/5-seg.png" /></td>
                        <td onclick="set_reports('20 Seg')"><img src="images/20-seg.png" /></td>
                    </tr>

                    <tr>
                        <td onclick="set_reports('Race Ban')"><img src="images/race-ban.png" /></td>
                        <td onclick="set_reports('20 Grid')"><img src="images/20-grid.png" /></td>
                    </tr>

                    <tr>
                        <td onclick="set_reports('!')"><img src="images/red-icon.png" /></td>
                        <td onclick="set_reports('!!')"><img src="images/orange-icon.png" /></td>
                    </tr>

                    <tr>
                        <td onclick="set_reports('NFA')" colspan="2"><img src="images/nfa.png" /></td>

                    </tr>

                    <tr>
                        <td onclick="set_reports('SWAP')" colspan="2"><img src="images/swap-icon.png" /></td>

                    </tr>
                    <tr>
                        <td onclick="set_reports('NEW CRASH')" colspan="2"><img src="images/new-crash.png" /></td>

                    </tr>

                </table>


            </td>
            <td width="45%" align="center">
                <div class="play_guilty_video">
                    <div id="guilty_video">

                        <img src="images/video-placeholder.png" />
                    </div>
                </div>






            </td>
        </tr>



        <tr style="background-color: black; color:white; text-align:left" class="verticalalign-top">
            <td width="45%">
                <h1 class=""> Victim: <span class="span_victim_name"></span></h1>
            </td>

            <td width="10%">

            </td>


            <td width="45%">
                <h1 class=""> Guilty: <span class="span_guilty_name"></span></h1>


                <div class="no_guilty_video_found " style="display: none;">
                    <div class="" style="margin-top:10px; display: flex;">
                        <div class="alert alert-danger html " style="font-weight: bold;">

                            <strong>Guilty video not found for:</strong>
                        </div>
                    </div>
                </div>
            </td>
        </tr>




        <tr style="background-color: black; color:white; text-align:left; height:80px;">
            <td width="45%">

                <!--
                <div class="incident_penalties_remarks">
                    <label for="incident_tags">  Resolucion: </label>
                    <input id="incident_tags" placeholder="Type Resolucion">
                    <input type="button" name="submit_resolucion" value="Submit" />
                </div>
                -->


            </td>

            <td width="10%">






            </td>
            <td width="45%">
                <div class="juez_images" style="">

                </div>






            </td>
        </tr>



        <tr style="background-color: black; color:white; text-align:left;">

            <td width="10%" colspan="3">






            </td>

        </tr>



    </table>


    <table class="typeOfIncidents details-grid" cellspacing="0" style="width: 100%;">
        <tr>
            <td class="width-45perc verticalalign-top">
                <table class="typeOfIncidents tddisplayinline" cellspacing="10" style="width: 100%;">
                    <tr>
                        <td><strong>Type of Incident: </strong></td>
                        <td class="type_of_incident"></td>
                    </tr>

                    <tr>
                        <td width=""><strong>Summary of Incident:</strong></td>
                        <td class="summary_of_incident"></td>
                    </tr>

                    <tr>
                        <td><strong>Fecha: </strong></td>
                        <td class="fetcha"></td>
                    </tr>
                </table>
            </td>

            <td class="width-10perc">
            </td>
            <td class="width-45perc verticalalign-top">
                <table class="typeOfIncidents tddisplayinline" cellspacing="10" style="width: 100%;">

                    <tr>
                        <td><strong>Lap: </strong></td>
                        <td class="lap"></td>
                    </tr>

                    <tr>
                        <td><strong>Resolucion: </strong></td>
                        <td class="incident_penalties_remarks">

                            <input id="incident_tags" placeholder="Type Resolucion">
                            <input type="button" name="submit_resolucion" value="Submit" />


                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>






    <input type="hidden" name="incident_ID" value="" />


    <table width="100%" class="muslimraza" style="margin-top:30px">

        <tr>
            <td width="45%">
                <?php echo DropdownHelper::categories_dropdown_HTML(); ?>
            </td>

            <td width="10%"></td>
            <td width="45%">

                <?php echo DropdownHelper::track_dropdown_HTML(); ?>

            </td>
        </tr>
    </table>



    <div class="incident_list" style="margin-top:20px">
        <?php

        $isAjax = false;
        include("ajax_incidents_list.php");
        if ($_data["status"] == "error") {
        ?>
            <div class="alert alert-danger">
                <strong><?php echo $_data["message"]; ?></strong>
            </div>
        <?php
        } else {

            echo $_data["message"]["data"];
        }
        ?>


    </div>

    <p style="height: 30px;">

    </p>


</body>