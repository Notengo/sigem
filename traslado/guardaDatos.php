<?php
/**
 *
 * @copyright  Copyright (c) 2013 INFORMATICA MINISTERIO DE SALUD
 * @version    1.0
 * @since      File available since Release 1.0
 *
*/
// Se chequea si existe un login
require_once '../usuarios/aut_verifica.inc.php';

// Se requieren los script para acceder a los datos de la DB
require_once '../ClasesBasicas/ActiveRecordAbstractFactory.php';
//require_once '../Clases/ActiveRecord/MysqlUbicacionActiveRecord.php';

$oMysql = ActiveRecordAbstractFactory::getActiveRecordFactory(ActiveRecordAbstractFactory::MYSQL);
$oMysql->conectar();

/* Obtengo los datos eviados desde el .js */
$equipo = $_POST['equipo'];
$nuevaubic = $_POST['nuevaubic'];
$nuevaserv = $_POST['nuevaserv'];
$nuevamoti = $_POST['nuevamoti'];

/*
 * Comienzo del proceso de grabacion de los datos en la tabla Ubicacion.
 */
$oUbicacion = new UbicacionValueObject();
$oUbicacion->setConfirma('N');
$oUbicacion->setIdEquipo($equipo);
$oUbicacion->setOfcodi($nuevaubic);
$oUbicacion->setIdServicio($nuevaserv);
$oUbicacion->setIdMotivoTraslado($nuevamoti);
$oUbicacion->setUsuarioAlta($_SESSION['usuario_id']);

$oMyUbicacion = $oMysql->getUbicacionActiveRecord();

mysql_query("begin;");
if($oMyUbicacion->insert($oUbicacion) ){
    mysql_query("commit");
    ?>
    <center>
        <div id='flotante'>
            <div class='exitoConfirma'>
                La ubicaci&oacute;n ha sido guardada con &eacute;xito
                <br/>
                <br/>
                <div align='right'>
                    <a href="javascript: cerrar('flotante');" class='buttonExito'>Aceptar</a>
                </div>
            </div>
        </div>
    </center>
    <?php
} else {
    mysql_query("rollback");
    ?>
    <center>
        <div id='flotante'>
            <div class='errorConfirma'>
                Ha ocurrido un error al tratar de guardar la ubicaci&oacute;n.
                <br/>
                Por favor intente nuevamente
                <div align='right'>
                    <a href="javascript: cerrar('flotante');" class='buttonError'>Aceptar</a>
                </div>
            </div>
        </div>
    </center>
    <?php
}
?>