<?php
/**
 * Description of NomenclValueObject
 *
 */
class NomenclValueObject {
    
   private $cod_eq, $des_eq, $rx;
   
   public function getCod_eq() {
       return $this->cod_eq;
   }

   public function setCod_eq($cod_eq) {
       $this->cod_eq = $cod_eq;
   }

   public function getDes_eq() {
       return $this->des_eq;
   }

   public function setDes_eq($des_eq) {
       $this->des_eq = $des_eq;
   }

   public function getRx() {
       return $this->rx;
   }

   public function setRx($rx) {
       $this->rx = $rx;
   }


}
?>