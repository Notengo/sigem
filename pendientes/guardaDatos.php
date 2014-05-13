<?php
/**
 * Archivo principal de la aplicacion para guardar los datos
 *
 * @copyright  Copyright (c) 2012 INFORMATICA MINISTERIO DE SALUD
 * @version    1.0
 * @since      File available since Release 1.0
 *
*/
// Se chequea si existe un login
require_once '../usuarios/aut_verifica.inc.php';

// Se requieren los script para acceder a los datos de la DB
require_once '../ClasesBasicas/ActiveRecordAbstractFactory.php';


require_once '../ClasesBasicas/CFecha.php';

$oMysql = ActiveRecordAbstractFactory::getActiveRecordFactory(ActiveRecordAbstractFactory::MYSQL);
$oMysql->conectar();

$error=0;
if(empty($_POST['orden'])) {
    return false;
} else {
    $repuesto = explode(',', $_POST['repuesto']);
    $repuestoc = explode(',', $_POST['repuestoc']);
    $repuestom = explode(',', $_POST['repuestom']);

    $orden = $_POST['orden'];
    $usuario = $_POST['usuario'];
    $fechaInicio = $_POST['fechaInicio'];
    $fechaFin = $_POST['fechaFin'];
    $tarea = $_POST['tarea'];
    if($_POST['objetoTarea'] != 0)
        $objetoTarea = $_POST['objetoTarea'];
    else
        $objetoTarea = 1;
    $cantidadRepuestos = $_POST['cantidadRepuestos'];

    $oMyTarea = $oMysql->getTareaAvtiveRecord();
    $oTarea = new TareaValueObject();

    $oMyTareaRepuespo = $oMysql->getTareaRepuestoActiveRecord();
    $oTareaRepuesto = new TareaRepuestoValueObject();
    
    $oTarea->setIdOrden($orden);
    $oTarea->setFechaInicio($fechaInicio);
    $oTarea->setFechaFin($fechaFin);
    $oTarea->setIdAccionObjeto($objetoTarea);
    $oTarea->setIdAccion($tarea);
    $oTarea->setIdUsers($usuario);
    
    mysql_query("begin;");
    
    if($oMyTarea->insert($oTarea))
        $error = 0;
    else
        $error = 1;
    
    echo $error;
    
    for($i = 1; $i <= $cantidadRepuestos; $i++){
        $oTareaRepuesto->setCantidad($repuestoc[$i]);
        $oTareaRepuesto->setIdAccion($tarea);
        $oTareaRepuesto->setIdAccionObjeto($objetoTarea);
        $oTareaRepuesto->setIdOrden($orden);
        $oTareaRepuesto->setIdRepuesto($repuesto[$i]);
        $oTareaRepuesto->setPrecio($repuestom[$i]);
        $oTareaRepuesto->setCajaChica(0);
        if($oMyTareaRepuespo->insert($oTareaRepuesto) && $error == 0)
            $error = 0;
        else
            $error++;
    }
        
    if($error == 0){
        mysql_query("COMMIT;");
        ?>
        <center>
                <div id='flotante'>
                <div class='exitoConfirma'>
                    La Orden de Trabajo ha sido modificada con &eacute;xito. <br/>                    
                    <br/>
                    <div align='right'>
                        <a href="<?php echo $oTareaRepuesto->getIdOrden(); ?>" class='buttonExito'>Aceptar</a>
                    </div>
                </div>
            </div>
        </center>
        <?php
    } else {
        mysql_query("ROLLBACK;");
        ?>
        <center>
            <div id='flotante'>
                <div class='errorConfirma'>
                    Ha ocurrido un error en la modificaci&oacute;n de la OT
                    <br/>
                    Por favor intente nuevamente
                    <div align='right'>
                        <a href="<?php echo $oTareaRepuesto->getIdOrden(); ?>" class='buttonError'>Aceptar</a>
                    </div>
                </div>
            </div>
        </center>
        <?php        
    }    
}