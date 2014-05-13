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
require_once '../Clases/ActiveRecord/MysqlUsuariosEquiposActiveRecord.php';

header ("Expires: Fri, 14 Mar 1980 20:53:00 GMT"); //la pagina expira en fecha pasada
header ("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); //ultima actualizacion ahora cuando la cargamos
header ("Cache-Control: no-cache, must-revalidate"); //no guardar en CACHE
header ("Pragma: no-cache"); //PARANOIA, NO GUARDAR EN CACHE

$oMysql = ActiveRecordAbstractFactory::getActiveRecordFactory(ActiveRecordAbstractFactory::MYSQL);
$oMysql->conectar();


$fecha = date('d/m/Y');

$oMysqlOrden = $oMysql->getOrdenActiveRecord();
$oOrden = new OrdenValueObject();
$oOrden->setFechaInicio($fecha);
$aOrden = $oMysqlOrden->findAll($oOrden);

$oMysqlOficexpe = $oMysql->getOficexpeActiveRecord();
$oOficina = new OficexpeValueObject();

$oMysqlProblema = $oMysql->getProblemaActiveRecord();
$oProblema = new ProblemaValueObject();

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

$i=0;
echo "Referencias: <cite class='alerta' style='padding:5px'>Nueva OT</cite>&nbsp; <cite class='info' style='padding:5px'>OT Asignada</cite>&nbsp; <cite class='finalizado' style='padding:5px'>OT Finalizada</cite>&nbsp; <cite class='cerrado' style='padding:5px'>OT Cerrada</cite><br/><br/>";

if(count($aOrden)<>0) {
   
    foreach ($aOrden as $value) {
        $i++;
        /// usuario que inicia la OT
        $oUsuarios = new UsuariosValueObject();
        $oAgentes = new AgentesValueObject();
        $oUsuarios->setId($value->getUsuarioAlta());
        $oUsuarios=$oMysqlUsuarios->find($oUsuarios); 
        $oAgentes->setDni($oUsuarios->getDni());
        $oAgentes = $oMysqlAgentes->find($oAgentes);       
        if($value->getEstado()==1){
            echo "<div class='alerta'> <b>".$value->getHoraInicio()."</b> Nueva orden de trabajo: ".$value->getNro()."<br/>";        
            echo "Registr&oacute; ".$oAgentes->getNombre()." el d&iacute;a ".$value->getFechaInicio()." a las ".$value->getHoraInicio()."<br/>"; 
        }
        if($value->getEstado()==2){
            echo "<div class=info> <b>".$value->getHoraAsignacion()."</b> Orden asignada: ".$value->getNro()."<br/>";        
            echo "Registr&oacute; ".$oAgentes->getNombre()." el d&iacute;a ".$value->getFechaInicio()." a las ".$value->getHoraInicio()."<br/>"; 
        }
        if($value->getEstado()==3){
            echo "<div class=finalizado> <b>".$value->getHoraFinalizacion()."</b> Orden finalizada: ".$value->getNro()."<br/>";        
            echo "Registr&oacute; ".$oAgentes->getNombre()." el d&iacute;a ".$value->getFechaInicio()." a las ".$value->getHoraInicio()."<br/>"; 
        }
        if($value->getEstado()==4){
            echo "<div class=cerrado> <b>".$value->getHoraCierre()."</b> Orden cerrada: ".$value->getNro()."<br/>";        
            echo "Registr&oacute; ".$oAgentes->getNombre()." el d&iacute;a ".$value->getFechaInicio()." a las ".$value->getHoraInicio()."<br/>"; 
        }           



        $oOficina->set_ofcodi($value->getOfcodi());
        $oOficina=$oMysqlOficexpe->find($oOficina);            
        echo htmlentities($oOficina->get_nombre()).": ";                            

        $oProblema->setId($value->getIdProblema());
        $oProblema=$oMysqlProblema->find($oProblema);  
        /// busca el tipo de problema
        $oTProblema->setId($oProblema->getIdTProblema());
        $oTProblema=$oMysqlTProblema->find($oTProblema);              
        // busca la especialidad
        $oEspecialidades->setId($oProblema->getIdEspecialidad());
        $oEspecialidades=$oMysqlEspecialidad->find($oEspecialidades);  
        /// muestra el problema completo
        echo html_entity_decode($oTProblema->getDescripcion()." ".$oEspecialidades->getDescripcion())."";  
        if($value->getDescripcion())
        echo "<br/><cite>".html_entity_decode($value->getDescripcion())."</cite>";
        echo "<br/>";
        /// si tiene un usuario asignado para la tarea lo muestra                        
        if($value->getUsuarioAsignado()<>null) {
            echo "Personal: ";
            /// busca el nombre del usuario
            $oAsignados = new AsignadosValueObject();
            $oAsignados->setNroOrden($value->getNro());
            $aAsignados = $oMysqlAsignados->findAll($oAsignados);
            if($aAsignados<>false) {
            foreach ($aAsignados as $usuAsig) {                
                $oUsuarios->setId($usuAsig->getIdUsuario());
                $oUsuarios=$oMysqlUsuarios->find($oUsuarios); 
                $oAgentes->setDni($oUsuarios->getDni());
                $oAgentes = $oMysqlAgentes->find($oAgentes);
                echo $oAgentes->getNombre()." - "; 
            }
                /// usuario que inicia la OT
            $oUsuarios = new UsuariosValueObject();
            $oAgentes = new AgentesValueObject();
            $oUsuarios->setId($value->getUsuarioAsignador());
            $oUsuarios=$oMysqlUsuarios->find($oUsuarios); 
            $oAgentes->setDni($oUsuarios->getDni());
            $oAgentes = $oMysqlAgentes->find($oAgentes);            
            echo "Asign&oacute;: ".$oAgentes->getNombre()." (".$value->getFechaAsignacion()." ".$value->getHoraAsignacion().")";
            } else { echo "<cite>Sin Asignar</cite>" ;}
        }             
        if($value->getFormaFinalizacion()==2)
            echo "<br/>Estado: Solucionado (".$value->getFechaFinalizacion()." ".$value->getHoraFinalizacion().")";
        if($value->getFormaFinalizacion()==3)
            echo "<br/>Estado: No Solucionado (".$value->getFechaFinalizacion()." ".$value->getHoraFinalizacion().")";
         if($value->getFormaFinalizacion()==4)
            echo "<br/>Estado: Anulado (".$value->getFechaFinalizacion()." ".$value->getHoraFinalizacion().")";
         if($value->getObservacion())
            echo "<br/><cite>".$value->getObservacion()."</cite>";
        ?>
<!--        <div class="link">
        <a href="../finalizados/ajax_mostrar.php?nro=<?php echo $value->getNro();?>" ><img src="../css/img_estilos/mostrar.png" /></a> 
        </div>-->
        <span style="width:350px;">
            <?php                                 
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
            }
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
            ?>
            </span>
            <?php 
        echo "</div>";
        } ?>

<?php } else {
    echo "No se encontraron movimientos registrados en la fecha seleccionada" ;   
}?>
<br/>

Registros encontrados: <?php echo $i;?><br />                                        