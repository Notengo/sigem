<?php 
require 'aut_verifica.inc.php'; // incluir motor de autentificacion.
include_once '../ClasesBasicas/ConsultaBD.php';
if ( $_SESSION['usuario_nivel'] != "Z") {
   echo "<div align=center class=error>Acceso Incorrecto</div>";
   exit;
}
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
   <body id="nav2">
      <div class="contenedor">
         <header><?php include_once 'Encabezado.php'; ?></header>
         <div id="cuerpo">
            <h1>Gesti&oacute;n de Usuarios</h1>                        
            <ul id="navegacion">
               <li class="nav1"><a href="aut_nuevo_usuario.php">Nuevo Usuario</a></li>
               <li class="nav2"><a href="aut_lista_usuarios.php">Listado de Usuarios</a></li>  
               <li class="nav3"><a href="aut_modifica_usuario.php">Actualización de Usuarios</a></li>
               <li class="nav4"><a href="aut_modifica_clave.php">Cambio de Clave</a></li>
            </ul>
            <br/>
            <br/>
            <div style="height: 960px;">
               <?php
               $usu = $_SESSION['usuario_id'];
               $con = new ConsultaBD();
               $con->Conectar();
               $sql = "SELECT id, nombre, apellido, identificacion, permiso, DATE_FORMAT(users.fechaAlta, '%d-%m-%Y') AS fechaAlta, users.fechaBaja FROM users ";
               $sql.= " INNER JOIN agentes on agentes.dni=users.dni WHERE id!= '$usu' order by nombre";               
               $con->executeQuery($sql);
               $con->Close();
               ?>
               <table id="grilla" class="lista" width="900px" style="text-align: left">
                  <thead><tr>
                  <th>Código</th>
                  <th>Nombre</th>
                  <th>Identificador</th>
                  <th>Permiso</th>
                  <th>Fecha Alta</th>
                  <th>Estado</th>
                      </tr></thead>
                  <?php
                  $cont=0;
                  while($resultados = $con->getFetchArray()) {                     
                  ?><tr>
                  <!-- cuerpo de la lista -->
                     <td><?php echo $resultados['id'] ?></td>
                     <td><?php echo $resultados['nombre']." ".$resultados['apellido'] ?></td>
                     <td><?php echo $resultados['identificacion'] ?></td>
                     <td><?php echo $resultados['permiso'] ?></td>
                     <td><?php echo $resultados['fechaAlta'] ?></td>
                     <td><?php echo ($resultados['fechaBaja']<>'0000-00-00 00:00:00') ? "Bloqueado" : "Activo" ?></td>
                  </tr>
                  <?php
                  }
                  ?>
               </table>
            </div>
         </div>
         <footer><?php include_once '../ClasesBasicas/Pie.php'; ?></footer>
      </div>
   </body>
</html>