<?php	
// Se chequea si existe un login
require_once '../usuarios/aut_verifica.inc.php';

// Se requieren los script para acceder a los datos de la DB
require_once '../ClasesBasicas/ActiveRecordAbstractFactory.php';
require_once '../Clases/ActiveRecord/MysqlLocalidadActiveRecord.php';
require_once '../Clases/ActiveRecord/MysqlDepartamentoActiveRecord.php';

$oMysql = ActiveRecordAbstractFactory::getActiveRecordFactory(ActiveRecordAbstractFactory::MYSQL);
$oMysql->conectar();

?>
<script language="javascript" type="text/javascript" src="js/select_localidad.js"></script>
<h1>Eliminar objeto de acci&oacute;n</h1>
<p>Por favor rellene el siguiente formulario</p>
<form action="javascript: fn_eliminar();" method="post" id="frm_per">
    <input type="hidden" id="ide_eq" name="ide_eq" value="<?=$_POST['nro']?>" />
    <table class="formulario">
        <tbody>
            <tr>
                <td>Objeto a eliminar</td>
                <td><strong><?php echo $_POST['nro']?></strong></td>
            </tr>
            <tr>
                <td>Motivo</td>
                <td><textarea id="observacion" name="observacion" class="required"></textarea>
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
        $(document).ready(function(){
		$("#frm_per").validate({
			rules:{
				observacion:{
					required: true
				}
			},
			messages: {
				observacion: "X"                               
			},
			onkeyup: false,
			submitHandler: function(form) {
				var respuesta = confirm('\xBFDesea realmente eliminar el equipo?')
				if (respuesta)
					form.submit();
			}
		});
	});
	
	function fn_eliminar(){
		var str = $("#frm_per").serialize();
		$.ajax({
			url: 'ajax_eliminar.php',
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