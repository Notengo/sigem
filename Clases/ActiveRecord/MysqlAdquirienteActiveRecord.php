<?php
//Se requiere la intefaz ActiveRecord
require_once '../ClasesBasicas/ActiveRecordInterface.php';
require_once '../Clases/ValueObject/AdquirienteValueObject.php';

/**
 * Description of MysqlAdquirienteActiveRecord
 *
 */
class MysqlAdquirienteActiveRecord implements ActiveRecord{
   /**
    * Cuenta la cantidad de registros que hay en la tabla Adquiriente.
    * @return int 
    */
   public function count() {
      $sql = "SELECT COUNT(*) FROM adquiriente;";
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
    * @param AdquirienteValueObject $oValueObject
    * @return boolean 
    */
   public function delete($oValueObject) {
      $sql = "DELETE FROM adquiriente WHERE id= " . $oValueObject->getCue() . ";";
      if(mysql_query($sql)){
         return true;
      } else {
         return false;
      }
   }
   
   /**
    *
    * @param AdquirienteValueObject $oValueObject
    * @return boolean 
    */
   public function exists($oValueObject) {
      $sql = "SELECT COUNT(*) FROM adquiriente WHERE id= " . $oValueObject->getCue() . ";";
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
    * @param AdquirienteValueObject $oValueObject
    * @return boolean 
    */
   public function find($oValueObject) {
      $sql = "SELECT * FROM adquiriente WHERE  idAdquiriente= " . $oValueObject->getId() . ";";         
      $resultado = mysql_query($sql);
      if($resultado){
            if(mysql_num_rows($resultado)>0) {
                $fila = mysql_fetch_object($resultado);
                $oValueObject->setId($fila->id);
                $oValueObject->setDescripcion($fila->descripcion);               
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
    * @param AdquirienteValueObject $oValueObject
    * @return boolean 
    */
   public function findDescripcion($oValueObject) {
      $sql = "SELECT * FROM adquiriente WHERE descripcion like '%" . $oValueObject->getDescripcion() . "%';";        
      $resultado = mysql_query($sql);
      if($resultado){
         $aAdquiriente = array();
         while ($fila = mysql_fetch_object($resultado)) {
            $oAdquiriente = new AdquirienteValueObject();
            $oAdquiriente->setId($fila->idAdquiriente);
            $oAdquiriente->setDescripcion($fila->descripcion);     
            $aAdquiriente[] = $oAdquiriente;
            unset ($oAdquiriente);
         }
         return $aAdquiriente;
      } else {
          return false;
      }
   }

     /**
    *
    * @param AdquirienteValueObject $oValueObject
    * @return boolean 
    */
   public function findUnaDescripcion($oValueObject) {
      $sql = "SELECT * FROM adquiriente WHERE descripcion='" . $oValueObject->getDescripcion() . "';";        
      $resultado = mysql_query($sql);      
         if($resultado){
            if(mysql_num_rows($resultado)>0) {
                $fila = mysql_fetch_object($resultado);
                $oValueObject->setId($fila->idAdquiriente);
                $oValueObject->setDescripcion($fila->descripcion);                
                return $oValueObject;
            } else {
                 return false;
            }           
        } else {
          return false;
        }
   }
        
   
   
      /**
    * Busca todos lo datos de la tabla Adquiriente que se encuentra en la base de datos.
    * @return boolean 
    */
   public function findAll() {
      $sql = "SELECT * from adquiriente order by descripcion";      
      $resultado = mysql_query($sql);
      if($resultado){
         $aAdquiriente = array();
         while ($fila = mysql_fetch_object($resultado)) {
            $oAdquiriente = new AdquirienteValueObject();
            $oAdquiriente->setId($fila->id);
            $oAdquiriente->setDescripcion($fila->descripcion);     
            $aAdquiriente[] = $oAdquiriente;
            unset ($oAdquiriente);
         }
         return $aAdquiriente;
      } else {
         return false;
      }
   }

     

   /**
    *
    * @param AdquirienteValueObject $oValueObject
    * @return boolean 
    */
   public function insert($oValueObject) {
      $sql = "INSERT INTO adquiriente (descripcion, usuarioAlta) VALUES (";
      $sql .= "'" . $oValueObject->getDescripcion() . "', ";
      $sql .= $oValueObject->getUsuarioAlta().");";            
      if (mysql_query($sql))  {                                    
            return true;           
       } else {            
            return false;
       }       
   }

   /**
    *
    * @param AdquirienteValueObject $oValueObject
    * @return boolean 
    */
   public function update($oValueObject) {
      $sql = "UPDATE adquiriente SET descripcion= " . $oValueObject->getDescripcion();
      $sql.=" WHERE id = ".$oValueObject->getId().";";           
      if (mysql_query($sql))
         return true;
      else
         return false;
   }
}
?>