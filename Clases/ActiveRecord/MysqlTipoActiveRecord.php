<?php
require_once '../Clases/ValueObject/TipoValueObject.php';

/**
 * Description of MysqlTipoActiveRecord
 *
 */
class MysqlTipoActiveRecord {

    /**
    * Busca todos lo datos de la tabla Tipo que se encuentra en la base de datos.
    * @param TipoValueObject $oValueObject
    * @return boolean 
    */
    public function findId($oValueObject) {
        $sql = "SELECT * from tipo WHERE fechaBaja='0000-00-00 00:00:00' "; 
        if($oValueObject->getId())
            $sql.=" and id='".$oValueObject->getId()."'";
        $sql.=" order by descripcion";        
        $resultado = mysql_query($sql);
        if($resultado){
            if(mysql_num_rows($resultado)>0) {
                $fila = mysql_fetch_object($resultado);                
                $oValueObject->setId($fila->id);
                $oValueObject->setDescripcion($fila->descripcion);
                $oValueObject->setMovIndependiente($fila->movIndependiente);                
                return $oValueObject;
            }  else return false;       
        } else {
          return false;
      }
    }
    
    /**
    * Busca todos lo datos de la tabla Tipo que se encuentra en la base de datos.
    * @param TipoValueObject $oValueObject
    * @return boolean 
    */
    public function findTipo($oValueObject) {
        $sql = "SELECT * from tipo WHERE fechaBaja='0000-00-00 00:00:00' "; 
        if($oValueObject->getDescripcion())
            $sql.=" and descripcion like '%".$oValueObject->getDescripcion()."%'";        
        $sql.=" order by descripcion";
        echo $sql;
        $resultado = mysql_query($sql);
        if($resultado){
            $aTipo = array();
            while ($fila = mysql_fetch_object($resultado)) {
                $oTipo = new TipoValueObject();
                $oTipo->setId($fila->id);
                $oTipo->setDescripcion($fila->descripcion);                            
                $aTipo[] = $oTipo;
                unset ($oTipo);
            }
            return $aTipo;
        } else {
            return false;
        }
    }

}
?>