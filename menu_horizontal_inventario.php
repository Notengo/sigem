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
        <li class="top">
            <a href="#" class="top_link">
                <span class="down">Administraci&oacute;n B&aacute;sica</span>
                <!--[if gte IE 7]><!-->
            </a>
            <!--<![endif]-->
            <!--[if lte IE 6]><table><tr><td><![endif]-->
            <ul class="sub">                    
                <li><a href="../oficexpe">Dependencias</a></li>
                <li><a href="../admProveedor">Proveedores</a></li>
                <li><a href="../admServicio">Servicios</a></li>
                <li><a href="../admSintoma">Sintomass</a></li>
                <li><a href="../admPedido">Pedidos</a></li>
                <li><a href="../admAccion">Acciones</a></li>
            </ul>
        </li>
        <li class="top">
            <a href="../admEquipo" class="a_link"><span class="down">Equipamiento</span><!--[if gte IE 7]><!--></a><!--<![endif]-->
        </li>
        <li class="top"><a href="#" class="top_link"><span class="down">Consultas</span><!--[if gte IE 7]><!--></a><!--<![endif]-->
            <!--[if lte IE 6]><table><tr><td><![endif]-->
            <ul class="sub">                    
                <li><a href="../consultaLocalizacion">Por localizaci&oacute;n</a></li>                                                    
            </ul>
        </li>
        <li class="top">
            <a href="#" class="top_link">
                <span class="down">Traslado</span>
                <!--[if gte IE 7]><!-->
            </a><!--<![endif]-->
            <!--[if lte IE 6]><table><tr><td><![endif]-->
            <ul class="sub">                    
                <li><a href="../traslado/">Enviar</a></li>                                                    
                <li><a href="../traslado/recibido.php">Recibir</a></li>                                                    
            </ul>
        </li>
    <?php } ?>
</ul>