<?php
require_once '../ClasesBasicas/ActiveRecordAbstractFactory.php';
require_once 'funciones.php';

$oMysql = ActiveRecordAbstractFactory::getActiveRecordFactory(ActiveRecordAbstractFactory::MYSQL);
$oMysql->conectar();

/*verificamos si las variables se envian*/
if(empty($_POST['nombre'])){
    echo "Debe completar los campos requeridos";
    exit;
}
	
/*modificar el registro*/
$sql = sprintf("UPDATE accionobjeto SET descripcion= '%s' where idAccionObjeto = %d;",
        fn_filtro(substr(utf8_decode($_POST['nombre']), 0, 150)),
        fn_filtro((int)$_POST['idAccionObjeto'])
        );
if(!mysql_query($sql))
    echo $sql."Error al modificar el objeto de la acci&oacute;n";
else 
    echo "Datos modificados";
exit;

?>