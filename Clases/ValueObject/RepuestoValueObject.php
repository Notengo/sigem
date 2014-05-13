<?php
/**
 * Description of RepuestoValueObject
 *
 * @author ssrolanr
 */
class RepuestoValueObject {
    private $idRepuesto, $descripcion;
    public function getIdRepuesto() {
        return $this->idRepuesto;
    }

    public function setIdRepuesto($idRepuesto) {
        $this->idRepuesto = $idRepuesto;
    }

    public function getDescripcion() {
        return $this->descripcion;
    }

    public function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }
}
?>