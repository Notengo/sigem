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
            <div id="cuerpo" style="height: 1000px;">
                <h1>Tareas realizadas</h1>
                <form action="" id="frm_buscar" name="frm_buscar" >
                    <fieldset>
                        <legend>Encabezado</legend>
                        <br/>
                        <?php $tabindex++; ?>
                        <label for="usuario" class="detalle">Usuario:</label>
                        
                        <?php
                        require_once '../Clases/ActiveRecord/MysqlUsuariosActiveRecord.php';
                        $oMysqlUsuario = $oMysql->getUsuariosActiveRecord();
                        $oUsuario = new UsuariosValueObject();
                        $oUsuario = $oMysqlUsuario->findAll();
                        ?>
                        <select name="usuario" id="usuario">
                        <?php
                        foreach ($oUsuario as $valor) {
                            echo "<option value='".$valor->getId()."'>".$valor->getIdentificacion()."</option>";
                        }
                        ?>
                        </select>
                        <br />
                        <?php $tabindex++; ?>
                        <label for="fechaInicio" class="detalle">Fecha Inicio:</label>
                        <input type="date" id="fecha" name="fecha" value="<?php echo date("Y-m-d"); ?>" />
                        <br />
                        <?php $tabindex++; ?>
                        
                        <label for="fechaFin" class="detalle">Fecha Fin:</label>
                        <input type="date" id="fechaFin"  name="fechaFin" value="<?php echo date("Y-m-d"); ?>" />
<!--                        <label for="hora" class="detalle">Hora inicio:</label>
                        
                        <input type="time" id="hora" name="hora" value="<?php //echo date("H:i"); ?>" />-->
                        <br />
                        <?php $tabindex++; ?>
                        <label for="tarea" class="detalle">Tarea:</label>
                        
                        <select type="text" id="tarea" name="tarea" >
                            <option value="0">Seleccione una tarea</option>
                            <?php
                            include_once '../Clases/ActiveRecord/MysqlAccionActiveRecord.php';
                            $oMysqlAccion = $oMysql->getAccionActiveRecord();
                            $oAccionVo = new AccionValueObject();
                            $oAccionVo = $oMysqlAccion->findAll();
                            foreach ($oAccionVo as $accion) {
                                echo "<option value='".$accion->getIdAccion()."'>".htmlentities($accion->getDescripcion())."</option>";
                            }
                            ?>
                        </select>
                        <br />&nbsp;
                        <?php $tabindex++; ?>
                        <label for="objetoTarea" class="detalle">Objeto de Tarea:</label>
                        
                        <select type="text" id="objetoTarea" name="objetoTarea" >
                            <option value="0">Seleccione una tarea</option>
                            <?php
                            include_once '../Clases/ActiveRecord/MysqlAccionActiveRecord.php';
                            $oMysqlAccion = $oMysql->getAccionActiveRecord();
                            $oAccionVo = new AccionValueObject();
                            $oAccionVo = $oMysqlAccion->findAll();
                            foreach ($oAccionVo as $accion) {
                                echo "<option value='".$accion->getIdAccion()."'>".htmlentities($accion->getDescripcion())."</option>";
                            }
                            ?>
                        </select>
                        <br />&nbsp;
                    </fieldset>
                    <fieldset>
                        <legend>Repuestos</legend>
                        <br/>
                        <?php $tabindex++; ?>
                        <label for="repuesto" class="detalle detalle2">Repuesto:</label>
                        
                        <?php
                        /* Aca va los datos del repuesto. */
                        require_once '../Clases/ActiveRecord/MysqlRepuestoActiveRecord.php';
                        $oRepuestoVo = new RepuestoValueObject();
                        $oMysqlRepuesto = $oMysql->getRepuestoActiveRecord();
                        $oRepuestoVo = $oMysqlRepuesto->findAll();
                        ?>
                        <select name="repuesto" id="repuesto">
                        <?php
                        foreach ($oRepuestoVo as $valorR) {
                            echo "<option value='".$valorR->getIdRepuesto()."'>".htmlentities($valorR->getDescripcion())."</option>";
                        }
                        ?>
                        </select>

                        <?php $tabindex++; ?>
                        <label for="cantidad" class="detalle detalle2">Cantidad:</label>
                        <input name="cantidad" id="cantidad" type="number" maxlength="2" value="1" style="width: 40px;" />

                        <?php $tabindex++; ?>
                        <label for="monto" class="detalle detalle2">Monto:</label>
                        <input id="monto" name="monto" size="5" type="text" />

                        <img src="../css/img_estilos/add.png" onclick="repuestoAgregar();" alt="Agregar Repuesto" title="Agregar Repuesto" />
                        <br />&nbsp;
                        <div id="respuestoDiv"></div>
                    </fieldset>
                    <br />
                    <input type="submit" value="&nbsp;&nbsp;&nbsp;Aceptar&nbsp;&nbsp;&nbsp;" class="button"/>
                    <div>
                        <table class="lista" >
                        <tr>
                            <th>Usuario</th>
                            <th>Tiempo de Comienzo</th>
                            <th>Tiempo de Fin</th>
                            <th>Descripci&oacute;n</th>
                        </tr>
<!--                        <tr>
                            <td>Juan</td>
                            <td>2014-02-10 12:40 p.m.</td>
                            <td><input type="date" id="fecha"  name="fecha" /><input type="time" id="hora" name="hora" value="<?php //echo date("H:i"); ?>" /> </td>
                            <td><a>Texto descriptivo</a></td>
                        </tr>
                        <tr>
                            <td>Juan</td>
                            <td>2014-02-10 12:40 p.m.</td>
                            <td><input type="date" id="fecha"  name="fecha" /><input type="time" id="hora" name="hora" value="<?php //echo date("H:i"); ?>" /> </td>
                            <td><a>Texto descriptivo</a></td>
                        </tr>-->
                    </table>
                </div>
                </form>
                
                <div id="div_oculto" style="display: none;"></div>
            </div>
            <footer>
                <?php include_once '../ClasesBasicas/Pie.php'; ?>
            </footer>
        </div>
    </body>
</html>


<body>

</body>
</html>