<?php
/**
 * Description of ComponenteIndependienteValueObject
 *
 */
class ComponenteIndependienteValueObject {
    
   private $id, $nro, $idTipo, $idMarca, $idModelo, $nroSerie, $detalle, $cantidad, $nroOrdenCompra, $ofcodi, $usuarioAlta;
   
   public function getId() {
       return $this->id;
   }

   public function setId($id) {
       $this->id = $id;
   }

   public function getNro() {
       return $this->nro;
   }

   public function setNro($nro) {
       $this->nro = $nro;
   }

   public function getIdTipo() {
       return $this->idTipo;
   }

   public function setIdTipo($idTipo) {
       $this->idTipo = $idTipo;
   }

   public function getIdMarca() {
       return $this->idMarca;
   }

   public function setIdMarca($idMarca) {
       $this->idMarca = $idMarca;
   }

   public function getIdModelo() {
       return $this->idModelo;
   }

   public function setIdModelo($idModelo) {
       $this->idModelo = $idModelo;
   }

   public function getNroSerie() {
       return $this->nroSerie;
   }

   public function setNroSerie($nroSerie) {
       $this->nroSerie = $nroSerie;
   }

   public function getDetalle() {
       return $this->detalle;
   }

   public function setDetalle($detalle) {
       $this->detalle = $detalle;
   }

   public function getCantidad() {
       return $this->cantidad;
   }

   public function setCantidad($cantidad) {
       $this->cantidad = $cantidad;
   }

   public function getNroOrdenCompra() {
       return $this->nroOrdenCompra;
   }

   public function setNroOrdenCompra($nroOrdenCompra) {
       $this->nroOrdenCompra = $nroOrdenCompra;
   }

   public function getOfcodi() {
       return $this->ofcodi;
   }

   public function setOfcodi($ofcodi) {
       $this->ofcodi = $ofcodi;
   }

   public function getUsuarioAlta() {
       return $this->usuarioAlta;
   }

   public function setUsuarioAlta($usuarioAlta) {
       $this->usuarioAlta = $usuarioAlta;
   }


}
?>