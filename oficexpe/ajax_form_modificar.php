<?php
require_once '../ClasesBasicas/ActiveRecordAbstractFactory.php';
require_once '../Clases/ActiveRecord/MysqlLocalidadActiveRecord.php';
require_once '../Clases/ActiveRecord/MysqlDepartamentoActiveRecord.php';
include_once 'funciones.php';

$oMysql = ActiveRecordAbstractFactory::getActiveRecordFactory(ActiveRecordAbstractFactory::MYSQL);
$oMysql->conectar();

$sql = sprintf("select * from oficexpe where ofcodi=%d",
        (int)$_POST['ide_per']
);
$per = mysql_query($sql);
$num_rs_per = mysql_num_rows($per);
if ($num_rs_per==0){
        echo "No existen dependencias con ese IDE";
        exit;
}

$rs_per = mysql_fetch_assoc($per);
	
?>
<h1>Modificaci&oacute;n de dependencias</h1>
<p>Por favor rellene el siguiente formulario</p>
<form action="javascript: fn_modificar();" method="post" id="frm_per">
	<input type="hidden" id="ofcodi" name="ofcodi" value="<?=$rs_per['ofcodi']?>" />
    <table class="formulario">
        <tbody>
            <tr>
                <td>Depend. Nro. </td>
                <td><strong><?=$rs_per['ofcodi']?></strong></td>
            </tr>
            <tr>
                <td>Nombre</td>
                <td><input name="nombre" type="text" id="nombre" size="50" class="required" value="<?=htmlentities($rs_per['nombre'])?>" />*</td>
            </tr>
            <tr>
                <td>Tipo</td>
                <td><select name="tipo" id="tipo" class="required">
                        <option value="H" <? if($rs_per['tipo']=="H") echo "selected='selected'";?>>Hospital</option>
                        <option value="C" <? if($rs_per['tipo']=="C") echo "selected='selected'";?>>Centro de Salud</option>
                        <option value="O" <? if($rs_per['tipo']=="O") echo "selected='selected'";?>>Oficina</option>
                    </select>*
                </td>
            </tr>
            <tr>
                <td>Domicilio</td>
                <td><input name="domicilio" type="text" id="domicilio" size="40" class="required" value="<?=htmlentities($rs_per['domicilio'])?>" />*</td>
            </tr>
            <tr>
                <td>Departamento</td>
                <td>
                    <select name="departamento" id="departamento" class="required" onChange='cargaContenido(this.id)'>            
                    <?php
                    $oMysqlDpto = $oMysql->getDepartamentoActiveRecord();
                    $oDpto = new DepartamentoValueObject();                                               
                    $oDpto = $oMysqlDpto->findAll();                        
                    foreach ($oDpto as $fila){
                        ?>
                        <option value='<?php echo $fila->getCoddpto() ?>' <?php if($fila->getCoddpto()==$rs_per['coddpto']) echo "selected='selected'";?> ><?php echo htmlentities($fila->getDescri()) ?></option>
                        <?php
                    }

                    ?>
                    </select>*
                </td>
            </tr>            
            <tr>
                <td>Localidad</td>
                <td>
                <?php            
                echo "<div>";
                echo "<select name='localidad' id='localidad' >";
                $oMysqlLocalidad = $oMysql->getLocalidadActiveRecord();
                $oLocalidad = new LocalidadValueObject();

                $oLocalidad->setCodloc($rs_per['codloc']);
                $oLocalidad->setCoddpto($rs_per['coddpto']);
                $oLocalidad = $oMysqlLocalidad->find($oLocalidad);
                echo "<option value=".$rs_per['codloc'].">".$oLocalidad->getDescri()."</option>";
                echo "</select>*";
                echo "</div>";
                ?>
                </td>
            </tr> 
            <tr>
                <td>Localizaci&oacute;n</td>
                <td><input name="localiza" type="text" id="localiza" size="30" value="<?=$rs_per['localiza']?>" /></td>
            </tr>
            <tr>
                <td>Tel&eacute;fono</td>
                <td><input name="telefono" type="text" id="telefono" size="30"  value="<?=$rs_per['telefono']?>" /></td>
            </tr>            
            <tr>
                <td>E-mail</td>
                <td><input name="email" type="text" id="email" size="50" value="<?=$rs_per['email']?>" /></td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="2">
                    <input name="modificar" type="submit" id="modificar" value="&nbsp;&nbsp;&nbsp;Modificar&nbsp;&nbsp;&nbsp;"  class="button"/>
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