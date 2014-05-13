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
$orden = $_POST['orden'];
$fechaFin =$_POST['fechaFin'];
$fechaRetirado = $_POST['fechaRetirado'];
$usuario = $_POST['usuario'];

/*
 * Comienzo del proceso de grabacion de los datos en la tabla Orden.
 */
$oOrdenVo = new Orden();
//$oOrdenVo->setFecha($fechita[2].'-'.$fechita[1].'-'.$fechita[0]);
$oOrdenVo->setIdorden($orden);
$oOrdenVo->setFechaFin($fechaFin);
$oOrdenVo->setFechaRetiro($fechaRetirado);

$oOrdenMysql = new MysqlOrden();
mysql_query("begin;");
if($oOrdenMysql->update($oOrdenVo)){
    mysql_query("commit");
    ?>
    <center>
        <div id='flotante'>
            <div class='exitoConfirma'>
                La orden ha sido guardada con &eacute;xito
                <br/>
                <br/>
                <div align='right'>
                    <a href="javascript: cerrar('flotante');" class='buttonExito'>Aceptar</a>
                </div>
                <div align='left'>
                    <a href="../ordenDeTrabajo/impresionRemito.php?id=<?php echo $oOrdenVo->getIdorden(); ?>" class='buttonExito'>Imprimir</a>
                    <!--target="_new"-->
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
                Ha ocurrido un error al tratar de guardar la finalización de la orden.
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