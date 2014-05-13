<?php
/**
 * Description of TipoValueObject
 *
 */
class TipoValueObject {
    
   private $id, $descripcion, $fechaAlta, $usuarioAlta, $fechaBaja;
   
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

}
?>