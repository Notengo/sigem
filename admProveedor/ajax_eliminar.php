<?php
// Se chequea si existe un login
require_once '../usuarios/aut_verifica.inc.php';

require_once '../ClasesBasicas/ActiveRecordAbstractFactory.php';
require_once '../ClasesBasicas/proveedor.php';
require_once '../includes/funciones.php';

$oMysql = ActiveRecordAbstractFactory::getActiveRecordFactory(ActiveRecordAbstractFactory::MYSQL);
$oMysql->conectar();

/*verificamos si las variables se envian*/
if(empty($_POST['ide'])){
        echo "Ha ocurrido un error intentando eliminar los datos";
        exit;
}

$oProveedor = new proveedor();
$oProveedor->setId($_POST['ide']);
$oProveedor->setUsuario($_SESSION['usuario_id']);
$oProveedor->deleteExistente();
echo "Registro Eliminado";
exit;


?>