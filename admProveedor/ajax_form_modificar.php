<?php
require_once '../ClasesBasicas/ActiveRecordAbstractFactory.php';
require_once '../Clases/ActiveRecord/MysqlLocalidadActiveRecord.php';
require_once '../Clases/ActiveRecord/MysqlDepartamentoActiveRecord.php';
include_once 'funciones.php';

$oMysql = ActiveRecordAbstractFactory::getActiveRecordFactory(ActiveRecordAbstractFactory::MYSQL);
$oMysql->conectar();

$sql = sprintf("select * from proveedor where id=%d",
        (int)$_POST['ide_per']
);
$per = mysql_query($sql);
$num_rs_per = mysql_num_rows($per);
if ($num_rs_per==0){
        echo "No existen proveedores con ese ID";
        exit;
}

$rs_per = mysql_fetch_assoc($per);
	
?>
<h1>Modificaci&oacute;n de proveedores</h1>
<p>Por favor rellene el siguiente formulario</p>
<form action="javascript: fn_modificar();" method="post" id="frm_per">
    <input type="hidden" id="id" name="id" value="<?=$rs_per['id']?>" />
    <table class="formulario">
        <tbody>
            <tr>
                <td>Nombre</td>
                <td><input name="nombre" type="text" id="nombre" size="50" class="required" value="<?=htmlentities($rs_per['nombre'])?>"/>*</td>
            </tr>
            <tr>
                <td>Due&ntilde;o</td>
                <td><input name="duenio" type="text" id="duenio" size="50" value="<?=htmlentities($rs_per['duenio'])?>" /></td>
            </tr>
            <tr>
                <td>Direcci&oacute;n</td>
                <td><input name="direccion" type="text" id="direccion" size="50" class="required" value="<?=htmlentities($rs_per['direccion'])?>"/>*</td>
            </tr>
             <tr>
                <td>Tel&eacute;fono</td>
                <td><input name="telefono" type="text" id="telefono" size="50"  value="<?=htmlentities($rs_per['telefono'])?>"/></td>
            </tr>
            <tr>
                <td>Fax</td>
                <td><input name="fax" type="text" id="fax" size="50" value="<?=htmlentities($rs_per['fax'])?>"/></td>
            </tr>            
            <tr>
                <td>Calificaci&oacute;n</td>
                <td><select name="calificacion" ide="calificacion" >
                        <option value="B" <?php if($rs_per['referencia']=='B') echo "selected"?> >Bueno</option>
                        <option value="R" <?php if($rs_per['referencia']=='R') echo "selected"?> >Regular</option>
                        <option value="M" <?php if($rs_per['referencia']=='M') echo "selected"?> >Malo</option>
                    </select>
                </td>
            </tr>  
        </tbody>
        <tfoot>
            <tr>
                <td colspan="2">
                    <input name="agregar" type="submit" id="agregar" value="&nbsp;&nbsp;&nbsp;Agregar&nbsp;&nbsp;&nbsp;" class="button"/>
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
				if(data != "")
					alert(data);
				fn_cerrar();
				fn_buscar();
			}
		});
	};
</script>