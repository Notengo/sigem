<?php
require_once '../Clases/ValueObject/ModeloValueObject.php';

/**
 * Description of MysqlModeloActiveRecord
 *
 */
class MysqlModeloActiveRecord {
   
      /**
    * Busca todos lo datos de la tabla Modelo que se encuentra en la base de datos.
    * @param ModeloValueObject $oValueObject
    * @return boolean 
    */
   public function findAll($oValueObject) {
      $sql = "SELECT * from modelo where idTipo=".$oValueObject->getIdTipo();
      $sql.= " and idMarca = ".$oValueObject->getIdMarca()." and fechaBaja='0000-00-00 00:00:00' ";          
      $resultado = mysql_query($sql);
      if($resultado){
         $aModelo = array();
         while ($fila = mysql_fetch_object($resultado)) {
            $oModelo = new ModeloValueObject();
            $oModelo->setIdTipo($fila->idTipo);
            $oModelo->setIdModelo($fila->idModelo);
            $oModelo->setIdMarca($fila->idMarca);
            $oModelo->setDescripcion($fila->descripcion);            
            $aModelo[] = $oModelo;
            unset ($oModelo);
         }
         return $aModelo;
      } else {
         return false;
      }
   }
   
    /**
    * Busca todos lo datos de la tabla Modelo que se encuentra en la base de datos.
    * @param ModeloValueObject $oValueObject
    * @return boolean 
    */
   public function findDescri($oValueObject) {
      $sql = "SELECT * from modelo where idTipo=".$oValueObject->getIdTipo();
      $sql.= " and idMarca = ".$oValueObject->getIdMarca()." and descripcion like '%".$oValueObject->getDescripcion()."%' and fechaBaja='0000-00-00 00:00:00' ";          
      $resultado = mysql_query($sql);
      if($resultado){
         $aModelo = array();
         while ($fila = mysql_fetch_object($resultado)) {
            $oModelo = new ModeloValueObject();
            $oModelo->setIdTipo($fila->idTipo);
            $oModelo->setIdModelo($fila->idModelo);
            $oModelo->setIdMarca($fila->idMarca);
            $oModelo->setDescripcion($fila->descripcion);            
            $aModelo[] = $oModelo;
            unset ($oModelo);
         }
         return $aModelo;
      } else {
         return false;
      }
   }
   
   
   /**
    *
    * @param ModeloValueObject $oValueObject
    * @return boolean 
    */
   public function insert($oValueObject) {
      $sql = "INSERT INTO modelo (idTipo, idMarca, descripcion, usuarioAlta) VALUES (";
      $sql.= $oValueObject->getIdTipo() . ", ";
      $sql.= $oValueObject->getIdMarca() . ", '";
      $sql.= $oValueObject->getDescripcion() . "', '";
      $sql.= $oValueObject->getUsuarioAlta() . "')";                    
      if (mysql_query($sql))  {        
           $result = mysql_query("SELECT DISTINCT LAST_INSERT_ID() FROM modelo");           
           $id = mysql_fetch_array($result);                       
           if($id[0]<>0) {
                $oValueObject->setIdModelo($id[0]);                
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
      $sql = "SELECT * FROM modelo WHERE  descripcion='".$oValueObject->getDescripcion()."' and idTipo = ".$oValueObject->getIdTipo()." and idMarca = ".$oValueObject->getIdMarca().";";            
      $resultado = mysql_query($sql);
      if($resultado){
            if(mysql_num_rows($resultado)>0) {
                $fila = mysql_fetch_object($resultado);
                $oValueObject->setIdModelo($fila->idModelo);
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
      $sql = "SELECT * FROM modelo WHERE idModelo=".$valor." ;";          
      $resultado = mysql_query($sql);
      if($resultado){
            if(mysql_num_rows($resultado)>0) {
                $fila = mysql_fetch_object($resultado);
                $oValueObject = new ModeloValueObject();
                $oValueObject->setIdModelo($fila->idModelo);
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
   public function findIdPorMarca($marca, $modelo) {
      $sql = "SELECT * FROM modelo WHERE idMarca=".$marca." and idModelo=".$modelo." ;";          
      $resultado = mysql_query($sql);
      if($resultado){
            if(mysql_num_rows($resultado)>0) {
                $fila = mysql_fetch_object($resultado);
                $oValueObject = new ModeloValueObject();
                $oValueObject->setIdModelo($fila->idModelo);
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