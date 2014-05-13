<?php
// Se chequea si existe un login
require_once '../usuarios/aut_verifica.inc.php';
require_once '../ClasesBasicas/ActiveRecordAbstractFactory.php';

// Se requieren los script para acceder a los datos de la DB
require_once '../ClasesBasicas/ActiveRecordAbstractFactory.php';
require_once '../Clases/ActiveRecord/MysqlServicioActiveRecord.php';
require_once 'funciones.php';

$oMysql = ActiveRecordAbstractFactory::getActiveRecordFactory(ActiveRecordAbstractFactory::MYSQL);
$oMysql->conectar();

/*verificamos si las variables se envian*/
if(empty($_POST['servicio'])){
        echo "Debe completar los campos requeridos";
        exit;
}

$oServ = new ServicioValueObject();
$oServ->setDescripcion($_POST['servicio']);
$oServ->setUsuarioAlta($_SESSION['usuario_id']);

$oMysqlServ = $oMysql->getServicioActiveRecord();

mysql_query("begin;");
if($oMysqlServ->findDescripcion($oServ)) {
    mysql_query("ROLLBACK;");
    echo "Servicio ya ingresado";
    exit;    
} else {
    if($oMysqlServ->insert($oServ)){
        mysql_query("COMMIT;");     
        echo "Datos guardados con exito";
        exit;
    } else {
        mysql_query("ROLLBACK;");
        echo "Ha ocurrido un error intentando guardar fdaslos datos";
        exit;
    }  
}
?>