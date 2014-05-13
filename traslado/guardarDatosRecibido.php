<?php
/**
 * @copyright  Copyright (c) 2014 INFORMATICA MINISTERIO DE SALUD
 * @version    1.0
 * @since      File available since Release 1.0
*/
// Se chequea si existe un login
require_once '../usuarios/aut_verifica.inc.php';
// Se requieren los script para acceder a los datos de la DB
require_once '../ClasesBasicas/ActiveRecordAbstractFactory.php';

$oMysql = ActiveRecordAbstractFactory::getActiveRecordFactory(ActiveRecordAbstractFactory::MYSQL);
$oMysql->conectar();

/* Obtengo los datos eviados desde el .js */
$equipo = $_POST['equipo'];

/* Busmco los datos del equipo en la tabla de ubicacion
 * para poder darlo de baja y luego poder dar de alta (conformar) la nueva ubicacion.
 */
require_once '../Clases/ActiveRecord/MysqlEquipoActiveRecord.php';
require_once '../Clases/ActiveRecord/MysqlUbicacionActiveRecord.php';

$oEquipoA = new MysqlEquipoActiveRecord();

$oUbicacion = new UbicacionValueObject();
$oUbicacion->setIdEquipo($equipo);
$oUbicacion->setConfirma('S');
$oUbicacion->setUsuarioBaja($_SESSION['usuario_id']);

$oUbicacionAr = new MysqlUbicacionActiveRecord();
$error = 0;
mysql_query('begin;');
if (!$oUbicacionAr->bajaOficina($oUbicacion)) { $error ++; }
if (!$oUbicacionAr->confirmar($oUbicacion)) { $error ++; }
echo $error;
if($error === 0){
    mysql_query("COMMIT");
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
    mysql_query("ROLLBACK");
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