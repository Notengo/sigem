<?php
//Se requiere la intefaz ActiveRecord
require_once '../ClasesBasicas/ActiveRecordInterface.php';
// Se requiere la clase EquipoValueObject
require_once '../Clases/ValueObject/RepuestoValueObject.php';

/**
 * Description of MysqlRepuestoActiveRecord
 *
 * @author ssrolanr
 */
class MysqlRepuestoActiveRecord implements ActiveRecord {
    /**
     * Contabiliza la cantidad total de repuestos existentes.
     * @return int
     */
    public function count() {
        $sql = "SELECT count(*) FROM repuesto;";
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
     * @param RepuestoValueObject $oValueObject
     * @return boolean
     */
    public function delete($oValueObject) {
        $sql = "DELETE FROM repuesto WHERE idRepuesto = " . $oValueObject->getIdRepuesto() . ";";
        if(mysql_query($sql)){
            return true;
        } else {
            return false;
        }
    }

    /**
     * 
     * @param RepuestoValueObject $oValueObject
     * @return boolean
     */
    public function exists($oValueObject) {
        $sql = "SELECT COUNT(*) FROM repuesto WHERE idRepuesto = " . $oValueObject->getIdRepuesto() . ";";
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
     * @param RepuestoValueObject $oValueObject
     * @return boolean
     */
    public function find($oValueObject) {
        $sql = "SELECT * FROM repuesto WHERE idRepuesto = " . $oValueObject->getIdRepuesto() . ";";         
        $resultado = mysql_query($sql);
        if($resultado){
            if(mysql_num_rows($resultado)>0) {
                $fila = mysql_fetch_object($resultado);
                $oValueObject->setIdRepuesto($fila->idRepuesto);
                $oValueObject->setDescripcion($fila->descripcion);
                return $oValueObject;
            } else {
                return false;
            }
        } else {
              return false;
        }
    }

    public function findAll() {
        $sql = "SELECT * FROM repuesto ORDER BY descripcion";      
        $resultado = mysql_query($sql);
        if($resultado){
            $aRepuesto = array();
            while ($fila = mysql_fetch_object($resultado)) {
                $oRepuesto = new RepuestoValueObject();
                $oRepuesto->setIdRepuesto($fila->idRepuesto);
                $oRepuesto->setDescripcion($fila->descripcion);     
                $aRepuesto[] = $oRepuesto;
                unset ($oRepuesto);
            }
            return $aRepuesto;
        } else {
            return false;
        }
    }

    public function insert($oValueObject) {
        
    }

    public function update($oValueObject) {
        
    }
}
?>