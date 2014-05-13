<?php
/**
 * Description of AsignadosValueObject
 *
 */
class AsignadosValueObject {
    
   private $nroOrden, $idUsuario;
   
   public function getNroOrden() {
       return $this->nroOrden;
   }

   public function setNroOrden($nroOrden) {
       $this->nroOrden = $nroOrden;
   }

   public function getIdUsuario() {
       return $this->idUsuario;
   }

   public function setIdUsuario($idUsuario) {
       $this->idUsuario = $idUsuario;
   }


}
?>