<?php
function fn_filtro($cadena) {
    if(get_magic_quotes_gpc() != 0) {
        $cadena = stripslashes($cadena);
    }
    return mysql_real_escape_string($cadena);
}

function tipo_establec($tipo) {
    $tip="";
    switch($tipo) {
        case 'H': $tip= "Hospital";break;
        case 'C': $tip= "Centro de Salud";break;
        case 'O': $tip= "Oficina";break;
    }
    return $tip;
}