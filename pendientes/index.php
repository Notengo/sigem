<?php
/**
 * Archivo principal de la aplicacion para dar de alta los ambitos.
 *
 * @copyright  Copyright (c) 2012 INFORMATICA MINISTERIO DE SALUD
 * @version    1.0
 * @since      File available since Release 1.0
 *
 * 01/02/2014
*/
// Se chequea si existe un login
require_once '../usuarios/aut_verifica.inc.php';
include_once 'funciones.php';
?>
<!DOCTYPE html>
<html>
<head>    
    <title>Sigem</title>
    <link rel="shortcut icon" href="../images/ingreso.ico" />    
    <link rel="stylesheet" href="../css/estilos.css" type="text/css" />      	   
    <script language="javascript" type="text/javascript" src="js/jquery-1.4.3.min.js"></script>
    <script language="javascript" type="text/javascript" src="js/jquery.blockUI.js"></script>
    <script language="javascript" type="text/javascript" src="js/index.js"></script>
    <script language="javascript" type="text/javascript" src="js/ajax-enviar-datos.js"></script>
</head>
<body>
<div class="contenedor">
<header> <?php include_once '../ClasesBasicas/Encabezado.php'; ?> </header>
<div id="cuerpo">
    <h1>&Oacute;rdenes de Trabajo Pendientes</h1>
    <form action="javascript: fn_buscar();" id="frm_buscar" name="frm_buscar" >
        <div align="right">
            <label>Ordenar por</label>
            <select name="criterio_ordenar_por" id="criterio_ordenar_por">
                <option value="idorden">Nro OT</option>
                <option value="prioridad">Prioridad</option>                                                                        
                <option value="fecha">Fecha</option>
            </select>
            <label>en forma</label>
            <select name="criterio_orden" id="criterio_orden">                                	                                                                
                <option value="asc">Ascendente</option>
                <option value="desc">Descendente</option>
            </select>                    
            <input type="submit" value="&nbsp;&nbsp;&nbsp;Aceptar&nbsp;&nbsp;&nbsp;" class="button"/>
        </div>
    </form>
    <div id="online">
        <div id="div_listar">
            <img src="../images/cargando.gif" /><br/>Cargando datos...
        </div>
    </div>
    <div id="div_oculto" style="display: none;"></div>
</div>
<footer><?php include_once '../ClasesBasicas/Pie.php'; ?></footer>
</div>
</body>
</html>