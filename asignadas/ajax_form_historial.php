<?php
// Se chequea si existe un login
require_once '../usuarios/aut_verifica.inc.php';

// Se requieren los script para acceder a los datos de la DB
require_once '../ClasesBasicas/ActiveRecordAbstractFactory.php';
require_once '../Clases/ActiveRecord/MysqlOrdenActiveRecord.php';

$oMysql = ActiveRecordAbstractFactory::getActiveRecordFactory(ActiveRecordAbstractFactory::MYSQL);
$oMysql->conectar();

$orden=$_POST['nro'];

$oMysqlOrden = $oMysql->getOrdenActiveRecord();
$oOrden = new OrdenValueObject();
$oOrden->setNro($orden);
$oMysqlOrden->find($oOrden);
?>
<h1>Generaci&oacute;n de entrada en el historial</h1>
<p>Por favor rellene el siguiente formulario</p>
<form action="javascript: fn_estado();" method="post" id="asignar">
    <input type="hidden" name="orden" id="orden" value="<?php echo $orden?>">
    <table class="formulario">
        <tbody>
            <tr>
                <td>Nro OT</td>
                <td><strong><?php echo $orden?></strong></td>
            </tr>                        
            <tr><td>Descripci&oacute;n<br/>del problema</td>
                <td><textarea name="problema"></textarea></td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="2">
                    <input name="agregar" type="submit" id="agregar" value="&nbsp;&nbsp;&nbsp;Aceptar&nbsp;&nbsp;&nbsp;" class="button"/>
                    <input name="cancelar" type="button" id="cancelar" value="&nbsp;&nbsp;&nbsp;Cancelar&nbsp;&nbsp;&nbsp;" onclick="fn_cerrar();" class="button"/>
                </td>
            </tr>
        </tfoot>
    </table>
</form>
<script language="javascript" type="text/javascript">	        
    function fn_estado(){
            var str = $("#asignar").serialize();
            $.ajax({
                    url: 'ajax_historial.php',
                    data: str,
                    type: 'post',
                    success: function(data){
                            if(data != "")
                                    alert(data);
                            else
                                alert('Datos guardados correctamente');
                            fn_cerrar();
                            fn_buscar();
                    }
            });
    };
</script>