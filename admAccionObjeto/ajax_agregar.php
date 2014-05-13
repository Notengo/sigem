<?php
// Se chequea si existe un login
require_once '../usuarios/aut_verifica.inc.php';
require_once '../ClasesBasicas/ActiveRecordAbstractFactory.php';

// Se requieren los script para acceder a los datos de la DB
require_once '../ClasesBasicas/ActiveRecordAbstractFactory.php';

require_once '../includes/funciones.php';

$oMysql = ActiveRecordAbstractFactory::getActiveRecordFactory(ActiveRecordAbstractFactory::MYSQL);
$oMysql->conectar();

/*verificamos si las variables se envian*/
if(empty($_POST['accionObjeto'])){
    echo "Debe completar los campos requeridos";
    exit;
}

$oAccionObjeto = new AccionObjetoValuoObject();
$oAccionObjeto->setIdAccion($_POST['idAccion']);
$oAccionObjeto->setDescripcion($_POST['accionObjeto']);

$oMyAccionObjeto = $oMysql->getAccionObjetoActiveRecord();

mysql_query("begin;");
if($oMyAccionObjeto->insert($oAccionObjeto)) {
    mysql_query("COMMIT;");     
    echo "Datos guardados con exito";
    exit;
} else {
    mysql_query("ROLLBACK;");
    echo "Ha ocurrido un error intentando guardar los datos";
    exit;
}
?>