<?php
// Se requiere la intefaz ActiveRecord
require_once '../ClasesBasicas/ActiveRecordInterface.php';
// Se requiere la clase LicenciaValueObject
require_once '../Clases/ValueObject/OficexpeValueObject.php';


/**
* Clase que nos permite operaciones de tipo CRUD (Active Record)
* sobre la tabla Oficexpe
*
* Clase que nos permite operaciones de tipos CRUD y otras sobre
* la tabla Oficexpe ubicada en la DB sgu de un motor MySQL.
*
* @copyright  Copyright (c) 2012 DIVISION DESARROLLO | DEPARTAMENTO INFORMATICA
* @license    http://www.gnu.org/licenses/   GPL License
* @version    1.0
* @since      Class available since Release 1.0
*/
class MysqlOficexpeActiveRecord implements ActiveRecord
{
	/**
	 * Nos permite obtener todos los registros de la tabla
	 * Oficexpe en un arreglo de ValueObject.
	 * 
	 * @return array OficexpeValueObject $aOficexpeValueObject or false
	 */
	public function findAll()
	{
		$resultado = mysql_query('SELECT * FROM oficexpe ORDER BY nombre');
		if ($resultado) {
                    $aValueObject = array();
                    while ($fila = mysql_fetch_object($resultado) ) {
                        $oOficexpeValueObject = new OficexpeValueObject();
                        $oOficexpeValueObject->set_ofcodi($fila->ofcodi);
                        $oOficexpeValueObject->set_nombre($fila->nombre);
                        $oOficexpeValueObject->set_domicilio($fila->domicilio);
                        $oOficexpeValueObject->set_coddpto($fila->coddpto);
                        $oOficexpeValueObject->set_codloc($fila->codloc);
                        $oOficexpeValueObject->set_localiza($fila->localiza);
                        $oOficexpeValueObject->set_tipo($fila->tipo);
                        $oOficexpeValueObject->set_cp($fila->cp);
                        $oOficexpeValueObject->set_telefono($fila->telefono);
                        $oOficexpeValueObject->set_telefono2($fila->telefono2);
                        $oOficexpeValueObject->set_fax($fila->fax);
                        $oOficexpeValueObject->set_email($fila->email);
                        $oOficexpeValueObject->set_email2($fila->email);
                        $oOficexpeValueObject->set_complejidad($fila->complejidad);
                        $aValueObject[] = $oOficexpeValueObject;
                        unset($oOficexpeValueObject);
                    }
                    return $aValueObject;
		} else {
			return false;
		} 
	}
	
	/**
	 * Nos permite buscar una oficina en la tabla Oficexpe
	 * utilizando el codigo para identificar la misma
	 * que se pasa por ValueObject.
	 * 
	 * @param OficexpeValueObject $oOficexpeValueObject
	 * @return OficexpeValueObject $oOficexpeValueObject o $oOficexpeValueObject (Sin Datos).
	 */
	public function find($oOficexpeValueObject)
	{
            $resultado = mysql_query('SELECT * FROM oficexpe WHERE ofcodi = '.$oOficexpeValueObject->get_ofcodi());            
            if ($resultado) {
                if(mysql_num_rows($resultado)>0) {
                    $fila = mysql_fetch_object($resultado);
                    $oOficexpeValueObject = new OficexpeValueObject();
                    $oOficexpeValueObject->set_ofcodi($fila->ofcodi);
                    $oOficexpeValueObject->set_nombre($fila->nombre);
                    $oOficexpeValueObject->set_domicilio($fila->domicilio);
                    $oOficexpeValueObject->set_coddpto($fila->coddpto);
                    $oOficexpeValueObject->set_codloc($fila->codloc);
                    $oOficexpeValueObject->set_localiza($fila->localiza);
                    $oOficexpeValueObject->set_tipo($fila->tipo);
                    $oOficexpeValueObject->set_cp($fila->cp);
                    $oOficexpeValueObject->set_telefono($fila->telefono);
                    $oOficexpeValueObject->set_telefono2($fila->telefono2);
                    $oOficexpeValueObject->set_fax($fila->fax);
                    $oOficexpeValueObject->set_email($fila->email);
                    $oOficexpeValueObject->set_email2($fila->email);
                    $oOficexpeValueObject->set_complejidad($fila->complejidad);
                    return $oOficexpeValueObject;
                }
                else {
                    $oOficexpeValueObject->set_ofcodi($oOficexpeValueObject->get_ofcodi());
                    $oOficexpeValueObject->set_nombre("");
                    return $oOficexpeValueObject;
                }
            }
            return false;
        }
        
        /**
	 * Nos permite buscar una oficina en la tabla Oficexpe y anexarle la localidad 
	 * utilizando el codigo para identificar la misma
	 * que se pasa por ValueObject.
	 * 
	 * @param OficexpeValueObject $oOficexpeValueObject
	 * @return OficexpeValueObject $oOficexpeValueObject o $oOficexpeValueObject (Sin Datos).
	 */
	public function findCompleta($oOficexpeValueObject)
	{            
            $sql = "select ofcodi, nombre, localiza, tipo, descri as localidad from oficexpe ";
            $sql .=" left join localida on (oficexpe.coddpto=localida.coddepto and oficexpe.codloc=localida.codloc)";
            $sql .=" where ofcodi = ".$oOficexpeValueObject->get_ofcodi();            
            $resultado = mysql_query($sql);
            
            if ($resultado) {
                if(mysql_num_rows($resultado)>0) {
                    $fila = mysql_fetch_object($resultado);
                    $oOficexpeValueObject = new OficexpeValueObject();
                    $oOficexpeValueObject->set_ofcodi($fila->ofcodi);
                    $oOficexpeValueObject->set_nombre($fila->nombre);
//                    $oOficexpeValueObject->set_domicilio($fila->domicilio);
//                    $oOficexpeValueObject->set_coddpto($fila->coddpto);
                    $oOficexpeValueObject->set_codloc($fila->localidad);
                    $oOficexpeValueObject->set_localiza($fila->localiza);
                    switch($fila->tipo)
                    {
                        case 'H': $tip= "Hospital";break;
                        case 'C': $tip= "Centro de Salud";break;
                        case 'O': $tip= "Oficina";break;
                        default: $tip= "";break;
                    }
                    $oOficexpeValueObject->set_tipo($tip);
//                    $oOficexpeValueObject->set_cp($fila->cp);
//                    $oOficexpeValueObject->set_telefono($fila->telefono);
//                    $oOficexpeValueObject->set_telefono2($fila->telefono2);
//                    $oOficexpeValueObject->set_fax($fila->fax);
//                    $oOficexpeValueObject->set_email($fila->email);
//                    $oOficexpeValueObject->set_email2($fila->email);
//                    $oOficexpeValueObject->set_complejidad($fila->complejidad);
                    return $oOficexpeValueObject;
                }
                else {
                    $oOficexpeValueObject->set_ofcodi($oOficexpeValueObject->get_ofcodi());
                    $oOficexpeValueObject->set_nombre("");
                    return $oOficexpeValueObject;
                }
            }
            return false;
        }
	
        /**
	 * Nos permite obtener todos los registros de la tabla
	 * Oficexpe en un arreglo de ValueObject.
	 * 
	 * @return array OficexpeValueObject $aOficexpeValueObject or false
	 */
	public function findPorTipo()
	{
            $sql = "SELECT oficexpe.`ofcodi`,oficexpe.nombre, oficexpe.tipo, localidades.`nombre` AS codloc FROM oficexpe";
            $sql.= " INNER JOIN localidades ON localidades.`id` = oficexpe.`codloc`";
            $sql.= " WHERE oficexpe.tipo = 'C' OR oficexpe.tipo = 'H' ORDER BY oficexpe.nombre";
            
            $resultado = mysql_query($sql);
		if ($resultado) {
                    $aValueObject = array();
                    while ($fila = mysql_fetch_object($resultado) ) {
                        $oOficexpeValueObject = new OficexpeValueObject();
                        $oOficexpeValueObject->set_ofcodi($fila->ofcodi);
                        $oOficexpeValueObject->set_nombre($fila->nombre);
                        $oOficexpeValueObject->set_codloc($fila->codloc);
                        $oOficexpeValueObject->set_tipo($fila->tipo);
                        $aValueObject[] = $oOficexpeValueObject;
                        unset($oOficexpeValueObject);
                    }
                    return $aValueObject;
		} else {
			return false;
		} 
	}
	
	
        
        /**
	 * Nos permite insertar una fila en la tabla Oficexpe y
	 * los datos se los pasamos por medio de ValueObject.
	 * 
	 * @param OficexpeValueObject $oOficexpeValueObject
	 * @return boolean
	 */
	public function insert($oOficexpeValueObject)
	{
            return false;
	}
	
	/**
	 * Nos permite actualizar una fila de la tabla Oficexpe
	 * utilizando un ValueObject para la entrega de los
	 * nuevos datos.
	 * 
	 * @param OficexpeValueObject $oOficexpeValueObject
	 * @return boolean
	 */
	public function update($oOficexpeValueObject)
	{
            return false;
	}
	
	/**
	 * Nos permite eliminar una fila de la tabla Oficexpe
	 * utilizando el ofcodi para poder eliminar la misma
	 * dentro del ValueObject.
	 * 
	 * @param OficexpeValueObject $oOficexpeValueObject
	 * @return boolean
	 */
	public function delete($oOficexpeValueObject)
	{
            return false;				
	}
	
	/**
	 * Nos permite saber si existe una oficina en la tabla de Oficexpe
	 * para lo cual le pasamos un ValueObject con el ofcodi a buscar.
	 * 
	 * @param OficexpeValueObject $oOficexpeValueObject
	 * @return boolean
	 */
	public function exists($oOficexpeValueObject)
	{
		$resultado = mysql_query('SELECT * FROM oficexpe WHERE ofcodi = '.$oOficexpeValueObject->get_ofcodi());
		if ($resultado) {
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * Nos permite obtener la cantidad de filas que tiene la tabla
	 * Oficexpe
	 * 
	 * @return integer $resultado or false
	 */
        public function count()
        {
                $resultado = mysql_query('SELECT count(*) FROM oficexpe');
                if ($resultado) {
                        return $resultado;
                } else {
                        return false;
                }
        }
        
        /**
         * Devuelve un array buscando por descripcion o parte de la misma o por codigo de oficina.
         * @return array OficexpeValueObject $aValueObject or false
         */
        public function findPorCodDescripcion($oOficexpeValueObject){
            $sql = "SELECT * FROM `oficexpe` ";
            $sql .= "WHERE nombre like '%".$oOficexpeValueObject->get_nombre()."%' order by nombre;";
            $resultado = mysql_query($sql);
            if ($resultado) {
                $aValueObject = array();
                while ($fila = mysql_fetch_object($resultado) ) {
                    $oOficexpeValueObject = new OficexpeValueObject();
                    $oOficexpeValueObject->set_ofcodi($fila->ofcodi);
                    $oOficexpeValueObject->set_nombre($fila->nombre);
                    $oOficexpeValueObject->set_domicilio($fila->domicilio);
                    $oOficexpeValueObject->set_coddpto($fila->coddpto);
                    $oOficexpeValueObject->set_codloc($fila->codloc);
                    $oOficexpeValueObject->set_localiza($fila->localiza);
                    $oOficexpeValueObject->set_tipo($fila->tipo);
                    $oOficexpeValueObject->set_cp($fila->cp);
                    $oOficexpeValueObject->set_telefono($fila->telefono);
                    $oOficexpeValueObject->set_telefono2($fila->telefono2);
                    $oOficexpeValueObject->set_fax($fila->fax);
                    $oOficexpeValueObject->set_email($fila->email);
                    $oOficexpeValueObject->set_email2($fila->email);
                    $oOficexpeValueObject->set_complejidad($fila->complejidad);
                    $aValueObject[] = $oOficexpeValueObject;
                    unset($oOficexpeValueObject);
                }
                return $aValueObject;
            } else {
                    return false;
            }
        }

}