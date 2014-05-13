<?php
	require_once '../ClasesBasicas/ActiveRecordAbstractFactory.php';
        require_once 'funciones.php';
        
        $oMysql = ActiveRecordAbstractFactory::getActiveRecordFactory(ActiveRecordAbstractFactory::MYSQL);
        $oMysql->conectar();
	
	/*verificamos si las variables se envian*/
	if(empty($_POST['ofcodi']) || empty($_POST['nombre']) || empty($_POST['domicilio']) || empty($_POST['localidad']) || empty($_POST['departamento'])){
		echo "Debe completar los campos requeridos";
		exit;
	}
	
	/*modificar el registro*/

	$sql = sprintf("UPDATE oficexpe SET  nombre='%s', domicilio='%s', coddpto=%d, codloc=%d, localiza='%s', tipo='%s',telefono='%s', email='%s' where ofcodi=%d;",
		fn_filtro(substr(utf8_decode($_POST['nombre']), 0, 50)),                
		fn_filtro(substr(utf8_decode($_POST['domicilio']), 0, 60)),
		fn_filtro((int)$_POST['departamento']),
		fn_filtro((int)$_POST['localidad']),
                fn_filtro(substr(utf8_decode($_POST['localiza']), 0, 30)),
                fn_filtro(substr($_POST['tipo'], 0, 1)),
                fn_filtro(substr($_POST['telefono'], 0, 30)),
                fn_filtro(substr($_POST['email'], 0, 50)),
		fn_filtro((int)$_POST['ofcodi'])
	);
	if(!mysql_query($sql))
		echo "Error al insertar la dependencia";
        else 
            echo "Datos modificados";
	exit;
?>