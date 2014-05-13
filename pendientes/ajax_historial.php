<?php
// Se chequea si existe un login
require_once '../usuarios/aut_verifica.inc.php';

// Se requieren los script para acceder a los datos de la DB
require_once '../ClasesBasicas/ActiveRecordAbstractFactory.php';
require_once '../Clases/ActiveRecord/MysqlOrdenActiveRecord.php';
require_once '../Clases/ActiveRecord/MysqlHistorialActiveRecord.php';

/*verificamos si las variables se envian*/
if($_POST['problema']==''){
        echo "ATENCION: Debe ingresar la descripcion del problema";
        exit;
}

$oMysql = ActiveRecordAbstractFactory::getActiveRecordFactory(ActiveRecordAbstractFactory::MYSQL);
$oMysql->conectar();

$oMysqlOrden = $oMysql->getOrdenActiveRecord();
$oMysqlHistorial = $oMysql->getHistorialActiveRecord();

$oOrden = new OrdenValueObject();
$oOrden->setNro($_POST['orden']);

$oHistorial = new HistorialValueObject();
$oHistorial = $oMysqlOrden->find($oOrden);

if($oMysqlHistorial->insert($oHistorial)==true) {
    $oOrden->setDescripcion($_POST['problema']);
    $oOrden->setUsuarioAlta($_SESSION['usuario_id']);
    $oMysqlOrden->updateDescripcion($oOrden);
} else {
   echo "ATENCION: Ha ocurrido un error intentando guardar los datos";
}

exit;
?>