<?php
// Se chequea si existe un login
require_once '../usuarios/aut_verifica.inc.php';

header ("Expires: Fri, 14 Mar 1980 20:53:00 GMT"); //la pagina expira en fecha pasada
header ("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); //ultima actualizacion ahora cuando la cargamos
header ("Cache-Control: no-cache, must-revalidate"); //no guardar en CACHE
header ("Pragma: no-cache"); //PARANOIA, NO GUARDAR EN CACHE

require_once '../ClasesBasicas/ActiveRecordAbstractFactory.php';
include_once "../ClasesBasicas/PHPPaging.lib.php";
require_once '../includes/funciones.php';

$oMysql = ActiveRecordAbstractFactory::getActiveRecordFactory(ActiveRecordAbstractFactory::MYSQL);
$oMysql->conectar();

$sql = "SELECT e.id, e.nro, e.`nroSerie`, n.`des_eq`, m.`descripcion` AS marca, modelo.descripcion AS modelo, o.nombre AS ubicacion, s.descripcion as servicio, u.subServicio FROM equipo e ";
$sql.= " LEFT JOIN nomencl n ON e.`cod_eq`=n.`cod_eq`";
$sql.= " LEFT JOIN marca AS m ON e.`idMarca`=m.`idMarca` ";
$sql.= " LEFT JOIN modelo AS modelo ON e.`idModelo`=modelo.idModelo ";
$sql.= " LEFT JOIN ubicacion AS u ON e.`id`=u.`idEquipo`  ";
$sql.= " LEFT JOIN servicio s ON u.`idServicio`=s.`idServicio`";
$sql.= " LEFT JOIN oficexpe AS o ON u.`ofcodi`=o.ofcodi WHERE e.fechaBaja='0000-00-00 00:00:00' ";
if ((is_numeric($_GET['criterio_usu_per'])))
        $sql .= " AND e.nro = '".$_GET['criterio_usu_per']."'";
else if($_GET['criterio_usu_per']<>'') {
        $sql .= " AND n.des_eq like '%".fn_filtro(substr(utf8_decode($_GET['criterio_usu_per']), 0, 16))."%' or m.descripcion like '%".fn_filtro(substr(utf8_decode($_GET['criterio_usu_per']), 0, 16))."%' or modelo.descripcion like '%".fn_filtro(substr(utf8_decode($_GET['criterio_usu_per']), 0, 16))."%' or o.nombre like '%".fn_filtro(substr(utf8_decode($_GET['criterio_usu_per']), 0, 16))."%'";    
}
if (isset($_GET['criterio_ordenar_por']))
        $sql .= sprintf(" order by %s %s", fn_filtro($_GET['criterio_ordenar_por']), fn_filtro($_GET['criterio_orden']));
else
        $sql .= " order by nro desc";       

$paging = new PHPPaging;
$paging->agregarConsulta($sql); 
$paging->div('div_listar');
$paging->modo('publicacion'); 
if (isset($_GET['criterio_mostrar']))
        $paging->porPagina(fn_filtro((int)$_GET['criterio_mostrar']));
$paging->verPost(true);
$paging->mantenerVar("criterio_usu_per", "criterio_ordenar_por", "criterio_orden", "criterio_mostrar");
$paging->ejecutar();

if($paging->numTotalRegistros()>0) {
    ?>
    <table id="grilla" class="lista" width="1000px">
        <thead>
            <tr>
                <th>NRO</th>
                <th>Nomenclador</th>
                <th>Marca | Modelo | Serie</th>
                <th>Ubicaci&oacute;n</th>                
                <th width="36px"><center><a href="../equipoGenerar"><img src="../css/img_estilos/add.png"></a></center></th>
            </tr>
        </thead>
            <tbody>
            <?php
            while ($rs_res = $paging->fetchResultado()) {            
            ?>
            <tr>
                <td><?=$rs_res['nro']?></td>
                <td style="text-align: left;"><?=utf8_encode($rs_res['des_eq'])?></td>
                <td style="text-align: left;"><?php echo utf8_encode($rs_res['marca'])." ".utf8_encode($rs_res['modelo'])." ".$rs_res['nroSerie']; ?></td>            
                <td style="text-align: left;"><?=$rs_res['ubicacion']."<br/>".$rs_res['servicio'];
                if($rs_res['subServicio'])
                    echo " - Sala: ".$rs_res['subServicio']?>
                </td>            
                <td>
                    <a href="../equipoGenerar/index.php?cambio=1&nro=<?=$rs_res['nro']?>"><img src="../css/img_estilos/page_edit.png" /></a>
                    <a href="javascript: fn_mostrar_frm_eliminar(<?=$rs_res['nro']?>);"><img src="../css/img_estilos/cancela.png" alt="Eliminar" title="Eliminar equipo" /></a>                        
                </td>            
            </tr>
        <?php } ?>
        </tbody>
    </table>
    <br/>
    <?php        
    echo $paging->fetchNavegacion();
} else {
    echo "No se encontraron registros" ;
}    ?>
<br/><br/>
Total de registros encontrados: <?php echo $paging->numTotalRegistros();?><br />                                                                        