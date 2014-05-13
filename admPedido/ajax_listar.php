<?php
// Se chequea si existe un login
require_once '../usuarios/aut_verifica.inc.php';

header ("Expires: Fri, 14 Mar 1980 20:53:00 GMT"); //la pagina expira en fecha pasada
header ("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); //ultima actualizacion ahora cuando la cargamos
header ("Cache-Control: no-cache, must-revalidate"); //no guardar en CACHE
header ("Pragma: no-cache"); //PARANOIA, NO GUARDAR EN CACHE

require_once '../ClasesBasicas/ActiveRecordAbstractFactory.php';
include_once "../ClasesBasicas/PHPPaging.lib.php";
require_once 'funciones.php';

$oMysql = ActiveRecordAbstractFactory::getActiveRecordFactory(ActiveRecordAbstractFactory::MYSQL);
$oMysql->conectar();

$sql = "SELECT * FROM pedido as p";
if($_GET['criterio_usu_per'] <> '') {
    $sql .= " WHERE p.descripcion like '%".fn_filtro(substr(utf8_decode($_GET['criterio_usu_per']), 0, 16))."%' ";
}
if (isset($_GET['criterio_ordenar_por']))
    $sql .= sprintf(" order by %s %s", fn_filtro($_GET['criterio_ordenar_por']), fn_filtro($_GET['criterio_orden']));
else
    $sql .= " order by id desc";


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
                <th>Pedido</th>
                <th width="36px"><center><a href="javascript: fn_mostrar_frm_agregar();"><img src="../css/img_estilos/add.png"></a></center></th>
            </tr>
        </thead>
            <tbody>
            <?php
            while ($rs_res = $paging->fetchResultado()) {            
            ?>
            <tr>                
                <td style="text-align: left;"><?=htmlentities($rs_res['descripcion'])?></td>                
                <td>
                    <a href="javascript: fn_mostrar_frm_modificar(<?=$rs_res['id']?>);"><img src="../css/img_estilos/page_edit.png" /></a>
                    <a href="javascript: fn_eliminar(<?=$rs_res['id']?>);"><img src="../css/img_estilos/cancela.png" /></a>
                </td>            
            </tr>
        <? } ?>        
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

                                 