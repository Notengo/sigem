<?php
/**
 * Description of TareaValueObject
 *
 * @author ssrolanr
 */
class TareaValueObject {
    private $idOrden, $idAccionObjeto, $fechaInicio, $fechaFin, $idUsers, $idAccion;
    public function getIdOrden() {
        return $this->idOrden;
    }

    public function setIdOrden($idOrden) {
        $this->idOrden = $idOrden;
    }

    public function getIdAccionObjeto() {
        return $this->idAccionObjeto;
    }

    public function setIdAccionObjeto($idAccionObjeto) {
        $this->idAccionObjeto = $idAccionObjeto;
    }

    public function getFechaInicio() {
        return $this->fechaInicio;
    }

    public function setFechaInicio($fechaInicio) {
        $this->fechaInicio = $fechaInicio;
    }

    public function getFechaFin() {
        return $this->fechaFin;
    }

    public function setFechaFin($fechaFin) {
        $this->fechaFin = $fechaFin;
    }

    public function getIdUsers() {
        return $this->idUsers;
    }

    public function setIdUsers($idUsers) {
        $this->idUsers = $idUsers;
    }
    
    public function getIdAccion() {
        return $this->idAccion;
    }

    public function setIdAccion($idAccion) {
        $this->idAccion = $idAccion;
    }
}
?>