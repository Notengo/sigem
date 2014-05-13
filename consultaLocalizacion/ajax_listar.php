<?php
// Se chequea si existe un login
require_once '../usuarios/aut_verifica.inc.php';

// Se requieren los script para acceder a los datos de la DB
require_once '../ClasesBasicas/ActiveRecordAbstractFactory.php';
require_once '../Clases/ActiveRecord/MysqlOrdenActiveRecord.php';
include_once "../ClasesBasicas/PHPPaging.lib.php";
require_once 'funciones.php';

header ("Expires: Fri, 14 Mar 1980 20:53:00 GMT"); //la pagina expira en fecha pasada
header ("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); //ultima actualizacion ahora cuando la cargamos
header ("Cache-Control: no-cache, must-revalidate"); //no guardar en CACHE
header ("Pragma: no-cache"); //PARANOIA, NO GUARDAR EN CACHE

$oMysql = ActiveRecordAbstractFactory::getActiveRecordFactory(ActiveRecordAbstractFactory::MYSQL);
$oMysql->conectar();

$departamento = $orden = $busqueda = '';

$departamento = $localidad = $orden = $busqueda = '';
if (isset($_GET['departamento']))
    $departamento = $_GET['departamento']; /// busca por departamento
if (isset($_GET['localidad']))
    $localidad = $_GET['localidad']; /// busca por localidad
if (isset($_GET['oficina_ID']))
    $ofcodi = $_GET['oficina_ID']; /// busca por oficina
if (isset($_GET['tipo']))
    $tipo = $_GET['tipo']; /// busca por tipo
if (isset($_GET['criterio_ordenar_por']))
    $criterio = fn_filtro($_GET['criterio_ordenar_por']);
if (isset($_GET['criterio_orden']))
    $orden = fn_filtro($_GET['criterio_orden']); /// orden en que se van a mostrar los resultados

$sql = "SELECT nro, des_eq, marca.descripcion AS marca, modelo.descripcion AS modelo, nroSerie, oficexpe.nombre AS oficina, 
departamentos.descri AS departamento, localida.descri AS localidad, edad  FROM oficexpe
INNER JOIN ubicacion ON ubicacion.`ofcodi`=oficexpe.`ofcodi`
INNER JOIN equipo ON ubicacion.`idEquipo`=equipo.`id`
LEFT JOIN marca ON marca.`idMarca`=equipo.`idMarca`
INNER JOIN modelo ON modelo.`idModelo`=equipo.`idModelo` 
INNER JOIN nomencl ON equipo.`cod_eq`=nomencl.`cod_eq` 
LEFT JOIN localida ON oficexpe.codloc =localida.`codloc` AND oficexpe.`coddpto`=localida.`coddepto`
LEFT JOIN departamentos ON departamentos.coddepto=oficexpe.coddpto 
WHERE equipo.`fechaBaja`='0000-00-00 00:00:00' ";        

if($departamento<>0){
    $sql.= " AND oficexpe.`coddpto` = ".$departamento;
}
if($localidad<>0){
    $sql.= " AND oficexpe.`codloc` = ".$localidad;
}
if($ofcodi<>0){
    $sql.= " AND oficexpe.`ofcodi` = ".$ofcodi;
}
if($tipo<>0){
    $sql.= " AND nomencl.`tipo` = ".$tipo;
}

if ($criterio<>'') {    
    $sql .= sprintf(" order by %s %s",$criterio, $orden);
} else
    $sql .= " order by equipo.nro ";         

$paging = new PHPPaging;
$paging->agregarConsulta($sql); 
$paging->div('div_listar');
$paging->modo('desarrollo'); 
if (isset($_GET['criterio_mostrar']))
        $paging->porPagina(fn_filtro((int)$_GET['criterio_mostrar']));
$paging->verPost(true);
$paging->mantenerVar("departamento","localidad","oficina_ID","tipo","criterio_ordenar_por", "criterio_orden");
$paging->ejecutar();

$i=0;

if($paging->numTotalRegistros()>0) {

?>   
<table id="grilla" class="lista" width="1000px" style="text-align: left">
<thead>
    <tr>
        <th>NRO</th>               
        <th>Nomenclador</th>
        <th>Marca | Modelo | Serie</th>
        <th>Ubicaci&oacute;n</th>                                  
        <th width="74px;">Antigüedad</th>        
    </tr>
</thead>
<tbody>
<?php
while ($rs_res = $paging->fetchResultado()) {              
    $i++;
    ?>
    <tr ><td align="center"><?=$rs_res['nro']?></td>                
        <td><?=htmlentities($rs_res['des_eq'])?></td>
        <td><?=htmlentities($rs_res['marca']." | ".$rs_res['modelo']." | ".$rs_res['nroSerie'])?></td>
        <td><?=htmlentities($rs_res['oficina']." ".$rs_res['departamento']." ".$rs_res['localidad'])?></td>
        <td><?=calculaedad($rs_res['edad'])?></td>        
    </tr>
        <?php }  
    ?>
    </tbody>
    </table>
    <?php
    echo $paging->fetchNavegacion();
} else {
    echo "No se encontraron registros asociados a la b&uacute;squeda seleccionada<br/>" ;
}?>
<br/><br/>
Total de registros encontrados: <?php echo $paging->numTotalRegistros();?><br />                   