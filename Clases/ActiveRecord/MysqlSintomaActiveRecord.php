<?php
//Se requiere la intefaz ActiveRecord
require_once '../ClasesBasicas/ActiveRecordInterface.php';
 // Se requiere la clase OftalmologiaValueObject
require_once '../Clases/ValueObject/SintomaValueObject.php';

/**
 * Description of MysqlSintomaActiveRecord
 *
 * @author ssrolanr
 */
class MysqlSintomaActiveRecord implements ActiveRecord {
    /**
     * @return int
     */
    public function count() {
        $sql = "SELECT COUNT(*) FROM sintoma;";
        $resultado = mysql_query($sql);
        if($resultado){
            $resultado = mysql_fetch_row($resultado);
            return $resultado[0];
        } else {
            return 0;
        }
    }

    /**
     * 
     * @param SintomaValueObject $oValueObject
     * @return boolean
     */
    public function delete($oValueObject) {
        $sql = "DELETE FROM sintoma WHERE id = " . $oValueObject->getId();
        if(mysql_query($sql)) return true;
        else return false;
    }

    /**
     * 
     * @param SintomaValueObject $oValueObject
     * @return boolean
     */
    public function exists($oValueObject) {
        $sql = "SELECT COUNT(*) FROM sintoma WHERE id = " . $oValueObject->getId();
        $resultado = mysql_query($sql);
        if($resultado){
            $resultado = mysql_fetch_row($resultado);
            if($resultado[0] > 0) return true;
            else return false;
        } else {
            return false;
        }
    }

    /**
     * 
     * @param SintomaValueObject $oValueObject
     * @return \SintomaValueObject
     */
    public function find($oValueObject) {
        $sql = "SELECT * FROM sintoma where ";
        if ($oValueObject->getId() !== ''){
            $sql .= "id = " . $oValueObject->getId();
        } elseif ($oValueObject->getDescripcion() !== ''){
            $sql .= "descripcion = " . $oValueObject->getDescripcion();
        }
        $resultado = mysql_query($sql);
        if($resultado){
            $fila = mysql_fetch_object($resultado);
            $oValueObject->setId($fila->id);
            $oValueObject->setDescripcion($fila->descripcion);
        }
        return $oValueObject;
    }

    /**
     * 
     * @return \SintomaValueObject|boolean
     */
    public function findAll() {
        $sql = "SELECT * FROM sintoma order by descripcion;";
        $resultado = mysql_query($sql);
        if($resultado){
            $aValueObject = array();
            while ($fila = mysql_fetch_object($resultado)) {
                $oValueObject = new SintomaValueObject();
                $oValueObject->setId($fila->id);
                $oValueObject->setDescripcion($fila->descripcion);
                $aValueObject[] = $oValueObject;
                unset($oValueObject);
            }
            return $aValueObject;
        } else {
            return false;
        }
    }

    /**
     * @param SintomaValueObject $oValueObject
     * @return boolean
     */
    public function insert($oValueObject) {
        $sql = "INSERT INTO sintoma (descripcion) value(";
        $sql .= "'".$oValueObject->getDescripcion()."');";
        if(mysql_query($sql)) return true;
        else return false;
    }

    /**
     * @param SintomaValueObject $oValueObject
     * @return boolean
     */
    public function update($oValueObject) {
        $sql = "UPDATE sintoma SET descripcion = '".$oValueObject->getDescripcion()."' ";
        $sql .= "WHERE id = '".$oValueObject->getId().";";
        if(mysql_query($sql)) return true;
        else return false;
    }
    
    /**
     * 
     * @param SintomaValueObject $oValueObject
     * @return boolean
     */
    public function findDescripcion($oValueObject){
        $sql = "SELECT * FROM sintoma WHERE descripcion = '" . $oValueObject->getDescripcion() . "';";
        $resultado = mysql_query($sql);
        if($resultado){
            if(mysql_num_rows($resultado)>0) {
                $fila = mysql_fetch_object($resultado);
                $oValueObject->setId($fila->id);
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
     * @param SintomaValueObject $oValueObject
     * @return boolean
     */
    public function deleteExistente($oValueObject){
        $sql = "SELECT count(*) FROM sintomaorden WHERE idSintoma = " . $oValueObject->getId();
        $resultado = mysql_query($sql);
        if($resultado){
            $fila = mysql_fetch_array($resultado);
            if ($fila[0] <= 0){
                if($this->delete($oValueObject)) return true;
                else return false;
            } else return false;
        } else return false;
    }
}
?>
