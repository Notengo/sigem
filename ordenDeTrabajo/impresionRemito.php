<?php
// Se chequea si existe un login
require_once '../usuarios/aut_verifica.inc.php';

// Seteo la zona horaria.
date_default_timezone_set("America/Argentina/Buenos_Aires");

// Se requieren los script para acceder a los datos de la DB
require_once '../ClasesBasicas/ActiveRecordAbstractFactory.php';
require_once '../Clases/ValueObject/Orden.php';
require_once '../Clases/ValueObject/ServicioValueObject.php';
require_once '../Clases/ValueObject/EquipoValueObject.php';
require_once '../Clases/ActiveRecord/MysqlPedidoOrdenActiveRecord.php';
require_once '../Clases/ActiveRecord/MysqlSintomaOrdenActiveRecord.php';
require_once '../Clases/ActiveRecord/MysqlUbicacionActiveRecord.php';

$oMysql = ActiveRecordAbstractFactory::getActiveRecordFactory(ActiveRecordAbstractFactory::MYSQL);
$oMysql->conectar();

?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" href="../css/estilos.css" type="text/css" />
        <script language="javascript" type="text/javascript" src="js/ajax-enviar-datos.js"></script>
        <title>Impresion de remitos</title>
            <script>
            function imprimir(que) {       
                if(confirm("¿Desea imprimir el remito?")) {
                    var ventana = window.open("", "", "");
                    var contenido = "<html><head><link rel='stylesheet' href='printComun.css' type='text/css' media='print'/></head><body onload='window.print();'>" + document.getElementById(que).innerHTML + "</body></html>";            
                    ventana.document.open();
                    ventana.document.write(contenido);
                    ventana.document.close();
                }
            }
            </script>
    </head>
    <?php
    if(!isset($_GET['id']) || $_GET['id'] == ""){
    ?>
    <body>
    <?php } else { ?>
    <body onload="javascript:imprimir('informe');">
    <?php }?>
        <div class="contenedor">
            <header> <?php include_once '../ClasesBasicas/Encabezado.php'; ?> </header>
            <div id="cuerpo" >
                <h1>Impresi&oacute;n Remito</h1>
                <?php
                if(!isset($_GET['id']) || $_GET['id'] == ''){
                ?>
                <form action="impresionRemito.php" id="frm_buscar" name="frm_buscar" method="get" >
                    <fieldset>
                        <legend>Orden de trabajo</legend>
                        <br/>
                        <label for="id" class="detalle">N&ordm; orden:</label>
                        <input type="text" name="id" id="id" class="imputbox" onKeyPress="return soloFecha(event);" autocomplete="off"
                               onkeyup="return esInteger(this.id);" maxlength="10" size="9"
                               onFocus="this.style.color='blue';"
                               onBlur="this.style.color='#333333';" value="" tabindex="1" />
                        <br/>
                        <br/>
                    </fieldset>
                    <br/><br/>
                    <input type="submit" name="aceptar" value="&nbsp;&nbsp;&nbsp;Aceptar&nbsp;&nbsp;&nbsp;" class="button" />
                </form>
                <!--<a href="javascript:imprimir('informe')"><img src="../css/img_estilos/imprimir.gif" alt="Imprimir" title="Imprimir OT">&nbsp;Imprimir</a>&nbsp;|&nbsp;-->
                <?php } else {
                    $oMyOrden = $oMysql->getOrdenActiveRecord();
                    $oOrden = new Orden();
                    $oOrden->setIdorden($_GET['id']);
                    $oOrden = $oMyOrden->find($oOrden);

                    $oMyOficina = $oMysql->getOficexpeActiveRecord();
                    $oOficina = new OficexpeValueObject();
                    $oOficina->set_ofcodi($oOrden->getOfcodi());
                    $oOficina = $oMyOficina->find($oOficina);

                    $oMyEquipo = $oMysql->getEquipoActiveRecord();
                    $oEquipo = new EquipoValueObject();
                    $oEquipo->setId($oOrden->getIdEquipo());
                    $oEquipo = $oMyEquipo->findPorId($oEquipo);

                    $oMyUbicacion = $oMysql->getUbicacionActiveRecord();
                    $oUbicacion = new UbicacionValueObject();
                    $oUbicacion->setIdEquipo($oEquipo->getId());
                    $oUbicacion = $oMyUbicacion->find($oUbicacion);

                    $oMyServicio = $oMysql->getServicioActiveRecord();
                    $oServicio = new ServicioValueObject();
                    $oServicio->setIdServicio($oUbicacion->getIdServicio());
                    $oServicio = $oMyServicio->find($oServicio);

                    $oMyEquipo = $oMysql->getEquipoActiveRecord();
                    $oEquipo = new EquipoValueObject();
                    $oEquipo->setId($oOrden->getIdEquipo());
                    $oEquipo = $oMyEquipo->findPorId($oEquipo);

                    $oMyNomenclador = $oMysql->getNomenclActiveRecord();
                    $oNomenclador = new NomenclValueObject();
                    $oNomenclador->setCod_eq($oEquipo->getCod_eq());
                    $oNomenclador = $oMyNomenclador->findId($oNomenclador);

                    $oMyMarca = $oMysql->getMarcaActiveRecord();
                    $oMarca = new MarcaValueObject();
                    $oMarca->setIdMarca($oEquipo->getIdMarca());
                    $oMarca = $oMyMarca->findId($oMarca->getIdMarca());

                    $oMyModelo = $oMysql->getModeloActiveRecord();
                    $oModelo = new ModeloValueObject();
                    //$oModelo->setIdMarca($oEquipo->getIdMarca());
                    $oModelo->setIdModelo($oEquipo->getIdModelo());
                    $oModelo = $oMyModelo->findId($oEquipo->getIdModelo());
                ?>
                <!--<a href="javascript:imprimir('informe')"><img src="../css/img_estilos/imprimir.gif" alt="Imprimir" title="Imprimir OT">&nbsp;Imprimir</a>&nbsp;|&nbsp;-->
                <div id="informe">
                    <hr>
                    <p style="font-family: Lucida Console; font-size: small;">
                        REMITO DE EQUIPOS - LAB. BIOINGENIERIA. MIN. DE SALUD. <?php echo date('Y-m-d H:m:s'); ?>
                    </p>
                        <hr>
                    <p style="font-family: Lucida Console; font-size: small;">
                        El d&iacute;a <?php echo date('Y-m-d'); ?> se remitio desde el Lab. Bioingenieria del Min. de Salud el equipamiento detallado a continuaci&oacute;n al establecimiento especificado:
                        <br />
                        N&ordm; de pedido: <?php echo $oOrden->getIdorden(); ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Fecha de Finalizaci&oacute;n: <?php echo date('d/m/Y'); ?>
                        <br />
                        Establecimiento: <?php echo $oOficina->get_nombre(); ?>
                        <br />
                        Servicio: <?php echo $oServicio->getDescripcion(); ?>
                        <br />
                        Equipo: <?php echo utf8_encode($oNomenclador->getDes_eq()); ?>
                        <br />
                        N&ordm; de inventario: <?php echo $oOrden->getIdEquipo(); ?> - N&ordm; de serie del fabricante: <?php echo $oEquipo->getNroSerie(); ?>
                        <br />
                        Marca: <?php echo $oMarca->getDescripcion(); ?> Modelo: <?php echo $oModelo->getDescripcion(); ?>
                        <br />
                        Accesorios: <?php echo $oOrden->getAccesorios(); ?>
                        <br />
                        Observaciones: <?php echo $oOrden->getObservacion(); ?>
                        <br />
                        <br />
                        <br />
                        <br />
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        - - - - - - - - - - - - -
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        - - - - - - - - - - - - -
                        <br />
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        Firma de quien recibe
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        Firma de quien entrega
                        <br />
                        <br />
                        <br />
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        - - - - - - - - - - - - -
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        - - - - - - - - - - - - -
                        <br />
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        Aclaraci&oacute;n
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        Aclaraci&oacute;n
                    </p>
                    <hr>
                    <br/>
                    <br/>

                    <hr>
                    <p style="font-family: Lucida Console; font-size: small;">
                        REMITO DE EQUIPOS - LAB. BIOINGENIERIA. MIN. DE SALUD. <?php echo date('Y-m-d H:m:s'); ?>
                    </p>
                    <hr>
                    <p style="font-family: Lucida Console; font-size: small;">
                        El d&iacute;a <?php echo date('Y-m-d'); ?> se remitio desde el Lab. Bioingenieria del Min. de Salud el equipamiento detallado a continuaci&oacute;n al establecimiento especificado:
                        <br />
                        N&ordm; de pedido: <?php echo $oOrden->getIdorden(); ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Fecha de Finalizaci&oacute;n: <?php echo date('d/m/Y'); ?>
                        <br />
                        Establecimiento: <?php echo $oOficina->get_nombre(); ?>
                        <br />
                        Servicio: <?php echo $oServicio->getDescripcion(); ?>
                        <br />
                        Equipo: <?php echo utf8_encode($oNomenclador->getDes_eq()); ?>
                        <br />
                        N&ordm; de inventario: <?php echo $oOrden->getIdEquipo(); ?> - N&ordm; de serie del fabricante: <?php echo $oEquipo->getNroSerie(); ?>
                        <br />
                        Marca: <?php echo $oMarca->getDescripcion(); ?> Modelo: <?php echo $oModelo->getDescripcion(); ?>
                        <br />
                        Accesorios: <?php echo $oOrden->getAccesorios(); ?>
                        <br />
                        Observaciones: <?php echo $oOrden->getObservacion(); ?>
                        <br />
                        <br />
                        <br />
                        <br />
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        - - - - - - - - - - - - -
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        - - - - - - - - - - - - -
                        <br />
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        Firma de quien recibe
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        Firma de quien entrega
                        <br />
                        <br />
                        <br />
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        - - - - - - - - - - - - -
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        - - - - - - - - - - - - -
                        <br />
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        Aclaraci&oacute;n
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        Aclaraci&oacute;n
                    </p>
                </div>
                <?php } ?>
            </div>
            <footer><?php include_once '../ClasesBasicas/Pie.php'; ?></footer>
        </div>
    </body>
</html>