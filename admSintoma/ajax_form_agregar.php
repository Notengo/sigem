<?php	
// Se chequea si existe un login
require_once '../usuarios/aut_verifica.inc.php';
?>
<script language="javascript" type="text/javascript" src="js/select_localidad.js"></script>
<h1>Agregando nuevo Sintoma</h1>
<p>Por favor rellene el siguiente formulario</p>
<form action="javascript: fn_agregar();" method="post" id="frm_per">
    <table class="formulario">
        <tbody>
            <tr>
                <td>Sintoma</td>
                <td><input name="sintoma" type="text" id="sintoma" size="50" class="required" />*</td>
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
                sintomo:{
                    required: true
                }
            },
            messages: {
                nombre: "x"
            },
            onkeyup: false,
            submitHandler: function(form) {
                var respuesta = confirm('\xBFDesea realmente agregar el sintoma?')
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