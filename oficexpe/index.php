<?php
// Se chequea si existe un login
require_once '../usuarios/aut_verifica.inc.php';
?>

<!DOCTYPE html>
<html>
<head>    
    <title>SIGEM</title>
    <link rel="shortcut icon" href="../images/ingreso.ico" />    
    <link rel="stylesheet" href="../css/estilos.css" type="text/css" />      	   
    <script language="javascript" type="text/javascript" src="js/jquery-1.4.3.min.js"></script>
    <script language="javascript" type="text/javascript" src="js/jquery.blockUI.js"></script>
    <script language="javascript" type="text/javascript" src="js/index.js"></script>      
    <script language="javascript" type="text/javascript" src="js/select_localidad.js"></script>
</head>
<body>
<div class="contenedor">
<header> <?php include_once '../ClasesBasicas/EncabezadoInventario.php'; ?> </header>
<div id="cuerpo">
    <h1>Administraci&oacute;n de Dependencias</h1>                        
    <form action="javascript: fn_buscar();" id="frm_buscar" name="frm_buscar" >      
                <div  style="float:right;">
                    <label>Dependencia</label>
                            <input name="criterio_usu_per" type="text" id="criterio_usu_per" />
                    <label>Ordenar </label>                    
                    <select name="criterio_ordenar_por" id="criterio_ordenar_por">
                        <option value="ofcodi">Ofcodi</option>                                                                                                        
                        <option value="nombre">Nombre</option>                                       
                        <option value="tipo">Tipo</option>
                    </select>
                    <label>En forma</label>                              
                    <select name="criterio_orden" id="criterio_orden">                                	                                    
                        <option value="desc">Descendente</option>                                    
                        <option value="asc">Ascendente</option>                                    
                    </select>                            
                    <input type="submit" value="&nbsp;&nbsp;&nbsp;Buscar&nbsp;&nbsp;&nbsp;" class="button"/>                        
                </div>
            </form>
            <div id="div_listar">
                        <img src="../images/cargando.gif" /><br/>Cargando datos...
            </div>
            <div id="div_oculto" style="display: none;"></div>
        </div>
        <footer><?php include_once '../ClasesBasicas/Pie.php'; ?></footer>
        </div>
    </body>
</html>