<?php
// verificador de sesion
require_once '../usuarios/aut_verifica.inc.php';
require_once '../ClasesBasicas/ConsultaBD.php';
include_once 'funciones.php';

if(isset($_GET['getAgenteByLetters']) && isset($_GET['letters'])){
	$letters = $_GET['letters'];
        $con = new ConsultaBD();
        $con->Conectar();        
	$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
	$sql = "select agentes.dni, agentes.nombre, apellido, usuarios.nombre as usuario from agentes inner join usuarios on usuarios.dni=agentes.dni ";        
        $sql .=" where CONCAT(agentes.nombre,' ',agentes.apellido) like '%".$letters."%'";
        $con->executeQuery($sql);
	while($inf = $con->getFetchArray()){
		$cod=$inf["dni"] ;
		$nombre =htmlentities($inf["usuario"]." - ".$inf['nombre']." ".$inf["apellido"]);
		echo $cod."###".$nombre."|";
	}
        $con->Close();
}

?>
