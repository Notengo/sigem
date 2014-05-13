<?php	
// Se chequea si existe un login
require_once '../usuarios/aut_verifica.inc.php';

// Se requieren los script para acceder a los datos de la DB
require_once '../ClasesBasicas/ActiveRecordAbstractFactory.php';

$oMysql = ActiveRecordAbstractFactory::getActiveRecordFactory(ActiveRecordAbstractFactory::MYSQL);
$oMysql->conectar();

?>
<h1>Agregar nueva adquiriente de equipo</h1>
<p>Por favor rellene el siguiente formulario</p>
<form action="javascript: fn_agregar();" method="post" id="frm_per">
    <table class="formulario">
        <tbody>           
            <tr>
                <td>Descripci&oacute;n</td>
                <td>
                    <input id="descripcion" name="descripcion" type="text" tabindex="1" size="50" value="" />
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
				descripcion:{
					required: true
				}
			},
			messages: {
				descripcion: "X"
			},
			onkeyup: false,
			submitHandler: function(form) {
				var respuesta = confirm('\xBFDesea realmente agregar el adquiriente?')
				if (respuesta)
					form.submit();
			}
		});
	});
	
	function fn_agregar(){
		var str = $("#frm_per").serialize();
		$.ajax({
			url: 'ajax_agregar_adquiriente.php',
			data: str,
			type: 'post',
			success: function(data){
				if(data != "")
					alert(data);
				fn_cerrar();				
			}
		});
	};
</script>