<?php
// verificador de sesion
require_once '../usuarios/aut_verifica.inc.php';
require_once '../ClasesBasicas/ConsultaBD.php';
include_once 'funciones.php';

//if(isset($_GET['getOficinaByLetters']) && isset($_GET['letters'])){
if(isset($_GET['letters'])){
	$letters = $_GET['letters'];
        $con = new ConsultaBD();
        $con->Conectar();
//	$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
	$sql = "SELECT idMotivoTraslado, descripcion, fechaBaja FROM motivotraslado ";
        $sql.= " WHERE descripcion LIKE '%".$letters."%'";
//        echo $sql;
//        idMotivoTraslado, descripcion, fechaAlta, usuarioAlta, fechaBaja, usuarioBaja
        $con->executeQuery($sql);
	while($inf = $con->getFetchArray()){
		$cod=$inf["idMotivoTraslado"] ;
                if($inf['fechaBaja'] === '0000-00-00 00:00:00') {
                    $nombre = htmlentities($inf["descripcion"]);
                    echo $cod."###".$cod." ".$nombre."|";
                }
	}
        $con->Close();
}
?>