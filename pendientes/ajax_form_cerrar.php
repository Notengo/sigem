<?php
// Se chequea si existe un login.
require_once '../usuarios/aut_verifica.inc.php';
require_once '../ClasesBasicas/ActiveRecordAbstractFactory.php';
$oMysql = ActiveRecordAbstractFactory::getActiveRecordFactory(ActiveRecordAbstractFactory::MYSQL);
$oMysql->conectar();
$tabindex = 0;
// Seteo la zona horaria.
date_default_timezone_set("America/Argentina/Buenos_Aires");

$orden=$_POST['id'];

?>
<h1>Cerrar Orden</h1>
<p>Por favor rellene el siguiente formulario</p>
<form action="" id="frm_buscar" name="frm_buscar" >
    <br />
    <table class="formulario">
        <tbody>
            <tr>
                <?php $tabindex++; ?>
                <td>N&ordm; Orden:</td>
                <td><input type="text" id="orden" name="orden" value="<?php echo $orden; ?>" size="3" disabled="disable" /></td>
            </tr>
            <tr>
                <?php $tabindex++; ?>
                <td>Usuario:</td>
                <td>
                    <?php
                    require_once '../Clases/ActiveRecord/MysqlUsuariosActiveRecord.php';
                    $oMysqlUsuario = $oMysql->getUsuariosActiveRecord();
                    $oUsuario = new UsuariosValueObject();
                    $oUsuario = $oMysqlUsuario->findAll();

                    $oOrden = new Orden();
                    $oMysqlOrden = $oMysql->getOrdenActiveRecord();
                    $oOrden->setIdorden($orden);
                    $oOrden = $oMysqlOrden->find($oOrden);
                    ?>
                    <select name="usuario" id="usuario">
                    <?php
                    foreach ($oUsuario as $valor) {
                        if($oOrden->getIdUsers() == $valor->getId())
                            echo "<option value='".$valor->getId()."' selected='selected'>".$valor->getIdentificacion()."</option>";
                        else
                            echo "<option value='".$valor->getId()."'>".$valor->getIdentificacion()."</option>";
                    }
                    ?>
                    </select>
                </td>
            </tr>
            <tr>
                <?php $tabindex++; ?>
                <td>Fecha Fin:</td>
                <td><input type="date" id="fechaFin"  name="fechaFin" value="<?php echo date("Y-m-d"); ?>" /></td>
            </tr>
            <tr>
                <?php $tabindex++; ?>
                <td>Fecha Retirado:</td>
                <td><input type="date" id="fechaRetirado" name="fechaRetirado" value="<?php echo date("Y-m-d"); ?>" /></td>
            </tr>
            <tr>
                <?php $tabindex++; ?>
                <td></td>
                <td></td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="2"><input type="button" value="&nbsp;&nbsp;&nbsp;Aceptar&nbsp;&nbsp;&nbsp;" class="button" onclick="guardarDatos();"/>
                <input type="button" value="&nbsp;&nbsp;&nbsp;&nbsp;Cerrar&nbsp;&nbsp;&nbsp;&nbsp;" class="button" onclick="fn_cerrar();"/></td>
            </tr>
        </tfoot>

<!--    <br />
    <?php // $tabindex++; ?>
    <label for="fechaConforme" class="detalle">Fecha Conforme:</label>
    <input type="date" id="fechaConforme" name="fechaConforme" value="<?php // echo date("Y-m-d"); ?>" />-->
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