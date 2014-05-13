<?php
/**
 * Description of Orden
 *
 * @author ssrolanr
 */
class Orden {
    private $idorden, $fecha, $ofcodi, $solicitante, $prioridad, $formaPedido, $idEquipo, $estado, $observacion;
    private $idServicio, $idUsers, $fechaAsignacion, $fechaFin, $accesorios, $fechaRetiro, $fechaConforme;
    public function getIdorden() {
        return $this->idorden;
    }

    public function setIdorden($idorden) {
        $this->idorden = $idorden;
    }

    public function getFecha() {
        return $this->fecha;
    }

    public function setFecha($fecha) {
        $this->fecha = $fecha;
    }

    public function getOfcodi() {
        return $this->ofcodi;
    }

    public function setOfcodi($ofcodi) {
        $this->ofcodi = $ofcodi;
    }

    public function getSolicitante() {
        return $this->solicitante;
    }

    public function setSolicitante($solicitante) {
        $this->solicitante = $solicitante;
    }

    public function getPrioridad() {
        return $this->prioridad;
    }

    public function setPrioridad($prioridad) {
        $this->prioridad = $prioridad;
    }

    public function getFormaPedido() {
        return $this->formaPedido;
    }

    public function setFormaPedido($formaPedido) {
        $this->formaPedido = $formaPedido;
    }

    public function getIdEquipo() {
        return $this->idEquipo;
    }

    public function setIdEquipo($idEquipo) {
        $this->idEquipo = $idEquipo;
    }

    public function getEstado() {
        return $this->estado;
    }

    public function setEstado($estado) {
        $this->estado = $estado;
    }

    public function getObservacion() {
        return $this->observacion;
    }

    public function setObservacion($observacion) {
        $this->observacion = $observacion;
    }
    
    public function getIdServicio() {
        return $this->idServicio;
    }

    public function setIdServicio($idServicio) {
        $this->idServicio = $idServicio;
    }

    public function getIdUsers() {
        return $this->idUsers;
    }

    public function setIdUsers($idUsers) {
        $this->idUsers = $idUsers;
    }

    public function getFechaAsignacion() {
        return $this->fechaAsignacion;
    }

    public function setFechaAsignacion($fechaAsignacion) {
        $this->fechaAsignacion = $fechaAsignacion;
    }

    public function getFechaFin() {
        return $this->fechaFin;
    }

    public function setFechaFin($fechaFin) {
        $this->fechaFin = $fechaFin;
    }
    
    public function getAccesorios() {
        return $this->accesorios;
    }

    public function setAccesorios($accesorios) {
        $this->accesorios = $accesorios;
    }

    public function getFechaRetiro() {
        return $this->fechaRetiro;
    }

    public function setFechaRetiro($fechaRetiro) {
        $this->fechaRetiro = $fechaRetiro;
    }

    public function getFechaConforme() {
        return $this->fechaConforme;
    }

    public function setFechaConforme($fechaConforme) {
        $this->fechaConforme = $fechaConforme;
    }
}
?>