<?php
/**
 * Description of ServicioValueObject
 *
 */
class ServicioValueObject {
   private $idServicio, $descripcion, $tipo, $fechaAlta, $usuarioAlta, $fechaBaja, $usuarioBaja;
   public function getIdServicio() {
       return $this->idServicio;
   }

   public function setIdServicio($idServicio) {
       $this->idServicio = $idServicio;
   }

   public function getDescripcion() {
       return $this->descripcion;
   }

   public function setDescripcion($descripcion) {
       $this->descripcion = $descripcion;
   }

   public function getTipo() {
       return $this->tipo;
   }

   public function setTipo($tipo) {
       $this->tipo = $tipo;
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