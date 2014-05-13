<?php
/**
 * Description of OrdenCompraValueObject
 *
 */
class OrdenCompraValueObject {
    private $id, $nro, $fecha, $proveedor, $observacion, $fechaAlta, $usuario;

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

    public function getFecha() {
        return $this->fecha;
    }

    public function setFecha($fecha) {
        $this->fecha = $fecha;
    }

    public function getProveedor() {
        return $this->proveedor;
    }

    public function setProveedor($proveedor) {
        $this->proveedor = $proveedor;
    }

    public function getObservacion() {
        return $this->observacion;
    }

    public function setObservacion($observacion) {
        $this->observacion = $observacion;
    }

    public function getFechaAlta() {
        return $this->fechaAlta;
    }

    public function setFechaAlta($fechaAlta) {
        $this->fechaAlta = $fechaAlta;
    }

    public function getUsuario() {
        return $this->usuario;
    }

    public function setUsuario($usuario) {
        $this->usuario = $usuario;
    }


}

?>
