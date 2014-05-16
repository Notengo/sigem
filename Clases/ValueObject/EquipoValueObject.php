<?php
/**
 * Description of EquipoValueObject
 *
 */
class EquipoValueObject {
    
//   private $id, $cod_eq, $nro, $idTipo, $idMarca, $idModelo, $nroSerie, $detalle, $ordenCompra, $garantiaDesde, $garantiaFin, $fechaIng, $edad, $manual, $observacion, $usuarioAlta, $fechaAlta, $fechaBaja, $idProveedor, $ma, $kv, $alimentacion, $intensificador, $idAdquiriente;
   private $id, $cod_eq, $nro, $idTipo, $idMarca, $idModelo, $nroSerie, 
           $detalle, $idOrdenCompra, $fechaOrdenCompra, $garantiaFin, 
           $fechaIng, $edad, $manual, $observacion, $idAdquiriente, 
           $usuarioAlta, $fechaAlta, $usuarioBaja, $fechaBaja, $idProveedor, $inventario;
   
   public function getId() {
       return $this->id;
   }

   public function setId($id) {
       $this->id = $id;
   }

   public function getCod_eq() {
       return $this->cod_eq;
   }

   public function setCod_eq($cod_eq) {
       $this->cod_eq = $cod_eq;
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

   public function getIdOrdenCompra() {
       return $this->idOrdenCompra;
   }

   public function setIdOrdenCompra($idOrdenCompra) {
       $this->idOrdenCompra = $idOrdenCompra;
   }

   public function getFechaOrdenCompra() {
       return $this->fechaOrdenCompra;
   }

   public function setFechaOrdenCompra($fechaOrdenCompra) {
       $this->fechaOrdenCompra = $fechaOrdenCompra;
   }

   public function getGarantiaFin() {
       return $this->garantiaFin;
   }

   public function setGarantiaFin($garantiaFin) {
       $this->garantiaFin = $garantiaFin;
   }

   public function getFechaIng() {
       return $this->fechaIng;
   }

   public function setFechaIng($fechaIng) {
       $this->fechaIng = $fechaIng;
   }

   public function getEdad() {
       return $this->edad;
   }

   public function setEdad($edad) {
       $this->edad = $edad;
   }

   public function getManual() {
       return $this->manual;
   }

   public function setManual($manual) {
       $this->manual = $manual;
   }

   public function getObservacion() {
       return $this->observacion;
   }

   public function setObservacion($observacion) {
       $this->observacion = $observacion;
   }

   public function getIdAdquiriente() {
       return $this->idAdquiriente;
   }

   public function setIdAdquiriente($idAdquiriente) {
       $this->idAdquiriente = $idAdquiriente;
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

   public function getUsuarioBaja() {
       return $this->usuarioBaja;
   }

   public function setUsuarioBaja($usuarioBaja) {
       $this->usuarioBaja = $usuarioBaja;
   }

   public function getFechaBaja() {
       return $this->fechaBaja;
   }

   public function setFechaBaja($fechaBaja) {
       $this->fechaBaja = $fechaBaja;
   }

   public function getIdProveedor() {
       return $this->idProveedor;
   }

   public function setIdProveedor($idProveedor) {
       $this->idProveedor = $idProveedor;
   }
   public function getInventario() {
       return $this->inventario;
   }

   public function setInventario($inventario) {
       $this->inventario = $inventario;
   }
}