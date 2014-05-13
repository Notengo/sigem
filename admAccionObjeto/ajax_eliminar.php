<?php
// Se chequea si existe un login
require_once '../usuarios/aut_verifica.inc.php';

require_once '../ClasesBasicas/ActiveRecordAbstractFactory.php';
require_once '../Clases/ActiveRecord/MysqlSintomaActiveRecord.php';
require_once 'funciones.php';

$oMysql = ActiveRecordAbstractFactory::getActiveRecordFactory(ActiveRecordAbstractFactory::MYSQL);
$oMysql->conectar();

/*verificamos si las variables se envian*/
if(empty($_POST['ide'])){
        echo "Ha ocurrido un error intentando eliminar los datos";
        exit;
}

$oAccionObjeto = new AccionObjetoValuoObject();
$oAccionObjeto->setIdAccionObjeto($_POST['ide']);

$oMysqlAccionObjeto = $oMysql->getAccionObjetoActiveRecord();
if($oMysqlAccionObjeto->delete($oAccionObjeto)) echo "Registro Eliminado";
else echo "No se pudo eliminar el registro";
exit;
?>