<?php
// Se chequea si existe un login
require_once '../usuarios/aut_verifica.inc.php';

require_once '../ClasesBasicas/ActiveRecordAbstractFactory.php';
require_once '../Clases/ActiveRecord/MysqlPedidoActiveRecord.php';
require_once 'funciones.php';

$oMysql = ActiveRecordAbstractFactory::getActiveRecordFactory(ActiveRecordAbstractFactory::MYSQL);
$oMysql->conectar();

/*verificamos si las variables se envian*/
if(empty($_POST['ide'])){
        echo "Ha ocurrido un error intentando eliminar los datos";
        exit;
}

$oPedido = new PedidoValueObject();
$oPedido->setId($_POST['ide']);

$oMysqlPedido = $oMysql->getPedidoActiveRecord();
if($oMysqlPedido->deleteExistente($oPedido)) echo "Registro Eliminado";
else echo "No se pudo eliminar el registro";
exit;
?>