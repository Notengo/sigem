<?php
//Se requiere la intefaz ActiveRecord
require_once '../ClasesBasicas/ActiveRecordInterface.php';
require_once '../Clases/ValueObject/ProblemaValueObject.php';

/**
 * Description of MysqlProblemaActiveRecord
 *
 */
class MysqlProblemaActiveRecord implements ActiveRecord{
   /**
    * Cuenta la cantidad de registros que hay en la tabla problema.
    * @return int 
    */
   public function count() {
      $sql = "SELECT COUNT(*) FROM problema;";
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
    * @param ProblemaValueObject $oValueObject
    * @return boolean 
    */
   public function delete($oValueObject) {
      $sql = "DELETE FROM problema WHERE id= " . $oValueObject->getCue() . ";";
      if(mysql_query($sql)){
         return true;
      } else {
         return false;
      }
   }
   
   /**
    *
    * @param ProblemaValueObject $oValueObject
    * @return boolean 
    */
   public function exists($oValueObject) {
      $sql = "SELECT COUNT(*) FROM problema WHERE id= " . $oValueObject->getCue() . ";";
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
    * @param ProblemaValueObject $oValueObject
    * @return boolean 
    */
   public function find($oValueObject) {
      $sql = "SELECT * FROM problema WHERE  id= " . $oValueObject->getId() . ";";           
      $resultado = mysql_query($sql);
      if($resultado){
            if(mysql_num_rows($resultado)>0) {
                $fila = mysql_fetch_object($resultado);
                $oValueObject->setId($fila->id);
                $oValueObject->setIdEspecialidad($fila->idEspecialidad);
                $oValueObject->setIdRubro($fila->idRubro);
                $oValueObject->setIdTProblema($fila->idTProblema);
                $oValueObject->setObservacion($fila->observacion);               
                $oValueObject->setRequiereEquipo($fila->requiereEquipo);                               
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
    * @param ProblemaValueObject $oValueObject
    * @return boolean 
    */
   public function findIds($oValueObject) {
      $sql = "SELECT * FROM problema ";      
      $sql.= " WHERE  idRubro= " . $oValueObject->getIdRubro() ;                  
      $sql.= " and idEspecialidad = ". $oValueObject->getIdEspecialidad();      
      $sql.= " and idTProblema =". $oValueObject->getIdTProblema();         
      $resultado = mysql_query($sql);
      if($resultado){
            if(mysql_num_rows($resultado)>0) {
                $fila = mysql_fetch_object($resultado);
                $oValueObject->setId($fila->id);
                $oValueObject->setIdEspecialidad($fila->idEspecialidad);
                $oValueObject->setIdRubro($fila->idRubro);
                $oValueObject->setIdTProblema($fila->idTProblema);
                $oValueObject->setObservacion($fila->observacion);               
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
    * @param ProblemaValueObject $oValueObject
    * @return boolean 
    */
   public function findPorId($oValueObject) {
      $sql = "SELECT * FROM problema ";
      if($oValueObject->getIdRubro())
      $sql.= " WHERE  idRubro= " . $oValueObject->getIdRubro() ;            
      if($oValueObject->getIdEspecialidad())
      $sql.= " and idEspecialidad = ". $oValueObject->getIdEspecialidad();
      if($oValueObject->getIdTProblema())
      $sql.= " and idTProblema =". $oValueObject->getIdTProblema();            
      $resultado = mysql_query($sql);
      if($resultado){
            $aProblema = array();
            while ($fila = mysql_fetch_object($resultado)) {
                $oProblema = new ProblemaValueObject();               
                $oProblema->setId($fila->id);
                $oProblema->setIdEspecialidad($fila->idEspecialidad);
                $oProblema->setIdRubro($fila->idRubro);
                $oProblema->setIdTProblema($fila->idTProblema);
                $oProblema->setObservacion($fila->observacion);      
                $aProblema[] = $oProblema;
                unset ($oProblema);
            }  
            return $aProblema;
      } else {
          return false;
      }
   }
   
      /**
    * Busca todos lo datos de la tabla Problema que se encuentra en la base de datos.
    * @return boolean 
    */
   public function findAll() {
      $sql = "SELECT * from problema where fechaBaja='0000-00-00 00:00:00'";      
      $resultado = mysql_query($sql);
      if($resultado){
         $aProblema = array();
         while ($fila = mysql_fetch_object($resultado)) {
            $oProblema = new ProblemaValueObject();
            $oProblema->setId($fila->id);
            $oProblema->setDescripcion($fila->descripcion);     
            $aProblema[] = $oProblema;
            unset ($oProblema);
         }
         return $aProblema;
      } else {
         return false;
      }
   }
   
      

     

   /**
    *
    * @param ProblemaValueObject $oValueObject
    * @return boolean 
    */
   public function insert($oValueObject) {
      $sql = "INSERT INTO problema (idRubro, idEspecialidad, idTProblema, observacion) VALUES (";
      $sql.= $oValueObject->getIdRubro(). ", ". $oValueObject->getIdEspecialidad();
      $sql.=", " . $oValueObject->getIdTProblema() . ", ";
      $sql.="'" . $oValueObject->getObservacion() . "'); ";            
      if (mysql_query($sql)) {
         $result = mysql_query("SELECT DISTINCT LAST_INSERT_ID() FROM problema");
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
    * @param ProblemaValueObject $oValueObject
    * @return boolean 
    */
   public function update($oValueObject) {
      $sql = "UPDATE problema SET descripcion= " . $oValueObject->getDescripcion();
      $sql.=" WHERE id = ".$oValueObject->getId().";";           
      if (mysql_query($sql))
         return true;
      else
         return false;
   }
}
?>