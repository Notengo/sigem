<?php
/**
 * Description of ProblemaValueObject
 *
 */
class ProblemaValueObject {
    
   private $id, $idRubro, $idEspecialidad, $idTProblema, $observacion, $requiereEquipo;
   
   public function getId() {
       return $this->id;
   }

   public function setId($id) {
       $this->id = $id;
   }

   public function getIdRubro() {
       return $this->idRubro;
   }

   public function setIdRubro($idRubro) {
       $this->idRubro = $idRubro;
   }

   public function getIdEspecialidad() {
       return $this->idEspecialidad;
   }

   public function setIdEspecialidad($idEspecialidad) {
       $this->idEspecialidad = $idEspecialidad;
   }

   public function getIdTProblema() {
       return $this->idTProblema;
   }

   public function setIdTProblema($idTProblema) {
       $this->idTProblema = $idTProblema;
   }

   public function getObservacion() {
       return $this->observacion;
   }

   public function setObservacion($observacion) {
       $this->observacion = $observacion;
   }
   
   public function getRequiereEquipo() {
       return $this->requiereEquipo;
   }

   public function setRequiereEquipo($requiereEquipo) {
       $this->requiereEquipo = $requiereEquipo;
   }


   
}
?>