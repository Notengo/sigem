<?php
/**
 * Archivo principal de la aplicacion para dar de alta los ambitos.
 *
 * @copyright  Copyright (c) 2012 INFORMATICA MINISTERIO DE SALUD
 * @version    1.0
 * @since      File available since Release 1.0
 *
*/
// Se chequea si existe un login
require_once '../usuarios/aut_verifica.inc.php';

// Se requieren los script para acceder a los datos de la DB
require_once '../ClasesBasicas/ActiveRecordAbstractFactory.php';
require_once '../Clases/ActiveRecord/MysqlRubroActiveRecord.php';
require_once '../Clases/ActiveRecord/MysqlOrdenActiveRecord.php';
require_once '../Clases/ActiveRecord/MysqlOficexpeActiveRecord.php';
require_once '../Clases/ActiveRecord/MysqlProblemaActiveRecord.php';
require_once '../Clases/ActiveRecord/MysqlTProblemaActiveRecord.php';
require_once '../Clases/ActiveRecord/MysqlEspecialidadesActiveRecord.php';
require_once '../Clases/ActiveRecord/MysqlRubroActiveRecord.php';

$oMysql = ActiveRecordAbstractFactory::getActiveRecordFactory(ActiveRecordAbstractFactory::MYSQL);
$oMysql->conectar();

if(isset($_GET['nro'])){
    $oOrden = new OrdenValueObject();
    $oOrden->setNro($_GET['nro']);
    $oMysqlOrden = $oMysql->getOrdenActiveRecord();
    $oOrden = $oMysqlOrden->find($oOrden);
    
    $oMysqlOficexpe = $oMysql->getOficexpeActiveRecord();
    $oOficina = new OficexpeValueObject();
    
    $oMysqlProblema = $oMysql->getProblemaActiveRecord();
    $oProblema = new ProblemaValueObject();

    $oMysqlRubro = $oMysql->getRubroActiveRecord();
    $oRubro = new RubroValueObject();
    
    $oMysqlTProblema = $oMysql->getTProblemaActiveRecord();
    $oTProblema = new TProblemaValueObject();

    $oMysqlEspecialidad = $oMysql->getEspecialidadesActiveRecord();
    $oEspecialidades = new EspecialidadesValueObject();
}
?>
<!DOCTYPE html>
<html>
   <head>
      <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
      <title>Orden de Trabajo</title>
      <link rel="shortcut icon" href="../images/ingreso.ico" />
      <link rel="stylesheet" href="../css/plantilla.css" type="text/css"  media="screen" />
      <link rel="stylesheet" href="../css/estilos.css" type="text/css" />      	              	   
      <script type="text/javascript" src="js/ajax-enviar-datos.js"></script>
      <!-- lista dinamica de oficinas -->
      <script type="text/javascript" src="js/ajax-dynamic-list.js"></script>
      <script type="text/javascript" src="js/ajax.js"></script>      
      <!-- select de 3 niveles-->      
      <script type="text/javascript" src="js/select_dependientes.js"></script>
   </head>
<body onload="document.getElementById('oficina').focus();">
<div class="contenedor">
<header> <?php include_once '../ClasesBasicas/Encabezado.php'; ?> </header>
<div id="cuerpo">           
<h1> Modificacion de Orden de Trabajo Nro. <?php echo $_GET['nro']; ?></h1>
<form id="two" name="formulario" autocomplete="off" method="POST" > 
    <input type="hidden" id="nro" name="nro" value="<?php echo $_GET['nro']; ?>" />
<div id="resultado">
<center>
<div align="right" style="margin-right: 137px; font-weight: bold;" >
<?php  echo "<tr><td>Usuario: ".$_SESSION['usuario_nombre']." ".$_SESSION['usuario_apellido']; ?>    
</div>
<fieldset>
    <legend>&nbsp;&nbsp;Encabezado</legend>
    <label for="oficina">Oficina Solicitante:</label>
    <?php
        $oOficina->set_ofcodi($oOrden->getOfcodi());
        $oOficina=$oMysqlOficexpe->find($oOficina);                             
    ?>
    <input type="text" id="oficina" name="oficina" onKeyUp="ajax_showOptionsOficina(this,'getOficinaByLetters',event)" size="80" onFocus="this.style.color='blue'" onBlur="this.style.color='#333333'"  value="<?php echo htmlentities($oOficina->get_nombre());    ?>"/>*
    <input type="hidden" id="oficina_hidden" name="oficina_ID" value="<?php echo $oOrden->getOfcodi(); ?>" />
    <div id="falta_ofcodi" class="falta_dato" style="display:none;">*</div>
    <br/>
    <label>Prioridad:</label>
    <select name="prioridad" id="prioridad">
        <option value="1" <?php if($oOrden->getPrioridad()==1) echo "selected"?>>Media</option>
        <option value="2" <?php if($oOrden->getPrioridad()==2) echo "selected"?>>Alta</option>
        <option value="0" <?php if($oOrden->getPrioridad()==0) echo "selected"?>>Baja</option>
    </select>   
    <label>Forma de recepci&oacute;n del pedido:</label>
    <select name="recepcion" id="recepcion">
        <option value="0" <?php if($oOrden->getTipoRecepcion()==0) echo "selected"?>>Telef&oacute;nicamente</option>
        <option value="1" <?php if($oOrden->getTipoRecepcion()==1) echo "selected"?>>Personalmente</option>
        <option value="2" <?php if($oOrden->getTipoRecepcion()==2) echo "selected"?>>Otra</option>
    </select>
    <br/>
    <br/>
</fieldset>
<fieldset>        
    <legend>&nbsp;&nbsp;Definici&oacute;n del Pedido</legend>    				
    <label>Categor&iacute;a:</label>    
     <?php
        $oProblema->setId($oOrden->getIdProblema());
        $oProblema=$oMysqlProblema->find($oProblema);  
        /// busca el rubro
        $oRubro->setId($oProblema->getIdRubro());
        $oRubro=$oMysqlRubro->find($oRubro);                    
        ?>
        <select name="categoria" id="categoria" onChange='cargaContenido(this.id)' >
        <option value="0">Seleccione</option>           
        <?php
        $oMysqlRubro = $oMysql->getRubroActiveRecord();
        $aRubros = $oMysqlRubro->findAll();
        foreach ($aRubros as $registro) {
            if($oRubro->getId()==$registro->getId())
                echo "<option value='".$registro->getId()."' selected>".$registro->getDescripcion()."</option>";
            else
                echo "<option value='".$registro->getId()."'>".$registro->getDescripcion()."</option>";
	}
        ?>
        <option value='9999'>Nueva</option>
    </select>*
    <div style="margin-left: 85px;"><input type="hidden" name="nuevaCategoria" id="nuevaCategoria" /></div>
    <div>
        <label>Especialidad:</label>    
        <select name="especialidades" id="especialidades" >
        <?php                
        $oEspecialidades->setId($oProblema->getIdRubro());
        $aEspecialidades = $oMysqlEspecialidad->findAllPorRubro($oEspecialidades);
        // busca la especialidad
        $oEspecialidades->setId($oProblema->getIdEspecialidad());
        $oEspecialidades=$oMysqlEspecialidad->find($oEspecialidades);
        foreach ($aEspecialidades as $registro) {
            if($oProblema->getIdEspecialidad()==$registro->getId())
                echo "<option value='".$registro->getId()."' selected>".$registro->getDescripcion()."</option>";
            else
                echo "<option value='".$registro->getId()."'>".$registro->getDescripcion()."</option>";
	}
        ?>
        </select>*
    </div>
    <div style="margin-left:98px;"><input type="hidden" name="nuevaEspecialidad" id="nuevaEspecialidad" /></div>
    <div>
        <label>Tipo Problema:</label>
        <select name="problema" id="problema" >
        <?php                
        $oTProblema->setId($oProblema->getIdRubro());
        $oTProblema->setDescripcion($oProblema->getIdEspecialidad());
        $aTProblema= $oMysqlTProblema->findAllPorRubroyEspec($oTProblema);
        // busca el Tipo de Problema         
        $oTProblema->setId($oProblema->getIdTProblema());
        $oTProblema=$oMysqlTProblema->find($oTProblema); 
        foreach ($aTProblema as $registro) {
            if($oProblema->getIdTProblema()==$registro->getId())
                echo "<option value='".$registro->getId()."' selected>".$registro->getDescripcion()."</option>";
            else
                echo "<option value='".$registro->getId()."'>".$registro->getDescripcion()."</option>";
	}
        ?>              
        </select>*          
        
    </div>    
    <div style="margin-left:110px;"><input type="hidden" name="nuevoTProblema" id="nuevoTProblema" /></div>
    <br/>
    <label>Descripci&oacute;n del problema:</label>
    <br/>
    <label>
        <textarea name="descripcion" id="descripcion" rows="2"><?php echo $oOrden->getDescripcion(); ?></textarea>
    </label>    
<br/><br/>
</fieldset>
<p>
  <input type="button" value="&nbsp;&nbsp;&nbsp;Modificar&nbsp;&nbsp;&nbsp;" class="button" onclick="guardarDatos()" />                     
  <input type="button" value="&nbsp;&nbsp;&nbsp;Cancelar&nbsp;&nbsp;&nbsp;" class="button" onclick="javascript:window.location='index.php'" />                    
</p>  
<div id="mensaje" style="color:brown; "></div>
</center>
</div>
</form>
</div>
<footer><?php include_once '../ClasesBasicas/Pie.php'; ?></footer>
</div>        
</body>
</html>
