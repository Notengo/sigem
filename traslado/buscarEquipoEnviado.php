<?php
// Se chequea si existe un login
require_once '../usuarios/aut_verifica.inc.php';

// Se requieren los script para acceder a los datos de la DB
require_once '../ClasesBasicas/ActiveRecordAbstractFactory.php';

require_once '../Clases/ActiveRecord/MysqlUbicacionActiveRecord.php';
require_once '../Clases/ActiveRecord/MysqlServicioActiveRecord.php';
require_once '../Clases/ActiveRecord/MysqlOficexpeActiveRecord.php';
require_once '../Clases/ActiveRecord/MysqlMotivoTrasladoActiveRecord.php';

$oMysql = ActiveRecordAbstractFactory::getActiveRecordFactory(ActiveRecordAbstractFactory::MYSQL);
$oMysql->conectar();

$oUbicacion = new UbicacionValueObject();
$oUbicacion->setIdEquipo($_POST['equipo']);
$oUbicacion->setConfirma($_POST['confirma']);
$oUbicacionAr = new MysqlUbicacionActiveRecord();
$oUbicacion = $oUbicacionAr->find($oUbicacion);
if($oUbicacion){
    $oServicioVo = new ServicioValueObject();
    $oServicioAr = new MysqlServicioActiveRecord();
    $oServicioVo->setIdServicio($oUbicacion->getIdServicio());
    $oServicioVo = $oServicioAr->find($oServicioVo);

    $oOficinaVo = new OficexpeValueObject();
    $oOficinaAr = new MysqlOficexpeActiveRecord();
    $oOficinaVo->set_ofcodi($oUbicacion->getOfcodi());
    $oOficinaVo = $oOficinaAr->find($oOficinaVo);

    $oMotivoTraslado = new MotivoTrasladoValueObject();
    $oMotivoTraslado->setIdMotivoTraslado($oUbicacion->getIdMotivoTraslado());

    $oMotivoVo = $oMysql->getMotivoTrasladoActiveRecord();
    $oMotivoTraslado = $oMotivoVo->find($oMotivoTraslado);
    ?>
    <input type="hidden" id="h_serv1" value="<?php echo utf8_encode($oServicioVo->getDescripcion()); ?>" />
    <input type="hidden" id="h_ubic1" value="<?php echo utf8_encode(htmlentities($oOficinaVo->get_nombre())); ?>" />
    <input type="hidden" id="h_moti1" value="<?php echo utf8_encode(htmlentities($oMotivoTraslado->getDescripcion())); ?>" />
<?php
} else {
    ?>
    <center>
        <div id='flotante'>
            <div class='errorConfirma'>
                No se encontro ning&uacute;n traslado para el equipo
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