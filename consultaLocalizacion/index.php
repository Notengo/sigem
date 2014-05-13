<?php
/**
 * @copyright  Copyright (c) 2014 INFORMATICA MINISTERIO DE SALUD
 * @version    1.0
 * @since      File available since Release 1.0
 *
*/
// Se chequea si existe un login
require_once '../usuarios/aut_verifica.inc.php';

// Se requieren los script para acceder a los datos de la DB
require_once '../ClasesBasicas/ActiveRecordAbstractFactory.php';
require_once '../Clases/ActiveRecord/MysqlLocalidadActiveRecord.php';
require_once '../Clases/ActiveRecord/MysqlDepartamentoActiveRecord.php';
require_once '../Clases/ActiveRecord/MysqlTipoActiveRecord.php';

$oMysql = ActiveRecordAbstractFactory::getActiveRecordFactory(ActiveRecordAbstractFactory::MYSQL);
$oMysql->conectar();

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
    <script type="text/javascript" src="js/validar_fecha.js"></script>
    <!-- lista dinamica de oficinas -->
    <script type="text/javascript" src="js/ajax-dynamic-list.js"></script>
    <script type="text/javascript" src="js/ajax.js"></script> 
    <!-- select de 3 niveles-->      
    <script type="text/javascript" src="js/select_localidad.js"></script>
</head>
<body  onload="document.getElementById('departamento').focus();" >
<div class="contenedor">
<header> <?php include_once '../ClasesBasicas/EncabezadoInventario.php'; ?> </header>
<div id="cuerpo">
    <h1>Consulta Equipamiento por Localizaci&oacute;n</h1>                        
    <form action="javascript: fn_buscar();" id="frm_buscar" name="frm_buscar" style="height: 220px;" autocomplete="off">     
    <fieldset>
        <legend>&nbsp;&nbsp;Criterios de B&uacute;squeda</legend>        
        <div  style="float:left;">
            <label>Departamento:</label>    
            <select name="departamento" id="departamento" class="required" onChange='cargaContenido(this.id)'>            
                    <option value="0">Seleccione</option>
                    <?php
                    $oMysqlDpto = $oMysql->getDepartamentoActiveRecord();
                    $oDpto = new DepartamentoValueObject();                                               
                    $oDpto = $oMysqlDpto->findAll();                        
                    foreach ($oDpto as $fila){
                        ?>
                        <option value='<?php echo $fila->getCoddpto() ?>' ><?php echo htmlentities($fila->getDescri()) ?></option>
                        <?php
                    }
                    ?>
            </select>
                        
        </div>    
         <div style="float:left">
            <label>Localidad:</label>    
            <?php           
            echo "<select disabled='disabled' name='localidad' id='localidad' >";
            echo "<option value=0>Seleccione</option>";
            echo "</select>";                       
            ?>
        </div>
        <br/>
        <div  style="float:left;">
            <label for="oficina">Dependencia:</label>
            <input type="text" id="oficina" name="oficina" value="" onKeyUp="ajax_showOptionsOficina(this,'getOficinaByLetters',event)" size="80" onFocus="this.style.color='blue'" onBlur="this.style.color='#333333'" />
            <input type="hidden" id="oficina_hidden" name="oficina_ID" />         
        </div>
        <br/>
        <div  style="float:left;">
            <label>Tipo equipamiento:</label>    
            <select name="tipo" id="tipo" class="required" >            
                    <option value="0">Todos</option>
                    <?php
                    $oMysqlTipo = $oMysql->getTipoActiveRecord();
                    $oTipo = new TipoValueObject();                                               
                    $aTipo = $oMysqlTipo->findTipo($oTipo);                        
                    foreach ($aTipo as $fila){
                        ?>
                        <option value='<?php echo $fila->getId() ?>' ><?php echo htmlentities($fila->getDescripcion()) ?></option>
                        <?php
                    }
                    ?>
            </select>                        
        </div>            
        <div  style="float:left;">
            <label>Ordenar por</label>            
            <select name="criterio_ordenar_por" id="criterio_ordenar_por">
                <option value="oficexpe.nombre">Dependencia</option>                                                                                                      
                <option value="equipo.nro">Nro. Equipo</option>
            </select>
            <label>en forma</label>
            <select name="criterio_orden" id="criterio_orden">                                	                                                                
                <option value="asc">Ascendente</option>
                <option value="desc">Descendente</option>
            </select>                               
        </div>     
        
        <div  style="float:right; margin-right: 45px; margin-top: 35px; margin-bottom: 10px;">
            <input type="submit" value="&nbsp;&nbsp;&nbsp;Buscar&nbsp;&nbsp;&nbsp;" class="button"/>
            <input type="button" value="&nbsp;&nbsp;&nbsp;Limpiar&nbsp;&nbsp;&nbsp;" class="button" onclick="javascript:window.location='index.php'"/>
        </div>                
    </fieldset>
    </form>       
    <div id="mensaje">
    </div>
    <div id="online">
    <div id="div_listar">               
    </div>
    </div>
    <div id="div_oculto" style="display: none;"></div>            
</div>
<footer><?php include_once '../ClasesBasicas/Pie.php'; ?></footer>
</div>
</body>
</html>