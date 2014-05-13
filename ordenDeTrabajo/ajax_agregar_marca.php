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
$oMarca = new MarcaValueObject();
$oMarcaN = new MarcaValueObject();
$oMysqlMarca = $oMysql->getMarcaActiveRecord();

$oModelo = new ModeloValueObject();
$oModeloN = new ModeloValueObject();
$oMysqlModelo = $oMysql->getModeloActiveRecord();

$marcacpu = $_POST['marca'];        
if(($_POST['tipo']==10) || ($_POST['tipo']==11)) {
    $oMarca->setIdTipo(9);
} else {
    $oMarca->setIdTipo($_POST['tipo']);
}  
$oMarca->setDescripcion($marcacpu);
$oMarca->setUsuarioAlta($_SESSION['usuario_id']);
$oMarcaN = $oMysqlMarca->findDescripcion($oMarca);

if($oMarcaN==false){
    mysql_query("begin;");
    if($oMysqlMarca->insert($oMarca)==true) {
        $modelocpu = $_POST['modelo'];        
        if(($_POST['tipo']==10) || ($_POST['tipo']==11)) {
            $oModelo->setIdTipo(9);
        } else {
            $oModelo->setIdTipo($_POST['tipo']);
        }  
        $oModelo->setIdMarca($oMarca->getIdMarca());
        $oModelo->setDescripcion($modelocpu);
        $oModelo->setUsuarioAlta($_SESSION['usuario_id']);
        $oModeloN = $oMysqlModelo->findDescripcion($oModelo);                
        if($oModeloN==false){
            if($oMysqlModelo->insert($oModelo)==false) $error=3;               
        } 
    } else $error = 3;
    
} else { echo "La marca ya existe. "; $error=3;}
            
if($error==3) {
    echo "Error intentando guardar la descripcion de la marca";
    mysql_query('rollback');    
} else {
    mysql_query('Commit');
   echo "Datos guardados";        
}
exit;
?>