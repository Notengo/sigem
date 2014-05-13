<?php
// Se chequea si existe un login
require_once '../usuarios/aut_verifica.inc.php';

// Se requieren los script para acceder a los datos de la DB
require_once '../ClasesBasicas/ActiveRecordAbstractFactory.php';
require_once '../Clases/ActiveRecord/MysqlUsuariosActiveRecord.php';
require_once '../Clases/ActiveRecord/MysqlAgentesActiveRecord.php';
require_once '../Clases/ActiveRecord/MysqlOficexpeActiveRecord.php';
require_once '../Clases/ActiveRecord/MysqlCategoriaActiveRecord.php';
require_once '../Clases/ActiveRecord/MysqlAsignadosActiveRecord.php';

$oMysql = ActiveRecordAbstractFactory::getActiveRecordFactory(ActiveRecordAbstractFactory::MYSQL);
$oMysql->conectar();

$orden=$_POST['nro'];
$ofcodi=$_POST['ofcodi'];
$especialidad=$_POST['especialidad'];

$oMysqlUsuarios = $oMysql->getUsuariosActiveRecord();
$aUsuarios=$oMysqlUsuarios->findPorOfcodi($ofcodi);

$oMysqlAgentes = $oMysql->getAgentesActiveRecord();
$oAgentes = new AgentesValueObject();

$oMysqlCategoria = $oMysql->getCategoriaActiveRecord();
$oCategoria = new CategoriaValueObject();

$oMysqlOficexpe = $oMysql->getOficexpeActiveRecord();
$oOficina = new OficexpeValueObject();

$oMysqlAsignados = $oMysql->getAsignadosActiveRecord();
$oAsignados = new AsignadosValueObject();

?>
<h1>Modificar Asignaci&oacute;n de Usuario</h1>
<p>Por favor rellene el siguiente formulario</p>
<form action="javascript: fn_modificar();" method="post" id="asignar2">
    <input type="hidden" name="orden" id="orden" value="<?php echo $orden?>">
    <input type="hidden" name="ofcodi" id="ofcodi" value="<?php echo $ofcodi?>">
    <table class="formulario">
        <tbody>
            <tr>
                <td>Nro OT</td>
                <td><strong><?php echo $orden?></strong></td>
            </tr>
            <tr>
                <td>Oficina</td>
                <td><strong><?php
                $oOficina->set_ofcodi($ofcodi);
                $oOficina=$oMysqlOficexpe->find($oOficina);            
                echo htmlentities($oOficina->get_nombre());   
                ?></strong></td>
            </tr>
            <tr>
                <td>Usuario</td>                
                <td><table>                    
                    <?php
                    $i=-1;
                    if(count($aUsuarios>0)) {
                        echo "<tr>";
                        foreach ($aUsuarios as $value) {
                            $i++;
                            if($i==4) { $i=0; echo "</tr><tr>";}
                            $oAgentes->setDni($value->getDni());
                            $oAgentes = $oMysqlAgentes->find($oAgentes);
                            $oCategoria->setIdUsuario($value->getId());
                            $oCategoria->setIdEspecialidad($especialidad);
                            $oAsignados->setNroOrden($orden);
                            $oAsignados->setIdUsuario($value->getId());
                            /// si el usuario fue seleccionado ....
                            if($oMysqlAsignados->find($oAsignados)==true)        
                               $opcion='checked';    
                            else $opcion='';
                            
                            if($oMysqlCategoria->find($oCategoria)<>false)
                                echo "<td><input type='checkbox' value='".$value->getId()."' name='".$value->getId()."' ".$opcion."><span style='color:red'>".$oAgentes->getNombre()."</span></input>&nbsp;</td>";                            
                            else
                                echo "<td><input type='checkbox' value='".$value->getId()."' name='".$value->getId()."' ".$opcion.">".$oAgentes->getNombre()."</input>&nbsp;</td>";                                                     
                        }
                    }
                    ?>                    
<!--                    </select>-->
                    </table></td>
            </tr> 
            <tr><td><br/></td></tr>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="2">
                    <input name="agregar" type="submit" id="agregar" value="&nbsp;&nbsp;&nbsp;Modificar&nbsp;&nbsp;&nbsp;" class="button"/>
                    <input name="cancelar" type="button" id="cancelar" value="&nbsp;&nbsp;&nbsp;Cancelar&nbsp;&nbsp;&nbsp;" onclick="fn_cerrar();" class="button"/>
                </td>
            </tr>
        </tfoot>
    </table>
</form>
<script language="javascript" type="text/javascript">	    
    function fn_modificar(){
            var str = $("#asignar2").serialize();
            $.ajax({
                    url: 'ajax_modificar.php',
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