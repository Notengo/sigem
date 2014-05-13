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
require_once '../Clases/ActiveRecord/MysqlMarcaActiveRecord.php';
require_once '../Clases/ActiveRecord/MysqlModeloActiveRecord.php';
require_once '../Clases/ActiveRecord/MysqlEquipoActiveRecord.php';
require_once '../Clases/ActiveRecord/MysqlUbicacionActiveRecord.php';
require_once '../ClasesBasicas/CFecha.php';
require_once 'funciones.php';

$oMysql = ActiveRecordAbstractFactory::getActiveRecordFactory(ActiveRecordAbstractFactory::MYSQL);
$oMysql->conectar();

$oMarca = new MarcaValueObject();
$oMarcaN = new MarcaValueObject();
$oMysqlMarca = $oMysql->getMarcaActiveRecord();
$aMarca = array();

$oModelo = new ModeloValueObject();
$oModeloN = new ModeloValueObject();
$oMysqlModelo = $oMysql->getModeloActiveRecord();
$aModelo = array();

$nro = $_POST['nro']; 
$oEquipo = new EquipoValueObject();
$oEquipo->setNro($nro);

$oMysqlEquipo = $oMysql->getEquipoActiveRecord();
$verEquipo = $oMysqlEquipo->find($oEquipo);    
$oEquipo->setCod_eq($_POST['codeq']);
$oEquipo->setIdMarca($_POST['marca']);
$oEquipo->setIdModelo($_POST['modelo']);
$oEquipo->setNroSerie($_POST['nrose']);
$oEquipo->setDetalle($_POST['detalle']);
$oEquipo->setEdad(calculafechanacimiento($_POST['edad']));
$oEquipo->setGarantiaDesde($_POST['garantiaDesde']);
$oEquipo->setGarantiaFin($_POST['garantiaHasta']);
$oEquipo->setOrdenCompra($_POST['oc']);
$oEquipo->setIdProveedor($_POST['proveedor']);
$oEquipo->setManual($_POST['manual']);
$oEquipo->setKv($_POST['kv']);
$oEquipo->setMa($_POST['ma']);
$oEquipo->setAlimentacion($_POST['alimentacion']);
$oEquipo->setIntensificador($_POST['intensificador']);
$oEquipo->setIdAdquiriente($_POST['adquiriente']);
$error=0;
if($verEquipo) {   
// si el equipo existe modifica
    mysql_query("begin;");
    if($oMysqlEquipo->update($oEquipo)==false)
        $error=3;   
    
    $verEquipoRX = $oMysqlEquipo->findRX($oEquipo);    
    // guarda el equipo rx
    if($_POST['eq_rx']<>'N') {
        if($verEquipoRX==false) {
             if($oMysqlEquipo->insertRX($oEquipo)==false)
                $error=3;
        } else {
            if($oMysqlEquipo->updateRX($oEquipo)==false)
            $error=3;  
        }
    } else {
        if($verEquipoRX==true) {
            if($oMysqlEquipo->bajaRX($oEquipo)==false)
                $error=3;  
        }
    }
} else {
// inserta nuevo equipo
    mysql_query("begin;");
    $oEquipo->setUsuarioAlta($_SESSION['usuario_id']);
    $idEquipo = $oMysqlEquipo->insert($oEquipo);
    
    if($idEquipo==false)
        $error=1;
    else {
        if($_POST['eq_rx']<>'N') {
            $oEquipo->setId($idEquipo);
            // GUARDAR EQUI_RX
            if($oMysqlEquipo->insertRX($oEquipo)==false)
                $error=3;
        }
        
        $oUbicacion = new UbicacionValueObject();
        $oMysqlUbicacion = $oMysql->getUbicacionActiveRecord();
        $oUbicacion->setIdEquipo($idEquipo);
        $oUbicacion->setOfcodi($_POST['ofcodi']);
        $oUbicacion->setIdServicio($_POST['servicio']);
        $oUbicacion->setSubServicio($_POST['subservicio']);
        $oUbicacion->setIdMotivoTraslado(1);
        $oUbicacion->setUsuarioAlta($_SESSION['usuario_id']);
        $oMysqlUbicacion->insert($oUbicacion);
    }
}

switch ($error) {
    case 0:
        mysql_query("COMMIT;");                  
        ?>
        <center>
                <div id='flotante'>
                <div class='exitoConfirma'>
                    El equipo ha sido guardado con &eacute;xito<br/>                    
                    <br/>
                    <div align='right'>
                        <a href="index.php" class='buttonExito'>Aceptar</a>
                    </div>
                </div>
            </div>
        </center>
        <?php
        break;       
    case 3:
        mysql_query("ROLLBACK;");
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
    case 4:
        mysql_query("ROLLBACK;");
        ?>
        <center>
            <div id='flotante'>
                <div class='errorConfirma'>
                    <div align="left">                              
                    <?php echo "<ul>".$errorDescri."</ul>"; ?>
                    </div>
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