<?php
//Se requiere la intefaz ActiveRecord
require_once '../ClasesBasicas/ActiveRecordInterface.php';
// Se requiere la clase OftalmologiaValueObject
require_once '../Clases/ValueObject/EspecialidadesValueObject.php';

/**
 * Description of MysqlEspecialidadesActiveRecord
 *
 */
class MysqlEspecialidadesActiveRecord implements ActiveRecord{
   /**
    * Cuenta la cantidad de registros que hay en la tabla Especialidades.
    * @return int 
    */
   public function count() {
      $sql = "SELECT COUNT(*) FROM especialidades;";
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
    * @param EspecialidadesValueObject $oValueObject
    * @return boolean 
    */
   public function delete($oValueObject) {
      $sql = "DELETE FROM especialidades WHERE id= " . $oValueObject->getCue() . ";";
      if(mysql_query($sql)){
         return true;
      } else {
         return false;
      }
   }
   
   /**
    *
    * @param EspecialidadesValueObject $oValueObject
    * @return boolean 
    */
   public function exists($oValueObject) {
      $sql = "SELECT COUNT(*) FROM especialidades WHERE id= " . $oValueObject->getCue() . ";";
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
    * @param EspecialidadesValueObject $oValueObject
    * @return boolean 
    */
   public function find($oValueObject) {
      $sql = "SELECT * FROM especialidades WHERE  id= " . $oValueObject->getId() . ";";            
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
    * @param EspecialidadesValueObject $oValueObject
    * @return boolean 
    */
   public function findDescripcion($oValueObject) {
      $sql = "SELECT * FROM especialidades WHERE descripcion= '" . $oValueObject->getDescripcion() . "';";            
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
    * Busca todos lo datos de la tabla Especialidades que se encuentra en la base de datos.
    * @return boolean 
    */
   public function findAll() {
      $sql = "SELECT * from especialidades where fechaBaja='0000-00-00 00:00:00'";      
      $resultado = mysql_query($sql);
      if($resultado){
         $aEspecialidades = array();
         while ($fila = mysql_fetch_object($resultado)) {
            $oEspecialidades = new EspecialidadesValueObject();
            $oEspecialidades->setId($fila->id);
            $oEspecialidades->setDescripcion($fila->descripcion);     
            $aEspecialidades[] = $oEspecialidades;
            unset ($oEspecialidades);
         }
         return $aEspecialidades;
      } else {
         return false;
      }
   }
   
         /**
    * Busca todos lo datos de la tabla Especialidades que pertenecen a un rubro
    * @return boolean 
    */
   public function findAllPorRubro($oValueObject) {
      $sql = "SELECT DISTINCT(idEspecialidad), descripcion FROM problema ";
      $sql.=" INNER JOIN especialidades ON problema.`idEspecialidad`=especialidades.`id`";
      $sql.=" WHERE idRubro=".$oValueObject->getId()." order by descripcion";           
      $resultado = mysql_query($sql);
      if($resultado){
         $aEspecialidades = array();
         while ($fila = mysql_fetch_object($resultado)) {
            $oEspecialidades = new EspecialidadesValueObject();
            $oEspecialidades->setId($fila->idEspecialidad);
            $oEspecialidades->setDescripcion($fila->descripcion);     
            $aEspecialidades[] = $oEspecialidades;
            unset ($oEspecialidades);
         }
         return $aEspecialidades;
      } else {
         return false;
      }
   }


     

   /**
    *
    * @param EspecialidadesValueObject $oValueObject
    * @return boolean 
    */
   public function insert($oValueObject) {
      $sql = "INSERT INTO especialidades (descripcion, usuarioAlta) VALUES (";
      $sql .= "'" . $oValueObject->getDescripcion() . "', ";
      $sql .= $oValueObject->getusuarioAlta().");";      
      if (mysql_query($sql)) {
         $result = mysql_query("SELECT DISTINCT LAST_INSERT_ID() FROM especialidades");
            $id = mysql_fetch_array($result);            
            if($id[0]<>0) {
                $oValueObject->setId($id[0]);                
                return true;
            } else { return false; }
      } else          {
         return false;
      }
   }

   /**
    *
    * @param EspecialidadesValueObject $oValueObject
    * @return boolean 
    */
   public function update($oValueObject) {
      $sql = "UPDATE especialidades SET descripcion= " . $oValueObject->getDescripcion();
      $sql.=" WHERE id = ".$oValueObject->getId().";";           
      if (mysql_query($sql))
         return true;
      else
         return false;
   }
}
?>