<?php
/**
 * Description of DepartamentoValueObject
 *
 * @author Martin
 */
class DepartamentoValueObject {
   private $coddpto, $descri;
   
   public function getCoddpto() {
      return $this->coddpto;
   }

   public function setCoddpto($coddpto) {
      $this->coddpto = $coddpto;
   }

   public function getDescri() {
      return $this->descri;
   }

   public function setDescri($descri) {
      $this->descri = $descri;
   }

   function __construct() {
      $this->coddpto = 10;
      $this->descri = 'Paraná';
   }

}

?>
