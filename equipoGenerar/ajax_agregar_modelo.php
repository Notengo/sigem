<?php
// verificador de sesion
require_once '../usuarios/aut_verifica.inc.php';
require_once '../ClasesBasicas/ActiveRecordAbstractFactory.php';
require_once '../Clases/ActiveRecord/MysqlMarcaActiveRecord.php';
require_once '../Clases/ActiveRecord/MysqlModeloActiveRecord.php';

$oMysql = ActiveRecordAbstractFactory::getActiveRecordFactory(ActiveRecordAbstractFactory::MYSQL);
$oMysql->conectar();

/*verificamos si las variables se envian*/
if(empty($_POST['marca']) || empty($_POST['modelo'])){
        echo "Debe completar los campos requeridos";
        exit;
}

/*insertamos el nuevo registro*/
$oModelo = new ModeloValueObject();
$oModeloN = new ModeloValueObject();
$oMysqlModelo = $oMysql->getModeloActiveRecord();
mysql_query("begin;");
$modelo =utf8_decode($_POST['modelo']);        
if(($_POST['tipo']==10) || ($_POST['tipo']==11)) {
    $oModelo->setIdTipo(9);
} else {
    $oModelo->setIdTipo($_POST['tipo']);
}  
$oModelo->setIdMarca($_POST['marca']);
$oModelo->setDescripcion($modelo);
$oModelo->setUsuarioAlta($_SESSION['usuario_id']);
$oModeloN = $oMysqlModelo->findDescripcion($oModelo);                
if($oModeloN==false){
    if($oMysqlModelo->insert($oModelo)==false) $error=3;               
} else $error=3;   

            
if($error==3) {
    echo "La descripcion del modelo ya existe";
    mysql_query('rollback');    
} else {
    mysql_query('Commit');
   echo "Datos guardados";        
}
exit;
?>