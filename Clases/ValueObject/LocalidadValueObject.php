<?php
/**
 * Description of LocalidadValueObject
 *
 * @author Martin
 */
class LocalidadValueObject {
   private $coddpto, $codloc, $descri, $cpostal;
   
   function __construct() {
      $this->coddpto = 10;
      $this->codloc = 1;
      $this->descri = '';
      $this->cpostal = 3100;
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

   public function getDescri() {
      return $this->descri;
   }

   public function setDescri($descri) {
      $this->descri = $descri;
   }

   public function getCpostal() {
      return $this->cpostal;
   }

   public function setCpostal($cpostal) {
      $this->cpostal = $cpostal;
   }
}

?>
