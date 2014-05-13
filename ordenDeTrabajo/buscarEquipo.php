<?php
// Se chequea si existe un login
require_once '../usuarios/aut_verifica.inc.php';

// Se requieren los script para acceder a los datos de la DB
require_once '../ClasesBasicas/ActiveRecordAbstractFactory.php';

require_once '../Clases/ActiveRecord/MysqlEquipoActiveRecord.php';
require_once '../Clases/ActiveRecord/MysqlNomenclActiveRecord.php';
require_once '../Clases/ActiveRecord/MysqlModeloActiveRecord.php';
require_once '../Clases/ActiveRecord/MysqlUbicacionActiveRecord.php';
require_once '../Clases/ActiveRecord/MysqlServicioActiveRecord.php';
require_once '../Clases/ActiveRecord/MysqlOficexpeActiveRecord.php';
require_once '../ClasesBasicas/proveedor.php';


$oMysql = ActiveRecordAbstractFactory::getActiveRecordFactory(ActiveRecordAbstractFactory::MYSQL);
$oMysql->conectar();

$oEquipoV = new EquipoValueObject();
$oEquipoV->setNro($_POST['equipo']);

$establecimiento = $_POST['establecimiento'];

$oEquipoA = new MysqlEquipoActiveRecord();
if($oEquipoV = $oEquipoA->find($oEquipoV)){
    $oNomencladorV = new NomenclValueObject();
    $oNomencladorV->setCod_eq($oEquipoV->getCod_eq());
    $oNomencladorA = new MysqlNomenclActiveRecord();
    $oNomencladorV = $oNomencladorA->findId($oNomencladorV);

    $edad = new DateTime($oEquipoV->getEdad());
    $hoy = new DateTime('NOW');
    $anoActual = $hoy->format('Y');
    $mesActual = $hoy->format('m');
    $diaActual = $hoy->format('d');
    $anoEquipo = $edad->format('Y');
    $mesEquipo = $edad->format('m');
    $diaEquipo = $edad->format('d');
    $diferencia = ($anoActual-$anoEquipo) . ' a&ntilde;os y ' . ($mesActual-$mesEquipo-1) . " meses";
//    $diferencia = $edad->diff($hoy)->format('%y años y %m meses');

    $oProveedor = new proveedor();
    $oProveedor->setId($oEquipoV->getIdProveedor());
    $oProveedor->findOne();

    $oUbicacion = new UbicacionValueObject();
    $oUbicacion->setIdEquipo($_POST['equipo']);
    $oUbicacion->setConfirma('S');
    $oUbicacionAr = new MysqlUbicacionActiveRecord();
    $oUbicacion = $oUbicacionAr->find($oUbicacion);
    
    $oServicioVo = new ServicioValueObject();
    $oServicioAr = new MysqlServicioActiveRecord();
    $oServicioVo->setIdServicio($oUbicacion->getIdServicio());
    $oServicioVo = $oServicioAr->find($oServicioVo);
    
    $oOficinaVo = new OficexpeValueObject();
    $oOficinaAr = new MysqlOficexpeActiveRecord();
    $oOficinaVo->set_ofcodi($oUbicacion->getOfcodi());
    $oOficinaVo = $oOficinaAr->find($oOficinaVo);
    
    if ($establecimiento != $oOficinaVo->get_ofcodi()){
        ?>
        <center>
            <div id='flotante'>
                <div class='errorConfirma'>
                    <?php
                    echo " El equipo pertenece al establecimiento" . htmlentities($oOficinaVo->get_nombre());
                    ?>
                    <br/>
                    Por favor intente nuevamente
                    <div align='right'>
                        <a href="javascript:cerrar('flotante');" class="buttonError">Aceptar</a>
                    </div>
                </div>
            </div>
        </center>
        <?php
    }
    $oModeloVo = new ModeloValueObject();
    $oModeloAr = new MysqlModeloActiveRecord();
    $oModeloVo->setIdModelo($oEquipoV->getIdModelo());
    $oModeloVo = $oModeloAr->findId($oEquipoV->getIdModelo());
    
    ?>
    <input type="hidden" id="h_encontrado" value="si" />
    <input type="hidden" id="h_desc" value="<?php echo utf8_encode($oNomencladorV->getDes_eq()); ?>" />
    <input type="hidden" id="h_seri" value="<?php echo utf8_encode($oEquipoV->getNroSerie()); ?>" />
    <input type="hidden" id="h_mode" value="<?php  echo utf8_encode($oModeloVo->getDescripcion()); ?>" />
    <!--<input type="hidden" id="h_mode" value="<?php // echo utf8_encode($oEquipoV->getIdModelo()); ?>" />-->
    <!--<input type="hidden" id="h_prov" value="<?php // echo utf8_encode($oEquipoV->getIdProveedor()); ?>" />-->
    <input type="hidden" id="h_prov" value="<?php echo utf8_encode($oProveedor->getNombre()); ?>" />
    <input type="hidden" id="h_falt" value="<?php echo utf8_encode($oEquipoV->getFechaAlta()); ?>" />
    <!-- <input type="hidden" id="h_edad" value="<?php // echo utf8_encode($oEquipoV->getEdad()); ?>" /> -->
    <input type="hidden" id="h_edad" value="<?php echo $diferencia; ?>" />
    <input type="hidden" id="h_manu" value="<?php echo utf8_encode($oEquipoV->getManual()); ?>" />
    <input type="hidden" id="h_serv" value="<?php echo utf8_encode($oServicioVo->getDescripcion()); ?>" />
    <input type="hidden" id="h_ubic" value="<?php echo utf8_encode(htmlentities($oOficinaVo->get_nombre())); ?>" />
<?php
} else {
    ?>
    <input type="hidden" id="h_encontrado" value="no" />
    <?php
}
?>