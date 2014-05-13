<?php
// Se chequea si existe un login
require_once '../usuarios/aut_verifica.inc.php';
require_once '../ClasesBasicas/ActiveRecordAbstractFactory.php';

// Se requieren los script para acceder a los datos de la DB
require_once '../ClasesBasicas/ActiveRecordAbstractFactory.php';
require_once '../Clases/ActiveRecord/MysqlPedidoActiveRecord.php';
require_once '../includes/funciones.php';

$oMysql = ActiveRecordAbstractFactory::getActiveRecordFactory(ActiveRecordAbstractFactory::MYSQL);
$oMysql->conectar();

/*verificamos si las variables se envian*/
if(empty($_POST['pedido'])){
    echo "Debe completar los campos requeridos";
    exit;
}

$oPedido = new PedidoValueObject();
$oPedido->setDescripcion($_POST['pedido']);
//$oPedido->setUsuarioAlta($_SESSION['usuario_id']);

$oMysqlPedido = $oMysql->getPedidoActiveRecord();

mysql_query("begin;");
if($oMysqlPedido->findDescripcion($oPedido)) {
    mysql_query("ROLLBACK;");
    echo "Pedido ya ingresado";
    exit;    
} else {
    if($oMysqlPedido->insert($oPedido)){
        mysql_query("COMMIT;");     
        echo "Datos guardados con exito";
        exit;
    } else {
        mysql_query("ROLLBACK;");
        echo "Ha ocurrido un error intentando guardar los datos";
        exit;
    }  
}
?>