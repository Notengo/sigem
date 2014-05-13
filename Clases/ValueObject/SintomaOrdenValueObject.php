<?php
/**
 * Description of SintomaOrdenValueObject
 *
 * @author ssrolanr
 */
class SintomaOrdenValueObject {
    private $idOrden, $idSintoma;
    
    public function getIdOrden() {
        return $this->idOrden;
    }

    public function setIdOrden($idOrden) {
        $this->idOrden = $idOrden;
    }

    public function getIdSintoma() {
        return $this->idSintoma;
    }

    public function setIdSintoma($idSintoma) {
        $this->idSintoma = $idSintoma;
    }


}

?>
