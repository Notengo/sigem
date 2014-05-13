<?php
require_once '../Clases/ValueObject/UsuariosEquiposValueObject.php';

/**
 * Description of MysqlUsuariosEquiposActiveRecord
 *
 */
class MysqlUsuariosEquiposActiveRecord {
 
    /**
    *
    * @param UsuariosEquiposValueObject $oValueObject
    * @return boolean 
    */
   public function find($oValueObject) {
      $sql = "SELECT * FROM usuarios WHERE nombre= '" . $oValueObject->getNombre() . "';";              
      $resultado = mysql_query($sql);
      if($resultado){
            if(mysql_num_rows($resultado)>0) {
                $fila = mysql_fetch_object($resultado);
                $oValueObject->setId($fila->id);
                $oValueObject->setDni($fila->dni);
                $oValueObject->setNombre($fila->nombre);                
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
    * @param UsuariosEquiposValueObject $oValueObject
    * @return boolean 
    */
   public function findId($oValueObject) {
      $sql = "SELECT * FROM usuarios WHERE id=" . $oValueObject->getId() . ";";                     
      $resultado = mysql_query($sql);
      if($resultado){
            if(mysql_num_rows($resultado)>0) {
                $fila = mysql_fetch_object($resultado);
                $oValueObject->setId($fila->id);
                $oValueObject->setDni($fila->dni);
                $oValueObject->setNombre($fila->nombre);                
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
    * @param UsuariosEquiposValueObject $oValueObject
    * @return boolean 
    */
   public function findDni($oValueObject) {
      $sql = "SELECT * FROM usuarios WHERE dni=" . $oValueObject->getDni() . ";";                           
      $resultado = mysql_query($sql);
      if($resultado){
            if(mysql_num_rows($resultado)>0) {
                $fila = mysql_fetch_object($resultado);
                $oValueObject->setId($fila->id);
                $oValueObject->setDni($fila->dni);
                $oValueObject->setNombre($fila->nombre);                
                return $oValueObject;
            } else {
                 return false;
            }           
        } else {
          return false;
      }
   }
   
//   
//   
//       /**
//    *
//    * @param UsuariosValueObject $oValueObject
//    * @return boolean 
//    */
//   public function findPorOfcodi($ofcodi) {
//      $sql = "SELECT * FROM users WHERE id NOT IN ";
//      $sql.= " (SELECT idUsuario FROM bloqueo WHERE fechaBaja='0000-00-00 00:00:00' AND ofcodi=".$ofcodi.") and fechaBaja='0000-00-00 00:00:00'";                  
//      $resultado = mysql_query($sql);
//      if($resultado){
//            $aUser = array();
//             while ($fila = mysql_fetch_object($resultado)) {
//                $oUser = new UsuariosValueObject();                
//                $oUser->setId($fila->id);
//                $oUser->setDni($fila->dni);
//                $oUser->setIdentificacion($fila->identificacion);
//                $oUser->setClave($fila->clave);
//                $oUser->setPermiso($fila->permiso);
//                $oUser->setAmbito($fila->ambito);    
//                $aUser[] = $oUser;
//                unset ($oUser);                
//            }
//            return $aUser;
//      } else {
//            return false;
//      }                   
//   }    
//   
//   /**
//    *
//    * @param UsuariosValueObject $oValueObject
//    * @return boolean 
//    */
//   public function findAll() {
//      $sql = "SELECT * FROM users order by identificacion";     
//      $resultado = mysql_query($sql);
//      if($resultado){
//            $aUser = array();
//             while ($fila = mysql_fetch_object($resultado)) {
//                $oUser = new UsuariosValueObject();                
//                $oUser->setId($fila->id);
//                $oUser->setDni($fila->dni);
//                $oUser->setIdentificacion($fila->identificacion);
//                $oUser->setClave($fila->clave);
//                $oUser->setPermiso($fila->permiso);
//                $oUser->setAmbito($fila->ambito);    
//                $aUser[] = $oUser;
//                unset ($oUser);                
//            }
//            return $aUser;
//      } else {
//            return false;
//      }                   
//   }    
//   
   
   /**
    * Busca todos lo datos de la tabla Usuarios que se encuentra en la base de datos.
    * @param UsuariosValueObject $oValueObject
    * @return boolean 
    */
   public function findNombre($oValueObject) {
      $sql = "SELECT id, dni, nombre from usuarios WHERE  ";     
      if($oValueObject->getNombre())
          $sql.=" nombre like '%".$oValueObject->getNombre()."%' ";
      if($oValueObject->getDni())
          $sql.=" dni = '".$oValueObject->getNombre()."' ";      
      $resultado = mysql_query($sql);
      if($resultado){
         $aUsuario = array();
         while ($fila = mysql_fetch_object($resultado)) {
            $oUsuario = new UsuariosEquiposValueObject();
            $oUsuario->setId($fila->id);
            $oUsuario->setDni($fila->dni);
            $oUsuario->setNombre($fila->nombre);            
            $aUsuario[] = $oUsuario;
            unset ($oUsuario);
         }
         return $aUsuario;
      } else {
         return false;
      }
   }
   
      /**
    * Busca todos lo datos de la tabla Usuarios que se encuentra en la base de datos.
    * @param UsuariosValueObject $oValueObject
    * @return boolean 
    */
   public function findAll($oValueObject) {
      $sql = "SELECT id, dni, nombre from usuarios ";     
      $resultado = mysql_query($sql);
      if($resultado){
         $aUsuario = array();
         while ($fila = mysql_fetch_object($resultado)) {
            $oUsuario = new UsuariosEquiposValueObject();
            $oUsuario->setId($fila->id);
            $oUsuario->setDni($fila->dni);
            $oUsuario->setNombre($fila->nombre);            
            $aUsuario[] = $oUsuario;
            unset ($oUsuario);
         }
         return $aUsuario;
      } else {
         return false;
      }
   }
   
      /**
    *
    * @param UsuariosEquiposValueObject $oValueObject
    * @return boolean 
    */
   public function insert($oValueObject) {
      $sql = "INSERT INTO usuarios (dni, nombre, usuarioAlta) VALUES (";
      $sql .= $oValueObject->getDni() . ", ";
      $sql .= "'".$oValueObject->getNombre() . "', ";                  
      $sql .= $oValueObject->getusuarioAlta().");";           
      if (mysql_query($sql)) {
           return true;
      } else { return false; }      
   }
      
         /**
    *
    * @param UsuariosEquiposValueObject $oValueObject
    * @return boolean 
    */
   public function update($oValueObject) {
      $sql = "UPDATE usuarios SET nombre=";      
      $sql .= "'".$oValueObject->getNombre() . "' WHERE ";                  
      $sql .= " id = ".$oValueObject->getId().";";              
      if (mysql_query($sql)) {
           return true;
      } else { return false; }      
   }
   
}
?>