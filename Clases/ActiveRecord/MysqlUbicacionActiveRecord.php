<?php
require_once '../Clases/ValueObject/UbicacionValueObject.php';

/**
 * Description of MysqlUbicacionActiveRecord
 *
 */
class MysqlUbicacionActiveRecord {
   
    /**
    *
    * @param UbicacionValueObject $oValueObject
    * @return boolean 
    */
   public function find($oValueObject) {
      $sql = "SELECT * FROM ubicacion WHERE idEquipo= " . $oValueObject->getIdEquipo()
              . " AND confirma = '" . $oValueObject->getConfirma()
              . "' AND fechaBaja = '0000-00-00 00:00:00'";

      
      $resultado = mysql_query($sql);
      if($resultado){
            if(mysql_num_rows($resultado)>0) {
                $fila = mysql_fetch_object($resultado);
                $oValueObject->setIdEquipo($fila->idEquipo);                        
                $oValueObject->setIdServicio($fila->idServicio);
                $oValueObject->setIdMotivoTraslado($fila->idMotivoTraslado);
                $oValueObject->setOfcodi($fila->ofcodi);
                $oValueObject->setSubServicio($fila->subServicio);
                $oValueObject->setIdMotivoTraslado($fila->idMotivoTraslado);
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
    * @param UbicacionValueObject $oValueObject
    * @return boolean 
    */
   public function findBaja($oValueObject,$inicio, $tamano) {
      $sql = "SELECT ubicacion.* FROM ubicacion 
        INNER JOIN oficexpe ON oficexpe.`ofcodi`=ubicacion.`ofcodi`
        WHERE ubicacion.`fechaBaja` IS NOT NULL AND idEquipo=".$oValueObject->getIdEquipo()." 
        ORDER BY ubicacion.`fechaBaja` desc ";       
       if($tamano<>0){ $sql.=" LIMIT ".$inicio.", ".$tamano; }
      $resultado = mysql_query($sql);
      if($resultado){
         $aRelacion = array();
         while ($fila = mysql_fetch_object($resultado)) {
            $oRelacion = new UbicacionValueObject();
            $oRelacion->setIdEquipo($fila->idEquipo);
            $oRelacion->setOfcodi($fila->ofcodi);
            $oRelacion->setFechaBaja($fila->fechaBaja);            
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
    * @param UbicacionValueObject $oValueObject
    * @return boolean 
    */
   public function insert($oValueObject) {
      $sql = "INSERT INTO ubicacion (idEquipo, ofcodi, fecha, idServicio, subServicio, idMotivoTraslado, usuarioAlta) VALUES (";
      $sql .= $oValueObject->getIdEquipo() . ", ";
      $sql .= $oValueObject->getOfcodi() . ", ";
      $sql .= "now(), ";
      $sql .= $oValueObject->getIdServicio() . ", '";
      $sql .= $oValueObject->getSubServicio() . "', '";
      $sql .= $oValueObject->getIdMotivoTraslado() . "', ";
      $sql .= $oValueObject->getUsuarioAlta() . ") ";

      if (mysql_query($sql))  {
          return true;
      } else {
          return false;
      }
   }
   
    /**
    *
    * @param UbicacionValueObject $oValueObject
    * @return boolean 
    */
   public function update($oValueObject) {
      $sql = "UPDATE ubicacion SET idEquipo = ".$oValueObject->getIdEquipo() . ", ";      
      $sql .= " ofcodi = ".$oValueObject->getOfcodi() . ", ";
      $sql .= " usuarioAlta = ".$oValueObject->getUsuarioAlta() . " ";                  
      $sql .= " WHERE idEquipo = ". $oValueObject->getIdEquipo();            
      if (mysql_query($sql))  {                                                
          return true;                
      } else {
          return false;
      }   
   }
   
    /**
    *
    * @param UbicacionValueObject $oValueObject
    * @return boolean 
    */
   public function confirmar($oValueObject) {
      $sql = "UPDATE ubicacion SET "
              . "confirma = 'S' "
              . "WHERE idEquipo = ". $oValueObject->getIdEquipo()
              . " AND fechaBaja = '0000-00-00 00:00:00' AND confirma = 'N'";
      echo $sql . "<br>";
      if (mysql_query($sql))  {                                                
          return true;                
      } else {
          return false;
      }   
   }
   
    /**
    *
    * @param UbicacionValueObject $oValueObject
    * @return boolean 
    */
   public function bajaOficina($oValueObject) {
      $sql = "UPDATE ubicacion SET  ";      
      $sql .= " fechaBaja = now(), ";
      $sql .= " usuarioBaja = ".$oValueObject->getUsuarioBaja() . " ";                  
      $sql .= " WHERE idEquipo = ". $oValueObject->getIdEquipo()
           . " AND fechaBaja = '0000-00-00 00:00:00' AND confirma = 'S'";
      echo $sql . "<br>";
      if (mysql_query($sql))  {                                                
            return true;                
      } else {     
            return false;
      }   
   }
   
   /**
	*
	* @param UbicacionValueObject $oValueObject
	* @return boolean 
	*/
   public function bajaCompleto($oValueObject) {
	  $sql = "UPDATE ubicacion SET fechaBaja=NOW(), usuarioBaja=".$oValueObject->getUsuarioBaja()." WHERE idEquipo=".$oValueObject->getIdEquipo().";";      
	  if (mysql_query($sql))  {                                                
			return true;                
	  } else {     
			return false;
	  }   
   }

    /**
    *
    * @param UbicacionValueObject $oValueObject
    * @return boolean 
    */
    public function deleteCompleto($oValueObject) {
       $sql = "DELETE FROM ubicacion WHERE idEquipo=".$oValueObject->getIdEquipo().";";
       if (mysql_query($sql))  {
           return true;
        } else {
            return false;
        }
    }
}
?>