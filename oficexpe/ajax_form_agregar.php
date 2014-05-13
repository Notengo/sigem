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
<h1>Agregando nueva dependencia</h1>
<p>Por favor rellene el siguiente formulario</p>
<form action="javascript: fn_agregar();" method="post" id="frm_per">
    <table class="formulario">
        <tbody>
            <tr>
                <td>Nombre</td>
                <td><input name="nombre" type="text" id="nombre" size="50" class="required" />*</td>
            </tr>
            <tr>
                <td>Tipo</td>
                <td><select name="tipo" ide="tipo" class="required">
                        <option value="H">Hospital</option>
                        <option value="C">Centro de Salud</option>
                        <option value="O">Oficina</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Domicilio</td>
                <td><input name="domicilio" type="text" id="domicilio" size="40"  />*</td>
            </tr>
            <tr>
                <td>Departamento</td>
                <td>
                    <select name="departamento" id="departamento" class="required" onChange='cargaContenido(this.id)'>            
                    <option value="0">Seleccione</option>
                    <?php
                    $oMysqlDpto = $oMysql->getDepartamentoActiveRecord();
                    $oDpto = new DepartamentoValueObject();                                               
                    $oDpto = $oMysqlDpto->findAll();                        
                    foreach ($oDpto as $fila){
                        ?>
                        <option value='<?php echo $fila->getCoddpto() ?>' ><?php echo htmlentities($fila->getDescri()) ?></option>
                        <?php
                    }
                    ?>
                    </select>
                *</td>
            </tr>            
            <tr>
                <td>Localidad</td>
                <td>
                    <?php            
                    echo "<div>";
                    echo "<select disabled='disabled' name='localidad' id='localidad' >";
                    echo "<option value=0>Seleccione</option>";
                    echo "</select>*";
                    echo "</div>";
                    ?>
                </td>
            </tr>    
            <tr>
                <td>Localizaci&oacute;n</td>
                <td><input name="localiza" type="text" id="localiza" size="30"  /></td>
            </tr>
            <tr>
                <td>Tel&eacute;fono</td>
                <td><input name="telefono" type="text" id="telefono" size="30"  /></td>
            </tr>            
            <tr>
                <td>E-mail</td>
                <td><input name="email" type="text" id="email" size="50" /></td>
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
				fn_buscar();
			}
		});
	};
</script>