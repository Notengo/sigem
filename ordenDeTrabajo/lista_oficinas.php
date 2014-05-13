<?php
// verificador de sesion
require_once '../usuarios/aut_verifica.inc.php';
require_once '../ClasesBasicas/ConsultaBD.php';
include_once 'funciones.php';

if(isset($_GET['getOficinaByLetters']) && isset($_GET['letters'])){
    $letters = $_GET['letters'];
    $con = new ConsultaBD();
    $con->Conectar();
    $letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
    $sql = "select ofcodi, nombre, localiza, tipo, descri from oficexpe ";
    $sql .=" left join localida on (oficexpe.coddpto=localida.coddepto and oficexpe.codloc=localida.codloc)";
    $sql .=" where (nombre like '%".$letters."%' or ofcodi like '%".$letters."%')";
    $con->executeQuery($sql);
    while($inf = $con->getFetchArray()){
        $cod=$inf["ofcodi"] ;
        $tipo = "";
        if($inf['tipo']<>null) {
            $tipo .=" - ".tipo_establec($inf['tipo']);
            if($inf['localiza']<>null)
                $tipo .=" - ".$inf['localiza']." ";
        }
        $nombre =htmlentities($inf["nombre"]." ".$tipo);
        echo $cod."###".$cod." ".$nombre."|";
    }
    $con->Close();
}