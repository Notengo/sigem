<?php
include_once '../usuarios/aut_verifica.inc.php';
$tabindex = 1;
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Sigem</title>
        <link rel="shortcut icon" href="../images/ingreso.ico" />    
        <link rel="stylesheet" href="../css/estilos.css" type="text/css" />      	
    </head>
    <body>
        <div class="contenedor">
            <header> <?php include_once '../ClasesBasicas/Encabezado.php'; ?> </header>
            <div id="cuerpo">
                <h1>&Oacute;rdenes de Trabajo Pendientes</h1>
                <div align="right" style="margin-right: 137px; font-weight: bold;" >
                    <?php  echo "<tr><td>Usuario: ".$_SESSION['usuario_nombre']." ".$_SESSION['usuario_apellido']; ?>
                </div>
                <form action="" id="frm_buscar" name="frm_buscar" >
                    <fieldset>
                        <legend>Busqueda</legend>
                        <br/>
                        <?php $tabindex++; ?>
                        <label for="establecimiento" class="detalle">Dependencia:</label>
                        <input type="text" name="establecimiento" id="establecimiento" class="imputbox" onkeyup="ajax_showOptionsOficina(this,'getOficinaByLetters',event)"
                               maxlength="150" size="75" onFocus="this.style.color='blue';"
                               onBlur="this.style.color='#333333';" value="" tabindex="<?php echo $tabindex;?>"/>*
                        <input type="hidden" id="establecimiento_hidden" name="establecimiento_ID" value="" />
                        <br/>
                        <br/>
                        <?php $tabindex++; ?>
                        <label for="fechaDesde" class="detalle">Fecha Desde:</label>
                        <input type="date" name="fechaDesde" id="fechaDesde" class="imputbox" onKeyPress="return soloFecha(event);"
                               onkeyup="return fechaControl(this.id, event);" maxlength="10" size="9"
                               onFocus="this.style.color='blue';"
                               onBlur="this.style.color='#333333';" value="<?php echo date('Y-m-01'); ?>" tabindex="<?php echo $tabindex;?>" />*
                        <br/>
                        <br/>
                        <?php $tabindex++; ?>
                        <label for="fechaHasta" class="detalle">Fecha Hasta:</label>
                        <input type="date" name="fechaHasta" id="fechaHasta" class="imputbox" onKeyPress="return soloFecha(event);"
                               onkeyup="return fechaControl(this.id, event);" maxlength="10" size="9"
                               onFocus="this.style.color='blue';"
                               onBlur="this.style.color='#333333';" value="<?php echo date('Y-m-d'); ?>" tabindex="<?php echo $tabindex;?>" />*
                        <br/>&nbsp;
                    </fieldset>
                    <p>
                        <?php $tabindex++; ?>
                        <input type="button" value="&nbsp;&nbsp;&nbsp;Procesar&nbsp;&nbsp;&nbsp;" class="button" onclick="buscarDatos();" tabindex="<?php echo $tabindex;?>"/>
                    </p>
                </form>
                <div id="resultado"></div>
            </div>
            <footer><?php include_once '../ClasesBasicas/Pie.php'; ?></footer>
        </div>
        <?php
        // put your code here
        ?>
    </body>
</html>
