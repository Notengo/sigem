<?php
/**
 * Description of TareaRepuesto
 *
 * @author ssrolanr
 */
class TareaRepuestoValueObject {
    private $idOrden, $idAccionObjeto, $idRepuesto, $cantidad, $precio, $cajaChica, $idAccion;
    
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

    public function getIdRepuesto() {
        return $this->idRepuesto;
    }

    public function setIdRepuesto($idRepuesto) {
        $this->idRepuesto = $idRepuesto;
    }

    public function getCantidad() {
        return $this->cantidad;
    }

    public function setCantidad($cantidad) {
        $this->cantidad = $cantidad;
    }

    public function getPrecio() {
        return $this->precio;
    }

    public function setPrecio($precio) {
        $this->precio = $precio;
    }

    public function getCajaChica() {
        return $this->cajaChica;
    }

    public function setCajaChica($cajaChica) {
        $this->cajaChica = $cajaChica;
    }

    public function getIdAccion() {
        return $this->idAccion;
    }

    public function setIdAccion($idAccion) {
        $this->idAccion = $idAccion;
    }


}
?>