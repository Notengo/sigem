<?php
/**
 * Description of PedidoOrdenValueObject
 *
 * @author ssrolanr
 */
class PedidoOrdenValueObject {
    private $idOrden, $idPedido;
    
    public function getIdOrden() {
        return $this->idOrden;
    }

    public function setIdOrden($idOrden) {
        $this->idOrden = $idOrden;
    }

    public function getIdPedido() {
        return $this->idPedido;
    }

    public function setIdPedido($idPedido) {
        $this->idPedido = $idPedido;
    }
}

?>
