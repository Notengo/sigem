<?php
//Se requiere la intefaz ActiveRecord
require_once '../ClasesBasicas/ActiveRecordInterface.php';
// Se requiere la clase OftalmologiaValueObject
require_once '../Clases/ValueObject/LocalidadValueObject.php';

/**
 * Description of MysqlLocalidadActiveRecord
 *
 * @author Martin
 */
class MysqlLocalidadActiveRecord implements ActiveRecord {
   /**
    * Cuenta cuantas localidaes estan cargadas en la tabla localida.
    * @return int 
    */
   public function count() {
      $sql = "Select count(*) FROM localida;";
      $resultado = mysql_query($sql);
      if($resultado){
         $resultado = mysql_fetch_row($resultado);
         return $resultado[0];
      } else {
         return 0;
      }
   }

   /**
    * Elimina los registros de la tabla localida que correspondan con el código de departamento y el de localida.
    * @param localidaValueObject $oValueObject 
    * @return Verdadero|Falso
    */
   public function delete($oValueObject) {
      $sql = "DELETE FROM localida WHERE coddepto = ". $oValueObject->getCoddpto();
      $sql .= " AND codloc = " . $oValueObject->getCodloc();
      if(mysql_query($sql))
         return true;
      else
         return false;
   }

   /**
    * Comprueba la existencia de una localida, necesita que se le pase el código de localida y el dedepartamento.
    * @param localidaValueObject $oValueObject
    * @return Verdadero|Falso 
    */
   public function exists($oValueObject) {
      $sql = "SELECT * FROM localida WHERE coddepto = ". $oValueObject->getCoddpto();
      $sql .= " AND codloc = " . $oValueObject->getCodloc();
      if(mysql_query($sql))
         return true;
      else
         return false;
   }

   /**
    * Busca en la tabla localida de la base de datos la descripción y el código postal de una localida,
    * se necesita que se le pase el código de localida y el código de departamento.
    * @param localidaValueObject $oValueObject
    * @return \localidaValueObject|falso 
    */
   public function find($oValueObject) {
      $sql = "SELECT * FROM localida WHERE coddepto = ". $oValueObject->getCoddpto();
      $sql .= " AND codloc = " . $oValueObject->getCodloc();
      $resultado = mysql_query($sql);
      if($resultado){
         $resultado = mysql_fetch_array($resultado);
         $oValueObject->setDescri($resultado['descri']);
         $oValueObject->setCpostal($resultado['cpostal']);
         return $oValueObject;
      } else {
         return false;
      }
      
   }

   /**
    * Busca todos los registros que se encuentran en la tabla localida,
    * los mismos van ordenados por codigo de departamento y codigo de localida.
    * @return \localidaValueObject|boolean 
    */
   public function findAll() {
      $sql = "SELECT * FROM localida ORDER BY coddepto, codloc;";
      $resultado = mysql_query($sql);
      if($resultado){
         $alocalida = array();
         while ($fila = mysql_fetch_object($resultado)) {
            $olocalida = new localidadValueObject();
            $olocalida->setCoddpto($fila->coddepto);
            $olocalida->setCodloc($fila->codloc);
            $olocalida->setDescri($fila->descri);
            $olocalida->setCpostal($fila->cpostal);
            $alocalida[] = $olocalida;
            unset($olocalida);
         }
         return $alocalida;
      } else
         return false;
   }

      /**
    * Busca todos las localidaes que se encuentran en la tabla localida,
    * que pertenzcan a un departamento los mismos van ordenados por codigo 
    * de departamento y codigo de localida.
    * @param localidaValueObject $oValueObject
    * @return \localidaValueObject|falso 
    */
   public function findPorDpto($oValueObject) {
      $sql = "SELECT * FROM localida where coddepto = ". $oValueObject->getCoddpto();
      $sql.= " ORDER BY coddepto, codloc;";
      $resultado = mysql_query($sql);
      if($resultado){
         $alocalida = array();
         while ($fila = mysql_fetch_object($resultado)) {
            $olocalida = new localidadValueObject();
            $olocalida->setCoddpto($fila->coddepto);
            $olocalida->setCodloc($fila->codloc);
            $olocalida->setDescri($fila->descri);
            $olocalida->setCpostal($fila->cpostal);
            $alocalida[] = $olocalida;
            unset($olocalida);
         }
         return $alocalida;
      } else
         return false;
   }
   
   /**
    * Agrega registros a la tabla localida de la base de datos.
    * @param localidaValueObject $oValueObject
    * @return boolean 
    */
   public function insert($oValueObject) {
      $sql = "INSERT INTO localida (coddepto, codloc, descri, cpostal) ";
      $sql .= "VALUES(" . $oValueObject->getCoddpto() . ", " . $oValueObject->getCodloc();
      $sql .= ", '" . $oValueObject->getDescri() . "', " . $oValueObject->getCpostal() . ");";
      if(mysql_query($sql))
         return true;
      else
         return false;
   }

   /**
    * Actualiza un registro en la base de datos.
    * @param localidaValueObject $oValueObject
    * @return boolean 
    */
   public function update($oValueObject) {
      $sql = "UPDATE localida SET descri = '" . $oValueObject->getDescri() . "', ";
      $sql .= " cpostal = " . $oValueObject->getCpostal() . " WHERE coddepto = " . $oValueObject->getCoddpto();
      $sql .= " AND codloc = " . $oValueObject->getCodloc();
      if(mysql_query($sql))
         return true;
      else
         return false;
   }
}

?>
