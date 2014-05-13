<?php
// Se chequea si existe un login
require_once '../usuarios/aut_verifica.inc.php';

require_once '../ClasesBasicas/ActiveRecordAbstractFactory.php';
require_once '../Clases/ActiveRecord/MysqlEquipoActiveRecord.php';
require_once '../includes/funciones.php';

$oMysql = ActiveRecordAbstractFactory::getActiveRecordFactory(ActiveRecordAbstractFactory::MYSQL);
$oMysql->conectar();

/*verificamos si las variables se envian*/
if((empty($_POST['ide_eq']))||(empty($_POST['observacion']))){
        echo "Ha ocurrido un error intentando eliminar los datos";
        exit;
}

$oEquipo = new EquipoValueObject();
$oEquipo->setNro($_POST['ide_eq']);
$oMysqlEquipo = $oMysql->getEquipoActiveRecord();
$verEquipo = $oMysqlEquipo->find($oEquipo); 
$oEquipo->setObservacion($_POST['observacion']);
$oEquipo->setUsuarioAlta($_SESSION['usuario_id']);
$oEquipo->setId($verEquipo->getId());

// ELIMINAR EQUI_RX
mysql_query("begin;");
if($oMysqlEquipo->delete($oEquipo)) {
    if($oMysqlEquipo->findPorRx($verEquipo)==true) {
        if($oMysqlEquipo->deleteRx($verEquipo)) {
            mysql_query("COMMIT;");     
            echo "Equipo eliminado con exito";
            exit;
        } else {
            mysql_query("ROLLBACK;");
            echo "Ha ocurrido un error intentando eliminar los datos";
            exit;
        }
    } else {
        mysql_query("COMMIT;");     
        echo "Equipo eliminado con exito";
        exit;
    }
} else {
    mysql_query("ROLLBACK;");
    echo "Ha ocurrido un error intentando eliminar los datos";
    exit;
}
?>