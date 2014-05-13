<?php
/**
 * Description of AccionObjetoValuoObject
 *
 * @author ssrolanr
 */
class AccionObjetoValuoObject {
    private $idAccionObjeto, $idAccion, $descripcion;
    public function getIdAccionObjeto() {
        return $this->idAccionObjeto;
    }

    public function setIdAccionObjeto($idAccionObjeto) {
        $this->idAccionObjeto = $idAccionObjeto;
    }

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
}
?>