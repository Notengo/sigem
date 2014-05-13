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
<h1>Agregando nuevo proveedor</h1>
<p>Por favor rellene el siguiente formulario</p>
<form action="javascript: fn_agregar();" method="post" id="frm_per">
    <table class="formulario">
        <tbody>
            <tr>
                <td>Nombre</td>
                <td><input name="nombre" type="text" id="nombre" size="50" class="required" />*</td>
            </tr>
            <tr>
                <td>Due&ntilde;o</td>
                <td><input name="duenio" type="text" id="duenio" size="50"  /></td>
            </tr>
            <tr>
                <td>Direcci&oacute;n</td>
                <td><input name="direccion" type="text" id="direccion" size="50" class="required" />*</td>
            </tr>
            <tr>
                <td>Tel&eacute;fono</td>
                <td><input name="telefono" type="text" id="telefono" size="50"  /></td>
            </tr>
            <tr>
                <td>Fax</td>
                <td><input name="fax" type="text" id="fax" size="50" /></td>
            </tr>            
            <tr>
                <td>Calificaci&oacute;n</td>
                <td><select name="calificacion" ide="calificacion" >
                        <option value="B">Bueno</option>
                        <option value="R">Regular</option>
                        <option value="M">Malo</option>
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
        $(document).ready(function(){
		$("#frm_per").validate({
			rules:{
				nombre:{
					required: true					
				},
                                direccion:{
					required: true					
				}
			},
			messages: {
				nombre: "x",
                                direccion: "x"
			},
			onkeyup: false,
			submitHandler: function(form) {
				var respuesta = confirm('\xBFDesea realmente agregar el proveedor?')
				if (respuesta)
					form.submit();
			}
		});
	});
        
	function fn_agregar(){
		var str = $("#frm_per").serialize();
		$.ajax({
			url: 'ajax_agregar.php',
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