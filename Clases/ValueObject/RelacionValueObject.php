<?php
/**
 * Description of RelacionValueObject
 *
 */
class RelacionValueObject {
    
  private $idEquipo, $idComponente, $inversa, $usuario, $fechaBaja;
  
  public function getIdEquipo() {
      return $this->idEquipo;
  }

  public function setIdEquipo($idEquipo) {
      $this->idEquipo = $idEquipo;
  }

  public function getIdComponente() {
      return $this->idComponente;
  }

  public function setIdComponente($idComponente) {
      $this->idComponente = $idComponente;
  }

  public function getInversa() {
      return $this->inversa;
  }

  public function setInversa($inversa) {
      $this->inversa = $inversa;
  }

  public function getUsuario() {
      return $this->usuario;
  }

  public function setUsuario($usuario) {
      $this->usuario = $usuario;
  }

  public function getFechaBaja() {
      return $this->fechaBaja;
  }

  public function setFechaBaja($fechaBaja) {
      $this->fechaBaja = $fechaBaja;
  }



}
?>