<?php
//Se requiere la intefaz ActiveRecord
require_once '../ClasesBasicas/ActiveRecordInterface.php';
require_once '../Clases/ValueObject/ServicioValueObject.php';

/**
 * Description of MysqlServicioActiveRecord
 *
 */
class MysqlServicioActiveRecord implements ActiveRecord{
   /**
    * Cuenta la cantidad de registros que hay en la tabla Servicio.
    * @return int 
    */
   public function count() {
      $sql = "SELECT COUNT(*) FROM servicio;";
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
    * @param ServicioValueObject $oValueObject
    * @return boolean 
    */
   public function delete($oValueObject) {
      $sql = "DELETE FROM servicio WHERE id= " . $oValueObject->getCue() . ";";
      if(mysql_query($sql)){
         return true;
      } else {
         return false;
      }
   }
   
   /**
    *
    * @param ServicioValueObject $oValueObject
    * @return boolean 
    */
   public function exists($oValueObject) {
      $sql = "SELECT COUNT(*) FROM servicio WHERE id= " . $oValueObject->getCue() . ";";
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
    * @param ServicioValueObject $oValueObject
    * @return boolean 
    */
   public function find($oValueObject) {
      $sql = "SELECT * FROM servicio WHERE  idServicio= " . $oValueObject->getIdServicio() . ";";
      $resultado = mysql_query($sql);
      if($resultado){
            if(mysql_num_rows($resultado)>0) {
                $fila = mysql_fetch_object($resultado);
                $oValueObject->setIdServicio($fila->idServicio);
                $oValueObject->setDescripcion($fila->descripcion);
                $oValueObject->setTipo($fila->tipo);
                $oValueObject->setFechaAlta($fila->fechaAlta);
                $oValueObject->setUsuarioAlta($fila->usuarioAlta);
                $oValueObject->setFechaBaja($fila->fechaBaja);
                $oValueObject->setUsuarioBaja($fila->usuarioBaja);
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
    * @param ServicioValueObject $oValueObject
    * @return boolean 
    */
   public function findDescripcion($oValueObject) {
      $sql = "SELECT * FROM servicio WHERE descripcion= '" . $oValueObject->getDescripcion() . "';";                  
      $resultado = mysql_query($sql);
      if($resultado){
            if(mysql_num_rows($resultado)>0) {
                $fila = mysql_fetch_object($resultado);
                $oValueObject->setIdServicio($fila->idServicio);
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
    * Busca todos lo datos de la tabla Servicio que se encuentra en la base de datos.
    * @return boolean 
    */
   public function findAll() {
      $sql = "SELECT * from servicio where fechaBaja='0000-00-00 00:00:00' order by descripcion";
      $resultado = mysql_query($sql);
      if($resultado){
         $aServicio = array();
         while ($fila = mysql_fetch_object($resultado)) {
            $oServicio = new ServicioValueObject();
            $oServicio->setIdServicio($fila->idServicio);
            $oServicio->setDescripcion($fila->descripcion);     
            $aServicio[] = $oServicio;
            unset ($oServicio);
         }
         return $aServicio;
      } else {
         return false;
      }
   }

     

   /**
    *
    * @param ServicioValueObject $oValueObject
    * @return boolean 
    */
   public function insert($oValueObject) {
      $sql = "INSERT INTO servicio (descripcion, usuarioAlta) VALUES (";
      $sql .= "'" . $oValueObject->getDescripcion() . "', ";
      $sql .= $oValueObject->getusuarioAlta().");";      
      if (mysql_query($sql))  {                                    
            $result = mysql_query("SELECT DISTINCT LAST_INSERT_ID() FROM servicio");
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
    * @param ServicioValueObject $oValueObject
    * @return boolean 
    */
   public function update($oValueObject) {
      $sql = "UPDATE servicio SET descripcion= " . $oValueObject->getDescripcion();
      $sql.=" WHERE id = ".$oValueObject->getId().";";           
      if (mysql_query($sql))
         return true;
      else
         return false;
   }
   
      /**
    *
    * @param ServicioValueObject $oValueObject
    * @return boolean 
    */
   public function deleteExistente($oValueObject) {
      $sql = "UPDATE servicio SET usuarioBaja= " . $oValueObject->getUsuarioAlta(). ", fechaBaja = now()";
      $sql.=" WHERE idServicio = ".$oValueObject->getId().";";           
      if (mysql_query($sql))
         return true;
      else
         return false;
   }
}
?>