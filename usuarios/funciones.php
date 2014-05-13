<?php 
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
?>
