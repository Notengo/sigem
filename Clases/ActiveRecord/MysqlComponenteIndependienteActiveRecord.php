<?php
// Se requiere la clase ComponenteValueObject
require_once '../Clases/ValueObject/ComponenteIndependienteValueObject.php';

/**
 * Description of MysqlComponenteIndependienteActiveRecord
 *
 */
class MysqlComponenteIndependienteActiveRecord {     
    /**
    *
    * @param ComponenteIndependienteValueObject $oValueObject
    * @return boolean 
    */
   public function find($oValueObject) {
      $sql = "SELECT * FROM componenteIndependiente WHERE id=" . $oValueObject->getId()." and fechaBaja='0000-00-00 00:00:00'";                                                
      $resultado = mysql_query($sql);
      if($resultado){
          if(mysql_num_rows($resultado)>0) {
            $fila = mysql_fetch_object($resultado);            
            $oValueObject->setId($fila->id);
            $oValueObject->setNro($fila->nro);
            $oValueObject->setIdTipo($fila->idTipo);
            $oValueObject->setIdMarca($fila->idMarca);
            $oValueObject->setIdModelo($fila->idModelo);
            $oValueObject->setNroSerie($fila->nroSerie);
            $oValueObject->setCantidad($fila->cantidad);
            return true;
          }   else {
                 return false;
          }           
        } else {
          return false;
      }
   }
   
   /**
    *
    * @param ComponenteIndependienteValueObject $oValueObject
    * @return boolean 
    */
   public function insert($oValueObject) {
      $sql = "INSERT INTO componenteIndependiente (nro, idTipo, idMarca, idModelo, nroSerie, detalle, cantidad, nroOrdenCompra, ofcodi, usuarioAlta) VALUES (";
      $sql .= $oValueObject->getNro() . ", ";      
      $sql .= $oValueObject->getIdTipo() . ", ";
      $sql .= $oValueObject->getIdMarca() . ", ";
      $sql .= $oValueObject->getIdModelo() . ", '";
      $sql .= $oValueObject->getNroSerie() . "', '";
      $sql .= $oValueObject->getDetalle() . "', '";
      $sql .= $oValueObject->getCantidad() . "', ";
      $sql .= $oValueObject->getNroOrdenCompra() . ", ";
      $sql .= $oValueObject->getOfcodi() . ", ";
      $sql .= $oValueObject->getUsuarioAlta() . ") ";                  
      if (mysql_query($sql))  {        
           $result = mysql_query("SELECT DISTINCT LAST_INSERT_ID() FROM componenteIndependiente");
           $id = mysql_fetch_array($result);            
           if($id[0]<>0) {                
                return $id[0];
           } else { return false; }
      } else {     
            return false;
      }  
    }

}
?>