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
<h1>Agregar nueva Orden de Compra</h1>
<p>Por favor rellene el siguiente formulario</p>
<form action="javascript: fn_agregar();" method="post" id="frm_per">
    <table class="formulario">
        <tbody>
            <tr>
                <td>N&uacute;mero</td>
                <td><input name="nro" type="text" id="nro" size="50" class="required" />*</td>
            </tr>
            <tr>
                <td>Fecha Compra</td>
                <td>
                <input id="fecha" name="fecha" type="text" tabindex="5" size="7" value="<?php echo date('d/m/Y') ?>" onblur="validar_fecha(this);" />*
                <cite style="color:grey; font-size: 11px;">(dd/mm/aaaa)</cite>
                </td>
            </tr>
            <tr>
                <td>Proveedor</td>
                <td>                    
                    <?php
                    require_once '../ClasesBasicas/proveedor.php';
                    $deno = new proveedor();
                    $prov = $deno->findAll();
                    ?>
                    <select name="proveedor" size="10" style="width: 350px;">
                        <option value="0" selected>Seleccione...</option>
                        <?php
                        foreach($prov as $proveedor) {
                            $idprov= $proveedor->id;
                            echo '<option value="' .$idprov . '">' .
                                htmlentities($proveedor->nombre).' | '. htmlentities($proveedor->duenio) . '</option>';
                        }
                        ?>
                    </select>                
                *</td>
            </tr>                        
            <tr>
                <td>Observacion</td>
                <td><textarea name="observacion" id="observacion" rows="2" cols="40" style="border-color: grey;" ></textarea></td>
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
			url: 'ajax_agregar.php',
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