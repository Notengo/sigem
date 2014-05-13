<?php
require_once '../Clases/ValueObject/CategoriaValueObject.php';

/**
 * Description of MysqlCategoriaActiveRecord
 *
 */
class MysqlCategoriaActiveRecord {
   /**
    * Cuenta la cantidad de registros que hay en la tabla Categoria.
    * @return int 
    */
   public function count() {
      $sql = "SELECT COUNT(*) FROM categoria;";
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
    * @param CategoriaValueObject $oValueObject
    * @return boolean 
    */
   public function find($oValueObject) {
      $sql = "SELECT * FROM categoria WHERE idUsuario= " . $oValueObject->getIdUsuario() . " and idEspecialidad=". $oValueObject->getIdEspecialidad()." and fechaBaja IS NULL";                        
      $resultado = mysql_query($sql);
      if($resultado){
            if(mysql_num_rows($resultado)>0) {
                $fila = mysql_fetch_object($resultado);
                $oValueObject->setIdUsuario($fila->idUsuario);
                $oValueObject->setIdEspecialidad($fila->idEspecialidad);                
                return $oValueObject;
            } else {
                 return false;
            }           
        } else {
          return false;
      }
   }

   /**
    * Busca todos lo datos de la tabla Categoria que se encuentra en la base de datos.
    * @return boolean 
    */
   public function findAll() {
      $sql = "SELECT * from categoria where fechaBaja is NULL";      
      $resultado = mysql_query($sql);
      if($resultado){
         $aCategoria = array();
         while ($fila = mysql_fetch_object($resultado)) {
            $oCategoria = new CategoriaValueObject();
            $oCategoria->setIdUsuario($fila->idUsuario);
            $oCategoria->setIdEspecialidad($fila->idEspecialidad);     
            $aCategoria[] = $oCategoria;
            unset ($oCategoria);
         }
         return $aCategoria;
      } else {
         return false;
      }
   }
   
    /**
    *
    * @param CategoriaValueObject $oValueObject
    * @return boolean 
    */
   public function insert($oValueObject) {
      $sql = "INSERT INTO categoria (idUsuario, idEspecialidad, usuarioAlta) VALUES (";
      $sql .= $oValueObject->getIdUsuario() . ", ";
      $sql .= $oValueObject->getIdEspecialidad().", ";
      $sql .= $oValueObject->getUsuarioAlta().");";   
      if (mysql_query($sql)) {
        return true;
      } else { return false; }      
   }
   
   
         /**
    *
    * @param CategoriaValueObject $oValueObject
    * @return boolean 
    */
   public function update($oValueObject) {
      $sql = "UPDATE categoria SET fechaBaja= now(), usuarioBaja=".$oValueObject->getUsuarioBaja();
      $sql.=" WHERE idUsuario = ".$oValueObject->getIdUsuario()." and idEspecialidad = ".$oValueObject->getIdEspecialidad();       
      if (mysql_query($sql))
         return true;
      else
         return false;
   }


}
?>