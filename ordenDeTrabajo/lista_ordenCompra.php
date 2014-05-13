<?php
// verificador de sesion
require_once '../usuarios/aut_verifica.inc.php';
require_once '../ClasesBasicas/ActiveRecordAbstractFactory.php';
require_once '../Clases/ActiveRecord/MysqlOrdenCompraActiveRecord.php';

if(isset($_GET['getOCByLetters']) && isset($_GET['letters'])){
	$letters = $_GET['letters'];                                        
        $oMysql = ActiveRecordAbstractFactory::getActiveRecordFactory(ActiveRecordAbstractFactory::MYSQL);
        $oMysql->conectar();
        $oOC = new OrdenCompraValueObject();        
        $letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
        $oOC->setNro($letters);        
        $oMysqlOC = $oMysql->getOrdenCompraActiveRecord();
        $aOC = $oMysqlOC->findOC($oOC);
        foreach ($aOC as $value) {
            $cod = $value->getId();
            $descri = htmlentities($value->getNro());
            echo $cod."###".$descri."|";            
        }
        unset($oOC);
}

?>
