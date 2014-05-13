<?php
require_once '../Clases/ValueObject/UsuariosValueObject.php';

/**
 * Description of MysqlUsuariosActiveRecord
 *
 */
class MysqlUsuariosActiveRecord {
 
    /**
    *
    * @param UsuariosValueObject $oValueObject
    * @return boolean 
    */
   public function find($oValueObject) {
      $sql = "SELECT * FROM users WHERE  id= " . $oValueObject->getId() . ";";
      $resultado = mysql_query($sql);
      if($resultado){
            if(mysql_num_rows($resultado)>0) {
                $fila = mysql_fetch_object($resultado);
                $oValueObject->setId($fila->id);
                $oValueObject->setDni($fila->dni);
                $oValueObject->setIdentificacion($fila->identificacion);
                $oValueObject->setClave($fila->clave);
                $oValueObject->setPermiso($fila->permiso);
                $oValueObject->setAmbito($fila->ambito);                
                return $oValueObject;
            } else {
                 return false;
            }           
        } else {
          return false;
      }
   }
   
   
       /**
    *
    * @param UsuariosValueObject $oValueObject
    * @return boolean 
    */
   public function findPorOfcodi($ofcodi) {
      $sql = "SELECT * FROM users WHERE id NOT IN ";
      $sql.= " (SELECT idUsuario FROM bloqueo WHERE fechaBaja='0000-00-00 00:00:00' AND ofcodi=".$ofcodi.") and fechaBaja='0000-00-00 00:00:00' order by identificacion";                  
      $resultado = mysql_query($sql);
      if($resultado){
            $aUser = array();
             while ($fila = mysql_fetch_object($resultado)) {
                $oUser = new UsuariosValueObject();                
                $oUser->setId($fila->id);
                $oUser->setDni($fila->dni);
                $oUser->setIdentificacion($fila->identificacion);
                $oUser->setClave($fila->clave);
                $oUser->setPermiso($fila->permiso);
                $oUser->setAmbito($fila->ambito);    
                $aUser[] = $oUser;
                unset ($oUser);                
            }
            return $aUser;
      } else {
            return false;
      }                   
   }    
   
   /**
    *
    * @param UsuariosValueObject $oValueObject
    * @return boolean 
    */
   public function findAll() {
      $sql = "SELECT * FROM users order by identificacion";     
      $resultado = mysql_query($sql);
      if($resultado){
            $aUser = array();
             while ($fila = mysql_fetch_object($resultado)) {
                $oUser = new UsuariosValueObject();                
                $oUser->setId($fila->id);
                $oUser->setDni($fila->dni);
                $oUser->setIdentificacion($fila->identificacion);
                $oUser->setClave($fila->clave);
                $oUser->setPermiso($fila->permiso);
                $oUser->setAmbito($fila->ambito);    
                $aUser[] = $oUser;
                unset ($oUser);                
            }
            return $aUser;
      } else {
            return false;
      }                   
   }    
      
}
?>