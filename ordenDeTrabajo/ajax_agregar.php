<?php
// verificador de sesion
require_once '../usuarios/aut_verifica.inc.php';
require_once '../ClasesBasicas/ActiveRecordAbstractFactory.php';
require_once '../Clases/ActiveRecord/MysqlOrdenCompraActiveRecord.php';
require_once '../ClasesBasicas/CFecha.php';

$oMysql = ActiveRecordAbstractFactory::getActiveRecordFactory(ActiveRecordAbstractFactory::MYSQL);
$oMysql->conectar();

/*verificamos si las variables se envian*/
if(empty($_POST['nro']) || empty($_POST['fecha']) || empty($_POST['proveedor'])){
        echo "Debe completar los campos requeridos";
        exit;
}


/*insertamos el nuevo registro*/
$oOC = new OrdenCompraValueObject();
$oOC->setNro($_POST['nro']);
$oFecha = new CFecha();
$oFecha->setFecha($_POST['fecha']);
$oFecha->convierto_mysql();
$oOC->setFecha($oFecha->getFecha());
$oOC->setProveedor($_POST['proveedor']);
$oOC->setObservacion($_POST['observacion']);
$oOC->setUsuario($_SESSION['usuario_id']);
$oMysqlOC = $oMysql->getOrdenCompraActiveRecord();
       
if(!$oMysqlOC->insert($oOC))
    echo "Error al insertar la Orden de Compra";
else
    echo "Datos guardados";
exit;
?>