<?php
// Se chequea si existe un login
require_once '../usuarios/aut_verifica.inc.php';

// Se requieren los script para acceder a los datos de la DB
require_once '../ClasesBasicas/ActiveRecordAbstractFactory.php';
require_once '../Clases/ActiveRecord/MysqlOrdenActiveRecord.php';
require_once '../Clases/ActiveRecord/MysqlProblemaActiveRecord.php';
require_once '../Clases/ActiveRecord/MysqlTProblemaActiveRecord.php';
require_once '../Clases/ActiveRecord/MysqlEspecialidadesActiveRecord.php';
require_once '../Clases/ActiveRecord/MysqlUsuariosActiveRecord.php';
require_once '../Clases/ActiveRecord/MysqlOficexpeActiveRecord.php';
require_once '../Clases/ActiveRecord/MysqlAgentesActiveRecord.php';
require_once '../Clases/ActiveRecord/MysqlAsignadosActiveRecord.php';
include_once 'funciones.php';
    
header ("Expires: Fri, 14 Mar 1980 20:53:00 GMT"); //la pagina expira en fecha pasada
header ("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); //ultima actualizacion ahora cuando la cargamos
header ("Cache-Control: no-cache, must-revalidate"); //no guardar en CACHE
header ("Pragma: no-cache"); //PARANOIA, NO GUARDAR EN CACHE

?>
<!DOCTYPE html>
<html>
<head>    
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Orden de Trabajo</title>
    <link rel="shortcut icon" href="../images/ingreso.ico" />    
    <link rel="stylesheet" href="../css/estilos.css" type="text/css" />      	       
    <style>
        FIELDSET {border:1px solid #000;   background-color: #FFF; width: 700px; FONT-FAMILY: "Trebuchet MS", Trebuchet, Verdana, Arial, Helvetica, sans-serif; FONT-SIZE: 15px;}
        .borde {border:1.5px dotted #000; padding: 5px;}
        .cmp {margin: 10px;}
        H1.SaltoDePagina   {    PAGE-BREAK-AFTER: always }
    </style>
    <script>
    function imprimir(que) {
    var ventana = window.open("", "", "");
    var contenido = "<html><head><link rel='stylesheet' href='images/print.css' type='text/css' media='print'/></head><body onload='window.print();'>" + document.getElementById(que).innerHTML + "</body></html>";
    ventana.document.open();
    ventana.document.write(contenido);
    ventana.document.close();}
    </script>
</head>
<body>
<div class="contenedor">
<header> <?php include_once '../ClasesBasicas/Encabezado.php'; ?> </header>
<div id="cuerpo" style="min-height: 500px;">
    <h1>Impresi&oacute;n de la Orden de Trabajo </h1>        
<?php
$nro = $_GET['nro'];

$oMysql = ActiveRecordAbstractFactory::getActiveRecordFactory(ActiveRecordAbstractFactory::MYSQL);
$oMysql->conectar();

$oMysqlOrden = $oMysql->getOrdenActiveRecord();
$oOrden = new OrdenValueObject();
$oOrden->setNro($nro);  
$oOrden = $oMysqlOrden->find($oOrden);

$oMysqlOficexpe = $oMysql->getOficexpeActiveRecord();
$oOficina = new OficexpeValueObject();

$oMysqlProblema = $oMysql->getProblemaActiveRecord();
$oProblema = new ProblemaValueObject();

$oMysqlTProblema = $oMysql->getTProblemaActiveRecord();
$oTProblema = new TProblemaValueObject();

$oMysqlEspecialidad = $oMysql->getEspecialidadesActiveRecord();
$oEspecialidades = new EspecialidadesValueObject();

?>
<div align="right" style="margin-right:35px;">
    <a href="javascript:imprimir('informe')"><img src="../css/img_estilos/imprimir.gif" alt="Imprimir" title="Imprimir OT">&nbsp;Imprimir</a>&nbsp;|&nbsp;
    <a href="index.php">Regresar</a>
</div>
<div id="informe">
    <div style="width: 640px; margin: 0 auto;">
 <div style="font-size: 12px;border: 1px solid #000;  margin-left:2px; margin-right:2px; margin-top: 10px; padding: 2px;  padding-right: 2px;   font-weight: bold; width: 310px; float:left;" >
     <div style="display: block; margin-left:30px; text-align: center; font-weight: bold;">         
         ORDEN DE TRABAJO<br/>
         <img src="../images/logo.jpg" style="margin:0; float:left;"/>
         <div align="left" style="padding-left: 90px; margin-top: 5px;" >
             Departamento Inform&aacute;tica<br/>
             Ministerio de Salud<br/>
             Gobierno de Entre R&iacute;os<br/>             
         </div>         
         <div align="left" style="font-weight: normal;padding-left: 90px;">
             <small>25 de Mayo 139 - Paran&aacute; - <br/>Tel: (0343) 4209634</small>
         </div>
     </div>
     <div align="right" >
     <label >NRO: <?php echo $nro;?></label>
     <br/>Original
     </div>     
     <hr>
     <div style="display: block; margin: auto; text-align: left; font-weight: normal; height: 250px;">
         <?php
         $oOficina->set_ofcodi($oOrden->getOfcodi());
         $oOficina=$oMysqlOficexpe->find($oOficina);            
         echo "Oficina: ".htmlentities($oOficina->get_nombre())."<br/>"; 
         $oProblema->setId($oOrden->getIdProblema());
         $oProblema=$oMysqlProblema->find($oProblema);  
         /// busca el tipo de problema
         $oTProblema->setId($oProblema->getIdTProblema());
         $oTProblema=$oMysqlTProblema->find($oTProblema);              
         // busca la especialidad
         $oEspecialidades->setId($oProblema->getIdEspecialidad());
         $oEspecialidades=$oMysqlEspecialidad->find($oEspecialidades);  
         /// muestra el problema completo
         echo html_entity_decode($oTProblema->getDescripcion()." ".$oEspecialidades->getDescripcion())."<br/> ";
         echo "Observaci&oacute;n: ".html_entity_decode($oOrden->getDescripcion());
         ?>
     </div>
     <div style="text-align: left; font-weight: normal; ">
     Fecha Impresi&oacute;n: <?php echo date('d-m-Y');?>
     </div>
  </div>  
    <div style="font-size: 12px;border: 1px solid #000;  margin-left:2px; margin-right:2px; margin-top: 10px; padding: 2px;  padding-right: 2px;   font-weight: bold; width: 310px; float:left;" >
     <div style="display: block; margin-left:30px; text-align: center; font-weight: bold;">         
         ORDEN DE TRABAJO<br/>
         <img src="../images/logo.jpg" style="margin:0; float:left;"/>
         <div align="left" style="padding-left: 90px; margin-top: 5px;" >
             Departamento Inform&aacute;tica<br/>
             Ministerio de Salud<br/>
             Gobierno de Entre R&iacute;os<br/>             
         </div>         
         <div align="left" style="font-weight: normal;padding-left: 90px;">
             <small>25 de Mayo 139 - Paran&aacute; - <br/>Tel: (0343) 4209634</small>
         </div>
     </div>
     <div align="right" >
     <label >NRO: <?php echo $nro;?></label>
     <br/>Duplicado
     </div>     
     <hr>
     <div style="display: block; margin: auto; text-align: left; font-weight: normal; height: 250px;">
         <?php
         $oOficina->set_ofcodi($oOrden->getOfcodi());
         $oOficina=$oMysqlOficexpe->find($oOficina);            
         echo "Oficina: ".htmlentities($oOficina->get_nombre())."<br/>"; 
         $oProblema->setId($oOrden->getIdProblema());
         $oProblema=$oMysqlProblema->find($oProblema);  
         /// busca el tipo de problema
         $oTProblema->setId($oProblema->getIdTProblema());
         $oTProblema=$oMysqlTProblema->find($oTProblema);              
         // busca la especialidad
         $oEspecialidades->setId($oProblema->getIdEspecialidad());
         $oEspecialidades=$oMysqlEspecialidad->find($oEspecialidades);  
         /// muestra el problema completo
         echo html_entity_decode($oTProblema->getDescripcion()." ".$oEspecialidades->getDescripcion())."<br/> ";
         echo "Observaci&oacute;n: ". html_entity_decode($oOrden->getDescripcion());
         ?>
     </div>
     <div style="text-align: left; font-weight: normal;">
     Fecha Impresi&oacute;n: <?php echo date('d-m-Y');?>
     </div>
  </div> 

  </div>
    </div>
</div>
<footer><?php include_once '../ClasesBasicas/Pie.php'; ?></footer>
</div>
</body>
</html>