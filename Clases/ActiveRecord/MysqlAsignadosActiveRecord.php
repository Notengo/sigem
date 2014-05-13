<?php
require_once '../Clases/ValueObject/AsignadosValueObject.php';

/**
 * Description of MysqlAsignadosActiveRecord
 *
 */
class MysqlAsignadosActiveRecord {
   /**
    * Cuenta la cantidad de registros que hay en la tabla Asignados.
    * @return int 
    */
   public function count() {
      $sql = "SELECT COUNT(*) FROM asignados;";
      $resultado = mysql_query($sql);
      if($resultado){
         $resultado = mysql_fetch_row($resultado);
         return $resultado[0];
      } else {
         return 0;
      }
   }

   /**
    *
    * @param AsignadosValueObject $oValueObject
    * @return boolean 
    */
   public function find($oValueObject) {
      $sql = "SELECT * FROM asignados WHERE idUsuario= " . $oValueObject->getIdUsuario() . " AND nroOrden=". $oValueObject->getNroOrden()." and fechaBaja ='0000-00-00 00:00:00'";                        
      $resultado = mysql_query($sql);
      if($resultado){
            if(mysql_num_rows($resultado)>0) {
                $fila = mysql_fetch_object($resultado);
                $oValueObject->setIdUsuario($fila->idUsuario);
                $oValueObject->setNroOrden($fila->nroOrden);                
                return true;
            } else {
                 return false;
            }           
        } else {
          return false;
      }
   }

   /**
    * Busca todos lo datos de la tabla Asignados que se encuentra en la base de datos.
    * @return boolean 
    */
   public function findAll($oValueObject) {
      $sql = "SELECT * FROM asignados WHERE nroOrden=". $oValueObject->getNroOrden()." and fechaBaja ='0000-00-00 00:00:00'";                              
      $resultado = mysql_query($sql);
      if($resultado){
         $aAsignados = array();
         while ($fila = mysql_fetch_object($resultado)) {
            $oAsignados = new AsignadosValueObject();
            $oAsignados->setNroOrden($fila->nroOrden);
            $oAsignados->setIdUsuario($fila->idUsuario);     
            $aAsignados[] = $oAsignados;
            unset ($oAsignados);
         }
         return $aAsignados;     
        } else {
          return false;
      }
   }

    /**
    * Busca todos lo datos de la tabla Asignados que se encuentra en la base de datos.
    * @param AsignadosValueObject $oValueObject
    * @return boolean 
    */
   public function findIdOrden($oValueObject) {
      $sql = "SELECT * FROM asignados WHERE idUsuario=". $oValueObject->getIdUsuario()." and fechaBaja ='0000-00-00 00:00:00'";                              
      $resultado = mysql_query($sql);
      if($resultado){
         $aAsignados = array();
         while ($fila = mysql_fetch_object($resultado)) {
            $oAsignados = new AsignadosValueObject();
            $oAsignados->setNroOrden($fila->nroOrden);
            $oAsignados->setIdUsuario($fila->idUsuario);     
            $aAsignados[] = $oAsignados;
            unset ($oAsignados);
         }
         return $aAsignados;     
        } else {
          return false;
      }
   }

      /**
    *
    * @param AsignadosValueObject $oValueObject
    * @return boolean 
    */
   public function insert($oValueObject) {
      $sql = "INSERT INTO asignados (nroOrden, idUsuario) VALUES (";
      $sql .= $oValueObject->getNroOrden() . ", ";
      $sql .= $oValueObject->getIdUsuario().");";      
      if (mysql_query($sql)) {
        return true;
      } else { return false; }      
   }

    /**
    *
    * @param AsignadosValueObject $oValueObject
    * @return boolean 
    */
   public function update($oValueObject) {
      $sql = "UPDATE asignados SET fechaBaja= now()";
      $sql.= " WHERE nroOrden = ".$oValueObject->getNroOrden()." AND fechaBaja='0000-00-00 00:00:00';";           
      if (mysql_query($sql))
         return true;
      else
         return false;
   }
   
   
    /**
    *
    * @param AsignadosValueObject $oValueObject
    * @return boolean 
    */
   public function updateUsuario($oValueObject) {
      $sql = "UPDATE asignados SET fechaBaja= now()";
      $sql.= " WHERE nroOrden = ".$oValueObject->getNroOrden()." AND fechaBaja='0000-00-00 00:00:00' AND idUsuario = ".$oValueObject->getIdUsuario().";";           
      if (mysql_query($sql))
         return true;
      else
         return false;
   }
}
?>