<?php
require_once '../Clases/ValueObject/MarcaValueObject.php';

/**
 * Description of MysqlMarcaActiveRecord
 *
 */
class MysqlMarcaActiveRecord {
   
      /**
    * Busca todos lo datos de la tabla Marca que se encuentra en la base de datos.
    * @param MarcaValueObject $oValueObject
    * @return boolean 
    */
   public function findAll($oValueObject) {
      $sql = "SELECT * from marca where idTipo=".$oValueObject->getIdTipo()." and fechaBaja='0000-00-00 00:00:00'";     
      $resultado = mysql_query($sql);
      if($resultado){
         $aMarca = array();
         while ($fila = mysql_fetch_object($resultado)) {
            $oMarca = new MarcaValueObject();
            $oMarca->setIdTipo($fila->idTipo);
            $oMarca->setIdMarca($fila->idMarca);
            $oMarca->setDescripcion($fila->descripcion);            
            $aMarca[] = $oMarca;
            unset ($oMarca);
         }
         return $aMarca;
      } else {
         return false;
      }
   }
   
         /**
    * Busca todos lo datos de la tabla Marca que se encuentra en la base de datos.
    * @param MarcaValueObject $oValueObject
    * @return boolean 
    */
   public function findDesc($oValueObject) {
      $sql = "SELECT * from marca where idTipo=".$oValueObject->getIdTipo()." and fechaBaja='0000-00-00 00:00:00' and descripcion like '%".$oValueObject->getDescripcion()."%'";           
      $resultado = mysql_query($sql);
      if($resultado){
         $aMarca = array();
         while ($fila = mysql_fetch_object($resultado)) {
            $oMarca = new MarcaValueObject();
            $oMarca->setIdTipo($fila->idTipo);
            $oMarca->setIdMarca($fila->idMarca);
            $oMarca->setDescripcion($fila->descripcion);            
            $aMarca[] = $oMarca;
            unset ($oMarca);
         }
         return $aMarca;
      } else {
         return false;
      }
   }
   
    /**
    *
    * @param MarcaValueObject $oValueObject
    * @return boolean 
    */
   public function insert($oValueObject) {
      $sql = "INSERT INTO marca (idTipo, descripcion, usuarioAlta) VALUES (";
      $sql.= $oValueObject->getIdTipo() . ", '";
      $sql.= $oValueObject->getDescripcion() . "', '";
      $sql.= $oValueObject->getUsuarioAlta() . "')";            
      if (mysql_query($sql))  {        
           $result = mysql_query("SELECT DISTINCT LAST_INSERT_ID() FROM marca");
           $id = mysql_fetch_array($result);            
           if($id[0]<>0) {
                $oValueObject->setIdMarca($id[0]);                
                return true;
           } else { return false; }
      } else {     
            return false;
      }   
   }
   
      /**
    *
    * @param MarcaValueObject $oValueObject
    * @return boolean 
    */
   public function findDescripcion($oValueObject) {
      $sql = "SELECT * FROM marca WHERE  descripcion='".$oValueObject->getDescripcion()."' and idTipo = ".$oValueObject->getIdTipo().";";            
      $resultado = mysql_query($sql);
      if($resultado){
            if(mysql_num_rows($resultado)>0) {
                $fila = mysql_fetch_object($resultado);
                $oValueObject->setIdMarca($fila->idMarca);
                $oValueObject->setIdTipo($fila->idTipo);
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
    * @param int $valor
    * @return boolean 
    */
   public function findId($valor) {
      $sql = "SELECT * FROM marca WHERE idMarca=".$valor." ;";                 
      $resultado = mysql_query($sql);
      if($resultado){
            if(mysql_num_rows($resultado)>0) {
                $fila = mysql_fetch_object($resultado);
                $oValueObject = new MarcaValueObject();
                $oValueObject->setIdMarca($fila->idMarca);
                $oValueObject->setIdTipo($fila->idTipo);
                $oValueObject->setDescripcion($fila->descripcion);                
                return $oValueObject;
            } else {
                 return false;
            }           
        } else {
          return false;
      }
   }
}
?>