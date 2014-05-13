<?php
// Array que vincula los IDs de los selects declarados en el HTML con el nombre de la tabla donde se encuentra su contenido
$listadoSelects=array(
"categoria"=>"rubro",
"especialidades"=>"especialidades",
"problema"=>"problema"
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

$selectDestino=$_GET["select"]; $opcionSeleccionada=$_GET["opcion"];$opcionSeleccionadaAntes=$_GET["opcion2"];

if(validaSelect($selectDestino) && validaOpcion($opcionSeleccionada))
{
	if($listadoSelects[$selectDestino]=='especialidades') {
            // Se requieren los script para acceder a los datos de la DB
            require_once '../ClasesBasicas/ActiveRecordAbstractFactory.php';
            require_once '../Clases/ActiveRecord/MysqlEspecialidadesActiveRecord.php';
            
            $oMysql = ActiveRecordAbstractFactory::getActiveRecordFactory(ActiveRecordAbstractFactory::MYSQL);
            $oMysql->conectar();
            $oMysqlEspecialidades = $oMysql->getEspecialidadesActiveRecord();
            $oEspecialidad = new EspecialidadesValueObject();
            $oEspecialidad->setId($opcionSeleccionada);
            $aEspecialidades = $oMysqlEspecialidades->findAllPorRubro($oEspecialidad);
            echo "<label>Especialidad:</label>";
            echo "<select name='especialidades' id='especialidades' onChange='cargaContenido(this.id)'>";
            echo "<option value='0'>Seleccione</option>";           
            foreach ($aEspecialidades as $registro) {
                echo "<option value='".$registro->getId()."'>".htmlentities($registro->getDescripcion())."</option>";
            }
            echo "<option value='9999'>Nueva</option>";
            echo "</select>*";	
        }
        if($listadoSelects[$selectDestino]=='problema') {
            // Se requieren los script para acceder a los datos de la DB
            require_once '../ClasesBasicas/ActiveRecordAbstractFactory.php';
            require_once '../Clases/ActiveRecord/MysqlTProblemaActiveRecord.php';
            
            $oMysql = ActiveRecordAbstractFactory::getActiveRecordFactory(ActiveRecordAbstractFactory::MYSQL);
            $oMysql->conectar();
            $oMysqlTProblema = $oMysql->getTProblemaActiveRecord();
            $oTProblema= new TProblemaValueObject();
            $oTProblema->setId($opcionSeleccionadaAntes);
            $oTProblema->setDescripcion($opcionSeleccionada);
            $aTProblema = $oMysqlTProblema->findAllPorRubroyEspec($oTProblema);
            echo "<label>Tipo Problema:</label>";
            echo "<select name='problema' id='problema' onChange='cargaTProblema()'>";
            echo "<option value='0'>Seleccione</option>";            
            foreach ($aTProblema as $registro) {
                echo "<option value='".$registro->getId()."'>".htmlentities($registro->getDescripcion())."</option>";
            }
            echo "<option value='9999'>Nuevo</option>";
            echo "</select>*";	            
        }
        
}
?>
