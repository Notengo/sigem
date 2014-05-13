<?php
	require_once '../ClasesBasicas/ActiveRecordAbstractFactory.php';
        require_once '../includes/funciones.php';
        
        $oMysql = ActiveRecordAbstractFactory::getActiveRecordFactory(ActiveRecordAbstractFactory::MYSQL);
        $oMysql->conectar();
        
	/*verificamos si las variables se envian*/
        if(empty($_POST['nombre']) || empty($_POST['localidad']) || empty($_POST['departamento'])){
		echo "Debe completar los campos requeridos";
		exit;
	}
	
	/*obtenemos el ide mayor*/
	$sql = "select ofcodi from oficexpe order by ofcodi desc limit 1";
	$per = mysql_query($sql);
	$rs_per = mysql_fetch_assoc($per);
	
	/*insertamos el nuevo registro*/
	$ofcodi = $rs_per['ofcodi'] + 1;
    
	$sql = sprintf("INSERT INTO `oficexpe` VALUES (%d, '%s', '%s', %d, %d,'%s','%s','', '%s','','','%s','','','','','');",
		fn_filtro((int)$ofcodi),
		fn_filtro(substr(utf8_decode($_POST['nombre']), 0, 50)),                
		fn_filtro(substr($_POST['domicilio'], 0, 60)),
		fn_filtro((int)$_POST['departamento']),
		fn_filtro((int)$_POST['localidad']),
                fn_filtro(substr($_POST['localiza'], 0, 50)),
                fn_filtro(substr($_POST['tipo'], 0, 30)),
                fn_filtro(substr($_POST['telefono'], 0, 30)),
                fn_filtro(substr($_POST['email'], 0, 50))		
	);

	if(!mysql_query($sql))
		echo "Error al insertar a la dependencia";
        else
            echo "Datos guardados";
	exit;
?>