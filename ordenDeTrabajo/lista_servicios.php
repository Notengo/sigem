<?php
// verificador de sesion
require_once '../usuarios/aut_verifica.inc.php';
require_once '../ClasesBasicas/ConsultaBD.php';
include_once 'funciones.php';

if(isset($_GET['getServicioByLetters']) && isset($_GET['letters'])){
    $letters = $_GET['letters'];
    $con = new ConsultaBD();
    $con->Conectar();

    $letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
    
    $sql = "SELECT idServicio, descripcion, tipo FROM servicio WHERE descripcion like '%" . $letters . "%' and fechaBaja = '0000-00-00 00:00:00';";
    $con->executeQuery($sql);

    while($inf = $con->getFetchArray()){
        $cod = $inf["idServicio"];
        $nombre =htmlentities($inf["descripcion"]/* . " - " . $inf['tipo']*/);
        echo $cod."###" . $cod . " - " . $nombre . "|";
    }
    $con->Close();
}
?>