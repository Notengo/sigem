<?php
// verificador de sesion
require_once '../usuarios/aut_verifica.inc.php';
require_once '../ClasesBasicas/ActiveRecordAbstractFactory.php';
require_once '../Clases/ActiveRecord/MysqlNomenclActiveRecord.php';

if(isset($_GET['getCodeqByLetters']) && isset($_GET['letters'])){	
        $letters = $_GET['letters'];
        $oMysql = ActiveRecordAbstractFactory::getActiveRecordFactory(ActiveRecordAbstractFactory::MYSQL);
        $oMysql->conectar();
        $oTipo = new NomenclValueObject();            
     //   $letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
        $oTipo->setDes_eq($letters);        
        $oMysqlTipo = $oMysql->getNomenclActiveRecord();
        $aTipo = $oMysqlTipo->findNomencl($oTipo);
        foreach ($aTipo as $value) {            
            $cod = $value->getCod_eq().$value->getRx();            
            $descri = htmlentities($value->getDes_eq());
            echo $cod."###".$descri."|";            
        }        
        unset($oTipo);
}

?>
