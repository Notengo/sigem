<?php
// verificador de sesion
require_once '../usuarios/aut_verifica.inc.php';
require_once '../ClasesBasicas/ConsultaBD.php';
include_once 'funciones.php';

if(isset($_GET['getListadoByLetters']) && isset($_GET['letters'])){
    $letters = $_GET['letters'];
    $con = new ConsultaBD();
    $con->Conectar();

    $letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
    
    $sql = "SELECT ofcodi, nombre, localiza, tipo, descri"
            . "FROM oficexpe"
            . "LEFT OUTHER JOIN localida ON "
            . "(oficexpe.coddpto=localida.coddepto AND oficexpe.codloc=localida.codloc)"
            . "WHERE (nombre LIKE '%".$letters."%' OR ofcodi LIKE '%".$letters."%')";
    $con->executeQuery($sql);

    while($inf = $con->getFetchArray()){
        $cod = $inf["idServicio"];
        $nombre =htmlentities($inf["descripcion"]/* . " - " . $inf['tipo']*/);
        echo $cod."###" . $cod . " - " . $nombre . "|";
    }
    $con->Close();
}