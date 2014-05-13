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
require_once '../Clases/ActiveRecord/MysqlEquipoActiveRecord.php';
require_once '../Clases/ActiveRecord/MysqlOficexpeActiveRecord.php';
require_once '../Clases/ActiveRecord/MysqlUbicacionActiveRecord.php';
require_once '../Clases/ActiveRecord/MysqlComponenteActiveRecord.php';
require_once '../Clases/ActiveRecord/MysqlRelacionActiveRecord.php';
require_once '../Clases/ActiveRecord/MysqlMarcaActiveRecord.php';
require_once '../Clases/ActiveRecord/MysqlModeloActiveRecord.php';
require_once '../Clases/ActiveRecord/MysqlTipoActiveRecord.php';
require_once '../Clases/ActiveRecord/MysqlUsuariosEquiposActiveRecord.php';

include_once 'funciones.php';
    
header ("Expires: Fri, 14 Mar 1980 20:53:00 GMT"); //la pagina expira en fecha pasada
header ("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); //ultima actualizacion ahora cuando la cargamos
header ("Cache-Control: no-cache, must-revalidate"); //no guardar en CACHE
header ("Pragma: no-cache"); //PARANOIA, NO GUARDAR EN CACHE

?>
<!DOCTYPE html>
<html>
<head>    
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
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
        if(!confirm("Desea imprimir la observación de la solución?")) {             
            var ventana = window.open("", "", "");
            var contenido = "<html><head><link rel='stylesheet' href='printComun.css' type='text/css' media='print'/></head><body onload='window.print();'>" + document.getElementById(que).innerHTML + "</body></html>";            
            ventana.document.open();
            ventana.document.write(contenido);
            ventana.document.close();
        } else {
             var ventana = window.open("", "", "");
            var contenido = "<html><head><link rel='stylesheet' href='print.css' type='text/css' media='print'/></head><body onload='window.print();'>" + document.getElementById(que).innerHTML + "</body></html>";
            ventana.document.open();
            ventana.document.write(contenido);
            ventana.document.close();
        }                    
    }
    </script>

</head>
<body >
<div class="contenedor">
<header> <?php include_once '../ClasesBasicas/Encabezado.php'; ?> </header>
<div id="cuerpo">
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
 <div style="display: block; margin-left:30px; text-align: center; font-weight: bold; font-size: 15px;border: 1px solid #000;  margin-left:35px; margin-right:35px;  padding: 10px;  padding-right: 25px;  font-family: Calibri, Arial, Helvetica, sans-serif; height: 420px;" >
      ORDEN DE TRABAJO N&ordm; <?php echo $nro;?>
     <div style="font-size: 12px; display: block; text-align: center; overflow:hidden;">                         
         <div style=" font-weight: bold; float:left; padding:10px; width:280px; text-align: left;" >
             Departamento Inform&aacute;tica<br/>
             Ministerio de Salud - Gobierno de Entre R&iacute;os<br/>             
             <small style="font-weight: normal;">25 de Mayo 139 - Paran&aacute; - Tel: (0343) 4209634</small>
         </div>                       
        <div style="float:right; padding:10px; width:200px; text-align: right;" >        
            Fecha Ingreso: <?php echo $oOrden->getFechaInicio(); ?><br/>
            Fecha: <?php echo date('d-m-Y');?><br/>Original
        </div>     
     </div>          
     <div style="clear:both; min-height: 260px;border-top: 1px solid; font-size: 12px; display: block; margin: auto; text-align: left; font-weight: normal; padding: 10px; line-height: 20px; font-family: Calibri, Arial, Helvetica, sans-serif;">         
         <?php
         $oOficina->set_ofcodi($oOrden->getOfcodi());
         $oOficina=$oMysqlOficexpe->find($oOficina);            
         echo "<u>Oficina:</u> ".htmlentities($oOficina->get_nombre())."<br/>"; 
         $oProblema->setId($oOrden->getIdProblema());
         $oProblema=$oMysqlProblema->find($oProblema);  
         /// busca el tipo de problema
         $oTProblema->setId($oProblema->getIdTProblema());
         $oTProblema=$oMysqlTProblema->find($oTProblema);              
         // busca la especialidad
         $oEspecialidades->setId($oProblema->getIdEspecialidad());
         $oEspecialidades=$oMysqlEspecialidad->find($oEspecialidades);  
         /// muestra el problema completo
         echo "<u>Motivo:</u> ".htmlentities($oTProblema->getDescripcion()." ".$oEspecialidades->getDescripcion())."<br/> ";
         echo "<u>Detalle:</u> ".$oOrden->getDescripcion();
         ?>
         <br/>
         <u>Equipo:</u>
         <?php 
            $oMysqlEquipo = $oMysql->getEquipoActiveRecord();             
            if(($oOrden->getEquipo()<>'0')&&($oOrden->getEquipo()<>NULL))  {                
                $oEquipo = new EquipoValueObject();
                $oEquipo->setId($oOrden->getEquipo());
                $oEquipo = $oMysqlEquipo->findPorId($oEquipo);
                if($oEquipo) {                  
                echo " <strong>".$oEquipo->getNro()."</strong>  <div style='margin-left:50px; line-height: 14px;'>"; 
                echo " Nombre: ".$oEquipo->getNombre(); ?>
                - <label for="ip">IP:</label>
                <?php echo $oEquipo->getIp();                            
                $idUsuario = $oEquipo->getUsuario();            
                if($idUsuario<>0) {
                    // levanta nombre de usuario
                    $oUsuario = new UsuariosEquiposValueObject();
                    $oUsuario->setId($idUsuario);
                    $oMysqlUsuario = $oMysql->getUsuariosEquiposActiveRecord();
                    $oUsuario = $oMysqlUsuario->findId($oUsuario);
                    echo " - <label for='usuario'>Usuario:</label> ".$oUsuario->getNombre()." - ";
                }                
                $observacion = $oEquipo->getObservacion();
                $nombreEquipo = $oEquipo->getNombre();
                $oUbicacion = new UbicacionValueObject();
                $oUbicacion->setIdEquipo($oEquipo->getId());
                $oMysqlUbicacion = $oMysql->getUbicacionActiveRecord();
                $oUbicacion = $oMysqlUbicacion->find($oUbicacion);    
                if($oUbicacion) {
                    $ofcodi = $oUbicacion->getOfcodi();
                    $oOfi = new OficexpeValueObject();               
                    if($ofcodi<>'') {
                        $oOfi->set_ofcodi($ofcodi);
                        $oMysqlOfi = $oMysql->getOficexpeActiveRecord();
                        $oOfi = $oMysqlOfi->findCompleta($oOfi);
                        echo "<label for='ubicacion'>Ubicacion:</label> ".$oOfi->get_ofcodi()." ".  htmlentities($oOfi->get_nombre())." - ".$oOfi->get_tipo()." de ".$oOfi->get_codloc();
                    }
                }
                echo "<br/>";
                /// busca los componente del equipo
                $oMysqlTipo = $oMysql->getTipoActiveRecord();
                $oMysqlMarca = $oMysql->getMarcaActiveRecord();
                $oMysqlModelo = $oMysql->getModeloActiveRecord();

                $oTipo = new TipoValueObject();
                $oRelacion = new RelacionValueObject();
                
                $oMysqlRelacion = $oMysql->getRelacionActiveRecord();
                $oRelacion->setIdEquipo($oEquipo->getId());
                $aRelacion_ = array();
                $aRelacion_ = $oMysqlRelacion->find($oRelacion);                                        
                if($aRelacion_<>false){  
                    $oComponenteInd = new ComponenteValueObject();
                    $oMysqlComponenteInd = $oMysql->getComponenteActiveRecord();                        
                    foreach($aRelacion_ as $value1) {                  
                        $oComponenteInd->setId($value1->getIdComponente());                
                        $oComponenteInd = $oMysqlComponenteInd->find($oComponenteInd);                        
                        if($oComponenteInd<>false){ 
                             $oTipo->setId($oComponenteInd->getIdTipo());
                             $oTipo = $oMysqlTipo->findId($oTipo);
                             if(($oTipo->getId()==9) or ($oTipo->getId()==10) or ($oTipo->getId()==11))
                                echo $oTipo->getDescripcion()." Nro ". $oComponenteInd->getNro(). ": ";   
                            else 
                                echo $oTipo->getDescripcion().": ";
                            echo "<cite>";
                             $oMarca = new MarcaValueObject();                                     
                             if($oComponenteInd->getIdMarca()) {
                                $oMarca = $oMysqlMarca->findId($oComponenteInd->getIdMarca());                             
                                echo " ".$oMarca->getDescripcion();
                             }   
                             $oModelo = new ModeloValueObject();        
                             if($oComponenteInd->getIdModelo()) {
                                $oModelo = $oMysqlModelo->findId($oComponenteInd->getIdModelo());
                                echo " ".$oModelo->getDescripcion();
                             }
                            echo " ".$oComponenteInd->getNroSerie()." ".$oComponenteInd->getCantidad()."</cite> - ";
                        }
                    }
                }
                }        
                echo "</div>";
            } else {               
                if(($oOrden->getNroEquipo()<>0)||($oOrden->getNroEquipo()<>NULL))
                    echo " ".$oOrden->getNroEquipo()."<br/>"; 
                else 
                    echo " - "."<br/>"; 
            }           
            
            
         ?>              
         <u>Usuario:</u>
         <?php 
            $oMysqlAgentes = $oMysql->getAgentesActiveRecord();
            $oAgentes = new AgentesValueObject();
            $oUsuario1 = new UsuariosEquiposValueObject();
            $oMysqlUsuario1 = $oMysql->getUsuariosEquiposActiveRecord();             
            if(($oOrden->getAgente()<>'0')&&($oOrden->getAgente()<>NULL))  {                            
                $oAgentes->setDni($oOrden->getAgente());
                $oAgentes = $oMysqlAgentes->find($oAgentes);
                $oUsuario1->setDni($oOrden->getAgente());
                $oMysqlUsuario1->findDni($oUsuario1);
                echo " ".$oUsuario1->getNombre()." - <cite>".$oAgentes->getNombre()." ".$oAgentes->getApellido()."</cite>";                
                unset($oAgentes);                               
            } else {
                echo " - ";
            }
            ?>
     <div id="no-print" ><u>Observación:</u>&nbsp;<?php echo $oOrden->getObservacion(); ?></div>
     <br/>
     <u>Resolución:</u>&nbsp;&nbsp;&nbsp;______________________________________________________________<br/>
     ________________________________________________________________________     
  </div>          
</div>
<div style="display: block; margin-left:30px; text-align: center; font-weight: bold; font-size: 15px;border: 1px solid #000;  margin-left:35px; margin-right:35px;  padding: 10px;  padding-right: 25px;  font-family: Calibri, Arial, Helvetica, sans-serif; height: 420px;" >
      ORDEN DE TRABAJO N&ordm; <?php echo $nro;?>
     <div style="font-size: 12px; display: block; text-align: center; overflow:hidden;">                         
         <div style=" font-weight: bold; float:left; padding:10px; width:280px; text-align: left;" >
             Departamento Inform&aacute;tica<br/>
             Ministerio de Salud - Gobierno de Entre R&iacute;os<br/>             
             <small style="font-weight: normal;">25 de Mayo 139 - Paran&aacute; - Tel: (0343) 4209634</small>
         </div>                       
        <div style="float:right; padding:10px; width:200px; text-align: right;" >        
            Fecha Ingreso: <?php echo $oOrden->getFechaInicio(); ?><br/>
            Fecha: <?php echo date('d-m-Y');?><br/>Duplicado
        </div>     
     </div>          
     <div style="clear:both; min-height: 260px;border-top: 1px solid; font-size: 12px; display: block; margin: auto; text-align: left; font-weight: normal; padding: 10px; line-height: 20px; font-family: Calibri, Arial, Helvetica, sans-serif;">         
         <?php
         $oOficina->set_ofcodi($oOrden->getOfcodi());
         $oOficina=$oMysqlOficexpe->find($oOficina);            
         echo "<u>Oficina:</u> ".htmlentities($oOficina->get_nombre())."<br/>"; 
         $oProblema->setId($oOrden->getIdProblema());
         $oProblema=$oMysqlProblema->find($oProblema);  
         /// busca el tipo de problema
         $oTProblema->setId($oProblema->getIdTProblema());
         $oTProblema=$oMysqlTProblema->find($oTProblema);              
         // busca la especialidad
         $oEspecialidades->setId($oProblema->getIdEspecialidad());
         $oEspecialidades=$oMysqlEspecialidad->find($oEspecialidades);  
         /// muestra el problema completo
         echo "<u>Motivo:</u> ".htmlentities($oTProblema->getDescripcion()." ".$oEspecialidades->getDescripcion())."<br/> ";
         echo "<u>Detalle:</u> ".$oOrden->getDescripcion();
         ?>
         <br/>
         <u>Equipo:</u>
         <?php 
            $oMysqlEquipo = $oMysql->getEquipoActiveRecord();             
            if(($oOrden->getEquipo()<>'0')&&($oOrden->getEquipo()<>NULL))  {                
                $oEquipo = new EquipoValueObject();
                $oEquipo->setId($oOrden->getEquipo());
                $oEquipo = $oMysqlEquipo->findPorId($oEquipo);
                if($oEquipo) {   
                echo " <strong>".$oEquipo->getNro()."</strong>  <div style='margin-left:50px; line-height: 14px;'>";                     
                echo " Nombre: ".$oEquipo->getNombre(); ?>
                - <label for="ip">IP:</label>
                <?php echo $oEquipo->getIp();                            
                $idUsuario = $oEquipo->getUsuario();            
                if($idUsuario<>0) {
                    // levanta nombre de usuario
                    $oUsuario = new UsuariosEquiposValueObject();
                    $oUsuario->setId($idUsuario);
                    $oMysqlUsuario = $oMysql->getUsuariosEquiposActiveRecord();
                    $oUsuario = $oMysqlUsuario->findId($oUsuario);
                    echo " - <label for='usuario'>Usuario:</label> ".$oUsuario->getNombre()." - ";
                }                
                $observacion = $oEquipo->getObservacion();
                $nombreEquipo = $oEquipo->getNombre();
                $oUbicacion = new UbicacionValueObject();
                $oUbicacion->setIdEquipo($oEquipo->getId());
                $oMysqlUbicacion = $oMysql->getUbicacionActiveRecord();
                $oUbicacion = $oMysqlUbicacion->find($oUbicacion);    
                if($oUbicacion) {
                    $ofcodi = $oUbicacion->getOfcodi();
                    $oOfi = new OficexpeValueObject();               
                    if($ofcodi<>'') {
                        $oOfi->set_ofcodi($ofcodi);
                        $oMysqlOfi = $oMysql->getOficexpeActiveRecord();
                        $oOfi = $oMysqlOfi->findCompleta($oOfi);
                        echo "<label for='ubicacion'>Ubicacion:</label> ".$oOfi->get_ofcodi()." ".  htmlentities($oOfi->get_nombre())." - ".$oOfi->get_tipo()." de ".$oOfi->get_codloc();
                    }
                }
                echo "<br/>";
                /// busca los componente del equipo
                $oMysqlTipo = $oMysql->getTipoActiveRecord();
                $oMysqlMarca = $oMysql->getMarcaActiveRecord();
                $oMysqlModelo = $oMysql->getModeloActiveRecord();

                $oTipo = new TipoValueObject();
                $oRelacion = new RelacionValueObject();
                
                $oMysqlRelacion = $oMysql->getRelacionActiveRecord();
                $oRelacion->setIdEquipo($oEquipo->getId());
                $aRelacion_ = array();
                $aRelacion_ = $oMysqlRelacion->find($oRelacion);                                        
                if($aRelacion_<>false){  
                    $oComponenteInd = new ComponenteValueObject();
                    $oMysqlComponenteInd = $oMysql->getComponenteActiveRecord();                        
                    foreach($aRelacion_ as $value1) {                  
                        $oComponenteInd->setId($value1->getIdComponente());                
                        $oComponenteInd = $oMysqlComponenteInd->find($oComponenteInd);                        
                        if($oComponenteInd<>false){ 
                             $oTipo->setId($oComponenteInd->getIdTipo());
                             $oTipo = $oMysqlTipo->findId($oTipo);
                             if(($oTipo->getId()==9) or ($oTipo->getId()==10) or ($oTipo->getId()==11))
                                echo $oTipo->getDescripcion()." Nro ". $oComponenteInd->getNro(). ": ";   
                            else 
                                echo $oTipo->getDescripcion().": ";
                            echo "<cite>";
                             $oMarca = new MarcaValueObject();                                     
                             if($oComponenteInd->getIdMarca()) {
                                $oMarca = $oMysqlMarca->findId($oComponenteInd->getIdMarca());                             
                                echo " ".$oMarca->getDescripcion();
                             }   
                             $oModelo = new ModeloValueObject();        
                             if($oComponenteInd->getIdModelo()) {
                                $oModelo = $oMysqlModelo->findId($oComponenteInd->getIdModelo());
                                echo " ".$oModelo->getDescripcion();
                             }
                            echo " ".$oComponenteInd->getNroSerie()." ".$oComponenteInd->getCantidad()."</cite> - ";
                        }
                    }
                }
                }        
                echo "</div>";
            } else {               
                if(($oOrden->getNroEquipo()<>0)||($oOrden->getNroEquipo()<>NULL))
                    echo " ".$oOrden->getNroEquipo()."<br/>"; 
                else 
                    echo " - "."<br/>";                       
            }                                   
         ?>              
         <u>Usuario:</u>
         <?php 
            $oMysqlAgentes = $oMysql->getAgentesActiveRecord();
            $oAgentes = new AgentesValueObject();
            $oUsuario1 = new UsuariosEquiposValueObject();
            $oMysqlUsuario1 = $oMysql->getUsuariosEquiposActiveRecord();             
            if(($oOrden->getAgente()<>'0')&&($oOrden->getAgente()<>NULL))  {                            
                $oAgentes->setDni($oOrden->getAgente());
                $oAgentes = $oMysqlAgentes->find($oAgentes);
                $oUsuario1->setDni($oOrden->getAgente());
                $oMysqlUsuario1->findDni($oUsuario1);
                echo " ".$oUsuario1->getNombre()." - <cite>".$oAgentes->getNombre()." ".$oAgentes->getApellido()."</cite>";                
                unset($oAgentes);                               
            } else {
                echo " - ";
            }
            ?>
         <div id="no-print" ><u>Observación:</u>&nbsp;<?php echo $oOrden->getObservacion(); ?></div>
     <br/>
     <u>Resolución:</u>&nbsp;&nbsp;&nbsp;______________________________________________________________<br/>
     ________________________________________________________________________
  
    
  </div>
</div>
</div>
</div>
<footer><?php include_once '../ClasesBasicas/Pie.php'; ?></footer>
</div>
</body>
</html>