<?php
require_once '../ClasesBasicas/ActiveRecordInterface.php';
require_once '../Clases/ValueObject/DepartamentoValueObject.php';

/**
 * Description of MysqlDepartamentoActiveRecord
 *
 */
class MysqlDepartamentoActiveRecord implements ActiveRecord {

   /**
    * Devuelve la cantidad de registros que se encuentran en la tabla departamentos.
    * @return int 
    */
   public function count() {
      $sql = "SELECT COUNT(*) FROM departamentos;";
      $resultado = mysql_query($sql);
      if($resultado){
         $resultado = mysql_fetch_row($resultado);
         return $resultado[0];
      } else {
         return 0;
      }
   }
   
   /**
    *
    * @param DepartamentoValueObject $oValueObject
    * @return Verdadero|Falso
    */
   public function delete($oValueObject) {
      $sql = "DELETE FROM departamentos WHERE coddepto = " . $oValueObject->getCoddpto();
      if (mysql_query($sql))
         return true;
      else
         return false;
   }
   
   /**
    * Comprueba la existencia de un departamento en la tabla dpto.
    * @param DepartamentoValueObject $oValueObject
    * @return boolean 
    */
   public function exists($oValueObject) {
      $sql = "SELECT COUNT(*) FROM departamentos WHERE coddepto = " . $oValueObject->getCoddpto() . ";";
      $resultado = mysql_query($sql);
      if($resultado){
         $resultado = mysql_fetch_row($resultado);
         if($resultado[0]>0){
            return true;
         } else {
            return false;
         }
      } else {
         return false;
      }
   }

   /**
    * Devuelve la descripcion de un registro de la base de datos, se necesita el codigo del departamento.
    * @param DepartamentoValueObject $oValueObject
    * @return boolean 
    */
   public function find($oValueObject) {
      $sql = "SELECT * FROM departamentos WHERE coddepto = " . $oValueObject->getCoddpto() . ";";
      $resultado = mysql_query($sql);
      if($resultado){
         $fila = mysql_fetch_object($resultado);
         $oValueObject->setDescri($fila->descri);
         return $oValueObject;
      } else {
         return false;
      }
   }

   /**
    * Busca todos los registros de la tabla Dpto.
    * @return \DepartamentoValueObject|boolean 
    */
   public function findAll() {
      $sql = "SELECT * FROM departamentos";      
      $resultado = mysql_query($sql);
      if($resultado){
         $aDpto = array();
         while ($fila = mysql_fetch_object($resultado)) {
            $oDpto = new DepartamentoValueObject();
            $oDpto->setCoddpto($fila->coddepto);
            $oDpto->setDescri($fila->descri);
            $aDpto[] = $oDpto;
            unset($oDpto);
         }
         return $aDpto;
      } else 
         return false;
   }
   
   /**
   * Agrega un registro a la tabla dpto de la base de datos.
   * @param DepartamentoValueObject $oValueObject
   * return Verdadero|Falso
   */
   public function insert($oValueObject) {
      $sql = "INSERT INTO departamentos (coddepto, descri) VALUES(";
      $sql .= $oValueObject->getCoddpto() . ", '" . $oValueObject->getDescri() . "')";
      if (mysql_query($sql))
         return true;
      else
         return false;
   }

   /**
    * Actualiza la tabla dpto.
    * @param DepartamentoValueObject $oValueObject
    * @return boolean 
    */
   public function update($oValueObject) {
      $sql = "UPDATE departamentos SET descri = '" . $oValueObject->getDescri() . "' ";
      $sql .= "WHERE coddepto = " . $oValueObject->getCoddpto() . ";";
      if (mysql_query($sql))
         return true;
      else
         return false;
   }
}
?>
