<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of EstadosValueObject
 *
 * @author ssrolanr
 */
class EstadosValueObject {
    private $id, $descripcion, $mant;
    
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getDescripcion() {
        return $this->descripcion;
    }

    public function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

    public function getMant() {
        return $this->mant;
    }

    public function setMant($mant) {
        $this->mant = $mant;
    }


}

?>
