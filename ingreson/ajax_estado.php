<?php
// Se chequea si existe un login
require_once '../usuarios/aut_verifica.inc.php';

// Se requieren los script para acceder a los datos de la DB
require_once '../ClasesBasicas/ActiveRecordAbstractFactory.php';
require_once '../Clases/ActiveRecord/MysqlOrdenActiveRecord.php';
require_once '../Clases/ActiveRecord/MysqlProblemaActiveRecord.php';


/*modificamos la tabla orden ahora con usuario asignado*/
$oMysql = ActiveRecordAbstractFactory::getActiveRecordFactory(ActiveRecordAbstractFactory::MYSQL);
$oMysql->conectar();

$oMysqlOrden = $oMysql->getOrdenActiveRecord();
$oOrden = new OrdenValueObject();

$oOrden->setNro($_POST['orden']);
$oMysqlOrden->find($oOrden);

$oProblema = new ProblemaValueObject();
$oProblema->setId($oOrden->getIdProblema());

$oMysqlProblema = $oMysql->getProblemaActiveRecord();
$oMysqlProblema->find($oProblema);

if(($oOrden->getNroEquipo()==0)&&($oOrden->getEquipo()==0)) {
    if($oProblema->getRequiereEquipo()==1)  {
        echo "ERROR: El problema requiere el ingreso del equipo";        
        exit;
    }    
} 

/*verificamos si las variables se envian*/
if($_POST['estado']==0){
        echo "ATENCION: Debe seleccionar el estado a asignar";
        exit;
}
if($_POST['observacion']==''){
        echo "ATENCION: Debe ingresar la descripcion de la solucion";
        exit;
}

$oOrden->setFormaFinalizacion($_POST['estado']);
$oOrden->setObservacion($_POST['observacion']);
if($oOrden->getFormaFinalizacion()<>1) {
    $oOrden->setEstado(3);
    $oOrden->setUsuarioFinalizacion($_SESSION['usuario_id']);
    if($oMysqlOrden->updateEstado($oOrden)==false)
        echo "Error al tratar cambiar el estado";
    else echo "Estado actualizado correctamente";
} else if($oOrden->getFormaFinalizacion()==1) {
    $oOrden->setUsuarioFinalizacion($_SESSION['usuario_id']);
    if($oMysqlOrden->updateObservacion($oOrden)==false)
        echo "Error al tratar cambiar el estado";
    else echo "Estado actualizado correctamente";
}
exit;
?>