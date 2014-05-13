<?php
require_once '../Clases/ValueObject/HistorialValueObject.php';

/**
 * Description of MysqlHistorialActiveRecord
 *
 */
class MysqlHistorialActiveRecord{
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
    * @param HistorialValueObject $oValueObject
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
    * @param HistorialValueObject $oValueObject
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
    * @param HistorialValueObject $oValueObject
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
    * @param HistorialValueObject $oValueObject
    * @return HistorialValueObject|boolean 
    */
   public function find($oValueObject) {
      $sql = "SELECT `nro`, DATE_FORMAT(DATE(`fechaInicio`),'%d-%m-%Y') AS fechaInicio, TIME(`fechaInicio`) AS horaInicio,";
      $sql.= " `usuarioAlta`, `idProblema`, `descripcion`, `prioridad`, `ofcodi`, `tipoRecepcion`, `estado`, `usuarioAsignado`,";
      $sql.= " `usuarioAsignador`, DATE_FORMAT(DATE(`fechaAsignacion`),'%d-%m-%Y') AS fechaAsignacion, TIME(`fechaAsignacion`) AS horaAsignacion, ";
      $sql.= " `formaFinalizacion`,  DATE_FORMAT(DATE(`fechaFinalizacion`),'%d-%m-%Y') AS fechaFinalizacion, TIME(`fechaFinalizacion`) AS horaFinalizacion, `observacion`, `cierre`, `usuarioCierre`, `fechaCierre`";
      $sql.= " FROM historial WHERE nro<>'' ";        
      if($oValueObject->getNro()){
          $sql.= " AND nro = ". $oValueObject->getNro();
      } else {
      if($oValueObject->getFechaInicio())
          $sql.= " AND DATE_FORMAT(DATE(`fechaInicio`),'%Y')='".$oValueObject->getFechaInicio()."'";
      if($oValueObject->getFechaCierre())
          $sql.= " AND DATE_FORMAT(DATE(`fechaInicio`),'%m')='".$oValueObject->getFechaCierre()."'";
      }
      $sql .= " order by fechaInicio desc";         
      $resultado = mysql_query($sql);
      if($resultado){
         $aHistorial = array();
         while ($fila = mysql_fetch_object($resultado)) {
            $oHistorial = new HistorialValueObject();
            $oHistorial->setNro($fila->nro);
            $oHistorial->setFechaInicio($fila->fechaInicio);
            $oHistorial->setHoraInicio($fila->horaInicio);
            $oHistorial->setUsuarioAlta($fila->usuarioAlta);
            $oHistorial->setIdProblema($fila->idProblema);
            $oHistorial->setDescripcion($fila->descripcion);
            $oHistorial->setPrioridad($fila->prioridad);
            $oHistorial->setOfcodi($fila->ofcodi);
            $oHistorial->setTipoRecepcion($fila->tipoRecepcion);
            $oHistorial->setEstado($fila->estado);
            $oHistorial->setUsuarioAsignado($fila->usuarioAsignado);
            $oHistorial->setUsuarioAsignador($fila->usuarioAsignador);
            $oHistorial->setFechaAsignacion($fila->fechaAsignacion);
            $oHistorial->setHoraAsignacion($fila->horaAsignacion);
            $oHistorial->setFormaFinalizacion($fila->formaFinalizacion);
            $oHistorial->setFechaFinalizacion($fila->fechaFinalizacion);
            $oHistorial->setHoraFinalizacion($fila->horaFinalizacion);
            $oHistorial->setObservacion($fila->observacion);
            $oHistorial->setCierre($fila->cierre);
            $oHistorial->setUsuarioCierre($fila->usuarioCierre);
            $oHistorial->setFechaCierre($fila->fechaCierre);                
            $aHistorial[] = $oHistorial;
            unset ($oHistorial);
         }        
         return $aHistorial;
      } else {
         return false;
      }
   }
   
      /**
    *
    * @param HistorialValueObject $oValueObject
    * @return HistorialValueObject|boolean 
    */
   public function findHistorial($oValueObject) {
//      if($oValueObject->getDni()<>0) {
//      $sql = "SELECT * FROM Historial WHERE anio = ". $oValueObject->getAnio() ." and dni=".$oValueObject->getDni().";";      
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
    * @param HistorialValueObject $oValueObject
    * @return HistorialValueObject|boolean 
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
         $aHistorial = array();
         while ($fila = mysql_fetch_object($resultado)) {
            $oHistorial = new HistorialValueObject();
            $oHistorial->setNro($fila->nro);
            $oHistorial->setFechaInicio($fila->fechaInicio);
            $oHistorial->setHoraInicio($fila->horaInicio);
            $oHistorial->setUsuarioAlta($fila->usuarioAlta);
            $oHistorial->setIdProblema($fila->idProblema);
            $oHistorial->setDescripcion($fila->descripcion);
            $oHistorial->setPrioridad($fila->prioridad);
            $oHistorial->setOfcodi($fila->ofcodi);
            $oHistorial->setTipoRecepcion($fila->tipoRecepcion);
            $oHistorial->setEstado($fila->estado);
            $oHistorial->setUsuarioAsignado($fila->usuarioAsignado);
            $oHistorial->setUsuarioAsignador($fila->usuarioAsignador);
            $oHistorial->setFechaAsignacion($fila->fechaAsignacion);
            $oHistorial->setHoraAsignacion($fila->horaAsignacion);
            $oHistorial->setFormaFinalizacion($fila->formaFinalizacion);
            $oHistorial->setFechaFinalizacion($fila->fechaFinalizacion);
            $oHistorial->setHoraFinalizacion($fila->horaFinalizacion);
            $oHistorial->setObservacion($fila->observacion);
            $oHistorial->setCierre($fila->cierre);
            $oHistorial->setUsuarioCierre($fila->usuarioCierre);
            $oHistorial->setFechaCierre($fila->fechaCierre);                
            $oHistorial->setHoraCierre($fila->horaCierre);     
            $oHistorial->setNroEquipo($fila->nroEquipo);
            $oHistorial->setEquipo($fila->idEquipo);
            $oHistorial->setAgente($fila->dni);  
            $aHistorial[] = $oHistorial;
            unset ($oHistorial);
         }        
         return $aHistorial;
      } else {
         return false;
      }
   }

      /**
    * @param HistorialValueObject $oValueObject
    * @return HistorialValueObject|boolean 
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
         $aHistorial = array();
         while ($fila = mysql_fetch_object($resultado)) {
            $oHistorial = new HistorialValueObject();
            $oHistorial->setNro($fila->nro);
            $oHistorial->setFechaInicio($fila->fechaInicio1);
            $oHistorial->setHoraInicio($fila->horaInicio1);
            $oHistorial->setUsuarioAlta($fila->usuarioAlta);
            $oHistorial->setIdProblema($fila->idProblema);
            $oHistorial->setDescripcion($fila->descripcion);
            $oHistorial->setPrioridad($fila->prioridad);
            $oHistorial->setOfcodi($fila->ofcodi);
            $oHistorial->setTipoRecepcion($fila->tipoRecepcion);
            $oHistorial->setEstado($fila->estado);
            $oHistorial->setUsuarioAsignado($fila->usuarioAsignado);
            $oHistorial->setUsuarioAsignador($fila->usuarioAsignador);
            $oHistorial->setFechaAsignacion($fila->fechaAsignacion1);
            $oHistorial->setHoraAsignacion($fila->horaAsignacion1);
            $oHistorial->setFormaFinalizacion($fila->formaFinalizacion);
            $oHistorial->setFechaFinalizacion($fila->fechaFinalizacion1);
            $oHistorial->setHoraFinalizacion($fila->horaFinalizacion1);
            $oHistorial->setObservacion($fila->observacion);
            $oHistorial->setCierre($fila->cierre);
            $oHistorial->setUsuarioCierre($fila->usuarioCierre);
            $oHistorial->setFechaCierre($fila->fechaCierre);                
            $oHistorial->setHoraCierre($fila->horaCierre);                
            $aHistorial[] = $oHistorial;
            unset ($oHistorial);
         }        
         return $aHistorial;
      } else {
         return false;
      }
   }

   
   /**
    * Busca todos lo datos de la tabla orden que se encuentra en la base de datos
    * segun el criterio de busqueda y el orden enviados por parametro
    * @param HistorialValueObject $oValueObject
    * @return HistorialValueObject|boolean     
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
            $sql.=" AND (`fechaInicio` between '".$fechaIni[2]."-".$fechaIni[1]."-".$fechaIni[0]."' AND '".$fechaFin[2]."-".$fechaFin[1]."-".$fechaFin[0]."') ";          
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
            $sql.=" AND (`fechaFinalizacion` between '".$fechaIni[2]."-".$fechaIni[1]."-".$fechaIni[0]."' AND '".$fechaFin[2]."-".$fechaFin[1]."-".$fechaFin[0]."') ";          
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
         $aHistorial = array();
         while ($fila = mysql_fetch_object($resultado)) {
            $oHistorial = new HistorialValueObject();
            $oHistorial->setNro($fila->nro);
            $oHistorial->setFechaInicio($fila->fechaInicio1);
            $oHistorial->setHoraInicio($fila->horaInicio);
            $oHistorial->setUsuarioAlta($fila->usuarioAlta);
            $oHistorial->setIdProblema($fila->idProblema);
            $oHistorial->setDescripcion($fila->descripcion);
            $oHistorial->setPrioridad($fila->prioridad);
            $oHistorial->setOfcodi($fila->ofcodi);
            $oHistorial->setTipoRecepcion($fila->tipoRecepcion);
            $oHistorial->setEstado($fila->estado);
            $oHistorial->setUsuarioAsignado($fila->usuarioAsignado);
            $oHistorial->setUsuarioAsignador($fila->usuarioAsignador);
            $oHistorial->setFechaAsignacion($fila->fechaAsignacion1);
            $oHistorial->setHoraAsignacion($fila->horaAsignacion);
            $oHistorial->setFormaFinalizacion($fila->formaFinalizacion);
            $oHistorial->setFechaFinalizacion($fila->fechaFinalizacion1);
            $oHistorial->setHoraFinalizacion($fila->horaFinalizacion);
            $oHistorial->setObservacion($fila->observacion);
            $oHistorial->setCierre($fila->cierre);
            $oHistorial->setUsuarioCierre($fila->usuarioCierre);
            $oHistorial->setFechaCierre($fila->fechaCierre);    
            $oHistorial->setNroEquipo($fila->nroEquipo);
            $oHistorial->setEquipo($fila->idEquipo);
            $oHistorial->setAgente($fila->dni);                
            $aHistorial[] = $oHistorial;
            unset ($oHistorial);
         }        
         return $aHistorial;
      } else {
         return false;
      }
   }
   
   /**
    * Busca todos lo datos de la tabla orden que se encuentra en la base de datos
    * segun el criterio de busqueda y el orden enviados por parametro
    * @param HistorialValueObject $oValueObject
    * @return HistorialValueObject|boolean     
    */   
   public function findAllPorCriterio($criterio, $orden, $oValueObject, $estado) {
      $sql = "SELECT `nro`, DATE_FORMAT(DATE(`fechaInicio`),'%d-%m-%Y') AS fechaInicio1, TIME(`fechaInicio`) AS horaInicio,";
      $sql.= " `usuarioAlta`, `idProblema`, `descripcion`, `prioridad`, `ofcodi`, `tipoRecepcion`, `estado`, `usuarioAsignado`,";
      $sql.= " `usuarioAsignador`, `fechaAsignacion`, `formaFinalizacion`,  DATE_FORMAT(DATE(`fechaFinalizacion`),'%d-%m-%Y') AS fechaFinalizacion, TIME(`fechaFinalizacion`) AS horaFinalizacion, `observacion`, `cierre`, `usuarioCierre`, `fechaCierre`, `idEquipo`,`nroEquipo`,`dni` ";
      $sql.= " FROM orden WHERE ";
      if($oValueObject->getUsuarioAsignado()) {
         $sql.=" ofcodi NOT IN (SELECT ofcodi FROM bloqueo WHERE idUsuario=".$oValueObject->getUsuarioAsignado()." AND fechaBaja='0000-00-00 00:00:00') AND ";
         $sql.= " (nro IN (SELECT nroHistorial FROM asignados WHERE idUsuario=".$oValueObject->getUsuarioAsignado()." and fechaBaja='0000-00-00 00:00:00') OR usuarioAsignado = 0) AND ";
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
         $aHistorial = array();
         while ($fila = mysql_fetch_object($resultado)) {
            $oHistorial = new HistorialValueObject();
            $oHistorial->setNro($fila->nro);
            $oHistorial->setFechaInicio($fila->fechaInicio1);
            $oHistorial->setHoraInicio($fila->horaInicio);
            $oHistorial->setUsuarioAlta($fila->usuarioAlta);
            $oHistorial->setIdProblema($fila->idProblema);
            $oHistorial->setDescripcion($fila->descripcion);
            $oHistorial->setPrioridad($fila->prioridad);
            $oHistorial->setOfcodi($fila->ofcodi);
            $oHistorial->setTipoRecepcion($fila->tipoRecepcion);
            $oHistorial->setEstado($fila->estado);
            $oHistorial->setUsuarioAsignado($fila->usuarioAsignado);
            $oHistorial->setUsuarioAsignador($fila->usuarioAsignador);
            $oHistorial->setFechaAsignacion($fila->fechaAsignacion);
            $oHistorial->setFormaFinalizacion($fila->formaFinalizacion);
            $oHistorial->setFechaFinalizacion($fila->fechaFinalizacion);
            $oHistorial->setHoraFinalizacion($fila->horaFinalizacion);
            $oHistorial->setObservacion($fila->observacion);
            $oHistorial->setCierre($fila->cierre);
            $oHistorial->setUsuarioCierre($fila->usuarioCierre);
            $oHistorial->setFechaCierre($fila->fechaCierre);  
            $oHistorial->setNroEquipo($fila->nroEquipo);
            $oHistorial->setEquipo($fila->idEquipo);
            $oHistorial->setAgente($fila->dni);
            $aHistorial[] = $oHistorial;
            unset ($oHistorial);
         }        
         return $aHistorial;
      } else {
         return false;
      }
   }
   
   /**
    * Busca todos lo datos de la tabla orden que se encuentra en la base de datos
    * segun el criterio de busqueda y el orden enviados por parametro
    * @param HistorialValueObject $oValueObject
    * @return HistorialValueObject|boolean     
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
         $aHistorial = array();
         while ($fila = mysql_fetch_object($resultado)) {
            $oHistorial = new HistorialValueObject();
            $oHistorial->setNro($fila->nro);
            $oHistorial->setFechaInicio($fila->fechaInicio);
            $oHistorial->setHoraInicio($fila->horaInicio);
            $oHistorial->setUsuarioAlta($fila->usuarioAlta);
            $oHistorial->setIdProblema($fila->idProblema);
            $oHistorial->setDescripcion($fila->descripcion);
            $oHistorial->setPrioridad($fila->prioridad);
            $oHistorial->setOfcodi($fila->ofcodi);
            $oHistorial->setTipoRecepcion($fila->tipoRecepcion);
            $oHistorial->setEstado($fila->estado);
            $oHistorial->setUsuarioAsignado($fila->usuarioAsignado);
            $oHistorial->setUsuarioAsignador($fila->usuarioAsignador);
            $oHistorial->setFechaAsignacion($fila->fechaAsignacion);
            $oHistorial->setHoraAsignacion($fila->horaAsignacion);
            $oHistorial->setFormaFinalizacion($fila->formaFinalizacion);
            $oHistorial->setFechaFinalizacion($fila->fechaFinalizacion);
            $oHistorial->setHoraFinalizacion($fila->horaFinalizacion);
            $oHistorial->setObservacion($fila->observacion);
            $oHistorial->setCierre($fila->cierre);
            $oHistorial->setUsuarioCierre($fila->usuarioCierre);
            $oHistorial->setFechaCierre($fila->fechaCierre);                
            $aHistorial[] = $oHistorial;
            unset ($oHistorial);
         }        
         return $aHistorial;
      } else {
         return false;
      }
   }
   
   /**
    * Busca todos lo datos de la tabla orden que se encuentra en la base de datos
    * segun el criterio de busqueda y el orden enviados por parametro
    * @param HistorialValueObject $oValueObject
    * @return HistorialValueObject|boolean     
    */   
   public function findAllPorCriterioyEstadoyUsuario($criterio, $orden, $oValueObject) {
      $sql = "SELECT `nro`, DATE_FORMAT(DATE(`fechaInicio`),'%d-%m-%Y') AS fechaInicio1, TIME(`fechaInicio`) AS horaInicio,";
      $sql.= " `usuarioAlta`, `idProblema`, `descripcion`, `prioridad`, `ofcodi`, `tipoRecepcion`, `estado`, `usuarioAsignado`,";
      $sql.= " `usuarioAsignador`, DATE_FORMAT(DATE(`fechaAsignacion`),'%d-%m-%Y') AS fechaAsignacion, TIME(`fechaAsignacion`) AS horaAsignacion, `formaFinalizacion`,  DATE_FORMAT(DATE(`fechaFinalizacion`),'%d-%m-%Y') AS fechaFinalizacion, TIME(`fechaFinalizacion`) AS horaFinalizacion, `observacion`, `cierre`, `usuarioCierre`, `fechaCierre`";
      $sql.= " FROM orden ";    
      if($oValueObject->getUsuarioAsignado())
            $sql.= " INNER JOIN asignados ON asignados.`nroHistorial`=orden.`nro` AND asignados.`idUsuario`= " . $oValueObject->getUsuarioAsignado()." AND asignados.`fechaBaja` = '0000-00-00 00:00:00'";
      if($oValueObject->getFechaAsignacion()<>'99/99/9999')
      $sql.=" WHERE DATE_FORMAT(DATE(`fechaAsignacion`),'%d/%m/%Y') = '". $oValueObject->getFechaAsignacion()."'";
      if ($criterio<>'')
          $sql .= sprintf(" order by %s %s",$criterio, $orden);
      else
          $sql .= " order by nro";                       
      $resultado = mysql_query($sql);
      if($resultado){
         $aHistorial = array();
         while ($fila = mysql_fetch_object($resultado)) {
            $oHistorial = new HistorialValueObject();
            $oHistorial->setNro($fila->nro);
            $oHistorial->setFechaInicio($fila->fechaInicio1);
            $oHistorial->setHoraInicio($fila->horaInicio);
            $oHistorial->setUsuarioAlta($fila->usuarioAlta);
            $oHistorial->setIdProblema($fila->idProblema);
            $oHistorial->setDescripcion($fila->descripcion);
            $oHistorial->setPrioridad($fila->prioridad);
            $oHistorial->setOfcodi($fila->ofcodi);
            $oHistorial->setTipoRecepcion($fila->tipoRecepcion);
            $oHistorial->setEstado($fila->estado);
            $oHistorial->setUsuarioAsignado($fila->usuarioAsignado);
            $oHistorial->setUsuarioAsignador($fila->usuarioAsignador);
            $oHistorial->setFechaAsignacion($fila->fechaAsignacion);
            $oHistorial->setHoraAsignacion($fila->horaAsignacion);
            $oHistorial->setFormaFinalizacion($fila->formaFinalizacion);
            $oHistorial->setFechaFinalizacion($fila->fechaFinalizacion);
            $oHistorial->setHoraFinalizacion($fila->horaFinalizacion);
            $oHistorial->setObservacion($fila->observacion);
            $oHistorial->setCierre($fila->cierre);
            $oHistorial->setUsuarioCierre($fila->usuarioCierre);
            $oHistorial->setFechaCierre($fila->fechaCierre);                
            $aHistorial[] = $oHistorial;
            unset ($oHistorial);
         }        
         return $aHistorial;
      } else {
         return false;
      }
   }
   
      /**
    * @param HistorialValueObject $oValueObject
    * @return HistorialValueObject|boolean 
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
         $aHistorial = array();
         while ($fila = mysql_fetch_object($resultado)) {             
            $oHistorial = new HistorialValueObject();
            $oHistorial->setNro($fila->nro);
            $oHistorial->setFechaInicio($fila->fechaInicio1);
            $oHistorial->setHoraInicio($fila->horaInicio);
            $oHistorial->setUsuarioAlta($fila->usuarioAlta);
            $oHistorial->setIdProblema($fila->idProblema);
            $oHistorial->setDescripcion($fila->descripcion);
            $oHistorial->setPrioridad($fila->prioridad);
            $oHistorial->setOfcodi($fila->ofcodi);
            $oHistorial->setTipoRecepcion($fila->tipoRecepcion);
            $oHistorial->setEstado($fila->estado);
            $oHistorial->setUsuarioAsignado($fila->usuarioAsignado);
            $oHistorial->setUsuarioAsignador($fila->usuarioAsignador);
            $oHistorial->setFechaAsignacion($fila->fechaAsignacion);
            $oHistorial->setHoraAsignacion($fila->horaAsignacion);
            $oHistorial->setFormaFinalizacion($fila->formaFinalizacion);
            $oHistorial->setFechaFinalizacion($fila->fechaFinalizacion);
            $oHistorial->setHoraFinalizacion($fila->horaFinalizacion);
            $oHistorial->setObservacion($fila->observacion);
            $oHistorial->setCierre($fila->cierre);
            $oHistorial->setUsuarioCierre($fila->usuarioCierre);
            $oHistorial->setFechaCierre($fila->fechaCierre);                
            $oHistorial->setHoraCierre($fila->horaCierre);     
            $oHistorial->setNroEquipo($fila->nroEquipo);
            $oHistorial->setEquipo($fila->idEquipo);
            $oHistorial->setAgente($fila->dni);  
            $aHistorial[] = $oHistorial;
            unset ($oHistorial);
         }        
         return $aHistorial;
      } else {
         return false;
      }
   }
   
   /**
    *
    * @param HistorialValueObject $oValueObject
    * @return boolean 
    */
   public function insert($oValueObject) {
      $sql = "INSERT INTO historial (nro, fechaInicio, usuarioAlta, idProblema, descripcion, prioridad, ofcodi, tipoRecepcion, estado, usuarioAsignado, idEquipo, nroEquipo, dni) VALUES(";
      $sql .= $oValueObject->getNro() . ", now(), " .$oValueObject->getUsuarioAlta() . ", " . $oValueObject->getIdProblema() . ", '";
      $sql .= $oValueObject->getDescripcion() . "', " . $oValueObject->getPrioridad() . ", " . $oValueObject->getOfcodi() . ", ";
      $sql .= $oValueObject->getTipoRecepcion() . ", " . $oValueObject->getEstado() . ", " . $oValueObject->getUsuarioAsignado() . ",'" ;
      $sql .= $oValueObject->getEquipo() . "', '" . $oValueObject->getNroEquipo() . "', '" . $oValueObject->getAgente() ;
      $sql .="');";               
      if(mysql_query($sql)){    
         return true;            
      } else {         
         return false;
      }
   }
   
   /**
    *
    * @param HistorialValueObject $oValueObject
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
    * @param HistorialValueObject $oValueObject
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
    * @param HistorialValueObject $oValueObject
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
    * @param HistorialValueObject $oValueObject
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
    * @param HistorialValueObject $oValueObject
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
    * @param HistorialValueObject $oValueObject
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
    * @param HistorialValueObject $oValueObject
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
    * @param HistorialValueObject $oValueObject
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
