<?php
// Se chequea si existe un login
require_once '../usuarios/aut_verifica.inc.php';

// Se requieren los script para acceder a los datos de la DB
require_once '../ClasesBasicas/ActiveRecordAbstractFactory.php';
require_once '../Clases/ActiveRecord/MysqlSintomaActiveRecord.php';
require_once '../Clases/ActiveRecord/MysqlPedidoActiveRecord.php';
require_once '../Clases/ActiveRecord/MysqlOficexpeActiveRecord.php';
require_once '../Clases/ActiveRecord/MysqlEstadosActiveRecord.php';
require_once '../Clases/ActiveRecord/MysqlEquipoActiveRecord.php';

$oMysql = ActiveRecordAbstractFactory::getActiveRecordFactory(ActiveRecordAbstractFactory::MYSQL);
$oMysql->conectar();

?>
<!DOCTYPE html>
<html>
<head>    
    <title>Gestion de Equipos</title>
    <link rel="shortcut icon" href="../images/ingreso.ico" />    
    <link rel="stylesheet" href="../css/estilos.css" type="text/css" />
    <style type="text/css">
        /*div.detalle { color: #003399; }*/
        .detalle { color: #003399; }
    </style>
    <script language="javascript" type="text/javascript" src="js/jquery-1.4.3.min.js"></script>
    <script language="javascript" type="text/javascript" src="js/jquery.blockUI.js"></script>
    <script language="javascript" type="text/javascript" src="js/index.js"></script>      
    <script language="javascript" type="text/javascript" src="js/validar_fecha.js"></script>      
    <script language="javascript" type="text/javascript" src="js/ajax-enviar-datos.js"></script>
    <!-- lista dinamica -->
    <script type="text/javascript" src="js/ajax-dynamic-list.js"></script>
    <script type="text/javascript" src="js/ajax.js"></script>      
</head>
<body onload="document.getElementById('establecimiento').focus();">
    <div class="contenedor">
        <header> <?php include_once '../ClasesBasicas/Encabezado.php'; ?> </header>
        <div id="cuerpo" style="height: 1000px;">
            <h1>Nueva Orden de Trabajo</h1>
            <form action="" id="frm_buscar" name="frm_buscar" >
                <input type="hidden" value="<?php if(isset($_GET['cambio'])) echo $_GET['cambio']; else  echo 0; ?>" id="cambio" name="cambio" />

                <center>
                    <div align="right" style="margin-right: 137px; font-weight: bold;" >
                        <?php  echo "<tr><td>Usuario: ".$_SESSION['usuario_nombre']." ".$_SESSION['usuario_apellido'];
                        $tabindex=1;
                        ?>
                    </div>
                    <fieldset>
                        <legend>Encabezado</legend>
                        <br/>
                        <?php $tabindex++; ?>
                        <label for="fecha" class="detalle">Fecha:</label>
                        <input type="date" name="fecha" id="fecha" class="imputbox" onKeyPress="return soloFecha(event);"
                               onkeyup="return fechaControl(this.id, event);" maxlength="10" size="9"
                               onFocus="this.style.color='blue';"
                               onBlur="this.style.color='#333333';" value="<?php echo date('Y-m-d'); ?>" tabindex="<?php echo $tabindex;?>" />*
                        <br/>
                        <?php $tabindex++; ?>
                        <label for="establecimiento" class="detalle">Dependencia:</label>
                        <input type="text" name="establecimiento" id="establecimiento" class="imputbox" onkeyup="ajax_showOptionsOficina(this,'getListadoByLetters',event)"
                               maxlength="150" size="75" onFocus="this.style.color='blue';"
                               onBlur="this.style.color='#333333';" value="" tabindex="<?php echo $tabindex;?>"/>*
                        <input type="hidden" id="establecimiento_hidden" name="establecimiento_ID" value="" />
                        <br/>
                        <?php $tabindex++; ?>
                        <label for="servici1" class="detalle">Servicio:</label>
                        <input type="text" name="servicio1" id="servicio1" class="imputbox" onkeyup="ajax_showOptionsServicio(this,'getServicioByLetters',event);"
                               maxlength="150" size="75" onFocus="this.style.color='blue';"
                               onBlur="this.style.color='#333333';" value="" tabindex="<?php echo $tabindex;?>"/>
                        <input type="hidden" id="servicio1_hidden" name="servicio1_ID" value="" />
                        <br/>
                        <?php $tabindex++; ?>
                        <label for="solicitante" class="detalle">Contacto:</label>
                        <input type="text" name="solicitante" id="solicitante" class="imputbox" placeholder="Persona solicitante"
                               maxlength="50" size="50" onFocus="this.style.color='blue';"
                               onBlur="this.style.color='#333333';" value="" tabindex="<?php echo $tabindex;?>"/>
                        <br/>
                        <label for="prioridad" >Prioridad:</label>
                        <?php $tabindex++; ?>
                        <select name="prioridad" id="prioridad" tabindex="<?php echo $tabindex; ?>">
                            <option value="0">Baja</option>
                            <option value="1">Media</option>
                            <option value="2">Alta</option>
                        </select>*
                        <label for="recepcion">Forma de recepci&oacute;n del pedido:</label>
                        <?php $tabindex++; ?>
                        <select name="recepcion" id="recepcion" tabindex="<?php echo $tabindex; ?>">
                            <option value="0" selected>Personalmente</option>
                            <option value="1">Telef&oacute;nicamente</option>
                            <option value="2">Por nota</option>
<!--                            <option value="2">Otra</option>-->
                        </select>
                            <br/>
                    </fieldset>

                    <fieldset>
                        <legend>Datos del dispositivo</legend>
                        <?php $tabindex++; ?>
                        <label for="equipo" class="detalle" >N&ring; inventario:</label>
                        <input type="text" name="equipo" id="equipo" class="imputbox" onKeyPress="return esInteger(event);"
                               maxlength="7" size="6" onFocus="this.style.color='blue';" placeholder="123456"
                               onBlur="this.style.color='#333333'; cargarEquipo(this.value);" value="" tabindex="<?php echo $tabindex; ?>" />*
                        <br />
                        <table>
                            <tr>
                                <td class="detalle">Descripci&oacute;n:</td><td id="desc"></td>
                                <td class="detalle">Modelo:</td><td id="mode"></td>
                                <td class="detalle">N&ordm; serie:</td><td id="seri"></td>
                            </tr>
                            <tr>
                                <td class="detalle">Proveedor:</td><td id="prov"></td>
                                <td class="detalle">Fecha Alta:</td><td id="falt"></td>
                                <td class="detalle">Antig&uuml;edad:</td><td id="edad"></td>
                            </tr>
                            <tr>
                                <td class="detalle">Manuales:</td><td id="manu"></td>
                                <td class="detalle">Ubicaci&oacute;n:</td><td id="ubic"></td>
                                <td class="detalle">Servicio:</td><td id="serv"></td>
                            </tr>
                        </table>
                        <div id="cambioubicacion" style="display: none;">
                            <table>
                                <tr>
                                    <input type="hidden" id="cambiohabilita" value="no" />
                                    <td>Ubicaci&oacute;n:</td><td><input id="nuevaubic" name="nuevaubic" onkeyup="ajax_showOptionsOficina(this,'getOficinaByLetters',event);" /></td>
                                    <input type="hidden" id="nuevaubic_hidden" name="nuevaubic_ID" />
                                    <td>Servicio:</td><td><input id="nuevaserv" name="nuevaserv" onkeyup="ajax_showOptionsServicio(this,'getServicioByLetters',event);" /></td>
                                    <input type="hidden" id="nuevaserv_hidden" name="nuevaserv_ID" />
                                    <td>Motivo:</td><td><input id="nuevamoti" name="nuevamoti" /></td>
                                </tr>
                            </table>
                        </div>
                        <?php $tabindex++; ?>
                        <label for="estado" class="detalle">Estado:</label>
                        <select name="estado" id="estado" tabindex="<?php echo $tabindex; ?>">
                            <option value="T">Seleccione un estado</option>
                            <?php
                            $oEstadoAR = new MysqlEstadosActiveRecord();
                            $oEstadoVO = $oEstadoAR->findAll();
                            foreach ($oEstadoVO as $valor) {
                                echo "<option value='".$valor->getId()."'>".$valor->getDescripcion()."</option>";
                            }
                            ?>

                        </select>
                        <br />
                        <div id="aparato"></div>
                    </fieldset>
                    <fieldset>
                        <legend>Pedido</legend>

                        <?php $tabindex++; ?>
                        <label for="pedido" class="detalle">Pedido:</label>
                        <select name="pedido" id="pedido" tabindex="<?php echo $tabindex; ?>">
                            <?php
                            $oPedidoAR = new MysqlPedidoActiveRecord();
                            $oPedidoVO = $oPedidoAR->findAll();
                            foreach ($oPedidoVO as $valor) {
                                echo "<option value='".$valor->getId()."'>".$valor->getDescripcion()."</option>";
                            }
                            ?>
                        </select>
                        <img alt="suma" src="../css/img_estilos/add.png" onclick="agregarPedido('pedido');" />
                        <input type="hidden" id="listaPedido" />
                        <div id="divPedido" style="margin-left: 115px;"></div>
                        <br />
                        <?php $tabindex++; ?>
                        <label for="sintoma" class="detalle">Sintoma:</label>
                        <select name="sintoma" id="sintoma" tabindex="<?php echo $tabindex; ?>">
                            <?php
                            $oSintomaAR = new MysqlSintomaActiveRecord();
                            $oSintomaVO = $oSintomaAR->findAll();
                            foreach ($oSintomaVO as $valor) {
                                echo "<option value='".$valor->getId()."'>".$valor->getDescripcion()."</option>";
                            }
                            ?>
                        </select>
                        <img alt="suma" src="../css/img_estilos/add.png" onclick="agregarSintoma('sintoma');" />
                        <input type="hidden" id="listaSintoma" />
                        <div id="divSintoma" style="margin-left: 115px;"></div>
                        <br />
                        <?php $tabindex++; ?>
                        <label for="accesorios" class="detalle">Accesorios:</label>
                        <textarea name="accesorios" id="accesorios" cols="60"
                                  maxlength="500" onFocus="this.style.color = 'blue';"
                                  onBlur="this.style.color='#333333';" tabindex="<?php echo $tabindex;?>" placeholder="Accesorios"></textarea>
                        <br />
                        <br />
                        <?php $tabindex++; ?>
                        <label for="observacion" class="detalle">Observaci&oacute;n:</label>
                        <textarea name="observacion" id="observacion" cols="60"
                                  maxlength="1000" onFocus="this.style.color = 'blue';"
                                  onBlur="this.style.color='#333333';" tabindex="<?php echo $tabindex;?>" placeholder="Observaci&oacute;n"></textarea>
                        <br />
                    </fieldset>
                    <p>
                        <?php $tabindex++; ?>
                        <input type="button" value="&nbsp;&nbsp;&nbsp;Guardar&nbsp;&nbsp;&nbsp;" class="button" onclick="guardarDatos();" tabindex="<?php echo $tabindex;?>"/>
                        <?php $tabindex++; ?>
                        <input type="button" value="&nbsp;&nbsp;&nbsp;Cancelar&nbsp;&nbsp;&nbsp;" class="button" onclick="javascript:window.location='index.php';" tabindex="<?php echo $tabindex;?>" />
                    </p>  
                    <div id="mensaje" style="color:brown; "></div>
                </center>

                <div id="resultado"></div>
                <div id="div_listar"></div>
                <!--<div id="div_oculto" style="display: none;"></div>-->
                <div id="div_oculto" ></div>
            </form>
        </div>
        <footer><?php include_once '../ClasesBasicas/Pie.php'; ?></footer>
    </div>       
</body>
</html>