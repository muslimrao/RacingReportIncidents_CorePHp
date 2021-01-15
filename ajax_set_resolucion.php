<?php
include("conf.php");

mysqli_query($mysqli_connect, "update`incidentes` set Resolucion = '" . $_REQUEST["Resolucion"] . "' where 1=1 and id = " . $_REQUEST['incident_id']);

$_data = array(
    "status"     => "success",
    "message"   => "Resolucion Updated."
);

echo json_encode($_data);
