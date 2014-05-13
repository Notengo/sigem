<?php

// Array que vincula los IDs de los selects declarados en el HTML con el nombre de la tabla donde se encuentra su contenido
$listadoSelects=array(
"departamento"=>"1",
"localidad"=>"2"
);

function validaSelect($selectDestino)
{
	// Se valida que el select enviado via GET exista
	global $listadoSelects;
	if(isset($listadoSelects[$selectDestino])) return true;
	else return false;
}

function validaOpcion($opcionSeleccionada)
{
	// Se valida que la opcion seleccionada por el usuario en el select tenga un valor numerico
	if(is_numeric($opcionSeleccionada)) return true;
	else return false;
}

$selectDestino=$_GET["select"]; $opcionSeleccionada=$_GET["opcion"];

if(validaSelect($selectDestino) && validaOpcion($opcionSeleccionada))
{
        require_once '../ClasesBasicas/ActiveRecordAbstractFactory.php';
        require_once '../Clases/ActiveRecord/MysqlLocalidadActiveRecord.php';
    	
        $oMysql = ActiveRecordAbstractFactory::getActiveRecordFactory(ActiveRecordAbstractFactory::MYSQL);
        $oMysql->conectar();

        $oMysqlLocalidad = $oMysql->getLocalidadActiveRecord();
        
        $oLocalidad = new LocalidadValueObject();
                  
        $oLocalidad->setCoddpto($opcionSeleccionada);
        $oLocalidad = $oMysqlLocalidad->findPorDpto($oLocalidad);
                        
	echo "<select name='".$selectDestino."' id='".$selectDestino."'>";
	foreach ($oLocalidad as $fila){
            echo "<option value=".$fila->getCodloc().">".htmlentities($fila->getDescri())."</option>";
	}
	echo"</select>";

}
?>