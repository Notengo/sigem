<?php	
// Se chequea si existe un login
require_once '../usuarios/aut_verifica.inc.php';

// Se requieren los script para acceder a los datos de la DB
require_once '../ClasesBasicas/ActiveRecordAbstractFactory.php';

if(isset($_POST['ide_tipo'])) {
    $uso = $_POST['ide_tipo'];        
} else {
    echo "Ha ocurrido un error intentando abrir la ventana";
    die();
}

$oMysql = ActiveRecordAbstractFactory::getActiveRecordFactory(ActiveRecordAbstractFactory::MYSQL);
$oMysql->conectar();  

?>
<h1>Agregar nueva Marca</h1>
<p>Por favor rellene el siguiente formulario</p>
<form action="javascript: fn_agregar();" method="post" id="frm_per">
    <input type="hidden" value="<?php echo $uso?>" name="tipo">
    <table class="formulario">
        <tbody>
            <tr>
                <td>Marca</td>
                <td><input name="marca" type="text" id="nro" size="50" class="required" />*</td>
            </tr>
            <tr>
                <td>Modelo</td>
                <td><input name="modelo" type="text" id="nro" size="50" class="required" />*</td>
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
	function fn_agregar(){
		var str = $("#frm_per").serialize();
		$.ajax({
			url: 'ajax_agregar_marca.php',
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