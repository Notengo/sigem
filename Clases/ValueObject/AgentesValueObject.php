<?php
/**
 * Description of AgentesValueObject
 *
 */
class AgentesValueObject {
    
   private $dni, $nombre, $apellido, $direccion, $coddpto, $codloc, $fechaAlta, $fechaBaja, $usuarioAlta, $usuarioBaja;
   
   public function getDni() {
       return $this->dni;
   }

   public function setDni($dni) {
       $this->dni = $dni;
   }

   public function getNombre() {
       return $this->nombre;
   }

   public function setNombre($nombre) {
       $this->nombre = $nombre;
   }

   public function getApellido() {
       return $this->apellido;
   }

   public function setApellido($apellido) {
       $this->apellido = $apellido;
   }

   public function getDireccion() {
       return $this->direccion;
   }

   public function setDireccion($direccion) {
       $this->direccion = $direccion;
   }

   public function getCoddpto() {
       return $this->coddpto;
   }

   public function setCoddpto($coddpto) {
       $this->coddpto = $coddpto;
   }

   public function getCodloc() {
       return $this->codloc;
   }

   public function setCodloc($codloc) {
       $this->codloc = $codloc;
   }

   public function getFechaAlta() {
       return $this->fechaAlta;
   }

   public function setFechaAlta($fechaAlta) {
       $this->fechaAlta = $fechaAlta;
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