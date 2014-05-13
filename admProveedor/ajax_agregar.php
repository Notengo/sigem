<?php
// Se chequea si existe un login
require_once '../usuarios/aut_verifica.inc.php';

require_once '../ClasesBasicas/ActiveRecordAbstractFactory.php';
require_once '../ClasesBasicas/proveedor.php';
require_once '../includes/funciones.php';

$oMysql = ActiveRecordAbstractFactory::getActiveRecordFactory(ActiveRecordAbstractFactory::MYSQL);
$oMysql->conectar();

/*verificamos si las variables se envian*/
if(empty($_POST['nombre']) || empty($_POST['direccion'])){
        echo "Debe completar los campos requeridos";
        exit;
}

$oProveedor = new proveedor();
$oProveedor->setNombre(utf8_decode($_POST['nombre']));
$oProveedor->setDuenio('');
$oProveedor->setDireccion(utf8_decode($_POST['direccion']));
$oProveedor->setTelefono($_POST['telefono']);
$oProveedor->setFax($_POST['fax']);
$oProveedor->setReferencia($_POST['calificacion']);
$oProveedor->setIva('');
$oProveedor->setDgr('');
$oProveedor->setCuit('');
$oProveedor->setUsuario($_SESSION['usuario_id']);
if($oProveedor->insertNuevo()==false)        
    echo "Error al insertar a la dependencia. Verifique que no este ingresada anteriormente";
else
    echo "Datos guardados";
exit;
?>