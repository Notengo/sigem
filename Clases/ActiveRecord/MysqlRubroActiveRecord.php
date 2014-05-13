<?php
//Se requiere la intefaz ActiveRecord
require_once '../ClasesBasicas/ActiveRecordInterface.php';
// Se requiere la clase OftalmologiaValueObject
require_once '../Clases/ValueObject/RubroValueObject.php';

/**
 * Description of MysqlRubroActiveRecord
 *
 */
class MysqlRubroActiveRecord implements ActiveRecord{
   /**
    * Cuenta la cantidad de registros que hay en la tabla Rubro.
    * @return int 
    */
   public function count() {
      $sql = "SELECT COUNT(*) FROM rubro;";
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
    * @param RubroValueObject $oValueObject
    * @return boolean 
    */
   public function delete($oValueObject) {
      $sql = "DELETE FROM rubro WHERE id= " . $oValueObject->getCue() . ";";
      if(mysql_query($sql)){
         return true;
      } else {
         return false;
      }
   }
   
   /**
    *
    * @param RubroValueObject $oValueObject
    * @return boolean 
    */
   public function exists($oValueObject) {
      $sql = "SELECT COUNT(*) FROM rubro WHERE id= " . $oValueObject->getCue() . ";";
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
    * @param RubroValueObject $oValueObject
    * @return boolean 
    */
   public function find($oValueObject) {
      $sql = "SELECT * FROM rubro WHERE  id= " . $oValueObject->getId() . ";";            
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
    * @param RubroValueObject $oValueObject
    * @return boolean 
    */
   public function findDescripcion($oValueObject) {
      $sql = "SELECT * FROM rubro WHERE descripcion= '" . $oValueObject->getDescripcion() . "';";            
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
    * Busca todos lo datos de la tabla Rubro que se encuentra en la base de datos.
    * @return boolean 
    */
   public function findAll() {
      $sql = "SELECT * from rubro order by descripcion";      
      $resultado = mysql_query($sql);
      if($resultado){
         $aRubro = array();
         while ($fila = mysql_fetch_object($resultado)) {
            $oRubro = new RubroValueObject();
            $oRubro->setId($fila->id);
            $oRubro->setDescripcion($fila->descripcion);     
            $aRubro[] = $oRubro;
            unset ($oRubro);
         }
         return $aRubro;
      } else {
         return false;
      }
   }

     

   /**
    *
    * @param RubroValueObject $oValueObject
    * @return boolean 
    */
   public function insert($oValueObject) {
      $sql = "INSERT INTO rubro (descripcion, usuarioAlta) VALUES (";
      $sql .= "'" . $oValueObject->getDescripcion() . "', ";
      $sql .= $oValueObject->getusuarioAlta().");";      
      if (mysql_query($sql))  {                                    
            $result = mysql_query("SELECT DISTINCT LAST_INSERT_ID() FROM rubro");
            $id = mysql_fetch_array($result);            
            if($id[0]<>0) {
                $oValueObject->setId($id[0]);                
                return true;
            } else { return false; }
       } else {            
            return false;
       }       
   }

   /**
    *
    * @param RubroValueObject $oValueObject
    * @return boolean 
    */
   public function update($oValueObject) {
      $sql = "UPDATE rubro SET descripcion= " . $oValueObject->getDescripcion();
      $sql.=" WHERE id = ".$oValueObject->getId().";";           
      if (mysql_query($sql))
         return true;
      else
         return false;
   }
}
?>