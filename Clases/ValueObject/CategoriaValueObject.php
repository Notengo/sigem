<?php
/**
 * Description of CategoriaValueObject
 *
 */
class CategoriaValueObject {
    
   private $idUsuario, $idEspecialidad, $fechaBaja, $usuarioAlta, $usuarioBaja;
   
   public function getIdUsuario() {
       return $this->idUsuario;
   }

   public function setIdUsuario($idUsuario) {
       $this->idUsuario = $idUsuario;
   }

   public function getIdEspecialidad() {
       return $this->idEspecialidad;
   }

   public function setIdEspecialidad($idEspecialidad) {
       $this->idEspecialidad = $idEspecialidad;
   }

   public function getFechaBaja() {
       return $this->fechaBaja;
   }

   public function setFechaBaja($fechaBaja) {
       $this->fechaBaja = $fechaBaja;
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



}
?>