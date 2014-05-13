<?php
/**
 * Description of UsuariosEquiposValueObject
 *
 */
class UsuariosEquiposValueObject {
    
   private $id, $dni, $nombre, $fechaAlta, $usuarioAlta;

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

   public function getNombre() {
       return $this->nombre;
   }

   public function setNombre($nombre) {
       $this->nombre = $nombre;
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

}
?>