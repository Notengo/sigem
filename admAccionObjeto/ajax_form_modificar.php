<?php
require_once '../ClasesBasicas/ActiveRecordAbstractFactory.php';
require_once '../Clases/ActiveRecord/MysqlLocalidadActiveRecord.php';
require_once '../Clases/ActiveRecord/MysqlDepartamentoActiveRecord.php';
include_once 'funciones.php';

$oMysql = ActiveRecordAbstractFactory::getActiveRecordFactory(ActiveRecordAbstractFactory::MYSQL);
$oMysql->conectar();

$sql = sprintf("SELECT * FROM accionobjeto WHERE idAccionObjeto = %d", (int)$_POST['ide_per']);

$per = mysql_query($sql);
$num_rs_per = mysql_num_rows($per);
if ($num_rs_per==0){
    echo "No existen Objetos de Acciones con ese ID";
    exit;
}

$rs_per = mysql_fetch_assoc($per);
	
?>
<h1>Modificaci&oacute;n objetos de acciones</h1>
<p>Por favor rellene el siguiente formulario</p>
<form action="javascript: fn_modificar();" method="post" id="frm_per">
    <input type="hidden" id="idAccionObjeto" name="idAccionObjeto" value="<?=$rs_per['idAccionObjeto']?>" />
    <table class="formulario">
        <tbody>
            <tr>
                <td>Acci&oacute;n</td>
                <td><input name="nombre" type="text" id="nombre" size="50" class="required" value="<?=htmlentities($rs_per['descripcion'])?>"/>*</td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="2">
                    <input name="Modificar" type="submit" id="agregar" value="&nbsp;&nbsp;&nbsp;Agregar&nbsp;&nbsp;&nbsp;" class="button"/>
                    <input name="cancelar" type="button" id="cancelar" value="&nbsp;&nbsp;&nbsp;Cancelar&nbsp;&nbsp;&nbsp;" onclick="fn_cerrar();" class="button"/>
                </td>
            </tr>
        </tfoot>
    </table>
</form>
<script language="javascript" type="text/javascript">
    function fn_modificar(){
        var str = $("#frm_per").serialize();
        $.ajax({
            url: 'ajax_modificar.php',
            data: str,
            type: 'post',
            success: function(data){
                if(data !== "")
                    alert(data);
                fn_cerrar();
                fn_buscar();
            }
        });
    };
</script>