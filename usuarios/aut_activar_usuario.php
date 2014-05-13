<?php
include_once 'aut_verifica.inc.php';
include_once '../ClasesBasicas/ConsultaBD.php';
$id = $_POST['ident'];

$con = new ConsultaBD();
$con->Conectar();
$sql = "UPDATE users SET fechaBaja = '0000-00-00 00:00:00' where id = '$id'";

if ($con->executeQuery($sql)) {
   $con->Close();
   
   echo '<meta http-equiv="refresh" content="0; url=aut_modifica_usuario.php">';
} else {
   $con->Close();
   
   echo '<meta http-equiv="refresh" content="0; url=aut_modifica_usuario.php">';
}
?>