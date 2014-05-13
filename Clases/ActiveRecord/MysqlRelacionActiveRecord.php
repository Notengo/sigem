<?php
require_once '../Clases/ValueObject/RelacionValueObject.php';

/**
 * Description of MysqlRelacionActiveRecord
 *
 */
class MysqlRelacionActiveRecord {
   
    /**
    *
    * @param RelacionValueObject $oValueObject
    * @return boolean 
    */
   public function find($oValueObject) {
      $sql = "SELECT * FROM relacion WHERE idEquipo=" . $oValueObject->getIdEquipo()." and fechaBaja='0000-00-00 00:00:00'";                                          
      $resultado = mysql_query($sql);
      if($resultado){
         $aRelacion = array();
         while ($fila = mysql_fetch_object($resultado)) {
            $oRelacion = new RelacionValueObject();
            $oRelacion->setIdComponente($fila->idComponente);
            $oRelacion->setIdEquipo($fila->idEquipo);
            $oRelacion->setInversa($fila->inversa);
            $aRelacion[] = $oRelacion;
            unset($oRelacion);
         }         
         return $aRelacion;     
        } else {
          return false;
      }
   }
   
       /**
    *
    * @param RelacionValueObject $oValueObject
    * @return boolean 
    */
   public function findOrdenado($oValueObject) {
      $sql = "SELECT * FROM relacion 
        INNER JOIN componente ON componente.`id`=relacion.`idComponente`
        INNER JOIN tipo ON tipo.`id`=componente.`idTipo`
        WHERE idEquipo=".$oValueObject->getIdEquipo()." AND relacion.fechaBaja='0000-00-00 00:00:00'
        ORDER BY tipo.`movIndependiente`, tipo.`id`";                                          
      $resultado = mysql_query($sql);
      if($resultado){
         $aRelacion = array();
         while ($fila = mysql_fetch_object($resultado)) {
            $oRelacion = new RelacionValueObject();
            $oRelacion->setIdComponente($fila->idComponente);
            $oRelacion->setIdEquipo($fila->idEquipo);
            $oRelacion->setInversa($fila->inversa);
            $aRelacion[] = $oRelacion;
            unset($oRelacion);
         }         
         return $aRelacion;     
        } else {
          return false;
      }
   }
   
          /**
    *
    * @param RelacionValueObject $oValueObject
    * @return boolean 
    */
   public function findBaja($oValueObject,$inicio, $tamano) {
      $sql = "SELECT relacion.`idComponente`, relacion.`idEquipo`, relacion.inversa, DATE_FORMAT(relacion.`fechaBaja`,'%d-%m-%Y') as fechaBaja1 FROM relacion 
        INNER JOIN componente ON componente.`id`=relacion.`idComponente`
        INNER JOIN tipo ON tipo.`id`=componente.`idTipo`
        WHERE idEquipo=".$oValueObject->getIdEquipo()." AND relacion.fechaBaja<>'0000-00-00 00:00:00'
        ORDER BY tipo.`movIndependiente`, tipo.`id` ";       
       if($tamano<>0)
        $sql.=" LIMIT ".$inicio.", ".$tamano;           
       
      $resultado = mysql_query($sql);
      if($resultado){
         $aRelacion = array();
         while ($fila = mysql_fetch_object($resultado)) {
            $oRelacion = new RelacionValueObject();
            $oRelacion->setIdComponente($fila->idComponente);
            $oRelacion->setIdEquipo($fila->idEquipo);
            $oRelacion->setInversa($fila->inversa);
            $oRelacion->setFechaBaja($fila->fechaBaja1);
            $aRelacion[] = $oRelacion;
            unset($oRelacion);
         }         
         return $aRelacion;     
        } else {
          return false;
      }
   }
   
   
    /**
    *
    * @param RelacionValueObject $oValueObject
    * @return boolean 
    */
   public function insert($oValueObject) {
      $sql = "INSERT INTO relacion (idEquipo, idComponente, inversa, usuarioAlta) VALUES (";
      $sql .= $oValueObject->getIdEquipo() . ", ";      
      $sql .= $oValueObject->getIdComponente() . ", ";
      $sql .= $oValueObject->getInversa() . ", ";
      $sql .= $oValueObject->getUsuario() . ") ";             
      if (mysql_query($sql))  {                                                
            return true;                
      } else {     
            return false;
      }   
   }
   
   /**
    *
    * @param RelacionValueObject $oValueObject
    * @return boolean 
    */
   public function delete($oValueObject) {
      $sql = "DELETE FROM relacion";
      $sql .= " WHERE idEquipo = ".$oValueObject->getIdEquipo()." AND idComponente = ".$oValueObject->getIdComponente()." AND fechaBaja='0000-00-00 00:00:00'";                   
      if (mysql_query($sql))  {                                                
            return true;                
      } else {     
            return false;
      }   
   }
   
   /**
    *
    * @param RelacionValueObject $oValueObject
    * @return boolean 
    */
   public function bajaCompleto($oValueObject) {
      $sql = "UPDATE relacion SET fechaBaja=NOW(), usuarioBaja=".$oValueObject->getUsuario()." WHERE idEquipo=".$oValueObject->getIdEquipo().";";            
      if (mysql_query($sql))  {                                                
            return true;                
      } else {     
            return false;
      }   
   }
   
   /**
    *
    * @param RelacionValueObject $oValueObject
    * @return boolean 
    */
   public function deleteCompleto($oValueObject) {
      $sql = "DELETE FROM relacion WHERE idEquipo=".$oValueObject->getIdEquipo().";";      
      if (mysql_query($sql))  {                                                
            return true;                
      } else {     
            return false;
      }   
   }

}
?>