<?php
/**
 *
 * @copyright  Copyright (c) 2014 INFORMATICA MINISTERIO DE SALUD
 * @version    1.0
 * @since      File available since Release 1.0
 *
 * 10/02/2014
*/
// Se chequea si existe un login.
require_once '../usuarios/aut_verifica.inc.php';

/* Se requieren los script para acceder a los datos de la DB */
require_once '../Clases/ActiveRecord/MysqlOficexpeActiveRecord.php';
require_once '../Clases/ActiveRecord/MysqlEquipoActiveRecord.php';
require_once '../Clases/ActiveRecord/MysqlMotivoTrasladoActiveRecord.php';
require_once '../ClasesBasicas/ActiveRecordAbstractFactory.php';
require_once '../Clases/ActiveRecord/MysqlOrden.php';
$oMysql = ActiveRecordAbstractFactory::getActiveRecordFactory(ActiveRecordAbstractFactory::MYSQL);
$oMysql->conectar();
$tabindex = 0;
// Seteo la zona horaria.
date_default_timezone_set("America/Argentina/Buenos_Aires");

?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Sigem</title>
        <link rel="shortcut icon" href="../images/ingreso.ico" />
        <link rel="stylesheet" href="../css/estilos.css" type="text/css" />
        <script language="javascript" type="text/javascript" src="js/jquery-1.4.3.min.js"></script>
        <script language="javascript" type="text/javascript" src="js/jquery.blockUI.js"></script>
        <script language="javascript" type="text/javascript" src="js/index.js"></script>
        <script language="javascript" type="text/javascript" src="js/ajax-enviar-datos.js"></script>
        <script type="text/javascript" src="js/ajax-dynamic-list.js"></script>
        <script type="text/javascript" src="js/ajax.js"></script>  
    </head>
    <body onload="document.getElementById('usuario').focus();">
        <div class="contenedor">
            <header> <?php include_once '../ClasesBasicas/EncabezadoInventario.php'; ?> </header>
            <div id="cuerpo">
                <h1>Traslado equipo</h1>
                <form action="" id="frm_buscar" name="frm_buscar" >
                    <fieldset>
                        <legend>Datos del dispositivo</legend>
                        <?php $tabindex++; ?>
                        <label for="equipo" class="detalle etiqueta" >N&ring; inventario:</label>
                        <input type="text" name="equipo" id="equipo" class="imputbox" onKeyPress="return esInteger(event);"
                               maxlength="7" size="6" onFocus="this.style.color='blue';" placeholder="123456"
                               onBlur="this.style.color='#333333'; cargarEquipoRecibido(this.value);" value="" tabindex="<?php echo $tabindex; ?>" />*
                        <br />
                        <table>
                            <tr>
                                <td class="etiqueta">Descripci&oacute;n:</td><td id="desc"></td>
                                <td class="etiqueta">Modelo:</td><td id="mode"></td>
                            </tr>
                            <tr>
                                <td class="etiqueta">N&ordm; serie:</td><td id="seri"></td>
                                <td class="etiqueta">Proveedor:</td><td id="prov"></td>
                            </tr>
                            <tr>
                                <td class="etiqueta">Fecha Alta:</td><td id="falt"></td>
                                <td class="etiqueta">Antig&uuml;edad:</td><td id="edad"></td>
                            </tr>
                            <tr>
                                <td class="etiqueta">Manuales:</td><td id="manu"></td>
                                <td class="etiqueta">Ubicaci&oacute;n:</td><td id="ubic"></td>
                            </tr>
                            <tr>
                                <td class="etiqueta">Servicio:</td><td id="serv"></td>
                            </tr>
                        </table>
                    </fieldset>
                    <fieldset>
                        <legend>Nuerva ubicaci&oacute;n</legend>
                        <table>
                            <tr>
                                <td class="etiqueta">Ubicaci&oacute;n:</td><td id="nuevaubic"></td>
                                <td class="etiqueta">Servicio:</td><td id="nuevaserv"></td>
                                <td class="etiqueta">Motivo:</td><td id="nuevamoti"></td>
                            </tr>
                        </table>
                        
                        <br />
                        <div id="aparato"></div>
                        <div id="aparato1"></div>
                    </fieldset>
                    <br />
                    <input type="button" value="&nbsp;&nbsp;&nbsp;Aceptar&nbsp;&nbsp;&nbsp;" class="button" onclick="guardarDatosRecibido();"/>
                    <div id="resultado"></div>
                </form>
                <div id="mensaje" style="color:brown; "></div>
                <!--<div id="mensaje" style="display: none;"></div>-->
                <div id="div_oculto" style="display: none;"></div>
            </div>
            <footer>
                <?php include_once '../ClasesBasicas/Pie.php'; ?>
            </footer>
                <div id="div_listar"></div>
        </div>
    </body>
</html>