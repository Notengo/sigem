<?php
//Se requiere la intefaz ActiveRecord
require_once '../ClasesBasicas/ActiveRecordInterface.php';
// Se requiere la clase OftalmologiaValueObject
require_once '../Clases/ValueObject/SintomaOrdenValueObject.php';
/**
 * Description of MysqlSintomaOrdenActiveRecord
 *
 * @author ssrolanr
 */
class MysqlSintomaOrdenActiveRecord implements ActiveRecord{
    public function count() {
        
    }

    public function delete($oValueObject) {
        
    }

    public function exists($oValueObject) {
        
    }

    /**
     * 
     * @param SintomaOrdenValueObject $oValueObject
     * @return \SintomaOrdenValueObject|boolean
     */
    public function find($oValueObject) {
        $sql = "SELECT * FROM sintomaorden WHERE idOrden = " . $oValueObject->getIdOrden();
        $resultado = mysql_query($sql);
        if($resultado){
            $aValueObject = array();
            while ($fila = mysql_fetch_object($resultado)) {
                $oValueObject = new SintomaOrdenValueObject();
                $oValueObject->setIdOrden($fila->idOrden);
                $oValueObject->setIdSintoma($fila->idSintoma);
                $aValueObject[] = $oValueObject;
                unset($oValueObject);
            }
            return $aValueObject;
        } else {
            return false;
        }
    }

    public function findAll() {
        
    }

    /**
     * 
     * @param SintomaOrdenValueObject $oValueObject
     */
    public function insert($oValueObject) {
        $sql = "INSERT INTO sintomaorden value(";
        $sql.= $oValueObject->getIdOrden() . ", " . $oValueObject->getIdSintoma();
        $sql .= ")";
        if(mysql_query($sql)){
            return true;
        } else {
            return false;
        }
    }

    public function update($oValueObject) {
        
    }    //put your code here
}

?>
