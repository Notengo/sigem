<?php
/**
 * Archivo de actualizacion de usuarios
 *
 * Archivo de actualizacion de nivel
 *
 * @copyright  Copyright (c) 2010 INFORMATICA MINISTERIO DE SALUD
 * @version    1.0
 * @since      File available since Release 1.0
 *
 * Archivo modificado 20-09-2011
*/

require 'aut_verifica.inc.php'; // incluir motor de autentificacion.
include_once '../ClasesBasicas/ConsultaBD.php';
if ( $_SESSION['usuario_nivel'] != "Z"){
    echo "<div align=center class=error>Acceso Incorrecto</div>";
    exit;
}


?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Gesti&oacute;n de Usuarios</title>
<link rel="stylesheet" href="../css/estilos.css" type="text/css">
<script type="text/javascript" src="js/sorttable.js"></script>
<script type="text/javascript" src="js/validacion.js"></script>
</head>
<body>
<center>
<br>
    <table>
    <tr>
        <td><h1><b>Gesti&oacute;n de Usuarios</b>
        </h1></td>
    </tr>
</table>
<?php
if(!isset($_GET['accion'])) {
/// si se quiere modificar el registro...
/// id del usuario a modificar
    $idModi = $_GET['id'];
    $sql = "SELECT usu_codigousu,usu_apellidoynombre,usu_iden,usu_clave,usu_permiso,ambito FROM users WHERE usu_codigousu=$idModi";
    
    $con = new ConsultaBD();
    $con->Conectar();
    $con->executeQuery($sql);
    $con->Close();
    while($resultados = $con->getFetchArray()) {
    /// muestra el formulario de actualizacion
    ?>
    <form method="post" action="aut_modifica_nivel.php?accion=editar" name="formu">
    <input type="hidden" name="id" value="<?php echo $resultados['usu_codigousu'] ?>">
    <br>
    <table id="formu" style="width: 600px">
        <tr><th colspan="2">Actualizaci&oacute;n de Datos</th></tr>
        <tr><td></td></tr>
        <tr>
            <td>Identificacion:</td>
            <td><?php echo $resultados['usu_iden']?></td>
        </tr>
        <tr>
            <td>Nivel de Acceso:</td>
            <td><input type=text name="nivel" class="imputbox" maxlength="1" size="2" onFocus="this.style.color='blue'" onBlur="this.style.color='#333333'" value="<?php echo $resultados['usu_permiso']?>"></td>
        </tr>
        <tr>
            <td colspan="2" height="40">
            <div align="center">
                <input type="button" class="button" name="Submit" value="&nbsp;&nbsp;Guardar&nbsp;&nbsp;" onclick="formu.submit()">
                <input type="button"  class="button" value="&nbsp;&nbsp;Regresar&nbsp;&nbsp;" onclick="javascript: window.location.href='aut_lista_usuarios.php?go=1';" >
                <div id="falta_dato" class="falta_dato" ></div>
            </div>
            </td>
        </tr>
        <tr><td></td></tr>
    </table>
    <br>
    </form>
    <?php


    }
}

else{
/// luego de la confirmacion del formulario levanta los nuevos datos y ejecuta lo siguiente:
if($_GET['accion']=='editar') {

    $id = $_POST['id'];   
    $nivel = $_POST['nivel'];
    $con = new ConsultaBD();
    $con->Conectar();
    $sql = "select * from users where usu_codigousu = $id";
    
    $con->executeQuery($sql);
    $con->Close();
    $total_encontrados = $con->getNumRows();

    if ($total_encontrados ==  0){
        echo "<div class=error>Ha ocurrido un error intentando actualizar los datos</div>";
        echo '<meta http-equiv="refresh" content="2; url=aut_modifica_usuario.php">';
    }
    else   {
        $con = new ConsultaBD();
        $con->Conectar();
        $sql="update users set usu_permiso = '$nivel' where usu_codigousu = '$id'";
        if ($con->executeQuery($sql)) {
            $con->Close();
            echo "<div class=exito>Los datos se actualizaron con exito</div>";
//                    echo '<meta http-equiv="refresh" content="0; url=mensaje/usuario.php?pag=aut_lista_usuarios.php?go=1&msj=1">';
            ?>
            <meta http-equiv="refresh" content="2; url=aut_lista_usuarios.php?go=1" />
            <?php

        } else  {
            $con->Close();
            echo "<div class=error>Ha ocurrido un error intentando guardar los datos</div>";
            echo '<meta http-equiv="refresh" content="2; url=aut_lista_usuarios.php?go=1">';
        }
    }
}
}
?>
</center>