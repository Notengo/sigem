<?php
include_once 'aut_verifica.inc.php';
include_once '../ClasesBasicas/ConsultaBD.php';
$nomap = $_POST['nombre'];
$usuario = $_POST['identif'];
$pass1 = $_POST['passw1'];
$pass2 = $_POST['passw2'];
$nivel = $_POST['nivel'];
$id = $_POST['ident'];

//$fechaHoy = date("Y-m-d");
$usuAlta =  $_SESSION['usuario_id'];

if ($nivel=="") {
   $baja = date('Y-m-d');
} else {
   $baja = '0000-00-00 00:00:00';
}

if (($pass1 == "") || ($pass2 == "") || ($usuario == "") || ($nomap == "")) {
   echo "<div class=falta_dato><b>Debe completar todos los campos para poder crear un usuario.</b></div>";    
} else {
   if ($pass1 != $pass2) {
      echo "<div class=falta_dato><b>Las Contraseñas No Coinciden</b></div>";
   } else {
      $con = new ConsultaBD();

      $usuario=stripslashes($usuario);
      $pass1 = md5($pass1);
      $con = new ConsultaBD();
      $con->Conectar();               
      $sql = "UPDATE users SET usu_apellidoynombre = '$nomap', usu_iden = '$usuario',
      usu_clave = '$pass1', usu_permiso = '$nivel' WHERE usu_codigousu = $id;";      
      if ($con->executeQuery($sql)) {
         $con->Close();
         echo "<center><div class=exito><b><br/>Los datos se actualizaron con exito</b></div></center>";
         echo '<meta http-equiv="refresh" content="2; url=aut_nuevo_usuario.php">';
      } else  {
         $con->Close();
         echo "<div class=error><b><br/>Ha ocurrido un error intentando guardar los datos</b></div>";
         echo '<meta http-equiv="refresh" content="0; url=aut_nuevo_usuario.php">';
      }
   }
}
?>
