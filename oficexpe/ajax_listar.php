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

$sql = "SELECT o.`ofcodi`, o.`nombre`, o.`domicilio`, o.localiza, l.`descri` AS localidad, d.`descri` AS departamento, o.`tipo`, o.`telefono`, o.fax, o.`email` FROM oficexpe o ";
$sql.= "LEFT JOIN departamentos d ON o.`coddpto`=d.`coddepto` LEFT JOIN localida AS l ON o.`codloc`=l.`codloc` AND o.`coddpto`=l.`coddepto`";
if (isset($_GET['criterio_usu_per']))
        $sql .= " where o.nombre like '%".fn_filtro(substr(utf8_decode ($_GET['criterio_usu_per']), 0, 16))."%'";
if (isset($_GET['criterio_ordenar_por']))
        $sql .= sprintf(" order by %s %s", fn_filtro($_GET['criterio_ordenar_por']), fn_filtro($_GET['criterio_orden']));
else
        $sql .= " order by ofcodi";       

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
                <th>Ofcodi</th>
                <th>Nombre</th>
                <th>Domicilio, Localidad (Departamento)</th>
                <th>Localizacion</th>
                <th>Tipo</th>
                <th>Tel&eacute;fono</th>                               
                <th width="36px"><center><a href="javascript: fn_mostrar_frm_agregar();"><img src="../css/img_estilos/add.png"></a></center></th>
            </tr>
        </thead>
        <tbody>
        <?php
        while ($rs_per = $paging->fetchResultado()) {            
        ?>
        <tr id="tr_<?=$rs_per['ofcodi']?>">
            <td><?=$rs_per['ofcodi']?></td>
            <td style="text-align: left;"><?=htmlentities($rs_per['nombre'])?></td>
            <td style="text-align: left;"><?php
                if($rs_per['domicilio']<>'')
                    echo htmlentities($rs_per['domicilio']).", ";
                echo htmlentities($rs_per['localidad']);
                if($rs_per['departamento'])
                    echo " (".htmlentities($rs_per['departamento']).")"
                        ?></td>
            <td style="text-align: left;"><?=htmlentities($rs_per['localiza'])?></td>
            <td style="text-align: left;"><?php
            switch($rs_per['tipo']) {
                    case 'H': echo "Hospital";break;
                    case 'C': echo "Centro de Salud";break;
                    case 'O': echo "Oficina";break;
            }
            ?>
            </td>
            <td style="text-align: left;"><?=$rs_per['telefono']?></td>            
            <td><a href="javascript: fn_mostrar_frm_modificar(<?=$rs_per['ofcodi']?>);"><img src="../css/img_estilos/page_edit.png" /></a>
            <a href="javascript: fn_eliminar(<?=$rs_per['ofcodi']?>);"><img src="../css/img_estilos/cancela.png" /></a></td>            
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
                                 