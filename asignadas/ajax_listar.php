<?php
// Se chequea si existe un login
require_once '../usuarios/aut_verifica.inc.php';

// Se requieren los script para acceder a los datos de la DB
require_once '../ClasesBasicas/ActiveRecordAbstractFactory.php';
require_once '../Clases/ActiveRecord/MysqlOrden.php';
require_once '../Clases/ActiveRecord/MysqlEquipoActiveRecord.php';
require_once '../Clases/ActiveRecord/MysqlNomenclActiveRecord.php';
require_once '../Clases/ActiveRecord/MysqlOficexpeActiveRecord.php';

//require_once '../Clases/ActiveRecord/MysqlProblemaActiveRecord.php';
//require_once '../Clases/ActiveRecord/MysqlTProblemaActiveRecord.php';
//require_once '../Clases/ActiveRecord/MysqlEspecialidadesActiveRecord.php';
//require_once '../Clases/ActiveRecord/MysqlUsuariosActiveRecord.php';
//require_once '../Clases/ActiveRecord/MysqlUsuariosEquiposActiveRecord.php';
//require_once '../Clases/ActiveRecord/MysqlAgentesActiveRecord.php';
//require_once '../Clases/ActiveRecord/MysqlAsignadosActiveRecord.php';
//require_once '../Clases/ActiveRecord/MysqlHistorialActiveRecord.php';
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
$oOrden = new Orden();
if($_SESSION['usuario_nivel']=='N') {
    $oOrden->setUsuarioAsignado($_SESSION['usuario_id']);
}

$estado=1;
$aOrden = $oMysqlOrden->findAllPorCriterio($criterio, $orden, $oOrden, $estado);

$oMysqlEquipo = $oMysql->getEquipoActiveRecord();
$oEquipo = new EquipoValueObject();

$oMysqlNomencla = $oMysql->getNomenclActiveRecord();
$oNomencaldor = new NomenclValueObject();

$oMysqlOficexpe = $oMysql->getOficexpeActiveRecord();
$oOficina = new OficexpeValueObject();

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
<div align="right" style="margin-right:0px;"></div>
<br/>
<div id="informe">
<table id="grilla" class="lista" width="1010px" style="text-align: left">
    <thead>
        <tr>
            <!--<th width="100px"></th>-->
            <th width="40px">Prioridad</th>
            <th width="50px">Nro</th>
            <th width="80px">Fecha</th>
            <th width="250px">Oficina</th>
            <th width="150px">Equipo</th>
            <th width="150px">Asignado</th>
            <th width="98px" id="boton">
                <center>
                    <a href="../generar" >
                        <img src="../css/img_estilos/add.png" title="Nueva OT">
                    </a>
                    &nbsp;&nbsp;|&nbsp;&nbsp;
                    <a href="javascript:imprimir('informe')">
                        <img src="../css/img_estilos/imprimir.gif" alt="Imprimir" title="Imprimir OT">
                    </a>
                </center>
            </th>
        </tr>
    </thead>
    <tbody>
        <?php
//        $oHistorial = new HistorialValueObject();
//        $oMysqlHistorial = $oMysql->getHistorialActiveRecord();
        foreach ($aOrden as $value) {
            $asig = 0;
            $i++;
        ?>
        <tr id="tr_<?=$value->getIdorden()?>">
            <?php
            if($value->getPrioridad() == 2)
                echo "<td class=urg5>Alta</td>";
            if($value->getPrioridad() == 1)
                echo "<td class=urg3>Media</td>";
            if($value->getPrioridad() == 0)
                echo "<td class=urg1>Baja</td>";
            ?>
            <td align="center"><?=$value->getIdorden()?></td>
            <td>
                    <?=$value->getFecha()?>
            </td>
        <td id="mostrar"><?php
            $oOficina->set_ofcodi($value->getOfcodi());
            $oOficina=$oMysqlOficexpe->findCompleta($oOficina);    
            $nombre = html_entity_decode($oOficina->get_nombre())." - ".$oOficina->get_tipo()." de ".$oOficina->get_codloc();
            echo htmlentities($nombre);
        ?></td>
        <td><?php if($value->getIdEquipo()) {?>
            <?php
            $oEquipo->setId($value->getIdEquipo());
            $oEquipo = $oMysqlEquipo->findPorId($oEquipo);
            $oNomencaldor->setCod_eq($oEquipo->getCod_eq());
            $oNomencaldor = $oMysqlNomencla->findId($oNomencaldor);
            echo htmlentities($oNomencaldor->getDes_eq());
            ?>
            <!--<a href="../consultaTabEquipo/otAsociadas.php?id=<?//=$oEquipo->getId();?>" <img src="../images/verdetalle.png" alt="Imprimir" title="Ver ficha equipo"></a>-->
        <?php }?>
        </td>
        <td>
            <select>
                <option value="0">Asignar...</option>
                <option value="1">Martin</option>
                <option value="2">Leandro</option>
                <option value="3">Juan Pablo</option>
            </select>
            <a><img src="../css/img_estilos/asignar.png" title="Asignar OT"/></a>
        </td>
        <td>
            <a href="verImpresion.php?nro=<?php echo $value->getIdorden(); ?>"><img src="../css/img_estilos/imprimir.gif" alt="Imprimir" title="Imprimir OT"></a>
            <a href="javascript: fn_mostrar_frm_historial(<?=$value->getIdorden(); ?>);"><img src="../css/img_estilos/historial.gif" alt="Historial" title="Nueva entrada historial" /></a>                        
            <?php                 
            if(($_SESSION['usuario_nivel']=='Z')||($asig==1)||($_SESSION['usuario_id']==$value->getUsuarioAlta())) {
            ?><a href="modificar.php?nro=<?=$value->getIdorden(); ?>"><img src="../css/img_estilos/change.png" title="Modificar OT"/></a>                    
            <?php
            }            
            if(($asig==1)||($_SESSION['usuario_nivel']=='Z')) { ?>                       
            <a href="javascript: fn_mostrar_frm_estado(<?=$value->getIdorden(); ?>);"><img src="../css/img_estilos/page_edit.png" /></a>            
            <?php }
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