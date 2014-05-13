<?php
// verificador de sesion
require_once '../usuarios/aut_verifica.inc.php';
require_once '../ClasesBasicas/ActiveRecordAbstractFactory.php';
require_once '../Clases/ActiveRecord/MysqlModeloActiveRecord.php';
include_once 'funciones.php';

if(isset($_GET['getModeloByLetters']) && isset($_GET['letters']) && isset($_GET['idmarca'])){
        $letters = $_GET['letters'];                                        
        $oMysql = ActiveRecordAbstractFactory::getActiveRecordFactory(ActiveRecordAbstractFactory::MYSQL);
        $oMysql->conectar();
        $oModelo = new ModeloValueObject();        
        $oModelo->setIdTipo(1);        
        $oModelo->setIdMarca($_GET['idmarca']);
        $letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
        $oModelo->setDescripcion($letters);        
        $oMysqlModelo = $oMysql->getModeloActiveRecord();
        $aModelo = $oMysqlModelo->findDescri($oModelo);
        foreach ($aModelo as $value) {
            $cod = $value->getIdModelo();
            $descri = htmlentities($value->getDescripcion());
            echo $cod."###".$descri."|";            
        }
        unset($oModelo);        
}

?>
