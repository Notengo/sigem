<?php
/**
 * Archivo de ingreso de nuevos usuarios
 *
 * Archivo de ingreso de nuevos usuarios que muestra el formulario de ingreso
 * y realiza la insercion en la base de datos
 *
 * @copyright  Copyright (c) 2010 INFORMATICA MINISTERIO DE SALUD
 * @version    1.0
 * @since      File available since Release 1.0
 *
 * Actualizado 14-02-2011
*/
if(isset($_SESSION['usuario_nivel'])){
if ( $_SESSION['usuario_nivel'] == "Z"){
    echo "<div align=center class=error>Acceso Incorrecto</div>";
    exit;
}
}

function tipo_establec($tipo)
{
$tip="";
switch($tipo)
{
	case 'H': $tip= "Hospital";break;
	case 'C': $tip= "Centro de Salud";break;
	case 'O': $tip= "Oficina";break;
}
return $tip;
}


require_once 'aut_verifica.inc.php'; // incluir motor de autentificacion.
?>
<html>
<head>
<title>Administraci&oacute;n de Usuarios</title>
<link rel="stylesheet" href="../css/estilos.css" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script type="text/javascript" src="js/sorttable.js"></script>
<script type="text/javascript" src="js/validacion.js"></script>
</head>
<body>
<center>
<br>
<table>
<tr>
    <td><h1>Administraci&oacute;n de Usuarios</h1></td>
</tr>
</table>
<br>
<form method="post" action="aut_nuevo_usuario.php?accion=hacernuevo" name="formu">
<table id="nuevo" style="width:750px">
    <tr><th colspan="2">Ingreso de Nuevos Usuarios</th></tr>
    <tr><td></td></tr>
    <tr>
        <td>Nombre y Apellido:</td>
        <td><input type="text" name="nombre" class="imputbox" maxlength="150" size="30" onFocus="this.style.color='blue'" onBlur="this.style.color='#333333'">
            <div id="nom" class="falta_dato" style="display:inline"></div>
        </td>
    </tr>
    <tr>
        <td>Identificacion:</td>
        <td><input type="text" name="usuarionombre" class="imputbox" maxlength="30" onFocus="this.style.color='blue'" onBlur="this.style.color='#333333'" >
            <div id="iden" class="falta_dato" style="display:inline"></div>
        </td>
    </tr>
    <tr>
        <td>Password:</td>
        <td><input type="password" name="password1" class="imputbox" maxlength="10" onFocus="this.style.color='blue'" onBlur="this.style.color='#333333'">
            <div id="pass1" class="falta_dato" style="display:inline"></div>
        </td>
    </tr>
    <tr>
        <td>Password (repetir):</td>
        <td><input type="password" name="password2" class="imputbox" maxlength="10" onFocus="this.style.color='blue'" onBlur="this.style.color='#333333'">
            <div id="pass2" class="falta_dato" style="display:inline"></div>
        </td>
    </tr>
    <tr>
        <td>Nivel de Acceso:</td>
        <td><input type=text name="nivel" class="imputbox" maxlength="1" size="2" onFocus="this.style.color='blue'" onBlur="this.style.color='#333333'"></td>
    </tr>
    <tr>
        <?php
        include_once '../ClasesBasicas/ConsultaBD.php';
        $sql = "select ofcodi, nombre, tipo, descri from oficexpe inner join localida on (oficexpe.coddpto=localida.coddepto and oficexpe.codloc=localida.codloc) order by nombre";
        
        ?>
        <td>Ambito:</td>
        <td><select name="ambito" onFocus="this.style.color='blue'" onBlur="this.style.color='#333333'">        
            <option value="">Seleccione</option>
            <?php
            $con = new ConsultaBD();
            $con->Conectar();
            $con->executeQuery($sql);
            while ($row = $con->getFetchArray())
            {
                    ?><option value='<?php echo $row['ofcodi']?>' >
                    <?php echo strtoupper(substr($row['nombre'],0,50))." - ".tipo_establec($row['tipo'])." (".$row['descri'].")" ?>
                    </option>
                <?php
            }
            $con->Close();
        ?>
        </select>
        <div id="efec" class="falta_dato" style="display:inline"></div>
        </td>
    </tr>
    <tr>
      <td colspan="2" height="40">
        <div align="center">
            <input type="button" class="button" name="Submit" value="&nbsp;&nbsp;Registrar&nbsp;&nbsp;" onclick="nuevoUsuario()">
            <input type="reset" class="button" value="&nbsp;&nbsp;Limpiar&nbsp;&nbsp;">
            <div id="falta_dato" class="falta_dato" style="display:inline"></div>
        </div>
      </td>
    </tr>
    <tr><td></td></tr>
</table>
</form>
</center>
</body>
</html>
<?php
if(isset($_GET['accion'])){
    
    if ($_GET['accion'] == "hacernuevo") {

    $nomap = $_POST['nombre'];
    $nivel= $_POST['nivel'];
    $usuario = $_POST['usuarionombre'];
    $pass1 = $_POST['password1'];
    $pass2 = $_POST['password2'];
    $ambito = $_POST['ambito'];
    $fechaHoy = date("Y-m-d");
    $usuAlta =  $_SESSION['usuario_id'];

    if ($nivel=="") { $baja = date('Y-m-d');    }
    else { $baja = '0000-00-00 00:00:00';  }

    if (($pass1 == "") || ($pass2 == "") || ($usuario == "")
            ||($ambito == "") || ($nomap == "")
        ){
        echo "<div class=falta_dato><b>Debe completar todos los campos para poder crear un usuario.</b></div>";    
    }   else    {
            if ($pass1 !=  $pass2)
            {
                    echo "<div class=falta_dato><b>Passwords no coinciden</b></div>";
            } else        {
                $con = new ConsultaBD();
                $con->Conectar();
                $sql="SELECT usu_codigousu FROM users WHERE usu_iden='$usuario'";
                $usuarios_consulta = $con->executeQuery($sql);
                $con->Close();
                $total_encontrados = $con->getNumRows();
                if ($total_encontrados !=  0)
                {
                    echo "<div class=falta_dato><b>El Usuario ya esta registrado</b></div>";
                }
                else
                {
                    $usuario=stripslashes($usuario);
                    $pass1 = md5($pass1);
                    $con = new ConsultaBD();
                    $con->Conectar();               
                    $sql = "INSERT INTO users (usu_apellidoynombre, usu_iden, usu_clave, usu_permiso, ambito, usu_alta, fechabaja, usu_baja) values('$nomap','$usuario','$pass1','$nivel','$ambito',$usuAlta, '$baja',$usuAlta)";                
                    if ($con->executeQuery($sql)) {
                        $con->Close();
                        echo "<center><div class=exito>Los datos se actualizaron con exito</div></center>";
                        echo '<meta http-equiv="refresh" content="2; url=aut_nuevo_usuario.php">';
                    } else  {
                        $con->Close();
                        echo "<div class=error>Ha ocurrido un error intentando guardar los datos</div>";
                        echo '<meta http-equiv="refresh" content="0; url=aut_nuevo_usuario.php">';
                    }
                }
            }
        }
    }
}

?>