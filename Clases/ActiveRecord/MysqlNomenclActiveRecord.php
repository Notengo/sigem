<?php
require_once '../Clases/ValueObject/NomenclValueObject.php';

/**
 * Description of MysqlNomenclActiveRecord
 *
 */
class MysqlNomenclActiveRecord {

    /**
    * Busca todos lo datos de la tabla Nomencl que se encuentra en la base de datos.
    * @param NomenclValueObject $oValueObject
    * @return boolean 
    */
    public function findId($oValueObject) {
        $sql = "SELECT * from nomencl "; 
        if($oValueObject->getCod_eq())
            $sql.=" where cod_eq='".$oValueObject->getCod_eq()."'";
        $sql.=" order by des_eq";              
        $resultado = mysql_query($sql);
        if($resultado){
            if(mysql_num_rows($resultado)>0) {
                $fila = mysql_fetch_object($resultado);                
                $oValueObject->setCod_eq($fila->cod_eq);
                $oValueObject->setDes_eq($fila->des_eq);                
                $oValueObject->setRx($fila->rx);         
                return $oValueObject;
            }  else return false;       
        } else {
          return false;
      }
    }
    
    /**
    * Busca todos lo datos de la tabla Nomencl que se encuentra en la base de datos.
    * @param NomenclValueObject $oValueObject
    * @return boolean 
    */
    public function findNomencl($oValueObject) {
        $sql = "SELECT * from nomencl WHERE "; 
        if($oValueObject->getDes_eq())
            $sql.=" des_eq like '%".$oValueObject->getDes_eq()."%'";
        $sql.=" order by des_eq";
        $resultado = mysql_query($sql);
        if($resultado){
            $aTipo = array();
            while ($fila = mysql_fetch_object($resultado)) {
                $oTipo = new NomenclValueObject();
                $oTipo->setCod_eq($fila->cod_eq);
                $oTipo->setDes_eq($fila->des_eq);     
                $oTipo->setRx($fila->rx);
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