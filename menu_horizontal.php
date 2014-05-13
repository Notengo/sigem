<?php
 /**
 * Menu principal de la aplicacion
 *
 * Menu principal de la aplicacion que es visible cuando la pestaña
 * de inicio esta activa, contiene las redirecciones a los
 * scripts de la aplicacion que permiten la administracion de usuarios
 *
 * @copyright  Copyright (c) 2010 INFORMATICA MINISTERIO DE SALUD
 * @version    1.0
 * @since      File available since Release 1.0
 *
*/

// Se chequea si existe un login
require_once 'usuarios/aut_verifica.inc.php';

?>
<link rel="stylesheet" href="../css/menu_horizontal.css" type="text/css"  media="screen" >
<span class="preload1"></span>
<span class="preload2"></span>
<ul class="menu2">
    <?php  if (($_SESSION['usuario_nivel']=='Z')||($_SESSION['usuario_nivel']=='N')) {?> 
        <li class="top"><a href="../ordenDeTrabajo" class="a_link"><span class="down">Registrar Nueva</span><!--[if gte IE 7]><!--></a><!--<![endif]--></li>
        <?php  }          
         
        ?>
    <?php  if (($_SESSION['usuario_nivel']=='Z')||($_SESSION['usuario_nivel']=='N')) {?>
    <li class="top">
        <a href="../pendientes" class="a_link">
            <span class="down">
                Ordenes Pendientes
            </span>
            <!--[if gte IE 7]><!-->
        </a><!--<![endif]-->
    </li>
    <?php } ?>
    <li class="top"><a href="#" class="top_link"><span class="down">Impresi&oacute;n</span><!--[if gte IE 7]><!--></a><!--<![endif]-->
        <!--[if lte IE 6]><table><tr><td><![endif]-->
        <ul class="sub">                    
            <li><a href="../ordenDeTrabajo/impresionRecibo.php">Recibo</a></li>
            <li><a href="../ordenDeTrabajo/impresionRemito.php">Remito</a></li>
            <li><a href="../ordenDeTrabajo/impresionGrilla.php">Grilla</a></li>
        </ul>
    </li>
</ul>