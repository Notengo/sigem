<?php
// verificador de sesion
require_once '../usuarios/aut_verifica.inc.php';
require_once '../ClasesBasicas/ActiveRecordAbstractFactory.php';
require_once '../Clases/ActiveRecord/MysqlAdquirienteActiveRecord.php';

if(isset($_GET['getAdquirienteByLetters']) && isset($_GET['letters'])){
	$letters = $_GET['letters'];                                        
        $oMysql = ActiveRecordAbstractFactory::getActiveRecordFactory(ActiveRecordAbstractFactory::MYSQL);
        $oMysql->conectar();
        //$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
        $oAdquiriente = new AdquirienteValueObject();
        $oAdquiriente->setDescripcion($letters);
        $oMysqlAdquiriente = $oMysql->getAdquirienteActiveRecord();
        $aAdquiriente = $oMysqlAdquiriente->findDescripcion($oAdquiriente);
        foreach ($aAdquiriente as $value) {
            $cod = $value->getId();
            $descri = htmlentities($value->getDescripcion());
            echo $cod."###".$descri."|";            
        }
        unset($oAdquiriente);
}

?>
