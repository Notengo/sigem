<?php
if (isset($_POST['accion'])){
    require_once '../Clases/ValueObject/AccionObjetoValuoObject.php';
    require_once '../ClasesBasicas/ActiveRecordAbstractFactory.php';
    $oMysql = ActiveRecordAbstractFactory::getActiveRecordFactory(ActiveRecordAbstractFactory::MYSQL);
    $oMysql->conectar();
    $oAccionObjetoVo = new AccionObjetoValuoObject();
    $oMysqlAccionObjeto = $oMysql->getAccionObjetoActiveRecord();
    $oAccionObjetoVo->setIdAccion($_POST['accion']);
    $oAccionObjetoVo = $oMysqlAccionObjeto->findAllAccion($oAccionObjetoVo);
    ?><label for="objetoTarea" class="detalle">Objeto de Tarea:</label><?php
    if(!$oAccionObjetoVo) {
        ?>
        <select type="text" id="objetoTarea" name="objetoTarea" >
            <option value="0">No hay objeto para esta tarea</option>
        </select>
        <?php
    } else {
        ?>
        <select type="text" id="objetoTarea" name="objetoTarea" >
            <option value="0">Seleccione una tarea</option>
            <?php
            foreach ($oAccionObjetoVo as $valorAccionObjeto) {
                echo "<option value='".$valorAccionObjeto->getIdAccionObjeto()."'>".htmlentities($valorAccionObjeto->getDescripcion())."</option>";
            }
            ?>
        </select>
        <?php
    }
}
?>
