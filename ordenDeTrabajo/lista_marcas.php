<?php
// verificador de sesion
require_once '../usuarios/aut_verifica.inc.php';
require_once '../ClasesBasicas/ActiveRecordAbstractFactory.php';
require_once '../Clases/ActiveRecord/MysqlMarcaActiveRecord.php';

if(isset($_GET['getMarcaByLetters']) && isset($_GET['letters'])){
	$letters = $_GET['letters'];                                        
        $oMysql = ActiveRecordAbstractFactory::getActiveRecordFactory(ActiveRecordAbstractFactory::MYSQL);
        $oMysql->conectar();
        $oMarca = new MarcaValueObject();
        $oMarca->setIdTipo(1);       
        $letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
        $oMarca->setDescripcion($letters);        
        $oMysqlMarca = $oMysql->getMarcaActiveRecord();
        $aMarca = $oMysqlMarca->findDesc($oMarca);
        foreach ($aMarca as $value) {
            $cod = $value->getIdMarca();
            $descri = htmlentities($value->getDescripcion());
            echo $cod."###".$descri."|";            
        }
        unset($oMarca);
}

?>
