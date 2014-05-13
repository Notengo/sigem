<?php
include_once 'aut_verifica.inc.php';
include_once '../ClasesBasicas/ConsultaBD.php';
$id = $_POST['ident'];

$con = new ConsultaBD();
$con->Conectar();
$sql = "UPDATE users SET fechaBaja = '".date('Y-m-d h:m:s')."' where id = '$id'";

if ($con->executeQuery($sql)) {
   $con->Close();
   
   echo '<meta http-equiv="refresh" content="0; url=aut_modifica_usuario.php">';
} else {
   $con->Close();
   
   echo '<meta http-equiv="refresh" content="0; url=aut_modifica_usuario.php">';
}
?>