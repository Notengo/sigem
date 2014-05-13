<?php
// Se chequea si existe un login
require_once '../usuarios/aut_verifica.inc.php';

require_once '../ClasesBasicas/ActiveRecordAbstractFactory.php';
require_once '../Clases/ActiveRecord/MysqlServicioActiveRecord.php';
require_once 'funciones.php';

$oMysql = ActiveRecordAbstractFactory::getActiveRecordFactory(ActiveRecordAbstractFactory::MYSQL);
$oMysql->conectar();

/*verificamos si las variables se envian*/
if(empty($_POST['ide'])){
        echo "Ha ocurrido un error intentando eliminar los datos";
        exit;
}

$oServicio = new ServicioValueObject();
$oServicio->setId($_POST['ide']);
$oServicio->setUsuarioAlta($_SESSION['usuario_id']);
$oMysqlServ = $oMysql->getServicioActiveRecord();
$oMysqlServ->deleteExistente($oServicio);
echo "Registro Eliminado";
exit;


?>