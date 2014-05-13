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
require_once '../Clases/ActiveRecord/MysqlOrdenActiveRecord.php';
require_once '../Clases/ActiveRecord/MysqlRubroActiveRecord.php';
require_once '../Clases/ActiveRecord/MysqlEspecialidadesActiveRecord.php';
require_once '../Clases/ActiveRecord/MysqlTProblemaActiveRecord.php';
require_once '../Clases/ActiveRecord/MysqlProblemaActiveRecord.php';
require_once '../Clases/ActiveRecord/MysqlEquipoActiveRecord.php';
require_once '../ClasesBasicas/CFecha.php';

$oMysql = ActiveRecordAbstractFactory::getActiveRecordFactory(ActiveRecordAbstractFactory::MYSQL);
$oMysql->conectar();

$oOrden = new OrdenValueObject();
$error=0;

if(empty($_POST['ofcodi'])) {
    $error=1;    
} else {
    mysql_query("begin;");
    $oRubro = new RubroValueObject();
    $oRubro->setId($_POST['categoria']);
    if($oRubro->getId()==9999) {
        
        $oRubroMysql = new MysqlRubroActiveRecord();
        $oRubro->setDescripcion($_POST['nuevaCategoria']);
        if($oRubroMysql->findDescripcion($oRubro)==false) {
            $oRubro->setUsuarioAlta($_SESSION['usuario_id']);
            if($oRubroMysql->insert($oRubro)==false) $error=2;
        } else {
            $oRubro=$oRubroMysql->findDescripcion($oRubro);
        }
    }        
    $oEspecialidad = new EspecialidadesValueObject();
    $oEspecialidad->setId($_POST['especialidades']);
    if($oEspecialidad->getId()==9999) {        
        $oEspecialidadMysql = new MysqlEspecialidadesActiveRecord();
        $oEspecialidad->setDescripcion($_POST['nuevaEspecialidad']);
        if($oEspecialidadMysql->findDescripcion($oEspecialidad)==false) {
            $oEspecialidad->setUsuarioAlta($_SESSION['usuario_id']);
            if($oEspecialidadMysql->insert($oEspecialidad)==false) $error=3;
        } else {
            $oEspecialidad=$oEspecialidadMysql->findDescripcion($oEspecialidad);
        }
    }
    $oTProblema = new TProblemaValueObject();
    $oTProblema->setId($_POST['problema']);
    if($oTProblema->getId()==9999) {        
        $oTProblemaMysql = new MysqlTProblemaActiveRecord();
        $oTProblema->setDescripcion($_POST['nuevoProblema']);
        if($oTProblemaMysql->findDescripcion($oTProblema)==false) {
            $oTProblema->setUsuarioAlta($_SESSION['usuario_id']);
            if($oTProblemaMysql->insert($oTProblema)==false) $error=4;
        } else {
            $oTProblema=$oTProblemaMysql->findDescripcion($oTProblema);
        }
    }
    $oProblema = new ProblemaValueObject();
    $oProblema->setIdRubro($oRubro->getId());
    $oProblema->setIdEspecialidad($oEspecialidad->getId());
    $oProblema->setIdTProblema($oTProblema->getId());   
    $oProblema->setObservacion("-");
    $oProblemaMysql = new MysqlProblemaActiveRecord();
    if($oProblemaMysql->findIds($oProblema)==false)  {
         if($oProblemaMysql->insert($oProblema)==false) $error=5;
    } else {
        $oProblema = $oProblemaMysql->findIds($oProblema);
    }
    
    if($_POST['nroEquipo']) {
    $oEquipo = new EquipoValueObject();
    $oEquipo->setNro($_POST['nroEquipo']);
    $oEquipo->setTipo($_POST['tipoEquipo']);
    $oEquipo->setUso($_POST['usoEquipo']);
    $oMysqlEquipo = new MysqlEquipoActiveRecord();    
    if($oMysqlEquipo->find($oEquipo)==false) {
        ?><center>
            <div id='flotante'>
                <div class='errorConfirma'>
                    Equipo no asociado<br/>Debe registrar el equipo antes de asociarlo
                    <br/>                                        
                </div>
            </div>
        </center>         
        <?php
        $oOrden->setNroEquipo(0);
        $oOrden->setEquipo(0);
    } else {
        $oOrden->setEquipo($oEquipo->getId());
        $oOrden->setNroEquipo(0);
    }
    } else {
        $oOrden->setNroEquipo(0);
        $oOrden->setEquipo(0);
    }
    $oOrden->setOfcodi($_POST['ofcodi']);
    if($_POST['agente'])
        $oOrden->setAgente($_POST['agente']);
    else
        $oOrden->setAgente(0);
    
    $oOrden->setNro($_POST['nro']);
    $oOrden->setOfcodi($_POST['ofcodi']);
    $oOrden->setIdProblema($oProblema->getId());
    $oOrden->setDescripcion($_POST['descripcion']);
    $oOrden->setPrioridad($_POST['prioridad']);
    $oOrden->setTipoRecepcion($_POST['recepcion']);
    $oOrden->setUsuarioAlta($_SESSION['usuario_id']);
    //$oOrden->setEstado(1);
    $oOrdenMysql = new MysqlOrdenActiveRecord();
    if($oOrdenMysql->edit($oOrden)==false) $error=6;
    
    if($error == 0){
        mysql_query("COMMIT;");
        ?>
        <center>
                <div id='flotante'>
                <div class='exitoConfirma'>
                    La Orden de Trabajo ha sido modificada con &eacute;xito. <br/>                    
                    <br/>
                    <div align='right'>
                        <a href="index.php" class='buttonExito'>Aceptar</a>
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
                    <a href="index.php" class='buttonError'>Aceptar</a>
                    </div>
                </div>
            </div>
        </center>
        <?php        
    }    
}