<?php
// Se chequea si existe un login
require_once '../usuarios/aut_verifica.inc.php';

// Se requieren los script para acceder a los datos de la DB
require_once '../ClasesBasicas/ActiveRecordAbstractFactory.php';
require_once '../Clases/ActiveRecord/MysqlEscuelaActiveRecord.php';

$cue = $_GET['cue'];

$oMysql = ActiveRecordAbstractFactory::getActiveRecordFactory(ActiveRecordAbstractFactory::MYSQL);
$oMysql->conectar();

$oMysqlEscuela = $oMysql->getEscuelaActiveRecord();
$oEscuela = new EscuelaValueObject();
$oEscuela_ = new EscuelaValueObject();

$oEscuela->setCue($cue);
$oEscuela_ = $oMysqlEscuela->find($oEscuela);

if($oEscuela_ == false)
        echo "true";
else
        echo "false";
?>