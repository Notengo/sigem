<?php
/**
 * Archivo principal de la aplicacion para guardar los datos
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
require_once '../Clases/ActiveRecord/MysqlOrden.php';
require_once '../Clases/ActiveRecord/MysqlPedidoOrdenActiveRecord.php';
require_once '../Clases/ActiveRecord/MysqlSintomaOrdenActiveRecord.php';
require_once '../Clases/ActiveRecord/MysqlUbicacionActiveRecord.php';
require_once '../ClasesBasicas/CFecha.php';

$oMysql = ActiveRecordAbstractFactory::getActiveRecordFactory(ActiveRecordAbstractFactory::MYSQL);
$oMysql->conectar();

/* Obtengo los datos eviados desde el .js */
$equipo = $_POST['equipo'];
$fecha = $_POST['fecha'];
$establecimiento =  $_POST['establecimiento'];
$solicitante = $_POST['solicitante'];
$prioridad = $_POST['prioridad'];
$recepcion = $_POST['recepcion'];
$estado = $_POST['estado'];
$observacion = $_POST['observacion'];
$listapedido = $_POST['listapedido'];
$listasintoma = $_POST['listasintoma'];
$establecimiento_h =  $_POST['establecimiento_h'];
$servicio1 =  $_POST['servicio1'];
$accesorios = $_POST['accesorios'];

// Datos de la ubicacion nueva.
$nuevaubic = $_POST['nuevaubic'];
$nuevaserv = $_POST['nuevaserv'];
$nuevamoti = $_POST['nuevamoti'];

//$fechita = explode("/", $fecha);
/*
 * Comienzo del proceso de grabacion de los datos en la tabla Orden.
 */
$oOrdenVo = new Orden();
//$oOrdenVo->setFecha($fechita[2].'-'.$fechita[1].'-'.$fechita[0]);
$oOrdenVo->setFecha($fecha);
$oOrdenVo->setOfcodi($establecimiento_h);
$oOrdenVo->setSolicitante($solicitante);
$oOrdenVo->setPrioridad($prioridad);
$oOrdenVo->setFormaPedido($recepcion);
$oOrdenVo->setIdEquipo($equipo);
$oOrdenVo->setEstado($estado);
$oOrdenVo->setObservacion($observacion);
$oOrdenVo->setIdServicio($servicio1);
$oOrdenVo->setAccesorios($accesorios);

$oOrdenMysql = new MysqlOrden();
mysql_query("begin;");
if($oOrdenMysql->insert($oOrdenVo)){
    
    // Obtener el id de la orden de trabajo.
//    $oOrdenVo = $oOrdenMysql->buscarId($oOrdenVo);
    
    $error = 0;
    $listadoPedido = explode("-", $listapedido);
    $oPedidoVo = new PedidoOrdenValueObject();
    $oPedidoMy = new MysqlPedidoOrdenActiveRecord();
    $oPedidoVo->setIdOrden($oOrdenVo->getIdorden());
    foreach ($listadoPedido as $value) {
        if($value !== ''&&$value !== 0){
            $oPedidoVo->setIdPedido($value);
            if($oPedidoMy->insert($oPedidoVo)){
                $error = 0;
            } else {
                $error += 1;
            }
        }
    }
    
    $listadoSintoma = explode("-", $listasintoma);
    $oSintomaVo = new SintomaOrdenValueObject();
    $oSintomaMy = new MysqlSintomaOrdenActiveRecord();
    $oSintomaVo->setIdOrden($oOrdenVo->getIdorden());
    foreach ($listadoSintoma as $value) {
        if($value !== ''&&$value !== 0){
            $oSintomaVo->setIdSintoma($value);
            if($oSintomaMy->insert($oSintomaVo)){
                $error = $error;
            } else {
                $error += 1;
            }
        }
    }
    /* Grabacion de los datos de la ubicacion. */
    if($_POST['cambio'] === 'si'){
        if (isset($nuevaubic)){
            $oUbicacionVo = new UbicacionValueObject();
            $oUbicacionAr = new MysqlUbicacionActiveRecord();
            $oUbicacionVo->setIdEquipo($equipo);
            $oUbicacionVo->setOfcodi($nuevaubic);
            $oUbicacionVo->setIdServicio($nuevaserv);
            $oUbicacionVo->setIdMotivoTraslado($nuevamoti);
            $oUbicacionVo->setUsuarioBaja($_SESSION['usuario_id']);
            $oUbicacionVo->setUsuarioAlta($_SESSION['usuario_id']);
            if($oUbicacionAr->bajaOficina($oUbicacionVo)){
                if(!$oUbicacionAr->insert($oUbicacionVo)){
                    $error ++;
                }
            } else {
                $error ++;
            }
        }
    }
    switch ($error) {
        case 0:
            mysql_query("commit");
            ?>
            <center>
                <div id='flotante'>
                    <div class='exitoConfirma'>
                        La orden ha sido guardada con &eacute;xito
                        <br/>
                        El n&uacute;mero de orden es <?php echo $oOrdenVo->getIdorden(); ?>
                        <br/>
                        <br/>
                        <div align='right'>
                            <a href="index.php" class='buttonExito'>Aceptar</a>
                        </div>
                        <div align='left'>
                            <a target="_new" href="impresionRecibo.php?id=<?php echo $oOrdenVo->getIdorden(); ?>" class='buttonExito'>Imprimir</a>
                        </div>
                    </div>
                </div>
            </center>
            <?php
            break;
        default:
            mysql_query("rollback");
            ?>
            <center>
                <div id='flotante'>
                    <div class='errorConfirma'>
                        Ha ocurrido un error al tratar de guardar el equipo
                        <br/>
                        Por favor intente nuevamente
                        <div align='right'>
                            <a href="index.php" class='buttonError'>Aceptar</a>
                        </div>
                    </div>
                </div>
            </center>
            <?php
            break;
    }
}
?>