<?php
require_once '../ClasesBasicas/ActiveRecordInterface.php';
include_once '../Clases/ValueObject/MotivoTrasladoValueObject.php';
/**
 * Description of MysqulMotivoTrasladoActiveRecord
 *
 * @author ssrolanr
 */
class MysqlMotivoTrasladoActiveRecord implements ActiveRecord{
    public function count() {
        
    }

    public function delete($oValueObject) {
        
    }

    public function exists($oValueObject) {
        
    }

    /**
     * 
     * @param MotivoTrasladoValueObject $oValueObject
     * @return MotivoTrasladoValueObject
     */
    public function find($oValueObject) {
        $sql = "SELECT * FROM motivotraslado WHERE idMotivoTraslado = "
                . $oValueObject->getIdMotivoTraslado() . ";";
        $resultado = mysql_query($sql);
        if($resultado){
            $fila = mysql_fetch_object($resultado);
            $oValueObject->setDescripcion($fila->descripcion);
            $oValueObject->setFechaAlta($fila->fechaAlta);
            $oValueObject->setFechaBaja($fila->fechaBaja);
            $oValueObject->setUsuarioAlta($fila->usuarioAlta);
            $oValueObject->setUsuarioBaja($fila->usuarioBaja);
        }
        return $oValueObject;
    }

    public function findAll() {
        
    }

    public function insert($oValueObject) {
        
    }

    public function update($oValueObject) {
        
    }
}
?>