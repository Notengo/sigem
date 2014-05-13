<?php
// Se chequea si existe un login
require_once '../usuarios/aut_verifica.inc.php';
// Se requieren los script para acceder a los datos de la DB
require_once '../ClasesBasicas/ActiveRecordAbstractFactory.php';
include_once '../Clases/ActiveRecord/MysqlOrden.php';
$oMysql = ActiveRecordAbstractFactory::getActiveRecordFactory(ActiveRecordAbstractFactory::MYSQL);
$oMysql->conectar();

$oMysqlOrden = $oMysql->getOrdenActiveRecord();
$oOrden = new Orden();
$oOrden->setIdorden($_POST['identificador']);
$oOrden->setIdUsers($_POST['usuario']);
$oOrden->setFechaAsignacion(date('Y-m-d'));

if($oMysqlOrden->asignar($oOrden)){
    ?>
    <center>
        <div id='flotante'>
            <div class='exitoConfirma'>
                La asignaci&oacute;n se realiz&oacute; correctamente.
                <br/>
                Por favor intente nuevamente
                <div align='right'>
                <a href="index.php" class='buttonExito'>Aceptar</a>
                </div>
            </div>
        </div>
    </center>
    <?php
} else {
    ?>
    <center>
        <div id='flotante'>
            <div class='errorConfirma'>
                Ha ocurrido un error en la modificaci&oacute;n de la OT
                <br/>
                Por favor intente nuevamente
                <div align='right'>
                <a href="index.php" class='buttonError'>Aceptar</a>
                </div>
            </div>
        </div>
    </center>
<?php
}
?>
