<?php
// Se chequea si existe un login
require_once '../usuarios/aut_verifica.inc.php';

header("Pragma: no-cache");
header('Cache-control: no-store, no-cache, must-revalidate');
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Content-type: application/vnd.ms-excel; charset=utf-8'");
header("Content-disposition: attachment; filename=consultaGeneral.xls");


/**
* Archivo que genera la planilla de excel
*
* Archivo que genera la planilla de excel con los datos que levanta de la base
* de datos segun los criterios que recibe de mostrar.cuerpo.php
*
* @copyright  Copyright (c) 2010 INFORMATICA MINISTERIO DE SALUD
* @version    1.0
* @since      File available since Release 1.0
*
*/

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
require_once '../Clases/ActiveRecord/MysqlRubroActiveRecord.php';
require_once '../Clases/ActiveRecord/MysqlEquipoActiveRecord.php';
require_once '../Clases/ActiveRecord/MysqlUsuariosEquiposActiveRecord.php';
include_once 'funciones.php';

header ("Expires: Fri, 14 Mar 1980 20:53:00 GMT"); //la pagina expira en fecha pasada
header ("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); //ultima actualizacion ahora cuando la cargamos
header ("Cache-Control: no-cache, must-revalidate"); //no guardar en CACHE
header ("Pragma: no-cache"); //PARANOIA, NO GUARDAR EN CACHE


$oMysql = ActiveRecordAbstractFactory::getActiveRecordFactory(ActiveRecordAbstractFactory::MYSQL);
$oMysql->conectar();

$criterio = $orden = $busqueda = $rubro = $especialidad = $problema = '';

$oMysqlOrden = $oMysql->getOrdenActiveRecord();
$oOrden = new OrdenValueObject();

if(isset($_GET['oficina_ID']))
    $oOrden->setOfcodi ($_GET['oficina_ID']);
if(isset($_GET['dproblema']))
    $oOrden->setDescripcion ($_GET['dproblema']);
if (isset($_GET['criterio_ordenar_por']))
    $criterio = fn_filtro($_GET['criterio_ordenar_por']); /// porque quiero ordenar
if (isset($_GET['criterio_orden']))
    $orden = fn_filtro($_GET['criterio_orden']); /// orden en que se van a mostrar los resultados
if(isset($_GET['formaFinalizacion'])) {
    if($_GET['formaFinalizacion']<>0)
    $oOrden->setFormaFinalizacion($_GET['formaFinalizacion']);   
}

if(($_GET['desde']<>'')&&($_GET['hasta']<>'')) {
    $oOrden->setFechaInicio($_GET['desde']);
    $oOrden->setFechaFinalizacion($_GET['hasta']);
}

if($_SESSION['usuario_nivel']=='N') {
    $oOrden->setUsuarioAsignado($_SESSION['usuario_id']);
} else {
    if($_GET['usuario'])
        $oOrden->setUsuarioAsignado($_GET['usuario']);            
}

$oOrden->setFechaAsignacion($_GET['fecha']);

$oMysqlProblema = $oMysql->getProblemaActiveRecord();
$oProblema = new ProblemaValueObject();

if(isset($_GET['categoria'])) {
    $oProblema->setIdRubro($_GET['categoria']);
    $rubro = $_GET['categoria'];
}
if(isset($_GET['especialidades'])) {
    $oProblema->setIdEspecialidad ($_GET['especialidades']);
    $especialidad = $_GET['especialidades'];
    
}
if(isset($_GET['problema'])) {
    $oProblema->setIdTProblema ($_GET['problema']);
    $problema = $_GET['problema'];
}

// busca todas las ordenes de trabajo
$aOrden = $oMysqlOrden->findMultipleCriterio($criterio, $orden, $oOrden, $rubro, $especialidad, $problema, $_GET['criterio_orden_fecha']);


$i=0;

if(count($aOrden)<>0) {

$oMysqlOficexpe = $oMysql->getOficexpeActiveRecord();
$oOficina = new OficexpeValueObject();

$oMysqlRubro = $oMysql->getRubroActiveRecord();
$oRubro = new RubroValueObject();

$oMysqlTProblema = $oMysql->getTProblemaActiveRecord();
$oTProblema = new TProblemaValueObject();

$oMysqlEspecialidad = $oMysql->getEspecialidadesActiveRecord();
$oEspecialidades = new EspecialidadesValueObject();

$oMysqlUsuarios = $oMysql->getUsuariosActiveRecord();
$oMysqlAsignados = $oMysql->getAsignadosActiveRecord();

$oMysqlAgentes = $oMysql->getAgentesActiveRecord();
$oAgentes = new AgentesValueObject();

$oMysqlEquipo = $oMysql->getEquipoActiveRecord();
$oEquipo = new EquipoValueObject();


?>   
<table style="text-align: left" border=1 cellspacing=0 cellpadding=2 bordercolor="666633">
<thead>
    <tr>
        <th>Nro</th>  
        <th>Oficina</th>
        <th>Categoria</th>  
        <th>Especialidad</th>  
        <th>Tipo de Problema</th>  
        <th>Descripcion Problema</th>
        <th>Estado</th>
        <th>Descripcion Estado</th>
        <th>Usuario<br/>Asignado</th>        
        <th width="74px;">Fecha<br/>Inicio</th>                
        <th width="74px;">Fecha<br/>Finalizaci&oacute;n</th>
        <th>Equipo</th>
        <th>Usuario Solicitante</th>
    </tr>
</thead>
<tbody>
<?php
foreach ($aOrden as $value) {           
    $i++;
     $oProblema->setId($value->getIdProblema());
     $oProblema=$oMysqlProblema->find($oProblema);
    ?>
    <tr ><td align="center"><?=$value->getNro()?></td>     
        <td><?php            
        $oOficina->set_ofcodi($value->getOfcodi());
        $oOficina=$oMysqlOficexpe->find($oOficina);            
        echo "<b>".htmlentities($oOficina->get_nombre())."</b>";  ?>
        </td>
        <td><?php
        $oRubro->setId($oProblema->getIdRubro());
        $oRubro=$oMysqlRubro->find($oRubro);
        echo html_entity_decode($oRubro->getDescripcion());
        ?>
        </td>
        <td><?php                 
        // busca la especialidad
        $oEspecialidades->setId($oProblema->getIdEspecialidad());
        $oEspecialidades=$oMysqlEspecialidad->find($oEspecialidades);  
        echo html_entity_decode($oEspecialidades->getDescripcion());
        ?>
        </td>
        <td><?php
        /// busca el tipo de problema
        $oTProblema->setId($oProblema->getIdTProblema());
        $oTProblema=$oMysqlTProblema->find($oTProblema);                      
        /// muestra el tipo de problema
        echo html_entity_decode($oTProblema->getDescripcion());            
        ?></td>
        <td><?php
        if($value->getDescripcion())
        echo "<cite>".html_entity_decode($value->getDescripcion())."</cite>";        ?> 
        </td><td>
        <?php
        switch ($value->getEstado()) {
            case 1:
                echo "Pendiente";
                break;
            case 2:
                echo "Asignado";
                break;
            case 3:
                echo "Finalizado: ";
               if($value->getFormaFinalizacion()==2)
                echo "<label style='color: green'>Solucionado</label>";
                if($value->getFormaFinalizacion()==3)
                echo "<label style='color: red'>No Solucionado</label>"; 
                 if($value->getFormaFinalizacion()==4)
                echo "<label style='color: brown'>Anulado</label>";  

                break;
            case 4:
                echo "Cerrado: ";
                if($value->getFormaFinalizacion()==2)
                echo "<label style='color: green'>Solucionado</label>";
                if($value->getFormaFinalizacion()==3)
                echo "<label style='color: red'>No Solucionado</label>";   
                if($value->getFormaFinalizacion()==4)
                echo "<label style='color: brown'>Anulado</label>";  
                break;            
        }
        ?>
        </td><td>    
        <?php
        if($value->getObservacion())                    
                echo "<cite>".html_entity_decode($value->getObservacion())."</cite>"; 
        ?>      
        </td>           
        <td><?php 
        /// si tiene un usuario asignado para la tarea lo muestra sino 
        /// si se trata del administrador muestra la lista de usuarios para
        /// asignar si es usuario normal permite asignarse la tarea        
        if($value->getUsuarioAsignado()<>0) {
            /// busca el nombre del usuario
            $oAsignados = new AsignadosValueObject();
            $oUsuarios = new UsuariosValueObject();
            $oAgentes = new AgentesValueObject();
            $oAsignados->setNroOrden($value->getNro());
            $aAsignados = $oMysqlAsignados->findAll($oAsignados);
            foreach ($aAsignados as $usuAsig) {                
                $oUsuarios->setId($usuAsig->getIdUsuario());
                $oUsuarios=$oMysqlUsuarios->find($oUsuarios); 
                $oAgentes->setDni($oUsuarios->getDni());
                $oAgentes = $oMysqlAgentes->find($oAgentes);
                echo $oAgentes->getNombre()." "; 
            }                                  
        } else { 
        echo "<cite>Sin asignar</cite>";
        } ?>

        </td>
        <td><?=$value->getFechaInicio()?></td>        
        <td><?php echo $value->getFechaFinalizacion()?></td>
        <td><?php
            if($value->getEquipo()) {
                $oEquipo->setId($value->getEquipo());
                $oEquipo = $oMysqlEquipo->findPorId($oEquipo);                
                if($oEquipo->getTipo()==1)
                    echo "<br/>Equipo ";
                else
                    echo "<br/>Impresora ";
                if($oEquipo->getUso()==0)
                    echo "Interno: ";
                else
                    echo "Externo: ";
                echo "<cite>".html_entity_decode($oEquipo->getNro())."</cite>";
            } else {
                if($value->getNroEquipo())
                    echo "<br/>Equipo no registrado: <cite>".html_entity_decode($value->getNroEquipo())."</cite>";
            }?>
        </td>
        <td><?php
         if($value->getAgente()) {
            $oAgentes = new AgentesValueObject();                
            $oAgentes->setDni($value->getAgente());
            $oAgentes = $oMysqlAgentes->find($oAgentes);
            $oUsuarioEq = new UsuariosEquiposValueObject();
            $oUsuarioEq->setDni($value->getAgente());
            $oMysqlUsuEquipo = $oMysql->getUsuariosEquiposActiveRecord();
            $oMysqlUsuEquipo->findDni($oUsuarioEq);
            echo "<br/>Usuario: <cite>".$oUsuarioEq->getNombre()." - ".$oAgentes->getNombre()." ".$oAgentes->getApellido()."</cite>";
            unset($oAgentes);

        }
        ?></td>
    </tr>
        <?php }  
    ?>
    </tbody>
    </table>
    <?php
} else {
    echo "No se encontraron registros asociados a la b&uacute;squeda seleccionada<br/>" ;
}?>
                                   