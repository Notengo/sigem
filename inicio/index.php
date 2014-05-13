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
      <header> <?php include_once '../ClasesBasicas/EncabezadoInicio.php'; ?> </header>
      <center>          
      <div id="cuerpo"  style="text-align:center; height: 800px; ">      
          <h1>Resumen de &Oacute;rdenes de Trabajo</h1>
        <br/>
        <table  class="lista" width="800px" style="text-align: left">
        <tbody>
          <?php
          $oMysql = ActiveRecordAbstractFactory::getActiveRecordFactory(ActiveRecordAbstractFactory::MYSQL);
          $oMysql->conectar();
          $sql="SELECT COUNT(`nro`) as total FROM orden WHERE (estado=1 OR estado=2) ORDER BY nro ASC";
          $resultado = mysql_query($sql);
          if($resultado){   
              $fila = mysql_fetch_object($resultado);                
              $total = $fila->total;
          }
          echo "<tr><td>Total de OT pendientes: <a href='../pendientes'><b>".$total."</b></a>";
          echo "</td></tr>";

          $sql = "SELECT COUNT(`nro`) as total FROM orden WHERE (estado=1 AND usuarioAsignado=0) ORDER BY nro ASC";          
          $resultado = mysql_query($sql);
          if($resultado){   
              $fila = mysql_fetch_object($resultado);                
              $total = $fila->total;
          }
          echo "<tr><td>Total de OT no asignadas: <a href='../pendientes'><b>".$total."</b></a>";      

          $sql = "SELECT COUNT(`nro`) as total FROM orden WHERE (estado=1 OR estado=2) AND prioridad=2 ORDER BY nro ASC";            
          $resultado = mysql_query($sql);
          if($resultado){   
              $fila = mysql_fetch_object($resultado);                
              $total = $fila->total;
          }
          echo "</td></tr>";
          echo "<tr><td>Total de OT pendientes de prioridad urgente: <a href='../pendientes'><b>".$total."</b></a>";          
          echo "</td></tr>";                    

          $sql = "SELECT COUNT(`nro`) as total FROM orden WHERE (estado=1 OR estado=2) AND prioridad=1 ORDER BY nro ASC";
          $resultado = mysql_query($sql);
          if($resultado){   
              $fila = mysql_fetch_object($resultado);                
              $total = $fila->total;
          }
          echo "<tr><td>Total de OT pendientes de prioridad media: <a href='../pendientes/'><b>".$total."</b></a>";  
          echo "</td></tr>";

          $sql = "SELECT COUNT(`nro`) as total FROM orden WHERE (estado=1 OR estado=2) AND prioridad=0 ORDER BY nro ASC";            
          $resultado = mysql_query($sql);
          if($resultado){   
              $fila = mysql_fetch_object($resultado);                
              $total = $fila->total;
          }                
          echo "<tr><td>Total de OT pendientes de prioridad baja: <a href='../pendientes/'><b>".$total."</b></a>";            
          echo "</td></tr>";                                           
          ?>
          </tbody>
          </table>        
          <br/><br/>
          <h1>Resumen del inventario</h1>
          <br/>
          <table  class="lista" width="800px" style="text-align: left">
          <tbody>
            <?php
            $oMysql = ActiveRecordAbstractFactory::getActiveRecordFactory(ActiveRecordAbstractFactory::MYSQL);
            $oMysql->conectar();
            
            $sql="SELECT COUNT(equipo.id) AS totalEquipo FROM equipo LEFT JOIN users ON users.id=equipo.usuarioAlta 
                LEFT JOIN ubicacion ON ubicacion.idEquipo=equipo.id LEFT JOIN oficexpe ON oficexpe.ofcodi=ubicacion.ofcodi 
                WHERE estado=0 AND (users.identificacion LIKE '%%' OR equipo.nombre LIKE '%%' OR equipo.nro LIKE '%%' OR 
                oficexpe.nombre LIKE '%%') ORDER BY nro ASC";
            $resultado = mysql_query($sql);
            if($resultado){   
                $fila = mysql_fetch_object($resultado);                
                $total = $fila->totalEquipo;
            }
            echo "<tr><td>Equipos pendientes de verificaci&oacute;n: <a href='../equiposPendientes'><b>".$total."</b></a>";
            echo "</td></tr>";
            
            $sql = "SELECT count(id) as totalEquipo";
            $sql.= " FROM componente WHERE 
            (componente.id NOT IN (SELECT relacion.idComponente FROM relacion WHERE fechaBaja='0000-00-00 00:00:00')) AND fechaBaja='0000-00-00 00:00:00'";                       
            $resultado = mysql_query($sql);
            if($resultado){   
                $fila = mysql_fetch_object($resultado);                
                $total = $fila->totalEquipo;
            }
            echo "<tr><td>Componentes disponibles: <a href='../componentesIPendientes'><b>".$total."</b></a>";      
            
            $sql = "SELECT COUNT(equipo.id) AS totalEquipo FROM equipo 
            WHERE equipo.tipo=1 AND equipo.`fechaBaja` IS NULL ORDER BY nro ASC";            
            $resultado = mysql_query($sql);
            if($resultado){   
                $fila = mysql_fetch_object($resultado);                
                $total = $fila->totalEquipo;
            }
            echo "</td></tr>";
            echo "<tr><td>Total de equipos en el inventario: <a href='../equiposIngresados'><b>".$total."</b></a>";          
            echo "</td></tr>";                    
            
            $sql = "SELECT COUNT(equipo.id) AS totalEquipo FROM equipo 
            WHERE equipo.tipo=2 AND equipo.`fechaBaja` IS NULL ORDER BY nro ASC";            
            $resultado = mysql_query($sql);
            if($resultado){   
                $fila = mysql_fetch_object($resultado);                
                $total = $fila->totalEquipo;
            }
            echo "<tr><td>Total de impresoras departamentales en el inventario: <a href='../impresorasIngresadas/'><b>".$total."</b></a>";  
            echo "</td></tr>";
            
            $sql="SELECT COUNT(equipo.`id`) as totalEquipo
            FROM equipo 
            LEFT JOIN ubicacion ON ubicacion.idEquipo=equipo.id AND ubicacion.`fechaBaja` IS NULL 
            LEFT JOIN oficexpe ON oficexpe.ofcodi=ubicacion.ofcodi 
            WHERE equipo.tipo=1  AND oficexpe.ofcodi IS NULL ORDER BY oficexpe.ofcodi, ubicacion.`fechaBaja`, nro ASC";
            $resultado = mysql_query($sql);
            if($resultado){   
                $fila = mysql_fetch_object($resultado);                
                $total = $fila->totalEquipo;
            }                
            echo "<tr><td>Equipos sin ubicaci&oacute;n: <a href='../equiposPorOficina/'><b>".$total."</b></a>";            
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