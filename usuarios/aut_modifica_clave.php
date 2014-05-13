<?php 
require 'aut_verifica.inc.php'; // incluir motor de autentificacion.
include_once '../ClasesBasicas/ConsultaBD.php';

?>
<!DOCTYPE html>
<html>
   <head>
      <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
      <title>Gesti&oacute;n de Usuarios</title>
      <link rel="shortcut icon" href="../images/ingreso.ico" />
      <link rel="stylesheet" href="../css/plantilla.css" type="text/css"  media="screen" />
      <link rel="stylesheet" href="../css/estilos.css" type="text/css" />
      <script type="text/javascript" src="js/validacion.js"></script>
   </head>
   <body id="nav4">
      <div class="contenedor">
         <header><?php include_once 'Encabezado.php'; ?></header>
         <div id="cuerpo">
            <h1>Gesti&oacute;n de Usuarios</h1>                        
            <?php
            if ( $_SESSION['usuario_nivel'] == "Z") { ?>  
            <ul id="navegacion">
               <li class="nav1"><a href="aut_nuevo_usuario.php">Nuevo Usuario</a></li>
               <li class="nav2"><a href="aut_lista_usuarios.php">Listado de Usuarios</a></li>  
               <li class="nav3"><a href="aut_modifica_usuario.php">Actualización de Usuarios</a></li>
               <li class="nav4"><a href="aut_modifica_clave.php">Cambio de Clave</a></li>
            </ul>            
            <br/>
            <br/>
            <?php } ?>
            <form id="two" name="formulario" autocomplete="off" method="post">
               <input name="ident" id="ident" value="<?php echo $_SESSION['usuario_id'] ?>" type="hidden">
               <fieldset>
                  <legend>
                     USUARIO <?php echo $_SESSION['usuario_login'] ?>
                  </legend>
                  <table id="formu" style="width: 400px; margin: 0 auto">
                  <tr>
                     <td colspan="2" align="center"></td>
                  </tr>
                  <tr>
                     <td>Clave Actual:</td>
                     <td>
                        <input type="password" name="passwordA" id="passwordA" class="imputbox" maxlength="10" onFocus="this.style.color='blue'" onBlur="this.style.color='#333333'">
                        <div id="passA" class="falta_dato" style="display: inline"></div>
                     </td>
                  </tr>
                  <tr>
                     <td>Clave Nueva:</td>
                     <td>
                        <input type="password" name="password1" id="password1" class="imputbox" maxlength="10" onFocus="this.style.color='blue'" onBlur="this.style.color='#333333'">
                        <div id="pass1" class="falta_dato" style="display: inline"></div>
                     </td>
                  </tr>
                  <tr>
                     <td>Clave Nueva: (repetir)</td>
                     <td>
                        <input type="password" name="password2" id="password2" class="imputbox" maxlength="10" onFocus="this.style.color='blue'" onBlur="this.style.color='#333333'">
                        <div id="pass2" class="falta_dato" style="display: inline"></div>
                     </td>
                  </tr>
                  <tr>
                     <td></td>
                  </tr>
               </table>
            </fieldset>
            <br />
            <div align="center">
               <input type="button" class="button" name="Submit" value="&nbsp;&nbsp;Guardar&nbsp;&nbsp;" onclick="modificacionClave()">
               <input type="button"  class="button" value="&nbsp;&nbsp;Cancelar&nbsp;&nbsp;" onclick="javascript: window.location.href='aut_modifica_clave.php';" >
               <div id="falta_dato" class="falta_dato" ></div>
            </div>
            <div id="resultado"></div>
         </div>
         <footer><?php include_once '../ClasesBasicas/Pie.php'; ?></footer>
      </div>
   </body>
</html>