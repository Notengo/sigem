<?php
// verificador de sesion
require_once '../usuarios/aut_verifica.inc.php';
require_once '../ClasesBasicas/ConsultaBD.php';
include_once 'funciones.php';

if(isset($_GET['getProveedorByLetters']) && isset($_GET['letters'])){
	$letters = $_GET['letters'];
        $con = new ConsultaBD();
        $con->Conectar();        
	$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
	$sql = "select id, nombre, direccion from proveedor ";        
        $sql .=" where (nombre like '%".$letters."%')";
        $con->executeQuery($sql);
	while($inf = $con->getFetchArray()){
		$cod=$inf["id"] ;                                
		$nombre =htmlentities($inf["nombre"]);
		echo $cod."###".$cod." ".$nombre."|";
	}
        $con->Close();
}


?>
