<?php
// Se chequea si existe un login
require_once '../usuarios/aut_verifica.inc.php';

// Se requieren los script para acceder a los datos de la DB
require_once '../ClasesBasicas/ActiveRecordAbstractFactory.php';
require_once '../Clases/ActiveRecord/MysqlOrdenActiveRecord.php';
require_once '../Clases/ActiveRecord/MysqlUsuariosActiveRecord.php';
require_once '../Clases/ActiveRecord/MysqlAsignadosActiveRecord.php';

/*modificamos la tabla orden ahora con usuario asignado*/
$oMysql = ActiveRecordAbstractFactory::getActiveRecordFactory(ActiveRecordAbstractFactory::MYSQL);
$oMysql->conectar();

$oMysqlOrden = $oMysql->getOrdenActiveRecord();
$oOrden = new OrdenValueObject();

$oMysqlAsignado = $oMysql->getAsignadosActiveRecord();
$oAsignado = new AsignadosValueObject();

$orden= $_POST['orden'];
$oMysqlUsuarios = $oMysql->getUsuariosActiveRecord();
$aUsuarios=$oMysqlUsuarios->findPorOfcodi($_POST['ofcodi']);
    
if(count($aUsuarios>0)) {
    $oAsignado->setNroOrden($orden);
    $i=0;
    foreach ($aUsuarios as $value) {
        $oAsignado->setIdUsuario($value->getId());
        $oMysqlAsignado->updateUsuario($oAsignado);
        if($_POST[$value->getId()]) {
            $i++;        
            $oAsignado->setIdUsuario($_POST[$value->getId()]);
            $oMysqlAsignado->insert($oAsignado);
        }
    }
    if($i==0) {
        $oOrden->setNro($orden);
        $oOrden->setEstado(1);        
        if($oMysqlOrden->updateSinAsignar($oOrden)==false) {                
                exit();
        }
        echo "Debe seleccionar el usuario a asignar";
        exit;
    } else {
        $oOrden->setNro($orden);
        $oOrden->setEstado(2);
        $oOrden->setUsuarioAsignador($_SESSION['usuario_id']);
        if($oMysqlOrden->updateYaAsignado($oOrden)==false) {
                echo "Error al tratar de asignar la OT";
                exit();
        }
    }
} else {
    echo "Debe seleccionar el usuario a asignar";
    exit;
}
exit;
?>
