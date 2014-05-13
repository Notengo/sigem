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
    </head>
    <body onload="document.getElementById('usuario').focus();">
        <div class="contenedor">
            <header> <?php include_once '../ClasesBasicas/Encabezado.php'; ?> </header>
            <div id="cuerpo">
                <h1>Cerrar Orden</h1>
                <form action="" id="frm_buscar" name="frm_buscar" >
                    <fieldset>
                        <legend>Encabezado</legend>
                        <br />
                        <?php $tabindex++; ?>
                        <label for="orden" class="detalle">N&ordm; Orden:</label>
                        <input type="text" id="orden" name="orden" value="<?php echo $_GET['id']; ?>" size="3" disabled="disable" />
                        
                        <br/>
                        <br/>
                        <?php $tabindex++; ?>
                        <label for="usuario" class="detalle">Usuario:</label>

                        <?php
                        require_once '../Clases/ActiveRecord/MysqlUsuariosActiveRecord.php';
                        $oMysqlUsuario = $oMysql->getUsuariosActiveRecord();
                        $oUsuario = new UsuariosValueObject();
                        $oUsuario = $oMysqlUsuario->findAll();
                        
                        $oOrden = new Orden();
                        $oMysqlOrden = $oMysql->getOrdenActiveRecord();
                        $oOrden->setIdorden($_GET['id']);
                        $oOrden = $oMysqlOrden->find($oOrden);
                        ?>
                        <select name="usuario" id="usuario">
                        <?php
                        foreach ($oUsuario as $valor) {
                            if($oOrden->getIdUsers() == $valor->getId())
                                echo "<option value='".$valor->getId()."' selected='selected'>".$valor->getIdentificacion()."</option>";
                            else
                                echo "<option value='".$valor->getId()."'>".$valor->getIdentificacion()."</option>";
                        }
                        ?>
                        </select>
                      
                        <br />
                        <br />
                        <?php $tabindex++; ?>
                        
                        <label for="fechaFin" class="detalle">Fecha Fin:</label>
                        <input type="date" id="fechaFin"  name="fechaFin" value="<?php echo date("Y-m-d"); ?>" />

                        <br />
                        <br />
                        <?php $tabindex++; ?>
                        <label for="fechaRetirado" class="detalle">Fecha Retirado:</label>
                        <input type="date" id="fechaRetirado" name="fechaRetirado" value="<?php echo date("Y-m-d"); ?>" />
                        
<!--                        <br />
                        <?php // $tabindex++; ?>
                        <label for="fechaConforme" class="detalle">Fecha Conforme:</label>
                        <input type="date" id="fechaConforme" name="fechaConforme" value="<?php // echo date("Y-m-d"); ?>" />-->
                        
                        <br />&nbsp;
                    </fieldset>

                    <br />
                    <input type="button" value="&nbsp;&nbsp;&nbsp;Aceptar&nbsp;&nbsp;&nbsp;" class="button" onclick="guardarDatos();"/>
                    <div id="resultado"></div>
                </form>
                <div id="mensaje" style="display: none;"></div>
                <div id="div_oculto" style="display: none;"></div>
            </div>
            <footer>
                <?php include_once '../ClasesBasicas/Pie.php'; ?>
            </footer>
        </div>
    </body>
</html>