<?php
require_once '../usuarios/aut_verifica.inc.php';

// Se requieren los script para acceder a los datos de la DB
require_once '../ClasesBasicas/ActiveRecordAbstractFactory.php';

?>
<!DOCTYPE html>
<html>
   <head>
      <meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
      <title>Gestion de Inventario</title>
      <link rel="shortcut icon" href="../images/ingreso.ico" />
      <link rel="stylesheet" href="../css/plantilla.css" type="text/css"  media="screen" />
      <link rel="stylesheet" href="../css/estilos.css" type="text/css" />      	              	       
   </head>
<body>
   <!-- wrap starts here -->
   <div id="wrap">
      <header> <?php include_once '../ClasesBasicas/EncabezadoInventario.php'; ?> </header>
      <center>          
      <div id="cuerpo"  style="text-align:center; height: 800px; ">          
        
      </div>
      </center>
      <footer><?php include_once '../ClasesBasicas/Pie.php'; ?></footer>
</div>
</body>
</html>