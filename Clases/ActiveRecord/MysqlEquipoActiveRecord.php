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
      $sql = "SELECT equipo.id, nro, cod_eq, idTipo, idMarca, idModelo, nroSerie, detalle, idOrdenCompra, garantiaFin, edad, manual, observacion, usuarioAlta, date_format(fechaBaja, '%d/%m/%Y') as fechadeBaja, idProveedor, date_format(fechaIng, '%d/%m/%Y') as fechaIngreso, kv, ma, inten, alime
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
                $oValueObject1->setIdOrdenCompra($fila->idOrdenCompra);
                $oValueObject1->setGarantiaFin($fila->garantiaFin);                
                $oValueObject1->setEdad($fila->edad);                
                $oValueObject1->setManual($fila->manual);     
                $oValueObject1->setObservacion($fila->observacion);    
                $oValueObject1->setUsuarioAlta($fila->usuarioAlta);    
                $oValueObject1->setFechaAlta($fila->fechaIngreso);    
                $oValueObject1->setFechaBaja($fila->fechadeBaja);
                $oValueObject1->setIdProveedor($fila->idProveedor);
//                $oValueObject1->setAlimentacion($fila->alime);
//                $oValueObject1->setKv($fila->kv);
//                $oValueObject1->setMa($fila->ma);
//                $oValueObject1->setIntensificador($fila->inten);
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
   public function findPorId($oValueObject1) {
       $sql = "SELECT * FROM equipo WHERE id = ".$oValueObject1->getId();
       $resultado = mysql_query($sql);
       if($resultado){
           if(mysql_num_rows($resultado)>0) {
               $fila = mysql_fetch_object($resultado);
               $oValueObject1->setId($fila->id);
               $oValueObject1->setCod_eq($fila->cod_eq);
               $oValueObject1->setNro($fila->nro);
               $oValueObject1->setIdTipo($fila->idTipo);
               $oValueObject1->setIdMarca($fila->idMarca);
               $oValueObject1->setIdModelo($fila->idModelo);
               $oValueObject1->setNroSerie($fila->nroSerie);
               $oValueObject1->setDetalle($fila->detalle);
               $oValueObject1->setIdOrdenCompra($fila->idOrdenCompra);
               $oValueObject1->setFechaOrdenCompra($fila->fechaOrdenCompra);
               $oValueObject1->setGarantiaFin($fila->garantiaFin);
               $oValueObject1->setFechaIng($fila->fechaIng);
               $oValueObject1->setEdad($fila->edad);
               $oValueObject1->setManual($fila->manual);
               $oValueObject1->setObservacion($fila->observacion);
               $oValueObject1->setIdAdquiriente($fila->idAdquiriente);
               $oValueObject1->setUsuarioAlta($fila->usuarioAlta);
               $oValueObject1->setFechaAlta($fila->fechaAlta);
               $oValueObject1->setUsuarioBaja($fila->usuarioBaja);
               $oValueObject1->setFechaBaja($fila->fechaBaja);
               $oValueObject1->setIdProveedor($fila->idProveedor);
               return $oValueObject1;
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
//      $sql = "INSERT INTO equipo (nro, uso, nombre, ip, idUsuario, observacion, usuarioAlta, tipo) VALUES (";
//      $sql .= $oValueObject->getNro() . ", ";
//      $sql .= $oValueObject->getUso() . ", '";
//      $sql .= $oValueObject->getNombre() . "', '";
//      $sql .= $oValueObject->getIp() . "', ";      
//      $sql .= $oValueObject->getUsuario() . ", '";      
//      $sql .= $oValueObject->getObservacion() . "', ";                  
//      $sql .= $oValueObject->getUsuarioAlta().", " ;
//      if($oValueObject->getTipo())
//            $sql .= $oValueObject->getTipo() ;
//      else $sql.=" 1 ";
//      $sql.= " ) ";          
//      if (mysql_query($sql))  {     
//           $result = mysql_query("SELECT DISTINCT LAST_INSERT_ID() FROM equipo");
//           $id = mysql_fetch_array($result);            
//           if($id[0]<>0) {                        
//                return $id[0];
//           } else {
//               return false;
//           }    
//      } else {     
//            return false;
//      }   
   }

   /**
    *   
    * @param EquipoValueObject $oValueObject
    * @return boolean 
    */
   public function update($oValueObject) {
//      $sql = "UPDATE equipo SET nombre='".$oValueObject->getNombre()."',";
//      $sql.=" ip ='".$oValueObject->getIp()."',";                       
//      $sql.=" idUsuario =".$oValueObject->getUsuario().",";      
//      $sql.=" observacion ='".$oValueObject->getObservacion()."',";       
//      $sql.=" usuarioAlta =".$oValueObject->getUsuarioAlta()."";       
//      $sql.=" WHERE id = ".$oValueObject->getId().";";        
//      if (mysql_query($sql))
//         return true;
//      else
//         return false;
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
}
?>