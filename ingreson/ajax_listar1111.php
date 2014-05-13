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
require_once '../Clases/ActiveRecord/MysqlUsuariosEquiposActiveRecord.php';
require_once '../Clases/ActiveRecord/MysqlOficexpeActiveRecord.php';
require_once '../Clases/ActiveRecord/MysqlAgentesActiveRecord.php';
require_once '../Clases/ActiveRecord/MysqlAsignadosActiveRecord.php';
require_once '../Clases/ActiveRecord/MysqlEquipoActiveRecord.php';
include_once 'funciones.php';

header ("Expires: Fri, 14 Mar 1980 20:53:00 GMT"); //la pagina expira en fecha pasada
header ("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); //ultima actualizacion ahora cuando la cargamos
header ("Cache-Control: no-cache, must-revalidate"); //no guardar en CACHE
header ("Pragma: no-cache"); //PARANOIA, NO GUARDAR EN CACHE


$oMysql = ActiveRecordAbstractFactory::getActiveRecordFactory(ActiveRecordAbstractFactory::MYSQL);
$oMysql->conectar();

$criterio = $orden = '';
if (isset($_GET['criterio_ordenar_por']))
    $criterio = fn_filtro($_GET['criterio_ordenar_por']); /// porque quiero ordenar
if (isset($_GET['criterio_orden']))
    $orden = fn_filtro($_GET['criterio_orden']); /// orden en que se van a mostrar los resultados

$oMysqlOrden = $oMysql->getOrdenActiveRecord();
$oOrden = new OrdenValueObject();
if($_SESSION['usuario_nivel']=='N') {
    $oOrden->setUsuarioAsignado($_SESSION['usuario_id']);
}

$estado=1;
$aOrden = $oMysqlOrden->findAllPorCriterio($criterio, $orden, $oOrden, $estado);

$oMysqlEquipo = $oMysql->getEquipoActiveRecord();
$oEquipo = new EquipoValueObject();

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

$i=0;

if(count($aOrden)<>0) {   
?>
<script type="text/javascript">
function confirmacion(id,usuario) {
	var answer = confirm("¿Asignarse la tarea?")
	if (answer){	
            fn_agregar(id,usuario);
	}
}

function fn_agregar(id,usuario){
            var str = $("#asignar").serialize();
            $.ajax({
                    url: 'ajax_asignar.php?orden='+id+"&usuario="+usuario,
                    data: str,
                    type: 'post',
                    success: function(data){
                            if(data != "")
                                    alert(data);
                            else
                                alert('Datos guardados correctamente');
                            fn_cerrar();
                            fn_buscar();
                    }
            });
    };
</script>
<script>
function imprimir(que) {
var ventana = window.open("", "", "");
var contenido = "<html><head><link rel='stylesheet' href='../css/printPendiente.css' type='text/css' media='print'/></head><body onload='window.print();'>" + document.getElementById(que).innerHTML + "</body></html>";
ventana.document.open();
ventana.document.write(contenido);
ventana.document.close();}
</script>
<div align="right" style="margin-right:0px;">
        
</div>
<br/>
<div id="informe">
<table id="grilla" class="lista" width="1010px" style="text-align: left">
<thead>
    <tr><th></th>
        <th>Prioridad</th>
        <th>Nro</th>
        <th width="100px">Fecha</th>
        <th id="boton">Hora</th>        
        <th width="250px">Problema</th>
        <th></th>
        <th>Oficina</th>                    
        <th width="68px">Asignado</th>
        <th width="77px" id="boton"><center><a href="../generar" ><img src="../css/img_estilos/add.png" title="Nueva OT"></a>&nbsp;&nbsp;|&nbsp;&nbsp;
		<a href="javascript:imprimir('informe')"><img src="../css/img_estilos/imprimir.gif" alt="Imprimir" title="Imprimir OT"></a></center></th>
    </tr>
</thead>
<tbody>
<?php
foreach ($aOrden as $value) {
    $asig=0;
    $i++;
    
?>
    <tr id="tr_<?=$value->getNro()?>">
        <td>
        <?php        
        $oAsignados = new AsignadosValueObject();            
        $oAsignados->setNroOrden($value->getNro());
        $oAsignados->setIdUsuario($_SESSION['usuario_id']);        
        if($oMysqlAsignados->find($oAsignados)==true)
         { $asig=1;?>
            <img src="../css/img_estilos/atencion.png" />
        <?php } ?>
        </td>
        <?php 
            if($value->getPrioridad()==2)
                echo "<td class=urg5>Alta</td>";
            if($value->getPrioridad()==1)
                echo "<td class=urg3>Media</td>";
            if($value->getPrioridad()==0)
                echo "<td class=urg1>Baja</td>";
        ?>
        <td align="center"><?=$value->getNro()?></td>
        <td><?=$value->getFechaInicio()?></td>
        <td id="boton"><?=$value->getHoraInicio()?></td>       
        <td >
            <div id="popup">            
            <a href="ajax_mostrar.php?nro=<?php echo $value->getNro();?>" ><img src="../css/img_estilos/mostrar.png" />
                <?php
            $oProblema->setId($value->getIdProblema());
            $oProblema=$oMysqlProblema->find($oProblema);  
            /// busca el tipo de problema
            $oTProblema->setId($oProblema->getIdTProblema());
            $oTProblema=$oMysqlTProblema->find($oTProblema);              
            // busca la especialidad
            $oEspecialidades->setId($oProblema->getIdEspecialidad());
            $oEspecialidades=$oMysqlEspecialidad->find($oEspecialidades);  
            /// muestra el problema completo
            echo html_entity_decode($oTProblema->getDescripcion()." ".$oEspecialidades->getDescripcion()); 
            ?>
            <span style="width:350px;">
            <?php        
             
            echo "<cite>".html_entity_decode($value->getDescripcion())."</cite>";
            if($value->getObservacion()<>'')
                echo "<br/>Obs.: <cite>".html_entity_decode($value->getObservacion())."</cite>";
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
            $oUsuariosA = new UsuariosValueObject();
            $oAgentesA = new AgentesValueObject();
            $oUsuariosA->setId($value->getUsuarioAlta());
            $oUsuariosA=$oMysqlUsuarios->find($oUsuariosA); 
            $oAgentesA->setDni($oUsuariosA->getDni());
            $oAgentesA = $oMysqlAgentes->find($oAgentesA);
            echo "<br/>Registrador: ".$oAgentesA->getNombre(); 
            ?>
            </span>
            </a>
            </div>
        </td>  
        <td><?php if($value->getEquipo()) {?>
            <a href="../consultaTabEquipo/otAsociadas.php?id=<?=$oEquipo->getId();?>"><img src="../images/verdetalle.png" alt="Imprimir" title="Ver ficha equipo"></a>                                   
        <?php }?>
        </td>
        <td id="mostrar"><?php
            $oOficina->set_ofcodi($value->getOfcodi());
            $oOficina=$oMysqlOficexpe->findCompleta($oOficina);    
            $nombre = html_entity_decode($oOficina->get_nombre())." - ".$oOficina->get_tipo()." de ".$oOficina->get_codloc();
            echo htmlentities($nombre);                
        ?></td>       
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
                echo $oAgentes->getNombre()."<br/>"; 
            }          
            unset($oAgentes);
            ?>
            <?php
        } else { 
            if($_SESSION['usuario_nivel']=='N') { ?>
            <a href="javascript: confirmacion(<?php echo $value->getNro()?>,<?php echo $_SESSION['usuario_id']?>);"><img src="../css/img_estilos/asignar.png" title="Asignar OT"/></a>    
                    <?php             
            } else {?>
                    <a href="javascript: fn_mostrar_frm_asignar(<?=$value->getNro(). ",". $value->getOfcodi().", ". $oEspecialidades->getId()?>)"><img src="../css/img_estilos/asignar.png" title="Asignar OT"/></a>    
                    <?php                             
            }             
        } ?>
                    
        </td>
        <td>
            <a href="verImpresion.php?nro=<?php echo $value->getNro()?>"><img src="../css/img_estilos/imprimir.gif" alt="Imprimir" title="Imprimir OT"></a>
            <?php                 
            if(($_SESSION['usuario_nivel']=='Z')||($asig==1)||($_SESSION['usuario_id']==$value->getUsuarioAlta())) {
            ?><a href="modificar.php?nro=<?=$value->getNro()?>"><img src="../css/img_estilos/change.png" title="Modificar OT"/></a>                    
            <?php
            }            
            if(($asig==1)||($_SESSION['usuario_nivel']=='Z')) { ?>                       
            <a href="javascript: fn_mostrar_frm_estado(<?=$value->getNro()?>);"><img src="../css/img_estilos/page_edit.png" /></a>            
            <?php }
              if(($_SESSION['usuario_nivel']=='Z')&&($value->getUsuarioAsignado()<>0)) {
                ?><a href="javascript: fn_mostrar_frm_modificar(<?=$value->getNro(). ",". $value->getOfcodi().", ". $oEspecialidades->getId()?>)"><img src="../css/img_estilos/modificar.gif" title="Modificar Asignaci&oacute;n de OT"/></a>    
            <?php
            }

            ?>     
            
        </td>
    </tr>
<?php } ?>
</tbody>
</table>
</div>
<?php } else {
    echo "No se encontraron registros pendientes" ;
}?>
<br/>
Registros encontrados: <?php echo $i;?><br />                                        