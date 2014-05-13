<?php
require_once '../ClasesBasicas/ConsultaBD.php';
$con = new ConsultaBD();
$con->Conectar();        
$equipo = $_GET['equipo'];
$sql = "select * from equipo where nro='$equipo'";
$con->executeQuery($sql);
$num_rs_eq = $con->getNumRows();
if($num_rs_eq == 0)
        echo "false";
else
        echo "true";
?>