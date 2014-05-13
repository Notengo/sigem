<?php
/**
 * Description of HistorialValueObject
 *
 */
class HistorialValueObject {
    private $nro, $fechaInicio, $horaInicio, $usuarioAlta, $idProblema, $descripcion, $prioridad, $ofcodi;
    private $tipoRecepcion, $estado, $usuarioAsignado, $usuarioAsignador, $fechaAsignacion, $horaAsignacion;
    private $formaFinalizacion, $fechaFinalizacion, $horaFinalizacion, $usuarioFinalizacion, $observacion, $cierre, $usuarioCierre, $fechaCierre, $horaCierre;
    private $equipo, $nroEquipo, $agente;
           
    public function getNro() {
        return $this->nro;
    }

    public function setNro($nro) {
        $this->nro = $nro;
    }

    public function getFechaInicio() {
        return $this->fechaInicio;
    }
    
    public function setFechaInicio($fechaInicio) {
        $this->fechaInicio = $fechaInicio;
    }

    public function getHoraInicio() {
        return $this->horaInicio;
    }
    
    public function setHoraInicio($horaInicio) {
        $this->horaInicio = $horaInicio;
    }

    public function getUsuarioAlta() {
        return $this->usuarioAlta;
    }

    public function setUsuarioAlta($usuarioAlta) {
        $this->usuarioAlta = $usuarioAlta;
    }

    public function getIdProblema() {
        return $this->idProblema;
    }

    public function setIdProblema($idProblema) {
        $this->idProblema = $idProblema;
    }

    public function getDescripcion() {
        return $this->descripcion;
    }

    public function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

    public function getPrioridad() {
        return $this->prioridad;
    }

    public function setPrioridad($prioridad) {
        $this->prioridad = $prioridad;
    }

    public function getOfcodi() {
        return $this->ofcodi;
    }

    public function setOfcodi($ofcodi) {
        $this->ofcodi = $ofcodi;
    }

    public function getTipoRecepcion() {
        return $this->tipoRecepcion;
    }

    public function setTipoRecepcion($tipoRecepcion) {
        $this->tipoRecepcion = $tipoRecepcion;
    }

    public function getEstado() {
        return $this->estado;
    }

    public function setEstado($estado) {
        $this->estado = $estado;
    }

    public function getUsuarioAsignado() {
        return $this->usuarioAsignado;
    }

    public function setUsuarioAsignado($usuarioAsignado) {
        $this->usuarioAsignado = $usuarioAsignado;
    }

    public function getUsuarioAsignador() {
        return $this->usuarioAsignador;
    }

    public function setUsuarioAsignador($usuarioAsignador) {
        $this->usuarioAsignador = $usuarioAsignador;
    }

    public function getFechaAsignacion() {
        return $this->fechaAsignacion;
    }

    public function setFechaAsignacion($fechaAsignacion) {
        $this->fechaAsignacion = $fechaAsignacion;
    }
    
    public function getHoraAsignacion() {
        return $this->horaAsignacion;
    }

    public function setHoraAsignacion($horaAsignacion) {
        $this->horaAsignacion = $horaAsignacion;
    }

    public function getFormaFinalizacion() {
        return $this->formaFinalizacion;
    }

    public function setFormaFinalizacion($formaFinalizacion) {
        $this->formaFinalizacion = $formaFinalizacion;
    }
    
    public function setUsuarioFinalizacion($usuarioFinalizacion) {
        $this->usuarioFinalizacion = $usuarioFinalizacion;
    }
    
    public function getUsuarioFinalizacion() {
        return $this->usuarioFinalizacion;
    }

    public function getObservacion() {
        return $this->observacion;
    }

    public function setObservacion($observacion) {
        $this->observacion = $observacion;
    }

    public function getCierre() {
        return $this->cierre;
    }

    public function setCierre($cierre) {
        $this->cierre = $cierre;
    }

    public function getUsuarioCierre() {
        return $this->usuarioCierre;
    }

    public function setUsuarioCierre($usuarioCierre) {
        $this->usuarioCierre = $usuarioCierre;
    }

    public function getFechaCierre() {
        return $this->fechaCierre;
    }

    public function setFechaCierre($fechaCierre) {
        $this->fechaCierre = $fechaCierre;
    }
    
    public function getHoraCierre() {
        return $this->horaCierre;
    }

    public function setHoraCierre($horaCierre) {
        $this->horaCierre = $horaCierre;
    }

    public function getFechaFinalizacion() {
        return $this->fechaFinalizacion;
    }

    public function setFechaFinalizacion($fechaFinalizacion) {
        $this->fechaFinalizacion = $fechaFinalizacion;
    }

    public function getHoraFinalizacion() {
        return $this->horaFinalizacion;
    }

    public function setHoraFinalizacion($horaFinalizacion) {
        $this->horaFinalizacion = $horaFinalizacion;
    }
    public function getEquipo() {
        return $this->equipo;
    }

    public function setEquipo($equipo) {
        $this->equipo = $equipo;
    }

    public function getAgente() {
        return $this->agente;
    }

    public function setAgente($agente) {
        $this->agente = $agente;
    }

    public function getNroEquipo() {
        return $this->nroEquipo;
    }

    public function setNroEquipo($nroEquipo) {
        $this->nroEquipo = $nroEquipo;
    }




    
}

?>
