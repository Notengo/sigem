<?php
// Se chequea si existe un login
require_once '../usuarios/aut_verifica.inc.php';
require_once '../ClasesBasicas/ActiveRecordAbstractFactory.php';

// Se requieren los script para acceder a los datos de la DB
require_once '../ClasesBasicas/ActiveRecordAbstractFactory.php';
require_once '../Clases/ActiveRecord/MysqlSintomaActiveRecord.php';
require_once 'funciones.php';

$oMysql = ActiveRecordAbstractFactory::getActiveRecordFactory(ActiveRecordAbstractFactory::MYSQL);
$oMysql->conectar();

/*verificamos si las variables se envian*/
if(empty($_POST['sintoma'])){
    echo "Debe completar los campos requeridos";
    exit;
}

$oSintoma = new SintomaValueObject();
$oSintoma->setDescripcion($_POST['sintoma']);
//$oSintoma->setUsuarioAlta($_SESSION['usuario_id']);

$oMysqlSintoma = $oMysql->getSintomaActiveRecord();

mysql_query("begin;");
if($oMysqlSintoma->findDescripcion($oSintoma)) {
    mysql_query("ROLLBACK;");
    echo "Sintoma ya ingresado";
    exit;    
} else {
    if($oMysqlSintoma->insert($oSintoma)){
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