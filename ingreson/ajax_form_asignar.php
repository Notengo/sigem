<?php
// Se chequea si existe un login
require_once '../usuarios/aut_verifica.inc.php';

// Se requieren los script para acceder a los datos de la DB
require_once '../ClasesBasicas/ActiveRecordAbstractFactory.php';
require_once '../Clases/ActiveRecord/MysqlUsuariosActiveRecord.php';
require_once '../Clases/ActiveRecord/MysqlAgentesActiveRecord.php';
require_once '../Clases/ActiveRecord/MysqlOficexpeActiveRecord.php';
require_once '../Clases/ActiveRecord/MysqlCategoriaActiveRecord.php';
require_once '../ClasesBasicas/ConsultaBD.php';

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

?>
<h1>Asignar Usuario</h1>
<p>Por favor rellene el siguiente formulario</p>
<form action="javascript: fn_asignar();" method="post" id="asignar2">
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
                    
<!--                    <select name="usuario" id="usuario" class="required" onChange="cargaAsignado(this.value, this.id)">            
                    <option value="0">Seleccione</option>-->
                    <?php
                    $i=-1;
                    $con = new ConsultaBD();
                    $con->Conectar(); 
                    $sql.=" SELECT users.`id`, users.`identificacion` FROM orden ";
                    $sql.=" INNER JOIN asignados ON orden.`nro`=asignados.`nroOrden` AND asignados.`fechaBaja`='0000-00-00 00:00:00'";
                    $sql.=" INNER JOIN users ON asignados.`idUsuario`=users.`id` ";
                    $sql.=" WHERE orden.`estado`=2 GROUP BY users.`id` order by identificacion";
                    $con->executeQuery($sql);
                    while($inf = $con->getFetchArray()){
                        $ocupados[$inf['id']] = $inf['id'];
                    }
                    if(count($aUsuarios>0)) {
                        echo "<tr>";
                        foreach ($aUsuarios as $value) {
                            $i++;
                            if($i==4) { $i=0; echo "</tr><tr>";}
                            if(isset($ocupados[$value->getId()])) {
                                if($ocupados[$value->getId()]==$value->getId()) {
                                    $oAgentes->setDni($value->getDni());
                                    $oAgentes = $oMysqlAgentes->find($oAgentes);
                                    $oCategoria->setIdUsuario($value->getId());
                                    $oCategoria->setIdEspecialidad($especialidad);
                                    if($oMysqlCategoria->find($oCategoria)<>false)
                                        echo "<td><input type='checkbox' value='".$value->getId()."' name='".$value->getId()."' ><span style='color:grey'>".$oAgentes->getNombre()."</span></input>&nbsp;</td>";                            
                                    else
                                        echo "<td><input type='checkbox' value='".$value->getId()."' name='".$value->getId()."'><span style='color:grey'>".$oAgentes->getNombre()."</span></input>&nbsp;</td>";                                                     
                                }                               
                            } else {                            
                                $oAgentes->setDni($value->getDni());
                                $oAgentes = $oMysqlAgentes->find($oAgentes);
                                $oCategoria->setIdUsuario($value->getId());
                                $oCategoria->setIdEspecialidad($especialidad);
                                if($oMysqlCategoria->find($oCategoria)<>false)
                                    echo "<td><input type='checkbox' value='".$value->getId()."' name='".$value->getId()."' ><span style='color:red'>".$oAgentes->getNombre()."</span></input>&nbsp;</td>";                            
                                else
                                    echo "<td><input type='checkbox' value='".$value->getId()."' name='".$value->getId()."'>".$oAgentes->getNombre()."</input>&nbsp;</td>";                                                     
                            }
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
                    <input name="agregar" type="submit" id="agregar" value="&nbsp;&nbsp;&nbsp;Asignar&nbsp;&nbsp;&nbsp;" class="button"/>
                    <input name="cancelar" type="button" id="cancelar" value="&nbsp;&nbsp;&nbsp;Cancelar&nbsp;&nbsp;&nbsp;" onclick="fn_cerrar();" class="button"/>
                </td>
            </tr>
        </tfoot>
    </table>
</form>
<script language="javascript" type="text/javascript">	
    function fn_asignar(){
            var str = $("#asignar2").serialize();
            $.ajax({
                    url: 'ajax_asignar.php',
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