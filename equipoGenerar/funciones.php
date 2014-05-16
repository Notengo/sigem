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

function calculafechanacimiento($edad){
    if($edad<>"") {    
    $anio  = date("Y") - $edad;
    $mes = date("m")/* - $mes*/;
    $dia = date("d")/* - $dia*/;    
    return $anio."-".$mes."-".$dia;
    }
}

function mostrarCategorias($idInput,$id,$categorias,$idCampo,$descripcion,$tabindex)
{        
    echo "<select name=\"" . $idInput . "\" id=\"" . $idInput . "\" class='campo' tabindex='".$tabindex."'>
        <option value=\"0\">Seleccione</option>";
    
    foreach ($categorias as $categoria)
    {
        if ($categoria->$idCampo()==$id)
        {
            echo "<option value=\"" . $categoria->$idCampo(). "\" selected=\"selected\">" . $categoria->$descripcion(). "</option>";
        } else  {
            echo "<option value=\"" .$categoria->$idCampo(). "\">" .$categoria->$idCampo." ".$categoria->$descripcion() . "</option>";
        }        
    }
    echo "</select>";
}

?>