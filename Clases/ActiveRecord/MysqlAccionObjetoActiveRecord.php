<?php
require_once '../ClasesBasicas/ActiveRecordInterface.php';
require_once '../Clases/ValueObject/AccionObjetoValuoObject.php';

/**
 * Description of MysqlAccionObjetoActiveRecord
 *
 * @author ssrolanr
 */
class MysqlAccionObjetoActiveRecord implements ActiveRecord {
    /**
     * 
     * @return int
     */
    public function count() {
        $sql = "SELECT count(*) FROM accionobjeto;";
        $respuesta = mysql_query($sql);
        if($respuesta){
            $respuesta = mysql_fetch_array($respuesta);
            return $respuesta[0];
        } else {
            return 0;
        }
    }

    /**
     * 
     * @param AccionObjetoValuoObject $oValueObject
     * @return boolean
     */
    public function delete($oValueObject) {
        $sql = "DELETE FROM accionobjeto WHERE idAccionObjeto = " . $oValueObject->getIdAccionObjeto() . ";";
        if(mysql_query($sql)){
            return true;
        } else {
            return false;
        }
    }

    /**
     * 
     * @param AccionObjetoValuoObject $oValueObject
     * @return boolean
     */
    public function exists($oValueObject) {
        $sql = "SELECT COUNT(*) FROM accionobjeto WHERE idAccionObjeto = " . $oValueObject->getIdAccionObjeto() . ";";
        $resultado = mysql_query($sql);
        if($resultado){
            $resultado = mysql_fetch_row($resultado);
            if($resultado[0]>0){
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * 
     * @param AccionObjetoValuoObject $oValueObject
     * @return boolean
     */
    public function find($oValueObject) {
        $sql = "SELECT * FROM accionobjeto WHERE idAccionObjeto = " . $oValueObject->getIdAccionObjeto() . ";";         
        $resultado = mysql_query($sql);
        if($resultado){
            if(mysql_num_rows($resultado)>0) {
                $fila = mysql_fetch_object($resultado);
                $oValueObject->setIdAccionObjeto($fila->idAccionObjeto);
                $oValueObject->setIdAccion($fila->idAccion);
                $oValueObject->setDescripcion($fila->descripcion);
                return $oValueObject;
            } else {
                return false;
            }
        } else {
              return false;
        }
    }

    /**
     * 
     * @return \AccionObjetoValuoObject|boolean
     */
    public function findAll() {
        $sql = "SELECT * FROM accionobjeto ORDER BY descripcion";      
        $resultado = mysql_query($sql);
        if($resultado){
            $aAccionObjeto = array();
            while ($fila = mysql_fetch_object($resultado)) {
                $oAccionObjeto = new AccionObjetoValuoObject();
                $oAccionObjeto->setIdAccionObjeto($fila->idAccionObjeto);
                $oAccionObjeto->setIdAccion($fila->idAccion);
                $oAccionObjeto->setDescripcion($fila->descripcion);
                $aAccionObjeto[] = $oAccionObjeto;
                unset ($oAccionObjeto);
            }
            return $aAccionObjeto;
        } else {
            return false;
        }
    }
    
    /**
     * 
     * @param AccionObjetoValuoObject $oValueObject
     * @return \AccionObjetoValuoObject|boolean
     */
    public function findAllAccion($oValueObject) {
        $sql = "SELECT * FROM accionobjeto WHERE idAccion = ";
        $sql.= $oValueObject->getIdAccion()." ORDER BY descripcion";      
        $resultado = mysql_query($sql);
        if($resultado){
            $aAccionObjeto = array();
            while ($fila = mysql_fetch_object($resultado)) {
                $oAccionObjeto = new AccionObjetoValuoObject();
                $oAccionObjeto->setIdAccionObjeto($fila->idAccionObjeto);
                $oAccionObjeto->setIdAccion($fila->idAccion);
                $oAccionObjeto->setDescripcion($fila->descripcion);
                $aAccionObjeto[] = $oAccionObjeto;
                unset ($oAccionObjeto);
            }
            return $aAccionObjeto;
        } else {
            return false;
        }
    }

    /**
     * 
     * @param AccionObjetoValuoObject $oValueObject
     * @return boolean
     */
    public function insert($oValueObject) {
        $sql = "INSERT INTO accionObjeto (idAccion, descripcion) value(";
        $sql.= $oValueObject->getIdAccion().", '".$oValueObject->getDescripcion()."')";
        if(mysql_query($sql))
            return true;
        else
            return false;
    }

    /**
     * 
     * @param AccionObjetoValuoObject $oValueObject
     * @return boolean
     */
    public function update($oValueObject) {
        $sql = "UPDATE accion set descripcion = '".$oValueObject->getDescripcion() . "'";
        $sql.= " WHERE idAccionObjeto = ".$oValueObject->getIdAccionObjeto().";";
        if(mysql_query($sql))
            return true;
        else
            return false;
    }
}
?>