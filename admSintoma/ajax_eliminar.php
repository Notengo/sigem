<?php
// Se chequea si existe un login
require_once '../usuarios/aut_verifica.inc.php';

require_once '../ClasesBasicas/ActiveRecordAbstractFactory.php';
require_once '../Clases/ActiveRecord/MysqlSintomaActiveRecord.php';
require_once '../includes/funciones.php';

$oMysql = ActiveRecordAbstractFactory::getActiveRecordFactory(ActiveRecordAbstractFactory::MYSQL);
$oMysql->conectar();

/*verificamos si las variables se envian*/
if(empty($_POST['ide'])){
        echo "Ha ocurrido un error intentando eliminar los datos";
        exit;
}

$oSintoma = new SintomaValueObject();
$oSintoma->setId($_POST['ide']);

$oMysqlSintoma = $oMysql->getSintomaActiveRecord();
if($oMysqlSintoma->deleteExistente($oSintoma)) echo "Registro Eliminado";
else echo "No se pudo eliminar el registro";
exit;
?>