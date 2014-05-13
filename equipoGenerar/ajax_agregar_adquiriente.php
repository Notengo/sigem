<?php
// verificador de sesion
require_once '../usuarios/aut_verifica.inc.php';
require_once '../ClasesBasicas/ActiveRecordAbstractFactory.php';
require_once '../Clases/ActiveRecord/MysqlAdquirienteActiveRecord.php';

$oMysql = ActiveRecordAbstractFactory::getActiveRecordFactory(ActiveRecordAbstractFactory::MYSQL);
$oMysql->conectar();

/*verificamos si las variables se envian*/
if(empty($_POST['descripcion'])){
        echo "Debe completar los campos requeridos";
        exit;
}


/*insertamos el nuevo registro*/
$oOC = new AdquirienteValueObject();
$oOC->setDescripcion(utf8_decode($_POST['descripcion']));
$oOC->setUsuarioAlta($_SESSION['usuario_id']);
$oMysqlOC = $oMysql->getAdquirienteActiveRecord();
if($oMysqlOC->findUnaDescripcion($oOC)==false){
if(!$oMysqlOC->insert($oOC))
    echo "Error al insertar el adquiriente";
else
    echo "Datos guardados";
} else {
   echo "El adquiriente ya existe";
}
exit;
?>