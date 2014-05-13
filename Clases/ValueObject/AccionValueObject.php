<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AccionValueObject
 *
 * @author ssrolanr
 */
class AccionValueObject {
    private $idAccion, $descripcion, $baja;
    public function getIdAccion() {
        return $this->idAccion;
    }

    public function setIdAccion($idAccion) {
        $this->idAccion = $idAccion;
    }

    public function getDescripcion() {
        return $this->descripcion;
    }

    public function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

    public function getBaja() {
        return $this->baja;
    }

    public function setBaja($baja) {
        $this->baja = $baja;
    }
}
?>