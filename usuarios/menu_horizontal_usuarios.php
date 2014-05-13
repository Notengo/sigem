<?php
require_once 'aut_verifica.inc.php';
?>
<link rel="stylesheet" href="../css/menu_horizontal.css" type="text/css"  media="screen" >
<span class="preload1"></span>
<span class="preload2"></span>
<ul class="menu2">
   <li class="top"><a href="#" class="top_link"><span class="down">Administraci&oacute;n de Usuarios</span></a>
      <ul class="sub">
      <?php if ( $_SESSION['usuario_nivel'] == "Z") { ?>
      <li><a href="aut_nuevo_usuario.php">Ingresar Nuevo</a></li>
      <li><a href="aut_lista_usuarios.php">Listar</a></li>
      <li><a href="aut_modifica_usuario.php">Actualizar</a></li>
      <?php } 
      ?>
      <li><a href="aut_modifica_clave.php">Actualizar Clave Actual</a></li>
      </ul>
   </li>   
</ul>
