<?php

function fn_filtro($cadena) {
	if(get_magic_quotes_gpc() != 0) {
		$cadena = stripslashes($cadena);
	}
	return mysql_real_escape_string($cadena);
}

/////////////////////////////////////////////////
function tipo_establec($tipo)
{
$tip="";
switch($tipo)
{
	case 'H': $tip= "Hospital";break;
	case 'C': $tip= "Centro de Salud";break;
	case 'O': $tip= "Oficina";break;
}
return $tip;
}

function calculaedad($fechanacimiento){
    if($fechanacimiento<>"") {
    list($ano,$mes,$dia) = explode("-",$fechanacimiento);
    $ano_diferencia  = date("Y") - $ano;
    $mes_diferencia = date("m") - $mes;
    $dia_diferencia   = date("d") - $dia;
    if ($mes_diferencia == 0 && $dia_diferencia < 0)
        $ano_diferencia--;
    if ($mes_diferencia < 0) {
        $ano_diferencia--;}
    return $ano_diferencia;
    }
}

?>