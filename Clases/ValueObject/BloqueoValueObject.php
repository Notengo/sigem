<?php
/**
 * Description of BloqueoValueObject
 *
 */
class BloqueoValueObject {
    
   private $idUsuario, $ofcodi, $fechaAlta, $usuarioAlta, $fechaBaja, $usuarioBaja;
   
   public function getIdUsuario() {
       return $this->idUsuario;
   }

   public function setIdUsuario($idUsuario) {
       $this->idUsuario = $idUsuario;
   }

   public function getOfcodi() {
       return $this->ofcodi;
   }

   public function setOfcodi($ofcodi) {
       $this->ofcodi = $ofcodi;
   }

   public function getFechaAlta() {
       return $this->fechaAlta;
   }

   public function setFechaAlta($fechaAlta) {
       $this->fechaAlta = $fechaAlta;
   }

   public function getUsuarioAlta() {
       return $this->usuarioAlta;
   }

   public function setUsuarioAlta($usuarioAlta) {
       $this->usuarioAlta = $usuarioAlta;
   }

   public function getFechaBaja() {
       return $this->fechaBaja;
   }

   public function setFechaBaja($fechaBaja) {
       $this->fechaBaja = $fechaBaja;
   }

   public function getUsuarioBaja() {
       return $this->usuarioBaja;
   }

   public function setUsuarioBaja($usuarioBaja) {
       $this->usuarioBaja = $usuarioBaja;
   }

}
?>