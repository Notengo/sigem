<?php
include_once '../ClasesBasicas/ActiveRecordAbstractFactory.php';
include_once '../Clases/ValueObject/TareaValueObject.php';

/**
 * Description of MysqlTareaAvtiveRecord
 *
 * @author ssrolanr
 */
class MysqlTareaAvtiveRecord implements ActiveRecord{
    public function count() {
        
    }

    public function delete($oValueObject) {
        
    }

    public function exists($oValueObject) {
        $sql = "SELECT COUNT(*) FROM tarea ";
        $sql.= "WHERE idOrden = " . $oValueObject->getIdOrden();
        $resultado = mysql_query($sql);
        $resultado = mysql_fetch_array($resultado);
        if ($resultado[0] > 0) return true;
        else return false;
    }

    /**
     * 
     * @param TareaValueObject $oValueObject
     * @return \TareaValueObject|boolean
     */
    public function find($oValueObject) {
        $sql = "SELECT idOrden, idAccionObjeto, fechaInicio, fechaFin, idUsers, idAccion ";
        $sql.= "FROM tarea WHERE idOrden = ".$oValueObject->getIdOrden()." ORDER BY fechaInicio, fechaFin;";
        $resultado = mysql_query($sql);
        if($resultado){
            $aTarea = array();
            while ($fila = mysql_fetch_object($resultado)) {
                $oTarea = new TareaValueObject();
                $oTarea->setIdOrden($fila->idOrden);
                $oTarea->setIdAccionObjeto($fila->idAccionObjeto);
                $oTarea->setFechaInicio($fila->fechaInicio);
                $oTarea->setFechaFin($fila->fechaFin);
                $oTarea->setIdUsers($fila->idUsers);
                $oTarea->setIdAccion($fila->idAccion);
                $aTarea[] = $oTarea;
                unset ($otarea);
            }
            return $aTarea;
        } else {
            return false;
        }
    }

    public function findAll() {
        
    }

    /**
     * 
     * @param TareaValueObject $oValueObject
     * @return boolean
     */
    public function insert($oValueObject) {
        $sql = "INSERT INTO tarea (idOrden, idAccionObjeto, fechaInicio, fechaFin, idUsers, idAccion) ";
        $sql.= "VALUES(" . $oValueObject->getIdOrden();
        $sql.= ", " . $oValueObject->getIdAccionObjeto();
        $sql.= ", '" . $oValueObject->getFechaInicio();
        $sql.= "', '" . $oValueObject->getFechaFin();
        $sql.= "', " . $oValueObject->getIdUsers();
        $sql.= ", " . $oValueObject->getidAccion() . ");";
        if (mysql_query($sql)) return true;
        else return false;
    }

    public function update($oValueObject) {
        
    }

}

?>
