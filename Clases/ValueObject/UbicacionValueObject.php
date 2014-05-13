<?php
/**
 * Description of UbicacionValueObject
 *
 */
class UbicacionValueObject {
    
  private $idEquipo, $ofcodi, $fecha, $idServicio, $idMotivoTraslado, 
          $subServicio, $usuarioAlta, $usuarioBaja, $fechaBaja, $confirma;
  
  public function getIdEquipo() {
      return $this->idEquipo;
  }

  public function setIdEquipo($idEquipo) {
      $this->idEquipo = $idEquipo;
  }

  public function getOfcodi() {
      return $this->ofcodi;
  }

  public function setOfcodi($ofcodi) {
      $this->ofcodi = $ofcodi;
  }

  public function getUsuarioAlta() {
      return $this->usuarioAlta;
  }

  public function setUsuarioAlta($usuarioAlta) {
      $this->usuarioAlta = $usuarioAlta;
  }

  public function getUsuarioBaja() {
      return $this->usuarioBaja;
  }

  public function setUsuarioBaja($usuarioBaja) {
      $this->usuarioBaja = $usuarioBaja;
  }

  public function getFechaBaja() {
      return $this->fechaBaja;
  }

  public function setFechaBaja($fechaBaja) {
      $this->fechaBaja = $fechaBaja;
  }

  public function getFecha() {
      return $this->fecha;
  }

  public function setFecha($fecha) {
      $this->fecha = $fecha;
  }

  public function getIdServicio() {
      return $this->idServicio;
  }

  public function setIdServicio($idServicio) {
      $this->idServicio = $idServicio;
  }

  public function getIdMotivoTraslado() {
      return $this->idMotivoTraslado;
  }

  public function setIdMotivoTraslado($idMotivoTraslado) {
      $this->idMotivoTraslado = $idMotivoTraslado;
  }

  public function getSubServicio() {
      return $this->subServicio;
  }

  public function setSubServicio($subServicio) {
      $this->subServicio = $subServicio;
  }
  
  public function getConfirma() {
      return $this->confirma;
  }

  public function setConfirma($confirma) {
      $this->confirma = $confirma;
  }
}
?>