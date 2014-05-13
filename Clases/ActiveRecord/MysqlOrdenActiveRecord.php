<?php
require_once '../Clases/ValueObject/OrdenValueObject.php';

/**
 * Description of MysqlOrdenActiveRecord
 *
 */
class MysqlOrdenActiveRecord{
   /**
    * Contabliza la cantidad de ordenes que existen en la tabla
    * @return int o 0 si no encuetra nada.
    */
   public function count() {
      $sql = "SELECT COUNT(*) FROM orden;";
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
    * @param OrdenValueObject $oValueObject
    * @return boolean 
    */
   public function delete($oValueObject) {
      $sql = "DELETE FROM orden WHERE nro = " . $oValueObject->getDni();
      if (mysql_query($sql))
         return true;
      else
         return false;
   }

   /**
    *
    * @param OrdenValueObject $oValueObject
    * @return boolean 
    */
   public function exists($oValueObject) {
      $sql = "SELECT COUNT(*) FROM orden WHERE nro = " . $oValueObject->getNro() . ";";
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
    * @param OrdenValueObject $oValueObject
    * @return boolean 
    */
   public function countPorOfcodi($oValueObject) {
      $sql = "SELECT COUNT(*) FROM orden WHERE ofcodi = " . $oValueObject->getOfcodi() . ";";
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
    * @param OrdenValueObject $oValueObject
    * @return OrdenValueObject|boolean 
    */
   public function find($oValueObject) {
      $sql = "SELECT `nro`, DATE_FORMAT(DATE(`fechaInicio`),'%d-%m-%Y') AS fechaInicio, TIME(`fechaInicio`) AS horaInicio,";
      $sql.= " `usuarioAlta`, `idProblema`, `descripcion`, `prioridad`, `ofcodi`, `tipoRecepcion`, `estado`, `usuarioAsignado`,";
      $sql.= " `usuarioAsignador`,  DATE_FORMAT(DATE(`fechaAsignacion`),'%d-%m-%Y') AS fechaAsignacion, TIME(`fechaAsignacion`) AS horaAsignacion, `formaFinalizacion`,  DATE_FORMAT(DATE(`fechaFinalizacion`),'%d-%m-%Y') AS fechaFinalizacion, TIME(`fechaFinalizacion`) AS horaFinalizacion, `observacion`, `cierre`, `usuarioCierre`, DATE_FORMAT(DATE(`fechaCierre`),'%d-%m-%Y') AS fechaCierre, TIME(`fechaCierre`) AS horaCierre , `idEquipo`,`nroEquipo`,`dni` ";
      $sql.= " FROM orden WHERE ";
      $sql.= " nro = " . $oValueObject->getNro().";";      
      $resultado = mysql_query($sql);
      if($resultado){
            $fila = mysql_fetch_object($resultado);
            $oValueObject->setNro($fila->nro);
            $oValueObject->setFechaInicio($fila->fechaInicio);
            $oValueObject->setHoraInicio($fila->horaInicio);
            $oValueObject->setUsuarioAlta($fila->usuarioAlta);
            $oValueObject->setIdProblema($fila->idProblema);
            $oValueObject->setDescripcion($fila->descripcion);
            $oValueObject->setPrioridad($fila->prioridad);
            $oValueObject->setOfcodi($fila->ofcodi);
            $oValueObject->setTipoRecepcion($fila->tipoRecepcion);
            $oValueObject->setEstado($fila->estado);
            $oValueObject->setUsuarioAsignado($fila->usuarioAsignado);
            $oValueObject->setUsuarioAsignador($fila->usuarioAsignador);
            $oValueObject->setFechaAsignacion($fila->fechaAsignacion);
            $oValueObject->setFormaFinalizacion($fila->formaFinalizacion);
            $oValueObject->setObservacion($fila->observacion);
            $oValueObject->setCierre($fila->cierre);
            $oValueObject->setUsuarioCierre($fila->usuarioCierre);
            $oValueObject->setFechaCierre($fila->fechaCierre);    
            $oValueObject->setEquipo($fila->idEquipo);
            $oValueObject->setNroEquipo($fila->nroEquipo);
            $oValueObject->setAgente($fila->dni);
            return $oValueObject;
      } else {
         return false;
      }
   }
   
      /**
    *
    * @param OrdenValueObject $oValueObject
    * @return OrdenValueObject|boolean 
    */
   public function findOrden($oValueObject) {
//      if($oValueObject->getDni()<>0) {
//      $sql = "SELECT * FROM Orden WHERE anio = ". $oValueObject->getAnio() ." and dni=".$oValueObject->getDni().";";      
//      $resultado = mysql_query($sql);
//      if($resultado){
//          if(mysql_num_rows($resultado)>0) {
//                $fila = mysql_fetch_object($resultado);
//                $oValueObject->setNroPlanilla($fila->nroPlanilla);
//                $oValueObject->setAnio($fila->anio);
//                $oValueObject->setDni($fila->dni);
//                $oValueObject->setFechaNacimiento($fila->fechaNacimiento);
//                $oValueObject->setEdad($fila->edad);
//                $oValueObject->setDomicilio($fila->domicilio);
//                $oValueObject->setTelefono($fila->telefono);
//                $oValueObject->setPrematuro($fila->prematuro);
//                $oValueObject->setPesoNacimiento($fila->pesoNacimiento);
//                $oValueObject->setNombre($fila->nombre);
//                $oValueObject->setSexo($fila->sexo);
//                return $oValueObject;
//          } else {
//                return false;
//          }
//      } else {
//         return false;
//      }
//      } else {
//          return false;
//      }
   }

   /**
    * @param OrdenValueObject $oValueObject
    * @return OrdenValueObject|boolean 
    */
   public function findAll($oValueObject) {
      $sql = "SELECT `nro`,idEquipo, nroEquipo, dni, DATE_FORMAT(DATE(`fechaInicio`),'%d-%m-%Y') AS fechaInicio, TIME(`fechaInicio`) AS horaInicio,";
      $sql.= " `usuarioAlta`, `idProblema`, `descripcion`, `prioridad`, `ofcodi`, `tipoRecepcion`, `estado`, `usuarioAsignado`,";
      $sql.= " `usuarioAsignador`,  DATE_FORMAT(DATE(`fechaAsignacion`),'%d-%m-%Y') AS fechaAsignacion, TIME(`fechaAsignacion`) AS horaAsignacion, `formaFinalizacion`,  DATE_FORMAT(DATE(`fechaFinalizacion`),'%d-%m-%Y') AS fechaFinalizacion, TIME(`fechaFinalizacion`) AS horaFinalizacion, `observacion`, `cierre`, `usuarioCierre`, DATE_FORMAT(DATE(`fechaCierre`),'%d-%m-%Y') AS fechaCierre, TIME(`fechaCierre`) AS horaCierre";
      $sql.= " FROM orden WHERE ";
      $sql.= " (DATE_FORMAT(DATE(`fechaInicio`),'%d/%m/%Y')='".$oValueObject->getFechaInicio()."' OR DATE_FORMAT(DATE(`fechaAsignacion`),'%d/%m/%Y')='".$oValueObject->getFechaInicio()."'
      OR DATE_FORMAT(DATE(`fechaFinalizacion`),'%d/%m/%Y')='".$oValueObject->getFechaInicio()."' OR DATE_FORMAT(DATE(`fechaCierre`),'%d/%m/%Y')='".$oValueObject->getFechaInicio()."')";
      $sql.= " ORDER BY IF(DATE_FORMAT(DATE(`fechaCierre`),'%d/%m/%Y')='".$oValueObject->getFechaInicio()."', TIME(`fechaCierre`),
        IF(DATE_FORMAT(DATE(`fechaFinalizacion`),'%d/%m/%Y')='".$oValueObject->getFechaInicio()."',TIME(`fechaFinalizacion`),
        IF(DATE_FORMAT(DATE(`fechaAsignacion`),'%d/%m/%Y')='".$oValueObject->getFechaInicio()."',TIME(`fechaAsignacion`),TIME(`fechaInicio`)))) DESC;";            
      $resultado = mysql_query($sql);
      if($resultado){
         $aOrden = array();
         while ($fila = mysql_fetch_object($resultado)) {
            $oOrden = new OrdenValueObject();
            $oOrden->setNro($fila->nro);
            $oOrden->setFechaInicio($fila->fechaInicio);
            $oOrden->setHoraInicio($fila->horaInicio);
            $oOrden->setUsuarioAlta($fila->usuarioAlta);
            $oOrden->setIdProblema($fila->idProblema);
            $oOrden->setDescripcion($fila->descripcion);
            $oOrden->setPrioridad($fila->prioridad);
            $oOrden->setOfcodi($fila->ofcodi);
            $oOrden->setTipoRecepcion($fila->tipoRecepcion);
            $oOrden->setEstado($fila->estado);
            $oOrden->setUsuarioAsignado($fila->usuarioAsignado);
            $oOrden->setUsuarioAsignador($fila->usuarioAsignador);
            $oOrden->setFechaAsignacion($fila->fechaAsignacion);
            $oOrden->setHoraAsignacion($fila->horaAsignacion);
            $oOrden->setFormaFinalizacion($fila->formaFinalizacion);
            $oOrden->setFechaFinalizacion($fila->fechaFinalizacion);
            $oOrden->setHoraFinalizacion($fila->horaFinalizacion);
            $oOrden->setObservacion($fila->observacion);
            $oOrden->setCierre($fila->cierre);
            $oOrden->setUsuarioCierre($fila->usuarioCierre);
            $oOrden->setFechaCierre($fila->fechaCierre);                
            $oOrden->setHoraCierre($fila->horaCierre);     
            $oOrden->setNroEquipo($fila->nroEquipo);
            $oOrden->setEquipo($fila->idEquipo);
            $oOrden->setAgente($fila->dni);  
            $aOrden[] = $oOrden;
            unset ($oOrden);
         }        
         return $aOrden;
      } else {
         return false;
      }
   }

      /**
    * @param OrdenValueObject $oValueObject
    * @return OrdenValueObject|boolean 
    */
   public function findAllPend($oValueObject) {
      $sql = "SELECT `nro`, DATE_FORMAT(DATE(`fechaInicio`),'%d-%m-%Y') AS fechaInicio1, TIME(`fechaInicio`) AS horaInicio1,";
      $sql.= " `usuarioAlta`, `idProblema`, `descripcion`, `prioridad`, `ofcodi`, `tipoRecepcion`, `estado`, `usuarioAsignado`,";
      $sql.= " `usuarioAsignador`,  DATE_FORMAT(DATE(`fechaAsignacion`),'%d-%m-%Y') AS fechaAsignacion1, TIME(`fechaAsignacion`) AS horaAsignacion1, `formaFinalizacion`,  DATE_FORMAT(DATE(`fechaFinalizacion`),'%d-%m-%Y') AS fechaFinalizacion1, TIME(`fechaFinalizacion`) AS horaFinalizacion1, `observacion`, `cierre`, `usuarioCierre`, DATE_FORMAT(DATE(`fechaCierre`),'%d-%m-%Y') AS fechaCierre1, TIME(`fechaCierre`) AS horaCierre1";
      $sql.= " FROM orden WHERE ";
      $sql.= " ( estado=1 OR estado=2 OR DATE_FORMAT(DATE(`fechaFinalizacion`),'%d/%m/%Y')='".$oValueObject->getFechaInicio()."')";
      $sql.= " ORDER BY IF(DATE_FORMAT(DATE(`fechaCierre`),'%d/%m/%Y')='".$oValueObject->getFechaInicio()."', `fechaCierre`,
        IF(DATE_FORMAT(DATE(`fechaFinalizacion`),'%d/%m/%Y')='".$oValueObject->getFechaInicio()."',`fechaFinalizacion`,
        IF(DATE_FORMAT(DATE(`fechaAsignacion`),'%d/%m/%Y')='".$oValueObject->getFechaInicio()."',`fechaAsignacion`,`fechaInicio`))) DESC;";                   
      $resultado = mysql_query($sql);
      if($resultado){
         $aOrden = array();
         while ($fila = mysql_fetch_object($resultado)) {
            $oOrden = new OrdenValueObject();
            $oOrden->setNro($fila->nro);
            $oOrden->setFechaInicio($fila->fechaInicio1);
            $oOrden->setHoraInicio($fila->horaInicio1);
            $oOrden->setUsuarioAlta($fila->usuarioAlta);
            $oOrden->setIdProblema($fila->idProblema);
            $oOrden->setDescripcion($fila->descripcion);
            $oOrden->setPrioridad($fila->prioridad);
            $oOrden->setOfcodi($fila->ofcodi);
            $oOrden->setTipoRecepcion($fila->tipoRecepcion);
            $oOrden->setEstado($fila->estado);
            $oOrden->setUsuarioAsignado($fila->usuarioAsignado);
            $oOrden->setUsuarioAsignador($fila->usuarioAsignador);
            $oOrden->setFechaAsignacion($fila->fechaAsignacion1);
            $oOrden->setHoraAsignacion($fila->horaAsignacion1);
            $oOrden->setFormaFinalizacion($fila->formaFinalizacion);
            $oOrden->setFechaFinalizacion($fila->fechaFinalizacion1);
            $oOrden->setHoraFinalizacion($fila->horaFinalizacion1);
            $oOrden->setObservacion($fila->observacion);
            $oOrden->setCierre($fila->cierre);
            $oOrden->setUsuarioCierre($fila->usuarioCierre);
            $oOrden->setFechaCierre($fila->fechaCierre);                
            $oOrden->setHoraCierre($fila->horaCierre);                
            $aOrden[] = $oOrden;
            unset ($oOrden);
         }        
         return $aOrden;
      } else {
         return false;
      }
   }

   
   /**
    * Busca todos lo datos de la tabla orden que se encuentra en la base de datos
    * segun el criterio de busqueda y el orden enviados por parametro
    * @param OrdenValueObject $oValueObject
    * @return OrdenValueObject|boolean     
    */   
   public function findMultipleCriterio($criterio, $orden, $oValueObject, $rubro, $especialidad, $problema, $ordenFecha) {
      $sql = "SELECT `nro`, idEquipo, nroEquipo, dni, DATE_FORMAT(DATE(`fechaInicio`),'%d-%m-%Y') AS fechaInicio1, TIME(`fechaInicio`) AS horaInicio,";
      $sql.= " `usuarioAlta`, `idProblema`, `descripcion`, `prioridad`, `ofcodi`, `tipoRecepcion`, `estado`, `usuarioAsignado`,";
      $sql.= " `usuarioAsignador`, DATE_FORMAT(DATE(`fechaAsignacion`),'%d-%m-%Y') AS fechaAsignacion1, TIME(`fechaAsignacion`) AS horaAsignacion, `formaFinalizacion`,  DATE_FORMAT(DATE(`fechaFinalizacion`),'%d-%m-%Y') AS fechaFinalizacion1, TIME(`fechaFinalizacion`) AS horaFinalizacion, orden.`observacion`, `cierre`, `usuarioCierre`, `fechaCierre`";
      $sql.= " FROM orden INNER JOIN problema p ON orden.`idProblema`=p.`id` ";
      if($rubro)
          $sql.= " AND p.idRubro = ".$rubro; 
      if($especialidad)
          $sql.= " AND p.idEspecialidad = ".$especialidad; 
      if($problema)
          $sql.= " AND p.idTProblema = ".$problema; 
      $sql.= " WHERE nro<>'' ";
      if(($ordenFecha=='fechaInicio')&&($oValueObject->getFechaInicio())&&($oValueObject->getFechaFinalizacion())) {
            if(preg_match('#/#', $oValueObject->getFechaInicio())){
                $fechaIni = explode("/", $oValueObject->getFechaInicio());
            } else {
                $fechaIni = explode("-",$oValueObject->getFechaInicio());
            }
            if(preg_match('#/#', $oValueObject->getFechaFinalizacion())){
                $fechaFin = explode("/", $oValueObject->getFechaFinalizacion());
            } else {
                $fechaFin = explode("-",$oValueObject->getFechaFinalizacion());
            }        
            $sql.=" AND (DATE(`fechaInicio`) between '".$fechaIni[2]."-".$fechaIni[1]."-".$fechaIni[0]."' AND '".$fechaFin[2]."-".$fechaFin[1]."-".$fechaFin[0]."') ";          
      }
      if(($ordenFecha=='fechaFinalizacion')&&($oValueObject->getFechaInicio())&&($oValueObject->getFechaFinalizacion())) {
          if(preg_match('#/#', $oValueObject->getFechaInicio())){
                $fechaIni = explode("/", $oValueObject->getFechaInicio());
            } else {
                $fechaIni = explode("-",$oValueObject->getFechaInicio());
            }
            if(preg_match('#/#', $oValueObject->getFechaFinalizacion())){
                $fechaFin = explode("/", $oValueObject->getFechaFinalizacion());
            } else {
                $fechaFin = explode("-",$oValueObject->getFechaFinalizacion());
            }
            $sql.=" AND (DATE(`fechaFinalizacion`) between '".$fechaIni[2]."-".$fechaIni[1]."-".$fechaIni[0]."' AND '".$fechaFin[2]."-".$fechaFin[1]."-".$fechaFin[0]."') ";          
      }                    
      if($oValueObject->getOfcodi())
          $sql.=" AND ofcodi = ".$oValueObject->getOfcodi();
      if($oValueObject->getFormaFinalizacion()==1)
          $sql.=" AND (estado=1 or estado=2)";
      if($oValueObject->getFormaFinalizacion()==2)
          $sql.=" AND formaFinalizacion = ".$oValueObject->getFormaFinalizacion()." AND (estado=3 or estado=4)";
      if($oValueObject->getFormaFinalizacion()==3)
          $sql.=" AND formaFinalizacion = ".$oValueObject->getFormaFinalizacion()." AND (estado=3 or estado=4)";
      if($oValueObject->getFormaFinalizacion()==4)
          $sql.=" AND formaFinalizacion = ".$oValueObject->getFormaFinalizacion()." AND (estado=3 or estado=4)";
      if($oValueObject->getDescripcion())
          $sql.=" AND descripcion like '%".$oValueObject->getDescripcion()."%' ";      
      if ($criterio<>'')
          $sql .= sprintf(" order by %s %s",$criterio, $orden);
      else
          $sql .= " order by nro";       
      
      $resultado = mysql_query($sql);
      if($resultado){
         $aOrden = array();
         while ($fila = mysql_fetch_object($resultado)) {
            $oOrden = new OrdenValueObject();
            $oOrden->setNro($fila->nro);
            $oOrden->setFechaInicio($fila->fechaInicio1);
            $oOrden->setHoraInicio($fila->horaInicio);
            $oOrden->setUsuarioAlta($fila->usuarioAlta);
            $oOrden->setIdProblema($fila->idProblema);
            $oOrden->setDescripcion($fila->descripcion);
            $oOrden->setPrioridad($fila->prioridad);
            $oOrden->setOfcodi($fila->ofcodi);
            $oOrden->setTipoRecepcion($fila->tipoRecepcion);
            $oOrden->setEstado($fila->estado);
            $oOrden->setUsuarioAsignado($fila->usuarioAsignado);
            $oOrden->setUsuarioAsignador($fila->usuarioAsignador);
            $oOrden->setFechaAsignacion($fila->fechaAsignacion1);
            $oOrden->setHoraAsignacion($fila->horaAsignacion);
            $oOrden->setFormaFinalizacion($fila->formaFinalizacion);
            $oOrden->setFechaFinalizacion($fila->fechaFinalizacion1);
            $oOrden->setHoraFinalizacion($fila->horaFinalizacion);
            $oOrden->setObservacion($fila->observacion);
            $oOrden->setCierre($fila->cierre);
            $oOrden->setUsuarioCierre($fila->usuarioCierre);
            $oOrden->setFechaCierre($fila->fechaCierre);    
            $oOrden->setNroEquipo($fila->nroEquipo);
            $oOrden->setEquipo($fila->idEquipo);
            $oOrden->setAgente($fila->dni);                
            $aOrden[] = $oOrden;
            unset ($oOrden);
         }        
         return $aOrden;
      } else {
         return false;
      }
   }
   
   /**
    * Busca todos lo datos de la tabla orden que se encuentra en la base de datos
    * segun el criterio de busqueda y el orden enviados por parametro
    * @param OrdenValueObject $oValueObject
    * @return OrdenValueObject|boolean     
    */   
   public function findAllPorCriterio($criterio, $orden, $oValueObject, $estado) {
      $sql = "SELECT `nro`, DATE_FORMAT(DATE(`fechaInicio`),'%d-%m-%Y') AS fechaInicio1, TIME(`fechaInicio`) AS horaInicio,";
      $sql.= " `usuarioAlta`, `idProblema`, `descripcion`, `prioridad`, `ofcodi`, `tipoRecepcion`, `estado`, `usuarioAsignado`,";
      $sql.= " `usuarioAsignador`, `fechaAsignacion`, `formaFinalizacion`,  DATE_FORMAT(DATE(`fechaFinalizacion`),'%d-%m-%Y') AS fechaFinalizacion, TIME(`fechaFinalizacion`) AS horaFinalizacion, `observacion`, `cierre`, `usuarioCierre`, `fechaCierre`, `idEquipo`,`nroEquipo`,`dni` ";
      $sql.= " FROM orden WHERE ";
      if($oValueObject->getUsuarioAsignado()) {
         $sql.=" ofcodi NOT IN (SELECT ofcodi FROM bloqueo WHERE idUsuario=".$oValueObject->getUsuarioAsignado()." AND fechaBaja='0000-00-00 00:00:00') AND ";
         $sql.= " (nro IN (SELECT nroOrden FROM asignados WHERE idUsuario=".$oValueObject->getUsuarioAsignado()." and fechaBaja='0000-00-00 00:00:00') OR usuarioAsignado = 0) AND ";
      }      
      if($estado==1)
            $sql.=" (estado=1 OR estado=2) ";
      else
            $sql.=" (estado = ".$estado.")";
      if ($criterio<>'')
          $sql .= sprintf(" order by %s %s",$criterio, $orden);
      else
          $sql .= " order by nro";         
      $resultado = mysql_query($sql);
      if($resultado){
         $aOrden = array();
         while ($fila = mysql_fetch_object($resultado)) {
            $oOrden = new OrdenValueObject();
            $oOrden->setNro($fila->nro);
            $oOrden->setFechaInicio($fila->fechaInicio1);
            $oOrden->setHoraInicio($fila->horaInicio);
            $oOrden->setUsuarioAlta($fila->usuarioAlta);
            $oOrden->setIdProblema($fila->idProblema);
            $oOrden->setDescripcion($fila->descripcion);
            $oOrden->setPrioridad($fila->prioridad);
            $oOrden->setOfcodi($fila->ofcodi);
            $oOrden->setTipoRecepcion($fila->tipoRecepcion);
            $oOrden->setEstado($fila->estado);
            $oOrden->setUsuarioAsignado($fila->usuarioAsignado);
            $oOrden->setUsuarioAsignador($fila->usuarioAsignador);
            $oOrden->setFechaAsignacion($fila->fechaAsignacion);
            $oOrden->setFormaFinalizacion($fila->formaFinalizacion);
            $oOrden->setFechaFinalizacion($fila->fechaFinalizacion);
            $oOrden->setHoraFinalizacion($fila->horaFinalizacion);
            $oOrden->setObservacion($fila->observacion);
            $oOrden->setCierre($fila->cierre);
            $oOrden->setUsuarioCierre($fila->usuarioCierre);
            $oOrden->setFechaCierre($fila->fechaCierre);  
            $oOrden->setNroEquipo($fila->nroEquipo);
            $oOrden->setEquipo($fila->idEquipo);
            $oOrden->setAgente($fila->dni);
            $aOrden[] = $oOrden;
            unset ($oOrden);
         }        
         return $aOrden;
      } else {
         return false;
      }
   }
   
   /**
    * Busca todos lo datos de la tabla orden que se encuentra en la base de datos
    * segun el criterio de busqueda y el orden enviados por parametro
    * @param OrdenValueObject $oValueObject
    * @return OrdenValueObject|boolean     
    */   
   public function findAllPorCriterioyEstado($criterio, $orden, $oValueObject) {
      $sql = "SELECT `nro`, DATE_FORMAT(DATE(`fechaInicio`),'%d-%m-%Y') AS fechaInicio, TIME(`fechaInicio`) AS horaInicio,";
      $sql.= " `usuarioAlta`, `idProblema`, `descripcion`, `prioridad`, `ofcodi`, `tipoRecepcion`, `estado`, `usuarioAsignado`,";
      $sql.= " `usuarioAsignador`, DATE_FORMAT(DATE(`fechaAsignacion`),'%d-%m-%Y') AS fechaAsignacion, TIME(`fechaAsignacion`) AS horaAsignacion, ";
      $sql.= " `formaFinalizacion`,  DATE_FORMAT(DATE(`fechaFinalizacion`),'%d-%m-%Y') AS fechaFinalizacion, TIME(`fechaFinalizacion`) AS horaFinalizacion, `observacion`, `cierre`, `usuarioCierre`, `fechaCierre`";
      $sql.= " FROM orden WHERE nro<>'' ";        
      if($oValueObject->getNro()){
          $sql.= " AND nro = ". $oValueObject->getNro();
      } else {
      if($oValueObject->getFechaInicio())
          $sql.= " AND DATE_FORMAT(DATE(`fechaInicio`),'%Y')='".$oValueObject->getFechaInicio()."'";
      if($oValueObject->getFechaCierre())
          $sql.= " AND DATE_FORMAT(DATE(`fechaInicio`),'%m')='".$oValueObject->getFechaCierre()."'";
      }
      if ($criterio<>'')
          $sql .= sprintf(" order by %s %s","orden.".$criterio, $orden);
      else
          $sql .= " order by nro ";         
      $resultado = mysql_query($sql);
      if($resultado){
         $aOrden = array();
         while ($fila = mysql_fetch_object($resultado)) {
            $oOrden = new OrdenValueObject();
            $oOrden->setNro($fila->nro);
            $oOrden->setFechaInicio($fila->fechaInicio);
            $oOrden->setHoraInicio($fila->horaInicio);
            $oOrden->setUsuarioAlta($fila->usuarioAlta);
            $oOrden->setIdProblema($fila->idProblema);
            $oOrden->setDescripcion($fila->descripcion);
            $oOrden->setPrioridad($fila->prioridad);
            $oOrden->setOfcodi($fila->ofcodi);
            $oOrden->setTipoRecepcion($fila->tipoRecepcion);
            $oOrden->setEstado($fila->estado);
            $oOrden->setUsuarioAsignado($fila->usuarioAsignado);
            $oOrden->setUsuarioAsignador($fila->usuarioAsignador);
            $oOrden->setFechaAsignacion($fila->fechaAsignacion);
            $oOrden->setHoraAsignacion($fila->horaAsignacion);
            $oOrden->setFormaFinalizacion($fila->formaFinalizacion);
            $oOrden->setFechaFinalizacion($fila->fechaFinalizacion);
            $oOrden->setHoraFinalizacion($fila->horaFinalizacion);
            $oOrden->setObservacion($fila->observacion);
            $oOrden->setCierre($fila->cierre);
            $oOrden->setUsuarioCierre($fila->usuarioCierre);
            $oOrden->setFechaCierre($fila->fechaCierre);                
            $aOrden[] = $oOrden;
            unset ($oOrden);
         }        
         return $aOrden;
      } else {
         return false;
      }
   }
   
   /**
    * Busca todos lo datos de la tabla orden que se encuentra en la base de datos
    * segun el criterio de busqueda y el orden enviados por parametro
    * @param OrdenValueObject $oValueObject
    * @return OrdenValueObject|boolean     
    */   
   public function findAllPorCriterioyEstadoyUsuario($criterio, $orden, $oValueObject) {
      $sql = "SELECT `nro`, DATE_FORMAT(DATE(`fechaInicio`),'%d-%m-%Y') AS fechaInicio1, TIME(`fechaInicio`) AS horaInicio,";
      $sql.= " `usuarioAlta`, `idProblema`, `descripcion`, `prioridad`, `ofcodi`, `tipoRecepcion`, `estado`, `usuarioAsignado`,";
      $sql.= " `usuarioAsignador`, DATE_FORMAT(DATE(`fechaAsignacion`),'%d-%m-%Y') AS fechaAsignacion, TIME(`fechaAsignacion`) AS horaAsignacion, `formaFinalizacion`,  DATE_FORMAT(DATE(`fechaFinalizacion`),'%d-%m-%Y') AS fechaFinalizacion, TIME(`fechaFinalizacion`) AS horaFinalizacion, `observacion`, `cierre`, `usuarioCierre`, `fechaCierre`";
      $sql.= " FROM orden ";    
      if($oValueObject->getUsuarioAsignado())
            $sql.= " INNER JOIN asignados ON asignados.`nroOrden`=orden.`nro` AND asignados.`idUsuario`= " . $oValueObject->getUsuarioAsignado()." AND asignados.`fechaBaja` = '0000-00-00 00:00:00'";
      if($oValueObject->getFechaAsignacion()<>'99/99/9999')
      $sql.=" WHERE DATE_FORMAT(DATE(`fechaAsignacion`),'%d/%m/%Y') = '". $oValueObject->getFechaAsignacion()."'";
      if ($criterio<>'')
          $sql .= sprintf(" order by %s %s",$criterio, $orden);
      else
          $sql .= " order by nro";                       
      $resultado = mysql_query($sql);
      if($resultado){
         $aOrden = array();
         while ($fila = mysql_fetch_object($resultado)) {
            $oOrden = new OrdenValueObject();
            $oOrden->setNro($fila->nro);
            $oOrden->setFechaInicio($fila->fechaInicio1);
            $oOrden->setHoraInicio($fila->horaInicio);
            $oOrden->setUsuarioAlta($fila->usuarioAlta);
            $oOrden->setIdProblema($fila->idProblema);
            $oOrden->setDescripcion($fila->descripcion);
            $oOrden->setPrioridad($fila->prioridad);
            $oOrden->setOfcodi($fila->ofcodi);
            $oOrden->setTipoRecepcion($fila->tipoRecepcion);
            $oOrden->setEstado($fila->estado);
            $oOrden->setUsuarioAsignado($fila->usuarioAsignado);
            $oOrden->setUsuarioAsignador($fila->usuarioAsignador);
            $oOrden->setFechaAsignacion($fila->fechaAsignacion);
            $oOrden->setHoraAsignacion($fila->horaAsignacion);
            $oOrden->setFormaFinalizacion($fila->formaFinalizacion);
            $oOrden->setFechaFinalizacion($fila->fechaFinalizacion);
            $oOrden->setHoraFinalizacion($fila->horaFinalizacion);
            $oOrden->setObservacion($fila->observacion);
            $oOrden->setCierre($fila->cierre);
            $oOrden->setUsuarioCierre($fila->usuarioCierre);
            $oOrden->setFechaCierre($fila->fechaCierre);                
            $aOrden[] = $oOrden;
            unset ($oOrden);
         }        
         return $aOrden;
      } else {
         return false;
      }
   }
   
      /**
    * @param OrdenValueObject $oValueObject
    * @return OrdenValueObject|boolean 
    */
   public function findEquipo($oValueObject,$inicio, $tamano) {
      $sql = "SELECT `nro`,idEquipo, nroEquipo, dni, DATE_FORMAT(DATE(`fechaInicio`),'%d-%m-%Y') AS fechaInicio1, TIME(`fechaInicio`) AS horaInicio,";
      $sql.= " `usuarioAlta`, `idProblema`, `descripcion`, `prioridad`, `ofcodi`, `tipoRecepcion`, `estado`, `usuarioAsignado`,";
      $sql.= " `usuarioAsignador`,  DATE_FORMAT(DATE(`fechaAsignacion`),'%d-%m-%Y') AS fechaAsignacion, TIME(`fechaAsignacion`) AS horaAsignacion, `formaFinalizacion`,  DATE_FORMAT(DATE(`fechaFinalizacion`),'%d-%m-%Y') AS fechaFinalizacion, TIME(`fechaFinalizacion`) AS horaFinalizacion, `observacion`, `cierre`, `usuarioCierre`, DATE_FORMAT(DATE(`fechaCierre`),'%d-%m-%Y') AS fechaCierre, TIME(`fechaCierre`) AS horaCierre";
      $sql.= " FROM orden WHERE ";
      $sql.= " idEquipo=".$oValueObject->getEquipo()." ORDER BY fechaInicio DESC ";
      if($tamano<>0)
        $sql.=" LIMIT ".$inicio.", ".$tamano;      
      $resultado = mysql_query($sql);
      if($resultado){
         $aOrden = array();
         while ($fila = mysql_fetch_object($resultado)) {             
            $oOrden = new OrdenValueObject();
            $oOrden->setNro($fila->nro);
            $oOrden->setFechaInicio($fila->fechaInicio1);
            $oOrden->setHoraInicio($fila->horaInicio);
            $oOrden->setUsuarioAlta($fila->usuarioAlta);
            $oOrden->setIdProblema($fila->idProblema);
            $oOrden->setDescripcion($fila->descripcion);
            $oOrden->setPrioridad($fila->prioridad);
            $oOrden->setOfcodi($fila->ofcodi);
            $oOrden->setTipoRecepcion($fila->tipoRecepcion);
            $oOrden->setEstado($fila->estado);
            $oOrden->setUsuarioAsignado($fila->usuarioAsignado);
            $oOrden->setUsuarioAsignador($fila->usuarioAsignador);
            $oOrden->setFechaAsignacion($fila->fechaAsignacion);
            $oOrden->setHoraAsignacion($fila->horaAsignacion);
            $oOrden->setFormaFinalizacion($fila->formaFinalizacion);
            $oOrden->setFechaFinalizacion($fila->fechaFinalizacion);
            $oOrden->setHoraFinalizacion($fila->horaFinalizacion);
            $oOrden->setObservacion($fila->observacion);
            $oOrden->setCierre($fila->cierre);
            $oOrden->setUsuarioCierre($fila->usuarioCierre);
            $oOrden->setFechaCierre($fila->fechaCierre);                
            $oOrden->setHoraCierre($fila->horaCierre);     
            $oOrden->setNroEquipo($fila->nroEquipo);
            $oOrden->setEquipo($fila->idEquipo);
            $oOrden->setAgente($fila->dni);  
            $aOrden[] = $oOrden;
            unset ($oOrden);
         }        
         return $aOrden;
      } else {
         return false;
      }
   }
   
   /**
    *
    * @param OrdenValueObject $oValueObject
    * @return boolean 
    */
   public function insert($oValueObject) {
      $sql = "INSERT INTO orden (usuarioAlta, idProblema, descripcion, prioridad, ofcodi, tipoRecepcion, estado, usuarioAsignado, idEquipo, nroEquipo, dni) VALUES(";
      $sql .= $oValueObject->getUsuarioAlta() . ", " . $oValueObject->getIdProblema() . ", '";
      $sql .= $oValueObject->getDescripcion() . "', " . $oValueObject->getPrioridad() . ", " . $oValueObject->getOfcodi() . ", ";
      $sql .= $oValueObject->getTipoRecepcion() . ", " . $oValueObject->getEstado() . ", 0," ;
      $sql .= $oValueObject->getEquipo() . ", " . $oValueObject->getNroEquipo() . ", " . $oValueObject->getAgente() ;
      $sql .=");";       
      if(mysql_query($sql)){
        $result = mysql_query("SELECT DISTINCT LAST_INSERT_ID() FROM orden");
            $id = mysql_fetch_array($result);            
            if($id[0]<>0) {
                $oValueObject->setNro($id[0]);                
                return true;
            } else { return false; }
      } else {         
         return false;
      }
   }
   
   /**
    *
    * @param OrdenValueObject $oValueObject
    * @return boolean 
    */
   public function edit($oValueObject) {
      $sql = "UPDATE orden SET usuarioAlta = ".$oValueObject->getUsuarioAlta().", ";
      $sql .= " idProblema = ".$oValueObject->getIdProblema() . ", ";
      $sql .= " descripcion = '".$oValueObject->getDescripcion()."', ";
      $sql .= " prioridad = ".$oValueObject->getPrioridad().", ";
      $sql .= " ofcodi = " . $oValueObject->getOfcodi() . ", ";
      $sql .= " tipoRecepcion = ".$oValueObject->getTipoRecepcion() . ", ";
	  if($oValueObject->getEstado())
      $sql .= " estado = ".$oValueObject->getEstado().", ";	  
      $sql .= " idEquipo = ".$oValueObject->getEquipo().", ";	  
      $sql .= " nroEquipo = ".$oValueObject->getNroEquipo().", ";	  
      $sql .= " dni = ".$oValueObject->getAgente();	  
      $sql .= " WHERE nro = ". $oValueObject->getNro();    
      if(mysql_query($sql)){        
         return true;        
      } else {         
         return false;
      }
   }
   
   /**
    *
    * @param OrdenValueObject $oValueObject
    * @return boolean 
    */
   public function update($oValueObject) {
      mysql_query("Begin");
      $sql = " select * from orden where nro=".$oValueObject->getNro()." and usuarioAsignado =0";
      $result=mysql_query($sql);
      if($result) {
          if(mysql_num_rows($result)==0) {
                $sql = "UPDATE orden SET usuarioAsignado = '".$oValueObject->getUsuarioAsignado()."', usuarioAsignador = " . $oValueObject->getUsuarioAsignador(). ", fechaAsignacion = now()";
                $sql .= " WHERE dni = ".$oValueObject->getNro().";";                      
                if(mysql_query($sql)){
                    mysql_query("Commit");
                    return true;
                } else {
                    mysql_query("Rollback");
                    return false;
                }
          } else {
              mysql_query("Rollback");
              return false;
          }
      } else {
              mysql_query("Rollback");
              return false;
      }
   }

    /**
    *
    * @param OrdenValueObject $oValueObject
    * @return boolean 
    */
   public function updateAsignado($oValueObject) {
      mysql_query("Begin");
      $sql =" select * from orden where nro=".$oValueObject->getNro()." and usuarioAsignado = 0";      
      $result=mysql_query($sql);      
      if($result) {          
          if(mysql_num_rows($result)<>0) {
                $sql1 = "UPDATE orden SET estado =".$oValueObject->getEstado().", usuarioAsignado = 1, usuarioAsignador = " . $oValueObject->getUsuarioAsignador(). ", fechaAsignacion = now()";
                $sql1 .= " WHERE nro = ".$oValueObject->getNro().";";                        
                if(mysql_query($sql1)){
                    mysql_query("Commit");
                    return true;
                } else {
                    mysql_query("Rollback");
                    return false;
                }
          } else {
              mysql_query("Rollback");
              return false;
          }
      } else {
              mysql_query("Rollback");
              return false;
      }
   }
   
   /**
    *
    * @param OrdenValueObject $oValueObject
    * @return boolean 
    */
   public function updateYaAsignado($oValueObject) {
      mysql_query("Begin");     
     $sql1 = "UPDATE orden SET estado =".$oValueObject->getEstado().", usuarioAsignado = 1, usuarioAsignador = " . $oValueObject->getUsuarioAsignador(). ", fechaAsignacion = now()";
     $sql1 .= " WHERE nro = ".$oValueObject->getNro().";";                        
     if(mysql_query($sql1)){
        mysql_query("Commit");
        return true;
     } else {
        mysql_query("Rollback");
        return false;
     }
   }
   
      /**
    *
    * @param OrdenValueObject $oValueObject
    * @return boolean 
    */
   public function updateSinAsignar($oValueObject) {
      mysql_query("Begin");     
     $sql1 = "UPDATE orden SET estado =".$oValueObject->getEstado().", usuarioAsignado = 0, usuarioAsignador = '(NULL)', fechaAsignacion = '0000-00-00 00:00:00'";
     $sql1 .= " WHERE nro = ".$oValueObject->getNro().";";                        
     if(mysql_query($sql1)){
        mysql_query("Commit");
        return true;
     } else {
        mysql_query("Rollback");
        return false;
     }
   }
       /**
    *
    * @param OrdenValueObject $oValueObject
    * @return boolean 
    */
   public function updateEstado($oValueObject) {
        $sql1 = "UPDATE orden SET estado =".$oValueObject->getEstado().", formaFinalizacion = ".$oValueObject->getFormaFinalizacion().", ";
        if(!$oValueObject->getFechaFinalizacion())
        $sql1.= "fechaFinalizacion = now(), ";
        $sql1.=" observacion= '".$oValueObject->getObservacion()."', usuarioFinalizacion = ".$oValueObject->getUsuarioFinalizacion();
        $sql1.= " WHERE nro = ".$oValueObject->getNro().";";                      
        if(mysql_query($sql1)){         
            return true;
        } else {       
            return false;
        }   
   }  
   
          /**
    *
    * @param OrdenValueObject $oValueObject
    * @return boolean 
    */
   public function updateObservacion($oValueObject) {
        $sql1 = "UPDATE orden SET ";
        $sql1.=" observacion= '".$oValueObject->getObservacion()."', usuarioFinalizacion = ".$oValueObject->getUsuarioFinalizacion();
        $sql1.= " WHERE nro = ".$oValueObject->getNro().";";                      
        if(mysql_query($sql1)){         
            return true;
        } else {       
            return false;
        }   
   }  
   
    /**
    *
    * @param OrdenValueObject $oValueObject
    * @return boolean 
    */
   public function updateDescripcion($oValueObject) {
        $sql1 = "UPDATE orden SET ";
        $sql1.= " descripcion= '".$oValueObject->getDescripcion()."', usuarioAlta=".$oValueObject->getUsuarioAlta()." ";
        $sql1.= " WHERE nro = ".$oValueObject->getNro().";";                 
        if(mysql_query($sql1)){         
            return true;
        } else {       
            return false;
        }   
   }  
   
   
   /**
    *
    * @param OrdenValueObject $oValueObject
    * @return boolean 
    */
   public function updateCierre($oValueObject) {
        $sql1 = "UPDATE orden SET ";
        if($oValueObject->getEstado())
            $sql1.=" estado = ".$oValueObject->getEstado().",";        
        if(($oValueObject->getUsuarioAsignado()==0)||($oValueObject->getUsuarioAsignado()==1))
            $sql1.=" usuarioAsignado = ".$oValueObject->getUsuarioAsignado().", ";
        $sql1.= " cierre =".$oValueObject->getCierre().", usuarioCierre = ".$oValueObject->getUsuarioCierre()." ";
        if($oValueObject->getFechaCierre()==1)
            $sql1.= ", fechaCierre = now()";
        $sql1 .= " WHERE nro = ".$oValueObject->getNro().";";                
        if(mysql_query($sql1)){         
            return true;
        } else {       
            return false;
        }   
   }   
   
}

?>
