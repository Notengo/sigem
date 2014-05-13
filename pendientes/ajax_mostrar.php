<?php
// Se chequea si existe un login
require_once '../usuarios/aut_verifica.inc.php';

// Se requieren los script para acceder a los datos de la DB
require_once '../ClasesBasicas/ActiveRecordAbstractFactory.php';
require_once '../Clases/ActiveRecord/MysqlProblemaActiveRecord.php';
require_once '../Clases/ActiveRecord/MysqlTProblemaActiveRecord.php';
require_once '../Clases/ActiveRecord/MysqlEspecialidadesActiveRecord.php';
require_once '../Clases/ActiveRecord/MysqlOrdenActiveRecord.php';
require_once '../Clases/ActiveRecord/MysqlProblemaActiveRecord.php';
require_once '../Clases/ActiveRecord/MysqlEquipoActiveRecord.php';
require_once '../Clases/ActiveRecord/MysqlOficexpeActiveRecord.php';
require_once '../Clases/ActiveRecord/MysqlUbicacionActiveRecord.php';
require_once '../Clases/ActiveRecord/MysqlComponenteActiveRecord.php';
require_once '../Clases/ActiveRecord/MysqlRelacionActiveRecord.php';
require_once '../Clases/ActiveRecord/MysqlMarcaActiveRecord.php';
require_once '../Clases/ActiveRecord/MysqlModeloActiveRecord.php';
require_once '../Clases/ActiveRecord/MysqlTipoActiveRecord.php';
require_once '../Clases/ActiveRecord/MysqlUsuariosEquiposActiveRecord.php';
require_once '../Clases/ActiveRecord/MysqlRubroActiveRecord.php';
include_once 'funciones.php';

$oMysql = ActiveRecordAbstractFactory::getActiveRecordFactory(ActiveRecordAbstractFactory::MYSQL);
$oMysql->conectar();

$oMysqlOrden = $oMysql->getOrdenActiveRecord();
$oOrden = new OrdenValueObject();

$oMysqlProblema = $oMysql->getProblemaActiveRecord();
$oProblema = new ProblemaValueObject();

$oMysqlRubro = $oMysql->getRubroActiveRecord();
$oRubro = new RubroValueObject();

$oMysqlTProblema = $oMysql->getTProblemaActiveRecord();
$oTProblema = new TProblemaValueObject();

$oMysqlEspecialidad = $oMysql->getEspecialidadesActiveRecord();
$oEspecialidades = new EspecialidadesValueObject();

$oOrden->setNro($_GET['nro']);
$oOrden = $oMysqlOrden->find($oOrden);
if ($oOrden==false){
        echo "La orden de trabajo no existe";
        exit;
}



?>
<!DOCTYPE html>
<html>
<head>    
    <title>ODT</title>
    <meta http-equiv="Content-type" content="text/html;charset=UTF-8">
    <link rel="shortcut icon" href="../images/ingreso.ico" />    
    <link rel="stylesheet" href="../css/estilos.css" type="text/css" />      	   
    <script language="javascript" type="text/javascript" src="js/jquery-1.4.3.min.js"></script>
    <script language="javascript" type="text/javascript" src="js/index.js"></script>      
        <style>
        FIELDSET {border:1px solid #000;   background-color: #FFF; width: 700px; FONT-FAMILY: "Trebuchet MS", Trebuchet, Verdana, Arial, Helvetica, sans-serif; FONT-SIZE: 15px; text-align: left;      }
        .borde {border:1.5px dotted #000; padding: 5px;}
        .cmp {margin: 10px;}
        H1.SaltoDePagina   {    PAGE-BREAK-AFTER: always }
        legend { margin: 0 0 5px 0px; height: 24px;  line-height: 24px;  width:60px;  padding: 0 5px;           background: #fff;
            font-size: 90%;
            font-weight: bold;
        }
        
    </style>
</head>
<body>
<div class="contenedor">
<header> <?php include_once '../ClasesBasicas/Encabezado.php'; ?> </header>
<div id="cuerpo">
<h1>Informaci&oacute;n Adicional de la Orden de Trabajo</h1>
    <input type="hidden" id="cue" name="cue" value="<?=$oOrden->getNro()?>" />
    <div align="right" style="margin-right:35px;">    
    <a href="index.php">Regresar</a>
    </div>
    <table class="formulario" style="width: 900px; ">
        <tbody>
            <tr>
                <td><cite>Nro OT: </cite><b><?=$oOrden->getNro()?></b></td>         
            </tr>
            <tr>                  
                <td><cite>Recepci&oacute;n del pedido: </cite><?php
                    switch ($oOrden->getTipoRecepcion()) {
                        case 0:
                            echo "Telef&oacute;nicamente";
                            break;
                        case 1:
                            echo "Personalmente";
                            break;
                        default:
                            echo "Otra";
                            break;
                    }                                    
                    ?>
                </td>
            </tr>
            <tr>
                <td><cite>Descripci&oacute;n del Problema: </cite><?php echo html_entity_decode($oOrden->getDescripcion())?></td>
            </tr>  
             <tr>
                 <td><cite>Categoria: </cite>
                    <?php              
                    $oProblema->setId($oOrden->getIdProblema());
                    $oProblema=$oMysqlProblema->find($oProblema);  
                    /// busca el rubro
                    $oRubro->setId($oProblema->getIdRubro());
                    $oRubro=$oMysqlRubro->find($oRubro);              
                    /// busca el tipo de problema
                    $oTProblema->setId($oProblema->getIdTProblema());
                    $oTProblema=$oMysqlTProblema->find($oTProblema);              
                    // busca la especialidad
                    $oEspecialidades->setId($oProblema->getIdEspecialidad());
                    $oEspecialidades=$oMysqlEspecialidad->find($oEspecialidades);  
                    /// muestra el problema completo
                    echo html_entity_decode($oRubro->getDescripcion()); 
                    echo " <cite>Especialidad: </cite>".html_entity_decode($oEspecialidades->getDescripcion()); 
                    echo " <cite>Tipo problema: </cite>".html_entity_decode($oTProblema->getDescripcion()); 
                    ?>
                    <tr>
                        <td><cite>Observación: </cite><?php if($oOrden->getObservacion()) echo html_entity_decode($oOrden->getObservacion()); else echo "-"; ?></td>
                    </tr>              
                    <?php
                    $oMysqlProblema = $oMysql->getProblemaActiveRecord();
                    $oProblema = new ProblemaValueObject();
                    $oProblema->setId($oOrden->getIdProblema());
                    $oProblema=$oMysqlProblema->find($oProblema);  
                    ?>  
<!--            <tr>
                <td>Observaci&oacute;n del Problema:<?=$oProblema->getObservacion()?></strong></td>
            </tr> -->
        </tbody>
        </table>
        <?php
        $oMysqlEquipo = $oMysql->getEquipoActiveRecord();
        $ip = $usuario = $ofcodi = $nombre= $orden = '';

        // si se ingreso un nro diferente al sugerido busca si existe
        $id = $oOrden->getEquipo();     
        $oEquipo = new EquipoValueObject();
        $oEquipo->setId($id);
        $oEquipo = $oMysqlEquipo->findPorId($oEquipo);
        // si el equipo existe cargo las variables para mostrarlas
        if($oEquipo) {
            $nro = $oEquipo->getNro();
            $ip = $oEquipo->getIp();
            $idUsuario = $oEquipo->getUsuario();      
            ?>        
                <div id="resultado">
                <center>
                <br/>
                <div id="informe">
                    <fieldset style="width: 900px; border:2px solid #000;">    
                        <p>    
                        <label for="nro">Equipo Nro:</label>&nbsp
                            <?php echo $nro."&nbsp;&nbsp;";
                            if($oEquipo->getNombre()) echo "Nombre: ".$oEquipo->getNombre()."&nbsp;&nbsp;";           
                            if($oEquipo->getIp()) echo "IP: ".$oEquipo->getIp()." ";  
                            if($idUsuario<>0) {
                                // levanta nombre de usuario
                                $oUsuario = new UsuariosEquiposValueObject();
                                $oUsuario->setId($idUsuario);
                                $oMysqlUsuario = $oMysql->getUsuariosEquiposActiveRecord();
                                $oUsuario = $oMysqlUsuario->findId($oUsuario);
                                echo "<label for='usuario'>Usuario:</label> ".$oUsuario->getNombre()."<br/>";
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
                            ?>                   
                        <br/>                
                        </p>
                    </fieldset>
                    <br/>
                    <fieldset  style="width: 900px;">
                        <legend >&nbsp;&nbsp;Detalle</legend>
                        <table style="margin-left: 20px; width:800px;">
                        <?php          
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
                                     ?><tr><td>
                                            <?php echo $oTipo->getDescripcion().": ";   
                                            $oMarca = new MarcaValueObject();                                     
                                            if($oComponenteInd->getIdMarca()) {
                                               $oMarca = $oMysqlMarca->findId($oComponenteInd->getIdMarca());                             
                                               echo "<cite>Marca:</cite>  ".$oMarca->getDescripcion()."&nbsp;";
                                            }   
                                            $oModelo = new ModeloValueObject();        
                                            if($oComponenteInd->getIdModelo()) {
                                               $oModelo = $oMysqlModelo->findId($oComponenteInd->getIdModelo());
                                               echo "<cite>Modelo:</cite> ".$oModelo->getDescripcion()."&nbsp;";
                                            }
                                            if($oComponenteInd->getNroSerie()) echo "<cite>Nro. Serie:</cite> ".$oComponenteInd->getNroSerie()."&nbsp;";
                                            if($oComponenteInd->getCantidad()) echo "<cite>Capacidad:</cite> ".$oComponenteInd->getCantidad()."&nbsp;";                                                                                                          
                                           ?>                            
                                    </td></tr>              
                                    <?php
                                }
                            }
                        }
                    ?>    
        </table>
        <br/>
        </fieldset>
        </div>
        </center>
    </div>
       
<?php } ?>

        
        
       
    
</div>
<footer><?php include_once '../ClasesBasicas/Pie.php'; ?></footer>
</div>
</body>
</html>