<?php
// Se chequea si existe un login
require_once '../usuarios/aut_verifica.inc.php';

// Se requieren los script para acceder a los datos de la DB
require_once '../ClasesBasicas/ActiveRecordAbstractFactory.php';
require_once '../Clases/ActiveRecord/MysqlOrdenActiveRecord.php';
require_once '../Clases/ActiveRecord/MysqlProblemaActiveRecord.php';

$oMysql = ActiveRecordAbstractFactory::getActiveRecordFactory(ActiveRecordAbstractFactory::MYSQL);
$oMysql->conectar();

$orden=$_POST['nro'];

$oMysqlOrden = $oMysql->getOrdenActiveRecord();
$oOrden = new OrdenValueObject();
$oOrden->setNro($orden);
$oMysqlOrden->find($oOrden);

$oProblema = new ProblemaValueObject();
$oProblema->setId($oOrden->getIdProblema());

$oMysqlProblema = $oMysql->getProblemaActiveRecord();
$oMysqlProblema->find($oProblema);

?>
<h1>Cambio de Estado</h1>
<form action="javascript: fn_estado();" method="post" id="asignar">
    <input type="hidden" name="orden" id="orden" value="<?php echo $orden?>">
    <table class="formulario">
    <?php     
    $requiereEquipo = 0;
    if(($oOrden->getNroEquipo()==0)&&($oOrden->getEquipo()==0)) {
        if($oProblema->getRequiereEquipo()==1) {
            echo "<br/><br/>ATENCION: Para cambiar el estado deberá ingresar el nro de equipo<br/><br/><br/>";        
            $requiereEquipo = 1;
        }
    } 
    if($requiereEquipo==0)   {
      
    ?>
        <tbody>
            <tr>
                <td>Nro OT</td>
                <td><strong><?php echo $orden?></strong></td>
            </tr>            
            <tr>
                <td>Estado</td>                
                <td>
                    <select name="estado" id="estado" class="required" >            
                        <option value="1">Pendiente</option>                   
                        <option value="2">Solucionado</option>
                        <option value="3">No Solucionado</option>                                     
                        <option value="4">Anulado</option>                                     
                    </select>
                </td>
            </tr> 
            <tr><td>Observaci&oacute;n</td>
                <td><textarea name="observacion"><?php echo $oOrden->getObservacion(); ?></textarea></td>
            </tr>
        </tbody>
    <?php } ?>
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
                    url: 'ajax_estado.php',
                    data: str,
                    type: 'post',
                    success: function(data){
                            if((data != "")&& (data!=1))
                                alert(data);
                            else
                                if((data == "") && (data!=1))
                                    alert('Datos guardados correctamente');                              
                            fn_cerrar();
                            fn_buscar();
                    }
            });
    };
</script>