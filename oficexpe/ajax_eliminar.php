<?php
require_once '../ClasesBasicas/ActiveRecordAbstractFactory.php';
require_once '../Clases/ActiveRecord/MysqlOrdenActiveRecord.php';
require_once '../Clases/ActiveRecord/MysqlBloqueoActiveRecord.php';
require_once '../includes/funciones.php';

$oMysql = ActiveRecordAbstractFactory::getActiveRecordFactory(ActiveRecordAbstractFactory::MYSQL);
$oMysql->conectar();

/*verificamos si las variables se envian*/
if(empty($_POST['ide_ofi'])){
        echo "Ha ocurrido un error intentando eliminar los datos";
        exit;
}

/* busca si la oficina esta siendo utilizada */
$oOrden = new OrdenValueObject();
$oBloqueo = new BloqueoValueObject();
$oOrden->setOfcodi($_POST['ide_ofi']);
$oBloqueo->setOfcodi($_POST['ide_ofi']);

$oMysqlOrden = $oMysql->getOrdenActiveRecord();
$oMysqlBloqueo = $oMysql->getBloqueoActiveRecord();

if($oMysqlOrden->countPorOfcodi($oOrden)) {
    echo "La dependencia esta siendo utilizada. Imposible eliminar";
    exit;
}
if($oMysqlBloqueo->countPorOfcodi($oBloqueo)){
    echo "La dependencia esta siendo utilizada. Imposible eliminar";
    exit;
}   

/*modificar el registro*/
$sql = sprintf("delete from oficexpe where ofcodi=%d",
		(int)$_POST['ide_ofi']
	);
if(!mysql_query($sql))
        echo "Error al eliminar la dependencia";
else 
    echo "Dependencia eliminada";
exit;
?>