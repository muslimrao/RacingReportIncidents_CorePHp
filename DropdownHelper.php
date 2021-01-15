<?php
include("conf.php");

class DropdownHelper
{

    static public function categories_dropdown_HTML()
    {
        global $mysqli_connect;

        $fetch_categories       = mysqli_query($mysqli_connect, "select DISTINCT(Categoria) FROM `incidentes`");
        $html = '<select name="category" class="form-control">
                    <option value="">Select Category</option>';

        foreach ($fetch_categories as $category) {
            $html .= '<option value="' . $category["Categoria"] . '">' . $category["Categoria"] . '</option>';
        }

        $html .= '</select>';

        return $html;
    }

    static public function track_dropdown_HTML()
    {
        global $mysqli_connect;

        $fetch_tracks            = mysqli_query($mysqli_connect, "select DISTINCT(Pista) FROM `incidentes`");

        $html = '<select name="track" class="form-control">
                    <option value="">Select Track</option>';


        foreach ($fetch_tracks as $track) {
            $html .=  '<option value="' . $track["Pista"] . '">' . $track["Pista"] . '</option>';
        }

        $html .= '</select>';


        return $html;
    }

    static public function guilty_dropdowns_HTML($incident_id = FALSE, $selected_guilty = FALSE)
    {

        $dropdown_values = self::guilty_dropdowns(true, $incident_id);

        $select = '<select name="select_guilty_racer" data-type="v" class="form-control">';
        $select .= '<option value="">Select a racer video</option>';

        foreach ($dropdown_values as $key => $value) {
            $selected_option = FALSE;
            if ($selected_guilty == $value) {
                $selected_option = "selected";
            }
            $select .= '<option ' . $selected_option . '  value="' . $key . '">' . $value . '</option>';
        }

        $select .= '</select>';

        return $select;
    }

    static public function victim_dropdowns_HTML($incident_id = FALSE, $selected_victim = FALSE)
    {

        $dropdown_values = self::victim_dropdowns(true, $incident_id);

        $select = '<select style="pointer-events:none;"  name="victim_racer" data-type="v" class="form-control">';
        $select .= '<option value="">Select a racer video</option>';


        foreach ($dropdown_values as $key => $value) {
            $selected_option = FALSE;
            if ($selected_victim == $value) {
                $selected_option = "selected";
            }
            $select .= '<option ' . $selected_option . '  value="' . $key . '">' . $value . '</option>';
        }

        $select .= '</select>';

        return $select;
    }

    static public function victim_dropdowns($hide_first_index = false, $incident_id = FALSE)
    {
        global $mysqli_connect;

        $fetch_incident       = mysqli_query($mysqli_connect, "select * FROM `incidentes`   where id = '" . $incident_id . "' ");


        $tmp_array = array();
        if (!$hide_first_index) {
            $tmp_array[""]                            = "Select a racer video";
        }


        if (mysqli_num_rows($fetch_incident) > 0) {
            $fetch_incident        = mysqli_fetch_assoc($fetch_incident);

            $tmp_array[$fetch_incident["Afectado"]]                 = $fetch_incident["Afectado"];
        } else {
            #$tmp_array[""]							= "Select a racer video";
        }


        return $tmp_array;
    }

    static public function guilty_dropdowns($hide_first_index = false, $incident_id = FALSE)
    {
        global $mysqli_connect;

        $fetch_incident       = mysqli_query($mysqli_connect, "select * FROM `incidentes`   where id = '" . $incident_id . "' ");


        $tmp_array = array();
        if (!$hide_first_index) {

            $tmp_array[""]                            = "Select a racer video";
        }


        if (mysqli_num_rows($fetch_incident) > 0) {
            $fetch_incident        = mysqli_fetch_assoc($fetch_incident);

            $fetch_victim_racers     = mysqli_query($mysqli_connect, "select distinct(Piloto) FROM `parc_ferme` where Categoria = '" . $fetch_incident["Categoria"] . "' and Pista = '" . $fetch_incident["Pista"] . "' "); //and Afectado = '". $fetch_incident["Afectado"] ."' "
            foreach ($fetch_victim_racers as $fvr) {
                $tmp_array[$fvr["Piloto"]]                 = $fvr["Piloto"];
            }
        }

        return $tmp_array;
    }
}
