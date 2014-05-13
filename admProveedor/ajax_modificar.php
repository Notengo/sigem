<?php
require_once '../ClasesBasicas/ActiveRecordAbstractFactory.php';
require_once 'funciones.php';

$oMysql = ActiveRecordAbstractFactory::getActiveRecordFactory(ActiveRecordAbstractFactory::MYSQL);
$oMysql->conectar();

/*verificamos si las variables se envian*/
if(empty($_POST['nombre']) || empty($_POST['direccion'])){
        echo "Debe completar los campos requeridos";
        exit;
}
	
/*modificar el registro*/
$sql = sprintf("UPDATE proveedor SET  nombre='%s', duenio='%s', direccion='%s', telefono='%s', fax='%s', referencia='%s' where id=%d;",
        fn_filtro(substr(utf8_decode($_POST['nombre']), 0, 150)),                
        fn_filtro(substr(utf8_decode($_POST['duenio']), 0, 150)),
        fn_filtro(substr(utf8_decode($_POST['direccion']), 0, 100)),
        fn_filtro(substr($_POST['telefono'], 0, 50)),
        fn_filtro(substr($_POST['fax'], 0, 50)),
        fn_filtro(substr($_POST['calificacion'], 0, 50)),
        fn_filtro((int)$_POST['id'])
        );
if(!mysql_query($sql))
        echo "Error al modificar el proveedor";
else 
    echo "Datos modificados";
exit;

?>