<?php
require_once '../Clases/ValueObject/OrdenCompraValueObject.php';

/**
 * Description of MysqlOrdenCompraActiveRecord
 *
 */
class MysqlOrdenCompraActiveRecord {

    /**
    *
    * @param OrdenCompraValueObject $oValueObject
    * @return boolean 
    */
   public function insert($oValueObject) {
      $sql = "INSERT INTO ordencompra (`nro`, `fecha`, `proveedor`, `observacion`,`usuarioAlta`) VALUES (";
      $sql .= "'".$oValueObject->getNro() . "', '" . $oValueObject->getFecha() . "', ";
      $sql .= $oValueObject->getProveedor() . ", '" . $oValueObject->getObservacion(). "', " . $oValueObject->getUsuario() . ") ";                                
      if(mysql_query($sql)){
         return true;        
      } else {         
         return false;
      }
   }
   
    /**
    * Busca todos lo datos de la tabla OrdenCompra que se encuentra en la base de datos.
    * @param OrdenCompraValueObject $oValueObject
    * @return boolean 
    */
    public function findOC($oValueObject) {        
        $sql = "SELECT * from ordencompra WHERE fechaBaja='0000-00-00 00:00:00' "; 
        if($oValueObject->getNro())
            $sql.=" and nro like '%".$oValueObject->getNro()."%'";
        $sql.=" order by nro";           
        $resultado = mysql_query($sql);
        if($resultado){
            $aOC = array();
            while ($fila = mysql_fetch_object($resultado)) {
                $oOC = new OrdenCompraValueObject();
                $oOC->setId($fila->id);
                $oOC->setNro($fila->nro);                                
                $aOC[] = $oOC;
                unset ($oOC);
            }
            return $aOC;
        } else {
            return false;
        }
    }

        /**
    *
    * @param OrdenCompraValueObject $oValueObject
    * @return boolean 
    */
   public function find($oValueObject) {
      $sql = "SELECT * FROM ordencompra WHERE  id= " . $oValueObject->getId() . ";";                           
      $resultado = mysql_query($sql);
      if($resultado){
            if(mysql_num_rows($resultado)>0) {
                $fila = mysql_fetch_object($resultado);
                $oValueObject->setId($fila->id);
                $oValueObject->setNro($fila->nro);
                $oValueObject->setProveedor($fila->proveedor);                
                $oValueObject->setFecha($fila->fecha);
                return $oValueObject;
            } else {
                 return false;
            }           
        } else {
          return false;
      }
   }

}
?>