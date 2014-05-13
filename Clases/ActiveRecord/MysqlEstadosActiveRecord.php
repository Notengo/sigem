<?php
include_once '../Clases/ValueObject/EstadosValueObject.php';
include_once '../ClasesBasicas/ActiveRecordInterface.php';

/**
 * Description of MysqlEstadosActiveRecord
 *
 * @author ssrolanr
 */
class MysqlEstadosActiveRecord implements ActiveRecord {
    public function count() {
        $sql = "SELECT COUNT(*) FROM estados;";
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
     * @param EstadosValueObject $oValueObject
     * @return boolean
     */
    public function delete($oValueObject) {
        $sql = "DELETE estados WHERE id = " . $oValueObject->getId();
        if(mysql_query($sql)) return true;
        else return false;
    }

    /**
     * 
     * @param EstadosValueObject $oValueObject
     * @return boolean
     */
    public function exists($oValueObject) {
        $sql = "SELECT COUNT(*) FROM estados WHERE id = " . $oValueObject->getId();
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
     * @param EstadosValueObject $oValueObject
     * @return EstadosValueObject Devuelve un registro correspondiente al id o a la descripcion buscada.
     */
    public function find($oValueObject) {
        $sql = "SELECT * FROM estados where ";
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
            $oValueObject->setMant($fila->mant);
        }
        return $oValueObject;
    }
    
    /**
     * 
     * @return EstadosValueObject
     */
    public function findAll() {
        $sql = "SELECT * FROM estados order by descripcion;";
        $resultado = mysql_query($sql);
        if($resultado){
            $aValueObject = array();
            while ($fila = mysql_fetch_object($resultado)) {
                $oValueObject = new EstadosValueObject();
                $oValueObject->setId($fila->id);
                $oValueObject->setDescripcion($fila->descripcion);
                $oValueObject->setMant($fila->mant);
                $aValueObject[] = $oValueObject;
                unset($oValueObject);
            }
            return $aValueObject;
        } else {
            return false;
        }
    }

    /**
     * 
     * @param EstadosValueObject $oValueObject
     * @return boolean
     */
    public function insert($oValueObject) {
        $sql = "INSERT INTO estados (descripcion, mant) value(";
        $sql .= "'".$oValueObject->getDescripcion()."', ";
        $sql .= "'".$oValueObject->getMant()."');";
        if(mysql_query($sql)) return true;
        else return false;
    }

    /**
     * 
     * @param EstadosValueObject $oValueObject
     * @return boolean
     */
    public function update($oValueObject) {
        $sql = "UPDATE estados SET descripcion = '".$oValueObject->getDescripcion()."', ";
        $sql .= "mant = '".$oValueObject->getMant()."'";
        $sql .= " WHERE id = '".$oValueObject->getId().";";
        if(mysql_query($sql)) return true;
        else return false;
    }
}
?>