<?php
/**
 * Description of Encabezado
 * @author Area Desarrollo - Departamento Informatica - Ministerio de Salud
 */
?>
<html>
   <head>
      <link rel="stylesheet" href="../css/Encabezado.css" type="text/css"  media="screen" />
      <link rel="stylesheet" href="../css/plantilla.css" type="text/css"  media="screen" />
   </head>
<body>
<!-- wrap starts here -->
<div id="wrap">
   <div id="header">
      <h1 id="logo"><span class="gray">Gestion</span>usuarios</h1>
      <h2 id="slogan">Ministerio de Salud de Entre R&iacute;os</h2>
      <br />
      <span id="liveclock" ></span>
      <div class="fechahoy">
         <?php
         include_once '../fecha.php';
         print(fecha()."<br />");
         ?>
      </div>
      <!-- Menu Tabs -->
          <ul>
        <li id="current"><a href="<?php echo '../inicio/index.php'; ?>" ><span>Inicio</span></a></li>   
        <li id="current" >
             <?php if($_SESSION['usuario_nivel']=='Z') { ?>
                <a href="<?php echo '../ingresoz/index.php'; ?>"><span>Orden de Trabajo</span></a> </li>         
         <? } else {
              ?>
            <a href="<?php echo '../ingreson/index.php'; ?>"><span>Incidentes</span></a> </li>         
        <?php
         }
         ?>
         <li id="current"><a href="<?php echo '../inventario/index.php'; ?>" ><span>Inventario</span></a></li>   
         <?php         
         if (!(isset($_SESSION['usuario_login']) || isset($_SESSION['usuario_password'])))
         {
            echo '<li><a href="../usuarios/index.php"><span>Loguearse</span></a></li>';
         } else {
            if ($_SESSION['usuario_nivel']=='Z')
               echo '<li ><a href="../usuarios/index.php" target="_self"><span>Administrador</span></a></li>';
            else
               echo '<li ><a href="../usuarios/index.php" target="_self"><span>Administracion</span></a></li>';
         }
         ?>
         <li id="current"><a href="../usuarios/logout.php"><span>Cerrar Sesi&oacute;n</span></a></li>
        </ul>
    </div>
    <?php include_once("menu_horizontal_usuarios.php"); ?>
</div>
</body>
</html>