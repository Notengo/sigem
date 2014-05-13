<?php
/**
 * @copyright  Copyright (c) 2012 INFORMATICA MINISTERIO DE SALUD
 * @version    1.0
 * @since      File available since Release 1.0
 *
 * 01/10/2012
*/
// Se chequea si existe un login
//require_once 'usuarios/aut_verifica.inc.php';

if($_SESSION['usuario_nivel']=='Z') {
?>
<!DOCTYPE html>
<html>
<head>    
    <title>Orden de Trabajo</title>
    <link rel="shortcut icon" href="../images/ingreso.ico" />    
    <link rel="stylesheet" href="../css/estilos.css" type="text/css" />      	   
    <script language="javascript" type="text/javascript" src="js/jquery-1.4.3.min.js"></script>
    <script language="javascript" type="text/javascript" src="js/jquery.blockUI.js"></script>
    <script language="javascript" type="text/javascript" src="js/index.js"></script>     
    <script type="text/javascript" src="js/validar_fecha.js"></script>
</head>
<body>
<div class="contenedor">
<header> <?php include_once '../ClasesBasicas/Encabezado.php'; ?> </header>
<div id="cuerpo">    
    <form action="javascript: fn_buscar();" id="frm_buscar" name="frm_buscar" >                                
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
<?php }
else {
     header("Location: usuarios/logout.php");
}