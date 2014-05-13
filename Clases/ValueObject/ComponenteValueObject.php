<?php
/**
 * Description of ComponenteValueObject
 *
 */
class ComponenteValueObject {
    
   private $id, $nro, $idTipo, $uso, $ofcodi, $idMarca, $idModelo, $nroSerie, $detalle, $cantidad, $nroOrdenCompra, $garantia, $usuarioAlta, $fechaAlta, $horaAlta;
   
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

   public function getUso() {
       return $this->uso;
   }

   public function setUso($uso) {
       $this->uso = $uso;
   }

   public function getOfcodi() {
       return $this->ofcodi;
   }

   public function setOfcodi($ofcodi) {
       $this->ofcodi = $ofcodi;
   }

   public function getNroOrdenCompra() {
       return $this->nroOrdenCompra;
   }

   public function setNroOrdenCompra($nroOrdenCompra) {
       $this->nroOrdenCompra = $nroOrdenCompra;
   }

   public function getGarantia() {
       return $this->garantia;
   }

   public function setGarantia($garantia) {
       $this->garantia = $garantia;
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

   public function getHoraAlta() {
       return $this->horaAlta;
   }

   public function setHoraAlta($horaAlta) {
       $this->horaAlta = $horaAlta;
   }



}
?>