<?php
// Se requiere la clase ComponenteValueObject
require_once '../Clases/ValueObject/ComponenteValueObject.php';

/**
 * Description of MysqlComponenteActiveRecord
 *
 */
class MysqlComponenteActiveRecord {     

    /**
    *
    * @param ComponenteValueObject $oValueObject
    * @return boolean 
    */
   public function find($oValueObject) {
      $sql = "SELECT * FROM componente WHERE id=".$oValueObject->getId()." and fechaBaja='0000-00-00 00:00:00'";               
      $resultado = mysql_query($sql);
     if($resultado){
            if(mysql_num_rows($resultado)>0) {
                $fila = mysql_fetch_object($resultado);                
                $oValueObject->setNro($fila->nro);
                $oValueObject->setUso($fila->uso);
                $oValueObject->setOfcodi($fila->ofcodi);
                $oValueObject->setIdTipo($fila->idTipo);
                $oValueObject->setIdMarca($fila->idMarca);
                $oValueObject->setIdModelo($fila->idModelo);
                $oValueObject->setNroSerie($fila->nroSerie);
                $oValueObject->setCantidad($fila->cantidad);
                $oValueObject->setNroOrdenCompra($fila->nroOrdenCompra);
                $oValueObject->setGarantia($fila->garantiaFin);
                $oValueObject->setDetalle($fila->detalle);
                return $oValueObject;
            }  else return false;       
        } else {
          return false;
      }
   }
   
    public function findTodo($oValueObject) {
      $sql = "SELECT * FROM componente WHERE id=".$oValueObject->getId()." ";               
      $resultado = mysql_query($sql);
     if($resultado){
            if(mysql_num_rows($resultado)>0) {
                $fila = mysql_fetch_object($resultado);                
                $oValueObject->setNro($fila->nro);
                $oValueObject->setUso($fila->uso);
                $oValueObject->setOfcodi($fila->ofcodi);
                $oValueObject->setIdTipo($fila->idTipo);
                $oValueObject->setIdMarca($fila->idMarca);
                $oValueObject->setIdModelo($fila->idModelo);
                $oValueObject->setNroSerie($fila->nroSerie);
                $oValueObject->setCantidad($fila->cantidad);
                $oValueObject->setNroOrdenCompra($fila->nroOrdenCompra);
                $oValueObject->setGarantia($fila->garantiaFin);
                $oValueObject->setDetalle($fila->detalle);
                return $oValueObject;
            }  else return false;       
        } else {
          return false;
      }
   }
   
    /**
    * Busca todos lo datos de la tabla componentes que no esten asociados 
    * @param ComponenteValueObject $oValueObject
    * @return array  $aC
    */
   public function findSinAsociar($oValueObject) {
      $sql = "SELECT id, nro, uso, ofcodi, idTipo, idModelo, idMarca, nroSerie, cantidad, detalle, nroOrdenCompra, garantiaFin, usuarioAlta, ";
      $sql.= " DATE_FORMAT(DATE(`fechaAlta`),'%d-%m-%Y') AS fechaAlta, TIME(`fechaAlta`) AS horaAlta FROM componente WHERE 
        (componente.id NOT IN (SELECT relacion.idComponente FROM relacion WHERE fechaBaja='0000-00-00 00:00:00')) AND fechaBaja='0000-00-00 00:00:00'";                             
      if($oValueObject->getIdTipo()<>'')
          $sql.=" AND idTipo=".$oValueObject->getIdTipo();
      if($oValueObject->getIdMarca()<>'')
          $sql.=" AND idMarca=".$oValueObject->getIdMarca();
      if($oValueObject->getIdModelo()<>'')
          $sql.=" AND idModelo=".$oValueObject->getIdModelo();      
      $sql.=" order by idTipo, idMarca, idModelo, nroSerie";      
      $resultado = mysql_query($sql);
      if($resultado){
         $aC = array();
         while ($fila = mysql_fetch_object($resultado)) {
            $oC = new ComponenteValueObject();
            $oC->setId($fila->id);
            $oC->setNro($fila->nro);
            $oC->setUso($fila->uso);
            $oC->setOfcodi($fila->ofcodi);
            $oC->setIdTipo($fila->idTipo);
            $oC->setIdMarca($fila->idMarca);
            $oC->setIdModelo($fila->idModelo);
            $oC->setNroSerie($fila->nroSerie);
            $oC->setCantidad($fila->cantidad);
            $oC->setDetalle($fila->detalle);
            $oC->setNroOrdenCompra($fila->nroOrdenCompra);
            $oC->setGarantia($fila->garantiaFin);
            $oC->setUsuarioAlta($fila->usuarioAlta);
            $oC->setFechaAlta($fila->fechaAlta);
            $oC->setHoraAlta($fila->horaAlta);
            $aC[] = $oC;
            unset ($oC);
         }
         return $aC;     
        } else {
          return false;
      }
   }
   
    /**
    *
    * @param ComponenteValueObject $oValueObject
    * @return boolean 
    */
   public function findTipo($oValueObject) {
      $sql = "SELECT * FROM componente WHERE idEquipo= " . $oValueObject->getIdEquipo()." AND idTipo = ".$oValueObject->getIdTipo()." and fechaBaja='0000-00-00 00:00:00'";                              
      $resultado = mysql_query($sql);
      if($resultado){
          if(mysql_num_rows($resultado)>0) {            
            return true;     
            } else {
          return false;
            }
      } else return false;
   }
    
   /**
    *
    * @param ComponenteValueObject $oValueObject
    * @return boolean 
    */
   public function insert($oValueObject) {      
      $sql = "INSERT INTO componente (nro, uso, ofcodi, nroOrdenCompra, idTipo, idMarca, idModelo, nroSerie, detalle, cantidad, garantiaFin, usuarioAlta) VALUES (";
      $sql .= $oValueObject->getNro() . ", ";
      $sql .= $oValueObject->getUso() . ", ";
      $sql .= $oValueObject->getOfcodi() . ", ";
      $sql .= $oValueObject->getNroOrdenCompra() . ", ";
      $sql .= $oValueObject->getIdTipo() . ", ";
      $sql .= $oValueObject->getIdMarca() . ", ";
      $sql .= $oValueObject->getIdModelo() . ", '";
      $sql .= $oValueObject->getNroSerie() . "', '";
      $sql .= $oValueObject->getDetalle() . "', '";
      $sql .= $oValueObject->getCantidad() . "', '";
      $sql .= $oValueObject->getGarantia() . "', ";
      $sql .= $oValueObject->getUsuarioAlta() . ") ";          
      if (mysql_query($sql))  {        
           $result = mysql_query("SELECT DISTINCT LAST_INSERT_ID() FROM componente");
           $id = mysql_fetch_array($result);            
           if($id[0]<>0) {                
                return $id[0];
           } else { return false; }
      } else {     
            return false;
      }   
   }

      /**
    *
    * @param ComponenteValueObject $oValueObject
    * @return boolean 
    */
   public function update($oValueObject) {
      $sql = "UPDATE componente SET idTipo =".$oValueObject->getIdTipo().", ";
      $sql.= " idMarca =". $oValueObject->getIdMarca() . ", ";
      $sql .= " idModelo = ".$oValueObject->getIdModelo() . ", ";
      $sql .= " nroSerie = '".$oValueObject->getNroSerie() . "', ";
      $sql .= " detalle = '".$oValueObject->getDetalle() . "', ";
      $sql .= " cantidad = '".$oValueObject->getCantidad() . "', ";
      if($oValueObject->getNroOrdenCompra())
          $sql .= " nroOrdenCompra = ".$oValueObject->getNroOrdenCompra() . " , ";
      if($oValueObject->getGarantia())
          $sql .= " garantiaFin = ".$oValueObject->getGarantia() . " , ";
      $sql .= " usuarioAlta = ".$oValueObject->getUsuarioAlta() . " ";
      if(($oValueObject->getOfcodi())||($oValueObject->getOfcodi()==0))
          $sql .= ", ofcodi = ".$oValueObject->getOfcodi() . " ";
      $sql .= " WHERE id = ".$oValueObject->getId()." AND fechaBaja='0000-00-00 00:00:00'";              
      if (mysql_query($sql))  {                                                
            return true;                
      } else {     
            return false;
      }   
   }
   
    /**
    *
    * @param ComponenteValueObject $oValueObject
    * @return boolean 
    */
   public function updateOF($oValueObject) {
      $sql = "UPDATE componente SET ";
      $sql .= " nro = '".$oValueObject->getNro() . "', ";            
      $sql .= " ofcodi = ".$oValueObject->getOfcodi() . " ";
      $sql .= " WHERE id = ".$oValueObject->getId()." AND fechaBaja='0000-00-00 00:00:00'";          
      if (mysql_query($sql))  {                                                
            return true;                
      } else {     
            return false;
      }   
   }
   
         /**
    *
    * @param ComponenteValueObject $oValueObject
    * @return boolean 
    */
   public function updateImp($oValueObject) {
      $sql = "UPDATE componente SET idTipo =".$oValueObject->getIdTipo().", ";
      $sql.= " idMarca =". $oValueObject->getIdMarca() . ", ";
      $sql.= " nro =". $oValueObject->getNro() . ", ";
      $sql .= " idModelo = ".$oValueObject->getIdModelo() . ", ";
      $sql .= " nroSerie = '".$oValueObject->getNroSerie() . "', ";
      $sql .= " detalle = '".$oValueObject->getDetalle() . "', ";
      $sql .= " cantidad = '".$oValueObject->getCantidad() . "', ";
      $sql .= " usuarioAlta = ".$oValueObject->getUsuarioAlta() . " ";
      if($oValueObject->getOfcodi())
          $sql .= ", ofcodi = ".$oValueObject->getOfcodi() . " ";
      $sql .= " WHERE id = ".$oValueObject->getId()." AND fechaBaja='0000-00-00 00:00:00'";                    
      if (mysql_query($sql))  {                                                
            return true;                
      } else {     
            return false;
      }   
   }
   
    /**
    *
    * @param ComponenteValueObject $oValueObject
    * @return boolean 
    */
   public function updateOC($oValueObject) {
      $sql = "UPDATE componente SET nroOrdenCompra =".$oValueObject->getNroOrdenCompra().", ";
      $sql.= " garantiaFin ='". $oValueObject->getGarantia() . "' ";
      $sql.= " WHERE id = ".$oValueObject->getId()." AND fechaBaja='0000-00-00 00:00:00'";                   
      if (mysql_query($sql))  {                                                
            return true;                
      } else {     
            return false;
      }   
   }
   
       /**
    *
    * @param ComponenteValueObject $oValueObject
    * @return boolean 
    */
   public function updateNro($oValueObject) {
      $sql = "UPDATE componente SET nro =".$oValueObject->getNro()." ";      
      $sql.= " WHERE id = ".$oValueObject->getId()." AND fechaBaja='0000-00-00 00:00:00'";                   
      if (mysql_query($sql))  {                                                
            return true;                
      } else {     
            return false;
      }   
   }
   
   /**
    *
    * @param ComponenteValueObject $oValueObject
    * @return boolean 
    */
   public function delete($oValueObject) {
      $sql = "DELETE FROM componente";
      $sql .= " WHERE id = ".$oValueObject->getId()." AND fechaBaja='0000-00-00 00:00:00'";             
      if (mysql_query($sql))  {                                                
            return true;                
      } else {     
            return false;
      }   
   }

    /**
    * Baja logica de los componentes de un equipo asociado
    * @param ComponenteValueObject $oValueObject
    * @return boolean 
    */
   public function bajaCompleto($oValueObject) {
      $sql = "UPDATE componente INNER JOIN relacion ON componente.id=relacion.`idComponente` AND idEquipo=".$oValueObject->getId()." SET componente.fechaBaja=now(), componente.usuarioBaja=".$oValueObject->getUsuarioAlta()." ";
//      $sql = "UPDATE componente SET fechaBaja='2013-11-13 12:47:38' WHERE id IN (SELECT * FROM (SELECT idComponente FROM relacion WHERE idEquipo=".$oValueObject->getId().")) AS p);";      
      mysql_query($sql) or die (mysql_error());
      if (mysql_query($sql))  {                                                
            return true;                
      } else {     
            return false;
      }   
   }
      
         /**
    * Eliminar definitivamente los componentes de un equipo asociado
    * @param ComponenteValueObject $oValueObject
    * @return boolean 
    */
   public function deleteCompleto($oValueObject) {
      $sql = "DELETE FROM componente WHERE id IN ( SELECT * FROM (SELECT idComponente FROM relacion WHERE idEquipo=".$oValueObject->getId().") AS p);";      
      if (mysql_query($sql))  {                                                
            return true;                
      } else {     
            return false;
      }   
   }
}
?>