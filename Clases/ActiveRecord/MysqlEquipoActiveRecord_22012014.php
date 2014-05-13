<?php
//Se requiere la intefaz ActiveRecord
require_once '../ClasesBasicas/ActiveRecordInterface.php';
// Se requiere la clase EquipoValueObject
require_once '../Clases/ValueObject/EquipoValueObject.php';

/**
 * Description of MysqlEquipoActiveRecord
 *
 */
class MysqlEquipoActiveRecord implements ActiveRecord{
   /**
    * Cuenta la cantidad de registros que hay en la tabla equipo
    * @return int 
    */
   public function count() {
//      $sql = "SELECT COUNT(*) FROM equipo;";
//      $resultado = mysql_query($sql);
//      if($resultado){
//         $resultado = mysql_fetch_row($resultado);
//         return $resultado[0];
//      } else {
//         return 0;
//      }
   }
   
   /**
    *
    * @param EquipoValueObject $oValueObject
    * @return boolean 
    */
   public function delete($oValueObject) {
      $sql = "UPDATE equipo SET observacion='".$oValueObject->getObservacion()."', fechaBaja=NOW(), usuarioBaja=".$oValueObject->getUsuarioAlta()." WHERE id= " . $oValueObject->getId() . ";";      
      if(mysql_query($sql)){
         return true;
      } else {
         return false;
      }
   }
   
    /**
    *
    * @param EquipoValueObject $oValueObject
    * @return boolean 
    */
   public function deleteRx($oValueObject) {
      $sql = "UPDATE equi_rx SET baja='*' WHERE id= " . $oValueObject->getId() . ";";      
      if(mysql_query($sql)){
         return true;
      } else {
         return false;
      }
   }
   
   /**
    *
    * @param EquipoValueObject $oValueObject
    * @return boolean 
    */
   public function exists($oValueObject) {
//      $sql = "SELECT COUNT(*) FROM equipo WHERE nro= " . $oValueObject->getNro() . ";";
//      $resultado = mysql_query($sql);
//      if($resultado){
//         $resultado = mysql_fetch_row($resultado);
//         if($resultado[0]>0){
//            return true;
//         } else {
//            return false;
//         }
//      } else {
//         return false;
//      }
   }

   /**
    *
    * @param EquipoValueObject $oValueObject1
    * @return boolean 
    */
   public function find($oValueObject1) {
      $sql = "SELECT equipo.id, nro, cod_eq, idTipo, idMarca, idModelo, nroSerie, detalle, ordenCompra, date_format(garantiaDesde, '%d/%m/%Y') as garantiaD, date_format(garantiaFin, '%d/%m/%Y') as garantiaF, edad, manual, observacion, usuarioAlta, date_format(fechaBaja, '%d/%m/%Y') as fechadeBaja, idProveedor, date_format(fechaIng, '%d/%m/%Y') as fechaIngreso, kv, ma, inten, alime, idAdquiriente
          FROM equipo LEFT JOIN equi_rx ON equi_rx.id = equipo.id WHERE  nro=".$oValueObject1->getNro()." ";                  
      $resultado = mysql_query($sql);
      if($resultado){
            if(mysql_num_rows($resultado)>0) {
                $fila = mysql_fetch_object($resultado);
                $oValueObject1->setId($fila->id);
                $oValueObject1->setNro($fila->nro);
                $oValueObject1->setCod_eq($fila->cod_eq);
                $oValueObject1->setIdTipo($fila->idTipo);
                $oValueObject1->setIdMarca($fila->idMarca);                
                $oValueObject1->setIdModelo($fila->idModelo);                
                $oValueObject1->setNroSerie($fila->nroSerie);            
                $oValueObject1->setDetalle($fila->detalle);                           
                $oValueObject1->setOrdenCompra($fila->ordenCompra);           
                $oValueObject1->setGarantiaDesde($fila->garantiaD);          
                $oValueObject1->setGarantiaFin($fila->garantiaF);                
                $oValueObject1->setEdad($fila->edad);                
                $oValueObject1->setManual($fila->manual);     
                $oValueObject1->setObservacion($fila->observacion);    
                $oValueObject1->setUsuarioAlta($fila->usuarioAlta);    
                $oValueObject1->setFechaAlta($fila->fechaIngreso);    
                $oValueObject1->setFechaBaja($fila->fechadeBaja);
                $oValueObject1->setIdProveedor($fila->idProveedor);
                $oValueObject1->setAlimentacion($fila->alime);
                $oValueObject1->setKv($fila->kv);
                $oValueObject1->setMa($fila->ma);
                $oValueObject1->setIntensificador($fila->inten);
                $oValueObject1->setIdAdquiriente($fila->idAdquiriente);
                return $oValueObject1;
            } else {
                 return false;
            }           
        } else {
          return false;
      }
   }
   
   /**
    *
    * @param EquipoValueObject $oValueObject1
    * @return boolean 
    */
   public function findRX($oValueObject1) {
      $sql = "SELECT * FROM equi_rx WHERE id=".$oValueObject1->getId()." ";             
      $resultado = mysql_query($sql);
      if($resultado){          
            $fila = mysql_fetch_object($resultado);                                
            if($fila->id<>"")
                return $fila->id;
            else 
                return false;            
      } else {
          return false;
      }
   }
   
  /**
    * @param int $uso
    * @return int
    */
   public function findUltimoPar() {
      $sql = "SELECT MAX(nro) AS nro FROM equipo ";            
      $resultado = mysql_query($sql);
      if($resultado){
            if(mysql_num_rows($resultado)>0) {
                $fila = mysql_fetch_object($resultado);                                
                if($fila->nro<>"")
                    return $fila->nro;
                else 
                    return 0;                
            } else {
                 return false;
            }           
        } else {
          return false;
      }
   }
   
   /**
    *
    * @param EquipoValueObject $oValueObject1
    * @return boolean 
    */
   public function findPorId($oValueObject1) {
//      $sql = "SELECT * FROM equipo WHERE  id=".$oValueObject1->getId();                              
//      $resultado = mysql_query($sql);
//      if($resultado){
//            if(mysql_num_rows($resultado)>0) {
//                $fila = mysql_fetch_object($resultado);
//                $oValueObject1->setId($fila->id);
//                $oValueObject1->setNro($fila->nro);
//                $oValueObject1->setUso($fila->uso);
//                $oValueObject1->setTipo($fila->tipo);
//                $oValueObject1->setNombre($fila->nombre);
//                $oValueObject1->setIp($fila->ip);                
//                $oValueObject1->setUsuario($fila->idUsuario);                
//                $oValueObject1->setObservacion($fila->observacion);       
//                $oValueObject1->setFechaBaja($fila->fechaBaja);
//                return $oValueObject1;
//            } else {
//                 return false;
//            }           
//        } else {
//          return false;
//      }
   }
   
      /**
    *
    * @param EquipoValueObject $oValueObject
    * @return boolean 
    */
   public function findPorRx($oValueObject) {
      $sql = "SELECT * FROM equi_rx WHERE id=".$oValueObject->getId();                
      $resultado = mysql_query($sql);
      if($resultado){
            if(mysql_num_rows($resultado)>0) {
                return true;
            } else {
                return false;
            }           
        } else {
          return false;
      }
   }
   
   
   
      /**
    * Busca todos lo datos de la tabla equipo que se encuentra en la base de datos.
    * @return boolean 
    */
   public function findAll() {
      $sql = "SELECT * from equipo order by nro";      
      $resultado = mysql_query($sql);
      if($resultado){
//         $aRubro = array();
//         while ($fila = mysql_fetch_object($resultado)) {
//            $oRubro = new RubroValueObject();
//            $oRubro->setId($fila->id);
//            $oRubro->setDescripcion($fila->descripcion);     
//            $aRubro[] = $oRubro;
//            unset ($oRubro);
//         }
//         return $aRubro;
      } else {
         return false;
      }
   }

     
 

   /**
    *
    * @param EquipoValueObject $oValueObject
    * @return boolean 
    */
   public function insert($oValueObject) {
      $sql = "INSERT INTO equipo (`cod_eq`,`nro`,`idTipo`,`idMarca`,`idModelo`,`nroSerie`,`detalle`,
             `ordenCompra`,`garantiaDesde`,`garantiaFin`,`edad`,`manual`,`observacion`,
             `idAdquiriente`,`usuarioAlta`,`idProveedor`,`fechaAlta`) VALUES ('";
      $sql .= $oValueObject->getCod_eq() . "', ";
      $sql .= $oValueObject->getNro() . ", ";
      $sql .= "1, ";
      $sql .= $oValueObject->getIdMarca() . ", '";      
      $sql .= $oValueObject->getIdModelo() . "', '";      
      $sql .= $oValueObject->getNroSerie() . "', '";                  
      $sql .= $oValueObject->getDetalle()."', '" ;
      $sql .= $oValueObject->getOrdenCompra() . "', '"; 
      
      $fechaD = explode("/", $oValueObject->getGarantiaDesde());
      $sql .= $fechaD[2]."-".$fechaD[1]."-".$fechaD[0]."', '";    
      
      $fechaH = explode("/", $oValueObject->getGarantiaFin());
      $sql .= $fechaH[2]."-".$fechaH[1]."-".$fechaH[0]."', '";      
      
      $sql .= $oValueObject->getEdad() . "', '";
      $sql .= $oValueObject->getManual() . "', '";
      $sql .= $oValueObject->getObservacion() . "', '";
      $sql .= $oValueObject->getIdAdquiriente() . "', '";
      $sql .= $oValueObject->getUsuarioAlta() . "', '";
      $sql .= $oValueObject->getIdProveedor() . "', ";
      $sql .= "now()";      
      $sql.= " ) ";               
      if (mysql_query($sql))  {     
           $result = mysql_query("SELECT DISTINCT LAST_INSERT_ID() FROM equipo");
           $id = mysql_fetch_array($result);            
           if($id[0]<>0) {                        
                return $id[0];
           } else {
               return false;
           }    
      } else {     
            return false;
      }   
   }

   /**
    *
    * @param EquipoValueObject $oValueObject
    * @return boolean 
    */
   public function insertRX($oValueObject) {
      $sql = "INSERT INTO equi_rx (`id`,`ma`,`kv`,`alime`,`inten`) VALUES (";
      $sql .= $oValueObject->getId() . ", '";
      $sql .= $oValueObject->getMa() . "', '";
      $sql .= $oValueObject->getKv() . "', '";
      $sql .= $oValueObject->getAlimentacion() . "', '";      
      $sql .= $oValueObject->getIntensificador() . "' ) ";      
      if (mysql_query($sql))  {     
            return true;           
      } else {     
            return false;
      }   
   }
   
   /**
    *   
    * @param EquipoValueObject $oValueObject
    * @return boolean 
    */
   public function update($oValueObject) {
        $fechaD = explode("/", $oValueObject->getGarantiaDesde());
        $fechaD = $fechaD[2]."-".$fechaD[1]."-".$fechaD[0];    
        
        $fechaH = explode("/", $oValueObject->getGarantiaFin());
        $fechaH = $fechaH[2]."-".$fechaH[1]."-".$fechaH[0];  
        
        $sql = "UPDATE equipo SET ";
        $sql.=" `cod_eq` = '".$oValueObject->getCod_eq()."',";
        $sql.=" `nro` = '".$oValueObject->getNro()."',";
        $sql.=" `idTipo` = '".$oValueObject->getIdTipo()."',";
        $sql.=" `idMarca` = '".$oValueObject->getIdMarca()."',";
        $sql.=" `idMarca` = '".$oValueObject->getIdMarca()."',";
        $sql.=" `idModelo` = '".$oValueObject->getIdModelo()."',";        
        $sql.=" `nroSerie` = '".$oValueObject->getNroSerie()."',";        
        $sql.=" `detalle` = '".$oValueObject->getDetalle()."',";                
        $sql.=" `ordenCompra` = '".$oValueObject->getOrdenCompra()."',";                
        $sql.=" `garantiaDesde` = '".$fechaD."',";                
        $sql.=" `garantiaFin` = '".$fechaH."',";                        
        $sql.=" `edad` = '".$oValueObject->getEdad()."',";                                
        $sql.=" `manual` = '".$oValueObject->getManual()."',";                                
        $sql.=" `observacion` = '".$oValueObject->getObservacion()."',";                                        
        $sql.=" `idAdquiriente` = '".$oValueObject->getIdAdquiriente()."',";                                                
        $sql.=" `idProveedor` = '".$oValueObject->getIdProveedor()."' ";                                                
        $sql.=" WHERE id = ".$oValueObject->getId().";";        
        
        if (mysql_query($sql))
           return true;
        else
           return false;
   }
   
   /**
    *   
    * @param EquipoValueObject $oValueObject
    * @return boolean 
    */
   public function updateRX($oValueObject) {       
        $sql = "UPDATE equi_rx SET ";
        $sql.=" `ma` = '".$oValueObject->getMa()."',";
        $sql.=" `kv` = '".$oValueObject->getKv()."',";
        $sql.=" `alime` = '".$oValueObject->getAlimentacion()."',";
        $sql.=" `inten` = '".$oValueObject->getIntensificador()."'";                                              
        $sql.=" WHERE id = ".$oValueObject->getId().";";                
        if (mysql_query($sql))
           return true;
        else
           return false;
   }
  
      /**
    *   
    * @param EquipoValueObject $oValueObject
    * @return boolean 
    */
   public function bajaRX($oValueObject) {       
        $sql = "DELETE FROM equi_rx ";        
        $sql.=" WHERE id = ".$oValueObject->getId().";";    
        if (mysql_query($sql))
           return true;
        else
           return false;
   }
   
   /**
    *
    * @param EquipoValueObject $oValueObject
    * @return boolean 
    */
   public function bajaCompleto($oValueObject) {
//      $sql = "UPDATE equipo SET fechaBaja=NOW(), usuarioBaja=".$oValueObject->getUsuarioAlta()." WHERE id=".$oValueObject->getId().";";      
//      if (mysql_query($sql))  {                                                
//            return true;                
//      } else {     
//            return false;
//      }   
   }

}
?>