<?php
/**
 * Description of ModeloValueObject
 *
 */
class ModeloValueObject {
    
   private $idTipo, $idMarca, $idModelo, $descripcion, $fechaAlta, $usuarioAlta, $fechaBaja, $usuarioBaja;
   
   public function getIdTipo() {
       return $this->idTipo;
   }

   public function setIdTipo($idTipo) {
       $this->idTipo = $idTipo;
   }

   public function getIdMarca() {
       return $this->idMarca;
   }

   public function setIdMarca($idMarca) {
       $this->idMarca = $idMarca;
   }

   public function getIdModelo() {
       return $this->idModelo;
   }

   public function setIdModelo($idModelo) {
       $this->idModelo = $idModelo;
   }

   public function getDescripcion() {
       return $this->descripcion;
   }

   public function setDescripcion($descripcion) {
       $this->descripcion = $descripcion;
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