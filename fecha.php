<?php
/**
 *
 * Funcion incluida en el  archivo principal de la aplicacion
 * Convierte la fecha actual al siguiente formato: dia de la semana, nro de dia mes y anio
 *
 * @copyright  Copyright (c) 2010 INFORMATICA MINISTERIO DE SALUD
 * @version    1.0
 * @since      File available since Release 1.0
 *
*/

function fecha()
{
    $mes=date('n');
    $dia=date('l');
    switch($mes)    {
        case 1:
            $mes='Enero';
            break;
	case 2:
            $mes='Febrero';
            break;
	case 3:
            $mes='Marzo';
            break;
	case 4:
            $mes='Abril';
            break;
	case 5:
            $mes='Mayo';
            break;
        case 6:
            $mes='Junio';
            break;
	case 7:
            $mes='Julio';
            break;
	case 8:
            $mes='Agosto';
            break;
        case 9:
            $mes='Septiembre';
             break;
        case 10:
             $mes='Octubre';
             break;
        case 11:
            $mes='Noviembre';
            break;
        case 12:
            $mes='Diciembre';
            break;
    }

    switch($dia)    {
         case 'Monday':
                   $dia='Lunes';
                   break;
         case 'Tuesday':
                   $dia='Martes';
                   break;
         case 'Wednesday':
                   $dia='Miercoles';
                   break;
         case 'Thursday':
                   $dia='Jueves';
                   break;
         case 'Friday':
                   $dia='Viernes';
                   break;
         case 'Saturday':
                   $dia='Sabado';
                   break;
         case 'Sunday':
                   $dia='Domingo';
                   break;
    }
	 
    echo " <font face='Verdana, Arial, Helvetica, sans-serif' size='2' color='000999'>".$dia.", ";
    echo "".date('j')." de ".$mes." de ".date('Y')." ";
    echo "</font>";
}
?>