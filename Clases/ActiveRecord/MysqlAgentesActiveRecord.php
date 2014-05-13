<?php
require_once '../Clases/ValueObject/AgentesValueObject.php';

/**
 * Description of MysqlAgentesActiveRecord
 *
 */
class MysqlAgentesActiveRecord {
 
    /**
    *
    * @param AgentesValueObject $oValueObject
    * @return boolean 
    */
   public function find($oValueObject) {
      if (is_numeric($oValueObject->getDni())){
            $sql = "SELECT * FROM agentes WHERE dni= " . $oValueObject->getDni() . ";";                
            $resultado = mysql_query($sql);
            if($resultado){
                if(mysql_num_rows($resultado)>0) {
                    $fila = mysql_fetch_object($resultado);
                    $oValueObject->setDni($fila->dni);
                    $oValueObject->setNombre($fila->nombre);
                    $oValueObject->setApellido($fila->apellido);
                    $oValueObject->setDireccion($fila->direccion);
                    $oValueObject->setCoddpto($fila->coddpto);
                    $oValueObject->setCodloc($fila->codloc);
                    $oValueObject->setFechaAlta($fila->fechaAlta);
                    $oValueObject->setFechaBaja($fila->fechaBaja);
                    $oValueObject->setUsuarioAlta($fila->usuarioAlta);
                    $oValueObject->setUsuarioBaja($fila->usuarioBaja);                    
                    return $oValueObject;
                } else {
                    return false;
                }           
            } else {
                return false;
            }
        } else {
            $sql = "SELECT * FROM agentes WHERE CONCAT(nombre,' ',apellido) like '%" . $oValueObject->getApellido() . "%' order by apellido, nombre;";                   
            $resultado = mysql_query($sql);
            if($resultado){
                $oAgente = array();
                while ($fila = mysql_fetch_object($resultado)) {
                    $oAgente = new AgentesValueObject();
                    $oAgente->setDni($fila->dni);
                    $oAgente->setNombre($fila->nombre);
                    $oAgente->setApellido($fila->apellido);
                    $oAgente->setDireccion($fila->direccion);
                    $oAgente->setCoddpto($fila->coddpto);
                    $oAgente->setCodloc($fila->codloc);
                    $oAgente->setFechaAlta($fila->fechaAlta);
                    $oAgente->setFechaBaja($fila->fechaBaja);
                    $oAgente->setUsuarioAlta($fila->usuarioAlta);
                    $oAgente->setUsuarioBaja($fila->usuarioBaja);                    
                    $aAgente[] = $oAgente;
                    unset ($oAgente);
                }     return $aAgente;                       
            } else {
                return false;
            }
        }
    }
   

    /**
    * Busca todos lo datos de la tabla Agentes que se encuentra en la base de datos.
    * @param AgentesValueObject $oValueObject
    * @return boolean 
    */
   public function findAll($oValueObject) {
      $sql = "SELECT dni, CONCAT(apellido,', ',nombre) AS apellido from agentes WHERE  ";     
      if($oValueObject->getApellido())
          $sql.=" CONCAT(apellido,', ',nombre) like '%".$oValueObject->getApellido()."%' ";
      $resultado = mysql_query($sql);
      if($resultado){
         $oAgente = array();
         while ($fila = mysql_fetch_object($resultado)) {
            $oAgente = new AgentesValueObject();
            $oAgente->setDni($fila->dni);
            $oAgente->setApellido($fila->apellido);            
            $aAgente[] = $oAgente;
            unset ($oAgente);
         }
         return $aAgente;
      } else {
         return false;
      }
   }
   
   /**
    *
    * @param AgentesValueObject $oValueObject
    * @return boolean 
    */
   public function insert($oValueObject) {
      $sql = "INSERT INTO agentes (dni, nombre, apellido, direccion, coddpto, codloc, usuarioAlta) VALUES (";
      $sql .= $oValueObject->getDni() . ", ";
      $sql .= "'".$oValueObject->getNombre() . "', ";
      $sql .= "'".$oValueObject->getApellido() . "', ";
      $sql .= "'".$oValueObject->getDireccion() . "', ";
      $sql .= "10,10, ";
      $sql .= $oValueObject->getusuarioAlta().");";           
      if (mysql_query($sql)) {
           return true;
      } else { return false; }      
   }
   
   /**
    *
    * @param AgentesValueObject $oValueObject
    * @return boolean 
    */
   public function update($oValueObject) {
      $sql = "UPDATE agentes SET nombre= '" . $oValueObject->getNombre()."', ";
      $sql.= " apellido = '".$oValueObject->getApellido()."', direccion = '".$oValueObject->getDireccion();
      $sql.="' WHERE dni = ".$oValueObject->getDni().";";             
      if (mysql_query($sql))
         return true;
      else
         return false;
   }
}
?>