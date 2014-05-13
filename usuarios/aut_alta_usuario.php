<?php
include_once 'aut_verifica.inc.php';
include_once '../ClasesBasicas/ConsultaBD.php';
// Se requieren los script para acceder a los datos de la DB
require_once '../ClasesBasicas/ActiveRecordAbstractFactory.php';
require_once '../Clases/ActiveRecord/MysqlAgentesActiveRecord.php';

$oAgente = new AgentesValueObject();

$oMysql = ActiveRecordAbstractFactory::getActiveRecordFactory(ActiveRecordAbstractFactory::MYSQL);
$oMysql->conectar();  

$existe = $_POST['existe'];
$dni = $_POST['dni'];
$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$direccion = $_POST['direccion'];
$usuario = $_POST['identif'];
$pass1 = $_POST['passw1'];
$pass2 = $_POST['passw2'];
$nivel= $_POST['nivel'];

$usuAlta =  $_SESSION['usuario_id'];

if ($nivel=="") {
   $baja = date('Y-m-d');
} else {
   $baja = '0000-00-00 00:00:00';
}
echo "<br/>";
if (($pass1 == "") || ($pass2 == "") || ($usuario == "") || ($nombre == "")) {
   echo "<div class=falta_dato><b>Debe completar todos los campos para poder crear un usuario.</b></div>";    
} else {
   if ($pass1 != $pass2) {
      echo "<div class=falta_dato><b>Las Contraseñas No Coinciden</b></div>";
   } else {
      $con = new ConsultaBD();
      $con->Conectar();      
      $sql="SELECT id FROM users WHERE identificacion='$usuario'";      
      $con->executeQuery($sql);
      $con->Close();
      $total_encontrados = 0;
      $total_encontrados = $con->getNumRows();      
      if ($total_encontrados !=  0) {
         echo "<div class=falta_dato><b>La identificaci&oacute;n del usuario ya est&aacute; registrada</b></div>";
      } else {
         $usuario=stripslashes($usuario);
         $pass1 = md5($pass1);
         $con = new ConsultaBD();
         $con->Conectar();  
         $con->executeQuery("begin");
         $oAgente->setApellido($apellido);
         $oAgente->setNombre($nombre);
         $oAgente->setDni($dni);
         $oAgente->setDireccion($direccion);
         $oAgente->setCoddpto(10);
         $oAgente->setCodloc(10);
         $oAgente->setUsuarioAlta($usuAlta);
         $oMysqlAgentes = $oMysql->getAgentesActiveRecord();             
         if($existe==0){      
             $oMysqlAgentes->insert($oAgente);             
         } else {
             $oMysqlAgentes->update($oAgente);             
         }         
         $sql = "INSERT INTO users (dni, identificacion, clave, permiso, usuarioAlta, fechabaja, usuarioBaja, ambito) ";
         $sql .= "VALUES('$dni','$usuario','$pass1','$nivel',$usuAlta, '$baja', 0, '2014')";                     
         if ($con->executeQuery($sql)) {
             $con->executeQuery("commit");
            $con->Close();
            echo "<center><div class=exito><b>Los datos se actualizaron con exito</b></div></center>";
            echo '<meta http-equiv="refresh" content="2; url=aut_nuevo_usuario.php">';
         } else  {
             $con->executeQuery("rollback");
            $con->Close();
            echo "<div class=error><b>Ha ocurrido un error intentando guardar los datos</b></div>";
            echo '<meta http-equiv="refresh" content="0; url=aut_nuevo_usuario.php">';
         }
      }
   }
}
?>
