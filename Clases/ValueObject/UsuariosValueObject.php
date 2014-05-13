<?php
/**
 * Description of UsuariosValueObject
 *
 */
class UsuariosValueObject {
    
   private $id, $dni, $identificacion, $clave, $permiso, $ambito, $fechaBaja, $fechaAlta, $usuarioBaja, $usuarioAlta;

   public function getId() {
       return $this->id;
   }

   public function setId($id) {
       $this->id = $id;
   }

   public function getDni() {
       return $this->dni;
   }

   public function setDni($dni) {
       $this->dni = $dni;
   }

   public function getIdentificacion() {
       return $this->identificacion;
   }

   public function setIdentificacion($identificacion) {
       $this->identificacion = $identificacion;
   }

   public function getClave() {
       return $this->clave;
   }

   public function setClave($clave) {
       $this->clave = $clave;
   }

   public function getPermiso() {
       return $this->permiso;
   }

   public function setPermiso($permiso) {
       $this->permiso = $permiso;
   }

   public function getAmbito() {
       return $this->ambito;
   }

   public function setAmbito($ambito) {
       $this->ambito = $ambito;
   }

   public function getFechaBaja() {
       return $this->fechaBaja;
   }

   public function setFechaBaja($fechaBaja) {
       $this->fechaBaja = $fechaBaja;
   }

   public function getFechaAlta() {
       return $this->fechaAlta;
   }

   public function setFechaAlta($fechaAlta) {
       $this->fechaAlta = $fechaAlta;
   }

   public function getUsuarioBaja() {
       return $this->usuarioBaja;
   }

   public function setUsuarioBaja($usuarioBaja) {
       $this->usuarioBaja = $usuarioBaja;
   }

   public function getUsuarioAlta() {
       return $this->usuarioAlta;
   }

   public function setUsuarioAlta($usuarioAlta) {
       $this->usuarioAlta = $usuarioAlta;
   }


}
?>