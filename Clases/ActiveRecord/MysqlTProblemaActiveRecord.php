<?php
//Se requiere la intefaz ActiveRecord
require_once '../ClasesBasicas/ActiveRecordInterface.php';
require_once '../Clases/ValueObject/TProblemaValueObject.php';

/**
 * Description of MysqlTProblemaActiveRecord
 *
 */
class MysqlTProblemaActiveRecord implements ActiveRecord{
   /**
    * Cuenta la cantidad de registros que hay en la tabla tipoproblema.
    * @return int 
    */
   public function count() {
      $sql = "SELECT COUNT(*) FROM tipoproblema;";
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
    * @param TProblemaValueObject $oValueObject
    * @return boolean 
    */
   public function delete($oValueObject) {
      $sql = "DELETE FROM tipoproblema WHERE id= " . $oValueObject->getCue() . ";";
      if(mysql_query($sql)){
         return true;
      } else {
         return false;
      }
   }
   
   /**
    *
    * @param TProblemaValueObject $oValueObject
    * @return boolean 
    */
   public function exists($oValueObject) {
      $sql = "SELECT COUNT(*) FROM tipoproblema WHERE id= " . $oValueObject->getCue() . ";";
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
    * @param TProblemaValueObject $oValueObject
    * @return boolean 
    */
   public function find($oValueObject) {
      $sql = "SELECT * FROM tipoproblema WHERE  id= " . $oValueObject->getId() . ";";            
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
    * @param TProblemaValueObject $oValueObject
    * @return boolean 
    */
   public function findDescripcion($oValueObject) {
      $sql = "SELECT * FROM tipoproblema WHERE  descripcion= '" . $oValueObject->getDescripcion() . "';";            
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
    * Busca todos lo datos de la tabla TProblema que se encuentra en la base de datos.
    * @return boolean 
    */
   public function findAll() {
      $sql = "SELECT * from tipoproblema where fechaBaja='0000-00-00 00:00:00'";      
      $resultado = mysql_query($sql);
      if($resultado){
         $aTProblema = array();
         while ($fila = mysql_fetch_object($resultado)) {
            $oTProblema = new TProblemaValueObject();
            $oTProblema->setId($fila->id);
            $oTProblema->setDescripcion($fila->descripcion);     
            $aTProblema[] = $oTProblema;
            unset ($oTProblema);
         }
         return $aTProblema;
      } else {
         return false;
      }
   }
   
         /**
    * Busca todos lo datos de la tabla tipoproblema que pertenecen a un rubro
    * @return boolean 
    */
   public function findAllPorRubroyEspec($oValueObject) {
      $sql = "SELECT DISTINCT(idTProblema), descripcion FROM problema ";
      $sql.=" INNER JOIN tipoproblema ON problema.`idTProblema`=tipoproblema.`id`";
      $sql.=" WHERE idRubro=".$oValueObject->getId()." AND idEspecialidad=".$oValueObject->getDescripcion()." order by descripcion";      
      $resultado = mysql_query($sql);
      if($resultado){
         $aTProblema = array();
         while ($fila = mysql_fetch_object($resultado)) {
            $oTProblema = new TProblemaValueObject();
            $oTProblema->setId($fila->idTProblema);
            $oTProblema->setDescripcion($fila->descripcion);     
            $aTProblema[] = $oTProblema;
            unset ($oTProblema);
         }
         return $aTProblema;
      } else {
         return false;
      }
   }


     

   /**
    *
    * @param TProblemaValueObject $oValueObject
    * @return boolean 
    */
   public function insert($oValueObject) {
      $sql = "INSERT INTO tipoproblema (descripcion, usuarioAlta) VALUES (";
      $sql .= " '" . $oValueObject->getDescripcion() . "', ";
      $sql .= $oValueObject->getusuarioAlta().");";      
      if (mysql_query($sql)){
        $result = mysql_query("SELECT DISTINCT LAST_INSERT_ID() FROM tipoproblema");
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
    * @param TProblemaValueObject $oValueObject
    * @return boolean 
    */
   public function update($oValueObject) {
      $sql = "UPDATE tipoproblema SET descripcion= " . $oValueObject->getDescripcion();
      $sql.=" WHERE id = ".$oValueObject->getId().";";           
      if (mysql_query($sql))
         return true;
      else
         return false;
   }
}
?>