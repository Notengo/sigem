<?php
require_once 'aut_verifica.inc.php';
?>
<!DOCTYPE html>
<html>
   <head>
      <meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
      <title>Gestion de Usuarios</title>
      <link rel="shortcut icon" href="../images/ingreso.ico" />
      <link rel="stylesheet" href="../css/plantilla.css" type="text/css"  media="screen" />
      <link rel="stylesheet" href="../css/estilos.css" type="text/css" />      	              	   
      <script type="text/javascript" src="js/plantilla.js"></script>
   </head>
<body>
   <!-- wrap starts here -->
   <div id="wrap">
      <header> <?php include_once 'Encabezado.php'; ?> </header>
      <center>
          <br/><br/>
      <div id="cuerpo"  style="text-align:center; height: 900px; ">
          <br/>
          <h1>Datos del Usuario Logueado</h1>
          <table  class="lista" width="800px" style="text-align: left">
          <tbody>
            <?php
            echo "<tr><td>Titular de la cuenta: ".$_SESSION['usuario_nombre']." ".$_SESSION['usuario_apellido'];
            echo "</td></tr>";
            echo "<tr><td>Nombre de Usuario: ".$_SESSION['usuario_login'];
            echo "</td></tr>";
            echo "<tr><td>Nivel de Acceso: ".$_SESSION['usuario_nivel'];
            if($_SESSION['usuario_nivel']=='Z')
                echo " - Super Usuario";
            if($_SESSION['usuario_nivel']=='N')
                echo " - Usuario Normal";
            if($_SESSION['usuario_nivel']=='C')
                echo " - Usuario de Consulta";
            echo "</td></tr>";
            ?>
            </tbody>
            </table>
      </div>
      </center>
      <footer><?php include_once '../ClasesBasicas/Pie.php'; ?></footer>
</div>
</body>
</html>