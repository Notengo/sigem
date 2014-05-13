<?php
//Se requiere la intefaz ActiveRecord
require_once '../ClasesBasicas/ActiveRecordInterface.php';
// Se requiere la clase OftalmologiaValueObject
require_once '../Clases/ValueObject/PedidoOrdenValueObject.php';

/**
 * Description of MysqlPedidoOrdenActiveRecord
 *
 * @author ssrolanr
 */
class MysqlPedidoOrdenActiveRecord implements ActiveRecord{
    public function count() {
        
    }

    public function delete($oValueObject) {
        
    }

    public function exists($oValueObject) {
        
    }

    /**
     * 
     * @param PedidoOrdenValueObject $oValueObject
     * @return \PedidoOrdenValueObject|boolean
     */
    public function find($oValueObject) {
        $sql = "SELECT * FROM pedidoorden WHERE idOrden = " . $oValueObject->getIdOrden();
        $resultado = mysql_query($sql);
        if($resultado){
            $aValueObject = array();
            while ($fila = mysql_fetch_object($resultado)) {
                $oValueObject = new PedidoOrdenValueObject();
                $oValueObject->setIdOrden($fila->idOrden);
                $oValueObject->setIdPedido($fila->idPedido);
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
     * @param PedidoOrdenValueObject $oValueObject
     * @return boolean
     */
    public function insert($oValueObject) {
        $sql = "INSERT INTO pedidoorden value(";
        $sql.= $oValueObject->getIdOrden() . ", " . $oValueObject->getIdPedido();
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
