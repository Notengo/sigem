<?php
require_once '../ClasesBasicas/ActiveRecordInterface.php';
require_once '../Clases/ValueObject/TareaRepuestoValueObject.php';

/**
 * Description of MysqlTareaRepuestoActiveRecord
 *
 * @author ssrolanr
 */
class MysqlTareaRepuestoActiveRecord implements ActiveRecord {
    public function count() {
        
    }

    public function delete($oValueObject) {
        
    }

    public function exists($oValueObject) {
        
    }

    public function find($oValueObject) {
        
    }

    public function findAll() {
        
    }

    /**
     * 
     * @param TareaRepuestoValueObject $oValueObject
     * @return boolean
     */
    public function insert($oValueObject) {
        $sql = "INSERT INTO tarearepuesto (idOrden, idAccionObjeto, idRepuesto, cantidad, precio, cajaChica, idAccion) ";
        $sql.= "VALUES (" . $oValueObject->getIdOrden();
        $sql.= ", " . $oValueObject->getIdAccionObjeto();
        $sql.= ", " . $oValueObject->getIdRepuesto();
        $sql.= ", " . $oValueObject->getCantidad();
        $sql.= ", " . $oValueObject->getPrecio();
        $sql.= ", " . $oValueObject->getCajaChica();
        $sql.= ", " . $oValueObject->getIdAccion() . ");";
echo $sql . "<br>";
        if (mysql_query($sql)) return true;
        else return false;
    }

    public function update($oValueObject) {
        
    }

}

?>
