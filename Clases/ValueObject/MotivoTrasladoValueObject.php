<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MotivoTrasladoValueObject
 *
 * @author ssrolanr
 */
class MotivoTrasladoValueObject {
    private $idMotivoTraslado, $descripcion, $fechaAlta, $usuarioAlta, $fechaBaja, $usuarioBaja;
    
    public function getIdMotivoTraslado() {
        return $this->idMotivoTraslado;
    }

    public function setIdMotivoTraslado($idMotivoTraslado) {
        $this->idMotivoTraslado = $idMotivoTraslado;
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

    public function getUsuarioBaja() {
        return $this->usuarioBaja;
    }

    public function setUsuarioBaja($usuarioBaja) {
        $this->usuarioBaja = $usuarioBaja;
    }
}
?>