<?php
/**
 * Description of AdquirienteValueObject
 *
 */
class AdquirienteValueObject {
    
   private $id, $descripcion, $usuarioAlta, $fechaAlta;
   public function getId() {
       return $this->id;
   }

   public function setId($id) {
       $this->id = $id;
   }

   public function getDescripcion() {
       return $this->descripcion;
   }

   public function setDescripcion($descripcion) {
       $this->descripcion = $descripcion;
   }

   public function getUsuarioAlta() {
       return $this->usuarioAlta;
   }

   public function setUsuarioAlta($usuarioAlta) {
       $this->usuarioAlta = $usuarioAlta;
   }

   public function getFechaAlta() {
       return $this->fechaAlta;
   }

   public function setFechaAlta($fechaAlta) {
       $this->fechaAlta = $fechaAlta;
   }


   
}
?>