<?php
/**
 * Archivo de ingreso del usuario y la contraseña
 *
 * @copyright  Copyright (c) 2010 INFORMATICA MINISTERIO DE SALUD
 * @version    1.0
 * @since      File available since Release 1.0
 *
*/
// No almacenar en el cache del navegador esta pagina.
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");             		// Expira en fecha pasada
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");		// Siempre p�gina modificada
header("Cache-Control: no-cache, must-revalidate");           		// HTTP/1.1
header("Pragma: no-cache");                                   		// HTTP/1.0

// Se inicia o reanuda una sesion
$nombre = explode("/", $_SERVER['PHP_SELF']);
session_name('odt');

session_start();
// Se genera el token para evitar ataques
$token = md5(uniqid(rand(), true));

// Se guarda el token en la sesion
$_SESSION['token'] = $token;

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title>Identificaci&oacute;n de Usuarios</title>
    <link rel="shortcut icon" href="img/lock.ico" />
    <style type="text/css">        
        .formLogin {width: 740px; margin: auto; font-size: 12px; font-family: sans-serif;}
        #cuerpo { border: none; padding-top: 3px; margin-top: 0px; background:#FFFFFF url(img/Inicio1.jpg) no-repeat center; height: 600px;}
        #field {text-align: left; margin-top: 25%; border: none; }
/*        #titulo {border: 1px solid #0099FF; padding: 3px; margin-top: 0px; background-color: #0099FF; color: white; margin-top: 50px; font-size: 15px; font-family: arial;}*/
        .formLogin input {border: 1px solid #A0A0A0; font-size: 12px; padding: 3px 0px 3px 25px; margin-left: 200px; width: 270px;}
        .formLogin input#username {background: #FFF url(img/user.png) no-repeat left; font-size: 24px; color:#666666; background-color:#FFFFFF; }
        .formLogin input#password {background: #FFF url(img/pass.png) no-repeat left;font-size: 24px;font-size: 24px; color:#666666; background-color:#FFFFFF;}
        .formLogin input.button:hover {background: url(img/boton2.png) no-repeat left; border: none; margin: 0; font-weight: bold;  margin-left: 290px; width: 126px; height: 33px;  margin-top: -17px; }
        .formLogin input.button {background: url(img/btn_ingresar.png) no-repeat left; border: none; margin: 0; font-weight: bold;  margin-left: 290px; width: 126px; height: 33px;  margin-top: -17px; }
        .error { background: #FF0000;  font-size: 12px; color: #FFF; text-align: center; font-weight: bold; margin:0px; padding: 0px;}
    </style>
</head>
<body onload="formu.user.focus()">
<div align="center">
<form  action="aut_verifica_ingreso.php" method="post" class="formLogin" name="formu" autocomplete="off">
    <input type='hidden' name='token' value="<?php  echo $token ?>" />
    <div id="cuerpo">
    <fieldset id="field">
    <p>
       <input type="text" name="user" size="20" id="username"/>
    </p>
    <p>       
        <input type="password" name="pass" size="20" id="password" />
    </p>
    <br/>
    <p>
        <input name="Entrar" type="submit" value="" class="button" />
    </p>
    <br/>
    <p class="error"><?php if(isset ($_SESSION['error_login']) ) echo $_SESSION['error_login']; ?></p>
    </fieldset>
    </div>
</form>
</div>
</body>
</html>