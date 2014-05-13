<?php
//Se requiere la intefaz ActiveRecord
require_once '../ClasesBasicas/ActiveRecordInterface.php';
require_once '../Clases/ValueObject/AccionValueObject.php';

/**
 * Description of MysqlAccionActiveRecord
 *
 * @author ssrolanr
 */
class MysqlAccionActiveRecord implements ActiveRecord {
    /**
     * Contabiliza la cantidad de tareas que existen.
     * @return int
     */
    public function count() {
        $sql = "SELECT COUNT(*) FROM accion;";
        $resultado = mysql_query($sql);
        if($resultado){
            $resultado = mysql_fetch_row($resultado);
            return $resultado[0];
        } else {
            return 0;
        }
    }

    /**
     * Elimina un registro de la base de datos correspondiente a la tabla Accion.
     * @param AccionValueObject $oValueObject
     * @return boolean
     */
    public function delete($oValueObject) {
        $sql = "DELETE FROM accion WHERE idAccion = " . $oValueObject->getIdAccion() . ";";
        if(mysql_query($sql)){
            return true;
        } else {
            return false;
        }
    }

    /**
     * Contabiliza las acciones correspondientes a un id especifico.
     * @param AccionValueObject $oValueObject
     * @return boolean
     */
    public function exists($oValueObject) {
        $sql = "SELECT COUNT(*) FROM adquiriente WHERE idAccion = " . $oValueObject->getIdAccion() . ";";
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
     * Retorna los datos correspondiente a un Identificador especifico.
     * @param AccionValueObject $oValueObject
     * @return boolean
     */
    public function find($oValueObject) {
        $sql = "SELECT * FROM accion WHERE idAccion = " . $oValueObject->getIdAccion() . ";";
        $resultado = mysql_query($sql);
        if($resultado){
            if(mysql_num_rows($resultado)>0) {
                $fila = mysql_fetch_object($resultado);
                $oValueObject->setIdAccion($fila->idAccion);
                $oValueObject->setDescripcion($fila->descripcion);
                $oValueObject->setBaja($fila->baja);
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
     * @return \AaccionValueObject|boolean
     */
    public function findAll() {
        $sql = "SELECT * FROM accion ORDER BY descripcion";      
        $resultado = mysql_query($sql);
        if($resultado){
            $aAccion = array();
            while ($fila = mysql_fetch_object($resultado)) {
                $oAccion = new AccionValueObject();
                $oAccion->setIdAccion($fila->idAccion);
                $oAccion->setDescripcion($fila->descripcion);     
                $oAccion->setBaja($fila->baja);     
                $aAccion[] = $oAccion;
                unset ($oAccion);
            }
            return $aAccion;
        } else {
            return false;
        }
    }

    /**
     * 
     * @param AccionValueObject $oValueObject
     * @return boolean
     */
    public function insert($oValueObject) {
        $sql = "INSERT INTO accion (descripcion) value('".$oValueObject->getDescripcion()."')";
        if(mysql_query($sql))
            return true;
        else
            return false;
    }

    /**
     * 
     * @param AccionValueObject $oValueObject
     * @return boolean
     */
    public function update($oValueObject) {
        $sql = "UPDATE accion set descripcion = '".$oValueObject->getDescripcion();
        $sql.= "' baja = '".$oValueObject->getBaja()."'";
        $sql.= " WHERE idAccion = ".$oValueObject->getIdAccion().";";
        if(mysql_query($sql))
            return true;
        else
            return false;
    }

}

?>
