<?php
require_once '../Clases/ValueObject/BloqueoValueObject.php';

/**
 * Description of MysqlBloqueoActiveRecord
 *
 */
class MysqlBloqueoActiveRecord {
   /**
    * Cuenta la cantidad de registros que hay en la tabla Bloqueo.
    * @return int 
    */
   public function count() {
      $sql = "SELECT COUNT(*) FROM bloqueo;";
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
    * @param OrdenValueObject $oValueObject
    * @return boolean 
    */
   public function countPorOfcodi($oValueObject) {
      $sql = "SELECT COUNT(*) FROM bloqueo WHERE ofcodi = " . $oValueObject->getOfcodi() . ";";
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
    * @param BloqueoValueObject $oValueObject
    * @return boolean 
    */
   public function find($oValueObject) {
      $sql = "SELECT * FROM bloqueo WHERE idUsuario= " . $oValueObject->getIdUsuario() ;      
      if($oValueObject->getOfcodi())
            $sql.= " and ofcodi=". $oValueObject->getOfcodi();
      $sql.= " and fechaBaja = '0000-00-00 00:00:00'";                        
      $resultado = mysql_query($sql);
      if($resultado){
            $aBloqueo = array();
            while ($fila = mysql_fetch_object($resultado)) {
                $oBloqueo = new BloqueoValueObject();
                $oBloqueo->setIdUsuario($fila->idUsuario);
                $oBloqueo->setOfcodi($fila->ofcodi);     
                $aBloqueo[] = $oBloqueo;
                unset ($oBloqueo);
            }
            return $aBloqueo;   
        } else {
          return false;
      }
   }

   /**
    * Busca todos lo datos de la tabla Bloqueo que se encuentra en la base de datos.
    * @return boolean 
    */
   public function findAll() {
      $sql = "SELECT * from bloqueo where fechaBaja = '0000-00-00 00:00:00'";      
      $resultado = mysql_query($sql);
      if($resultado){
         $aBloqueo = array();
         while ($fila = mysql_fetch_object($resultado)) {
            $oBloqueo = new BloqueoValueObject();
            $oBloqueo->setIdUsuario($fila->idUsuario);
            $oBloqueo->setOfcodi($fila->ofcodi);     
            $aBloqueo[] = $oBloqueo;
            unset ($oBloqueo);
         }
         return $aBloqueo;
      } else {
         return false;
      }
   }
   
       /**
    *
    * @param BloqueoValueObject $oValueObject
    * @return boolean 
    */
   public function insert($oValueObject) {
      $sql = "INSERT INTO bloqueo (idUsuario,ofcodi, usuarioAlta) VALUES (";
      $sql .= $oValueObject->getIdUsuario() . ", ";
      $sql .= $oValueObject->getOfcodi().", ";
      $sql .= $oValueObject->getUsuarioAlta().");";                  
      if (mysql_query($sql)) {
        return true;
      } else { return false; }      
   }
   
      /**
    *
    * @param BloqueoValueObject $oValueObject
    * @return boolean 
    */
   public function update($oValueObject) {
      $sql = "UPDATE bloqueo SET fechaBaja= now(), usuarioBaja=".$oValueObject->getUsuarioBaja();
      $sql.=" WHERE idUsuario = ".$oValueObject->getIdUsuario()." and ofcodi = ".$oValueObject->getOfcodi(); 
      if (mysql_query($sql))
         return true;
      else
         return false;
   }

}
?>