<?php
/**
 * Description of MysqlOrden
 *
 * @author ssrolanr
 */
require_once '../Clases/ValueObject/Orden.php';
require_once '../ClasesBasicas/ActiveRecordInterface.php';

class MysqlOrden implements ActiveRecord{
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
    * @param Orden $oValueObject
    * @return boolean 
    */
    public function delete($oValueObject) {
        $sql = "DELETE FROM orden WHERE idorden = " . $oValueObject->getIdorden();
        if (mysql_query($sql))
            return true;
        else
            return false;
    }
    /**
    *
    * @param Orden $oValueObject
    * @return boolean 
    */
    public function exists($oValueObject) {
        $sql = "SELECT COUNT(*) FROM orden WHERE idorden = " . $oValueObject->getIdorden() . ";";
        $resultado = mysql_query($sql);
        if($resultado){
            $resultado = mysql_fetch_row($resultado);
            if($resultado[0] > 0){
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
    * @param Orden $oValueObject
    * @return Orden|boolean 
    */
    public function find($oValueObject) {
        $sql = "SELECT idorden, DATE_FORMAT(DATE(`fecha`),'%d-%m-%Y') as fecha, ";
        $sql.= "ofcodi, solicitante, prioridad, formaPedido, idEquipo, estado, ";
        $sql.= "observacion, idUsers, fechaAsignacion, fechaFin, accesorios, idServicio, fechaRetiro, fechaConforme";
        $sql.= " FROM orden WHERE ";
        $sql.= " idorden = " . $oValueObject->getIdorden().";";
        $resultado = mysql_query($sql);
        if($resultado){
            $fila = mysql_fetch_object($resultado);
            $oValueObject->setIdorden($fila->idorden);
            $oValueObject->setFecha($fila->fecha);
            $oValueObject->setOfcodi($fila->ofcodi);
            $oValueObject->setSolicitante($fila->solicitante);
            $oValueObject->setPrioridad($fila->prioridad);
            $oValueObject->setFormaPedido($fila->formaPedido);
            $oValueObject->setIdEquipo($fila->idEquipo);
            $oValueObject->setestado($fila->estado);
            $oValueObject->setObservacion($fila->observacion);
            $oValueObject->setIdUsers($fila->idUsers);
            $oValueObject->setFechaAsignacion($fila->fechaAsignacion);
            $oValueObject->setFechaFin($fila->fechaFin);
            $oValueObject->setAccesorios($fila->accesorios);
            $oValueObject->setIdServicio($fila->idServicio);
            $oValueObject->setFechaRetiro($fila->fechaRetiro);
            $oValueObject->setFechaConforme($fila->fechaConforme);
            return $oValueObject;
        } else {
            return false;
        }
    }
    

    /**
     * @param Orden $oOrden
     * @return \Orden|boolean
     */
    public function findAll() {
        $sql = "SELECT idorden, DATE_FORMAT(DATE(`fecha`),'%d-%m-%Y') as fecha, ";
        $sql .= "ofcodi, solicitante, prioridad, formaPedido, idEquipo, estado, observacion, accesorios, fechaRetiro, fechaConforme";
        $sql .= " FROM orden";
        $resultado = mysql_query($sql);
        if($resultado){
            $aOrden = array();
            while ($fila = mysql_fetch_object($resultado)) {
                $oOrden = new OrdenValueObject();
                $fila = mysql_fetch_object($resultado);
                $oOrden->setIdorden($fila->idorden);
                $oOrden->setFecha($fila->fecha);
                $oOrden->setOfcodi($fila->ofcodi);
                $oOrden->setSolicitante($fila->solicitante);
                $oOrden->setPrioridad($fila->prioridad);
                $oOrden->setFormaPedido($fila->formaPedido);
                $oOrden->setIdEquipo($fila->idEquipo);
                $oOrden->setestado($fila->estado);
                $oOrden->setObservacion($fila->observacion);
                $oOrden->setAccesorios($fila->accesorios);
                $oOrden->setFechaRetiro($fila->fechaRetiro);
                $oOrden->setFechaConforme($fila->fechaConforme);
                $aOrden[] = $oOrden;
                unset($oOrden);
            }
            return $aOrden;
        } else {
            return false;
        }
    }

    /**
    *
    * @param Orden $oValueObject
    * @return boolean 
    */
    public function insert($oValueObject) {
        $sql = "INSERT INTO orden (fecha, ofcodi, solicitante, prioridad, formaPedido,
            idEquipo, estado, observacion, accesorios, idServicio)";
        $sql .= " VALUES ('" . $oValueObject->getFecha() . "', ";
        $sql .= $oValueObject->getOfcodi() . ", ";
        $sql .= "'".$oValueObject->getSolicitante() . "', ";
        $sql .= $oValueObject->getPrioridad() . ", ";
        $sql .= $oValueObject->getFormaPedido() . ", ";
        $sql .= $oValueObject->getIdEquipo() . ", ";
        $sql .= $oValueObject->getEstado() . ", ";
        $sql .= "'" . $oValueObject->getObservacion() . "', ";
        $sql .= "'" . $oValueObject->getAccesorios() . "', ";
        $sql .= $oValueObject->getIdServicio();
        $sql .= ")";
        if(mysql_query($sql)){
            $result = mysql_query("SELECT DISTINCT LAST_INSERT_ID() FROM orden");
            $id = mysql_fetch_array($result);
            if($id[0]<>0) {
                $oValueObject->setIdorden($id[0]);
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
     * @param Orden $oValueObject
     * @return boolean
     */
    public function update($oValueObject) {
        $sql = "UPDATE orden SET fechaFin = '" . $oValueObject->getFechaFin();
        $sql.= "', fechaRetiro = '" . $oValueObject->getFechaRetiro() . "'";
//        $sql.= ", fechaConforme = '" . $oValueObject->getFechaConforme() . "'";
        $sql.= " WHERE idOrden = " . $oValueObject->getIdorden();
        if(mysql_query($sql))
            return true;
        else
            return false;
    }
    
    /**
     * 
     * @param Orden $oValueObject
     * @return boolean 
     */
    public function asignar($oValueObject) {
        $sql = "UPDATE orden SET idUsers = " . $oValueObject->getIdUsers();
        $sql.= ", fechaAsignacion = '" . $oValueObject->getFechaAsignacion() . "'";
        $sql.= " WHERE idOrden = " . $oValueObject->getIdorden();
        if(mysql_query($sql))
            return true;
        else
            return false;
    }
    
    /**
    * Busca todos lo datos de la tabla orden que se encuentra en la base de datos
    * segun el criterio de busqueda y el orden enviados por parametro
    * @param Orden $oValueObject
    * @return Orden|boolean     
    */
    public function findAllPorCriterio($criterio, $orden, $oValueObject, $estado) {
        $sql = "SELECT idorden, DATE_FORMAT(DATE(`fecha`),'%d-%m-%Y') AS fecha, ofcodi, 
            solicitante, prioridad, formaPedido, idEquipo, estado, observacion, idUsers,
            idServicio, DATE_FORMAT(DATE(`fechaAsignacion`),'%d-%m-%Y') AS fechaAsignacion,
            DATE_FORMAT(DATE(`fechaFin`),'%d-%m-%Y') AS fechaFin, accesorios,
            DATE_FORMAT(DATE(`fechaRetiro`),'%d-%m-%Y') AS fechaRetiro,
            DATE_FORMAT(DATE(`fechaConforme`),'%d-%m-%Y') AS fechaConforme";
        $sql.= " FROM orden ";
        $sql .= " WHERE fechaFin = '0000-00-00' ";
        if ($criterio <> '')
            $sql .= sprintf(" order by %s %s",$criterio, $orden);
        else
            $sql .= " order by idorden";

        $resultado = mysql_query($sql);
        if($resultado){
            $aOrden = array();
         while ($fila = mysql_fetch_object($resultado)) {
            $oOrden = new Orden();
            $oOrden->setIdorden($fila->idorden);
            $oOrden->setFecha($fila->fecha);
            $oOrden->setOfcodi($fila->ofcodi);
            $oOrden->setSolicitante($fila->solicitante);
            $oOrden->setPrioridad($fila->prioridad);
            $oOrden->setFormaPedido($fila->formaPedido);
            $oOrden->setIdEquipo($fila->idEquipo);
            $oOrden->setEstado($fila->estado);
            $oOrden->setObservacion($fila->observacion);
            $oOrden->setIdUsers($fila->idUsers);
            $oOrden->setIdServicio($fila->idServicio);
            $oOrden->setFechaAsignacion($fila->fechaAsignacion);
            $oOrden->setFechaFin($fila->fechaFin);
            $oOrden->setAccesorios($fila->accesorios);
            $oOrden->setFechaRetiro($fila->fechaRetiro);
            $oOrden->setFechaConforme($fila->fechaConforme);
            
            $aOrden[] = $oOrden;
            unset ($oOrden);
         }        
         return $aOrden;
      } else {
         return false;
      }
   }
}
?>