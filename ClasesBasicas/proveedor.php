<?php
/**
* Clase que nos permite mapear la tabla PROVEEDOR a un objeto
*
* @copyright  Copyright (c) 2010
* @version    1.0
* @since      Class available since Release 1.0
*/

// incluye la conexion a la base de datos
require_once 'ConsultaBD.php';

class proveedor
{
/// atributos de la clase
    public $id;
    public $fechaAlta;
    public $nombre;
    public $duenio;
    private $direccion;
    private $telefono;
    private $fax;
    private $iva;
    private $ivaId;
    private $dgr;
    private $cuit;
    private $usuario;    
    private $referencia;    

/// metodos de la clase
    /**
     * seteo de atributo ID
     * @param int $id
     */
    public function setId($id)	 { $this->id=$id;}
    /**
     * seteo de la fecha de alta
     * @param int $id
     */
    public function setFechaAlta($fecha)	 { $this->fechaAlta=$fecha;}
    /**
     * seteo de atributo NOMBRE
     * @param string $nombre
     */
    public function setNombre($nombre)   { $this->nombre=$nombre;}
    /**
     * seteo de atributo DUEÑO
     * @param int $duenio
     */
    public function setDuenio($duenio) { $this->duenio=$duenio;}
    /**
     * seteo de atributo DIRECCION
     * @param int $dire
     */
    public function setDireccion($dire) { $this->direccion=$dire;}
    /**
     * seteo de atributo TELEFONO
     * @param int $tel
     */
    public function setTelefono($tel) { $this->telefono=$tel;}
    /**
     * seteo de atributo FAX
     * @param int $fax
     */
    public function setFax($fax) { $this->fax=$fax;}
    /**
     * seteo de atributo IVA
     * @param int $idIva
     */
    public function setIva($iva) {
       $this->iva=$iva;
    }
    /**
     * seteo de atributo DGR
     * @param int $dgr
     */
    public function setDgr($dgr) { $this->dgr=$dgr;}
    /**
     * seteo de atributo CUIT
     * @param int $cuit
     */
    public function setCuit($cuit) { $this->cuit=$cuit;}
    /**
     * seteo de atributo USUARIO
     * @param int $usuario
     */
    public function setUsuario($usuario) { $this->usuario=$usuario;}
    
    public function getReferencia() {
        return $this->referencia;
    }

    public function setReferencia($referencia) {
        $this->referencia = $referencia;
    }

    /*----------------
    /**
     * devuelve el ID 
     * @return int ID
     */
    public function getId() { return $this->id; }
    /**
     * devuelve la fecha
     * @return date fecha
     */
    public function getFechaAlta() { return $this->fechaAlta; }
    /**
     * devuelve la DESCRIPCION 
     * @return string DESCRIPCION
     */
    public function getNombre() { return $this->nombre;}
    /**
     * devuelve el nombre del DUEÑO
     * @return string DUEÑO
     */
    public function getDuenio() { return $this->duenio;}
    /**
     * devuelve la DIRECCION
     * @return string DIRECCION
     */
    public function getDireccion() { return $this->direccion;}
    /**
     * devuelve el TELEFONO
     * @return string TELEFONO
     */
    public function getTelefono() { return $this->telefono;}
    /**
     * devuelve el FAX
     * @return string FAX
     */
    public function getFax() { return $this->fax;}
    /**
     * devuelve la DGR
     * @return string DGR
     */
    public function getDgr() { return $this->dgr;}
    /**
     * devuelve el la descripcion de la condicion del IVA
     * @return string IVA
     */
    public function getIva() { return $this->iva;}
     /**
     * devuelve el id de la condicion del IVA
     * @return int IVAID
     */
    public function getIvaId() { return $this->ivaId;}
    /**
     * devuelve la CUIT
     * @return string CUIT
     */
    public function getCuit() { return $this->cuit;}

    /**
     * devuelve el nro de USUARIO
     * @return smallint USUARIO
     */
    public function getUsuario() { return $this->usuario;}

    /**
     * Nos permite buscar un nombre y dueño en la tabla PROVEEDOR
     * @return string 0 or 1
    */   
    private function existeDescripcion(){
        $oConexion=new ConsultaBD();
        $oConexion->Conectar();
        $cadena = $this->nombre.' '.$this->duenio;
        $query ="SELECT id, duenio, nombre, direccion ";
        $query.=" FROM proveedor WHERE CONCAT_WS(' ' , nombre, duenio) LIKE '%$cadena%' and fecha_baja='0000-00-00 00:00:00'";
        $oConexion->executeQuery($query);
        $oConexion->Close();
        if ($oConexion->getNumRows()>0){
            $result = $oConexion->getFetchObject();
            $id = $result->id;            
            $oConexion->Clean();
            $this->observacion="El nombre del proveedor ingresado </br>ya existe en la base de datos";
            return $id;
        }   else {
            $oConexion->Clean();
            return 0;
        }
    }

    /**
     * busca en la tabla presupesto la existencia del provedor
     * @return <type>
     */
    public function proveedorCargado()  {
        $oConexion=new ConsultaBD();
        $oConexion->Conectar();
        $query="select presupuesto.proveedor_fecha from presupuesto where proveedor_id='$this->id' and proveedor_fecha='$this->fechaAlta' ";
        $oConexion->executeQuery($query);
        $oConexion->Close();
        if ($oConexion->getNumRows()>0){
            $result = $oConexion->getFetchObject();
            $this->fechaAlta = $result->proveedor_fecha;
            $oConexion->Clean();
            return $this->fechaAlta;
        }   else {  // no existe el proveedor en la tabla presupuesto
            $oConexion->Clean();
            return 0;
        }
    }

    /**
     * inserta un nuevo registro buscando el ultimo id ingresado para incrementarlo en uno y asi generar el nuevo
     * @return <type>
     */
    public function insertNuevo()  {
        $this->getNombre();
        $this->getUsuario();
        $id = $this->existeDescripcion();
        $divcuerpo="actualiza";
        if($id==0) { // si los datos ingresados no estan duplicados
            $oConexion=new ConsultaBD();
            $oConexion->Conectar();
            $last_insert_id = "SELECT MAX(id) + 1 AS ultimoId FROM proveedor"  ;
            $oConexion->executeQuery($last_insert_id);
            $id = $oConexion->getFetchObject();
            $this->id=$id->ultimoId;
            $query ="insert into proveedor (id, nombre, duenio, direccion, telefono, fax, iva_id, dgr, cuit, usuario_alta, referencia) ";
            $query.="values ('$this->id','$this->nombre','$this->duenio', '$this->direccion', '$this->telefono', '$this->fax', '$this->ivaId', '$this->dgr', '$this->cuit', '$this->usuario', '$this->referencia')";
            $oConexion->executeQuery($query);
            $oConexion->Close();            
            return true;
        } else {            
            return false;
        }
    }

    /**
     * modifica el registro actual
     * @return <type>
     */
    public function actualizaActual(){
        $oConexion=new ConsultaBD();
        $oConexion->Conectar();
        $query = "update proveedor set nombre = '$this->nombre' ,duenio = '$this->duenio' , direccion = '$this->direccion' , ";
        $query.= "telefono = '$this->telefono' , fax = '$this->fax' , iva_id = '$this->ivaId' , dgr = '$this->dgr' , cuit = '$this->cuit' ";
        $query.= " where id = '$this->id' and fecha_alta = '$this->fechaAlta' ";
        $oConexion->executeQuery($query);
        $oConexion->Close();
        return true;
    }

    /** da de baja el registro existente poniendo la fecha actual en la fecha de baja, y agrega un nuevo registro con la descripcion correspondiente
     *
     * @return <type>
     */
    public function dadebajayAgrega(){
        $oConexion=new ConsultaBD();
        $oConexion->Conectar();
        $query = "update proveedor set usuario_baja = '$this->usuario', fecha_baja=CURRENT_TIMESTAMP() where id = '$this->id'";
        $oConexion->executeQuery($query);
        $query ="insert into proveedor (id, nombre, duenio, direccion, telefono, fax, iva_id, dgr, cuit, usuario_alta) ";
        $query.="values ('$this->id','$this->nombre','$this->duenio', '$this->direccion', '$this->telefono', '$this->fax', '$this->ivaId', '$this->dgr', '$this->cuit', '$this->usuario')";
        $oConexion->executeQuery($query);
        $oConexion->Close();
        return true;
    }

    /**
     * Nos permite insertar una descripcion nueva en la tabla IVA, muestra el mensaje de exito
     * en el caso de ingresar el nuevo registro, si el registro ya existe verifica que se trate del mismo id para la
     * modificacion (que implica dar de baja el registro existente y generar uno nuevo)
     * @return string true or false
    */
    public function actualiza()  {
        $this->getNombre();
        $this->getUsuario();
        $id = $this->existeDescripcion();
        $divcuerpo="actualiza";
        if($this->proveedorCargado()==0){   // si no existe el proveedor en la tabla presupuesto
            if($id==0) { // si los datos ingresados no estan duplicados
                // modifica directamente el registro
                $this->actualizaActual();
                echo "<div id=actualiza><div class=exitoConfirma style='text-align: center'>".strtoupper($this->nombre)." se modific&oacute; con &eacute;xito<br/><br/><div align=right><a href=# onclick=cerrar('".$divcuerpo."') class='buttonExito'>Aceptar</a></div></div></div>";                
                return true;
            } else {
                if($id==$this->id) {// si se trata del mismo registro, modifica directamente el registro
                    $this->actualizaActual();
                    echo "<div id=actualiza><div class=exitoConfirma style='text-align: center'>".strtoupper($this->nombre)." se modific&oacute; con &eacute;xito<br/><br/><div align=right><a href=# onclick=cerrar('".$divcuerpo."') class='buttonExito'>Aceptar</a></div></div></div>";
                    return true;
                }   else {  // si se trata de otro registro
                    /// muestra el msj de que el registro esta siendo duplicado
                    echo "<div id=actualiza><div class=errorConfirma style='text-align: center'>$this->observacion <br/><br/><div align=right><a href=# onclick=cerrar('".$divcuerpo."') class='buttonError'>Aceptar</a></div></div></div>";
                    return false;
                }
            }
        } else {    //si el proveedor esta siendo utilizado en la bd presupuesto
            if($id==0) {// si los datos ingresados para modificar no estan duplicados
                    // modifica el registro dando de baja el actual e ingresando uno nuevo
                    $this->dadebajayAgrega();
                    echo "<div id=actualiza><div class=exitoConfirma style='text-align: center'>".strtoupper($this->nombre)." se modific&oacute; con &eacute;xito<br/><br/><div align=right><a href=# onclick=cerrar('".$divcuerpo."') class='buttonExito'>Aceptar</a></div></div></div>";
                    return true;
            } else {
                if($id==$this->id) {// si se trata del mismo registro, modifica directamente el registro
                    $this->dadebajayAgrega();
                    echo "<div id=actualiza><div class=exitoConfirma style='text-align: center'>".strtoupper($this->nombre)." se modific&oacute; con &eacute;xito<br/><br/><div align=right><a href=# onclick=cerrar('".$divcuerpo."') class='buttonExito'>Aceptar</a></div></div></div>";
                    return true;
                }   else {  // si se trata de otro registro
                    /// muestra el msj de que el registro esta siendo duplicado
                    echo "<div id=actualiza><div class=errorConfirma style='text-align: center'>$this->observacion <br/><br/><div align=right><a href=# onclick=cerrar('".$divcuerpo."') class='buttonError'>Aceptar</a></div></div></div>";
                    return false;
                }
            }
        }
    }

    /**
     * Devuelve un arreglo de objetos
     * @return objeto $listado or false
     */
    public function findAll(){
        $oConexion=new ConsultaBD();
        $oConexion->Conectar();
        $oConexion->executeQuery("select proveedor.id, nombre, duenio, direccion, telefono, fax, iva_id, dgr, cuit, fecha_alta from proveedor where proveedor.fecha_baja='0000-00-00' order by nombre");
        if($oConexion->getNumRows()>0) {
            while ($fila = $oConexion->getFetchObject()){
                $oObj = new proveedor();
                $oObj->setId($fila->id);
                $oObj->setFechaAlta($fila->fecha_alta);
                $oObj->setDuenio($fila->duenio);
                $oObj->setNombre($fila->nombre);
                $oObj->setDireccion($fila->direccion);
                $oObj->setTelefono($fila->telefono);
                $oObj->setFax($fila->fax);
                $oObj->setIva($fila->iva_id);
                $oObj->setDgr($fila->dgr);
                $oObj->setCuit($fila->cuit);
                $Listado[] = $oObj;
                unset($oObj);
            }
            $oConexion->Clean();
            $oConexion->Close();
            return $Listado;
        } else {
            $oConexion->Clean();
            $oConexion->Close();
            return false;
        }
    }

        /**
     * busca en la tabla proveedor la existencia del provedor
     * @return <type>
     */
    public function findOne()  {
        $oConexion=new ConsultaBD();
        $oConexion->Conectar();
        $query="select nombre, duenio, direccion from proveedor where id='$this->id' ";        
        $oConexion->executeQuery($query);
        //$oConexion->Close();
        if ($oConexion->getNumRows()>0){
            $result = $oConexion->getFetchObject();
            $this->nombre = $result->nombre;
            $this->duenio = $result->duenio;
            $this->direccion = $result->direccion;            
            return $this->nombre;
        }   else {  // no existe el proveedor en la tabla presupuesto
            $oConexion->Clean();            
            return 0;
        }
    }

    /**
     * elimina un registro de la base de datos ingresando la fecha y el usuario en los campos de baja
     * @return true
     */
    function deleteExistente() {
        $oConexion=new ConsultaBD();
        $oConexion->Conectar();
        $query = "update proveedor set usuario_baja = '$this->usuario', fecha_baja=CURRENT_TIMESTAMP() where id = '$this->id'";
        $oConexion->executeQuery($query);        
        return true;
    }

    /**
     * busca todos los registros que se corresponden con la cadena enviada por parametro
     * @param string $cadena
     * @return proveedor $Listado
     */
     public function searchAll($cadena){
        $oConexion=new ConsultaBD();
        $oConexion->Conectar();
        $nueva_cadena = ereg_replace("[^A-Za-zñÑ0-9]", " ", $cadena);
        $query="SELECT id, duenio, nombre, direccion, telefono, fax, iva_id, dgr, cuit, fecha_alta FROM proveedor WHERE CONCAT_WS(' ' , nombre, duenio, direccion) LIKE '%$nueva_cadena%' and fecha_baja='0000-00-00'";
        $oConexion->executeQuery($query);
        if($oConexion->getNumRows()>0) {
            while ($fila = $oConexion->getFetchObject()){
                $oObj = new proveedor();
                $oObj->setId($fila->id);
                $oObj->setFechaAlta($fila->fecha_alta);
                $oObj->setDuenio($fila->duenio);
                $oObj->setNombre($fila->nombre);
                $oObj->setDireccion($fila->direccion);
                $oObj->setTelefono($fila->telefono);
                $oObj->setFax($fila->fax);
                $oObj->setIva($fila->iva_id);
                $oObj->setDgr($fila->dgr);
                $oObj->setCuit($fila->cuit);
                $Listado[] = $oObj;
                unset($oObj);
            }
            $oConexion->Clean();
            $oConexion->Close();
            return $Listado;
        } else {
            $oConexion->Clean();
            $oConexion->Close();
            return false;
        }
    }

            /**
     * Devuelve un arreglo de objetos
     * @return objeto $listado or false
     */
    public function findxPresu($anio){
        $oConexion=new ConsultaBD();
        $oConexion->Conectar();
        $sql = "select prov.id, prov.nombre, prov.duenio, prov.direccion, prov.telefono, prov.fax, prov.iva_id, prov.fecha_alta, ";
        $sql.= "prov.dgr, prov.cuit from presupuesto p ";
        $sql.= "inner JOIN proveedor prov on (prov.id=p.proveedor_id and prov.fecha_alta=p.proveedor_fecha ) ";
        $sql.= "where p.anticipo_anio=$anio and p.fecha_baja='0000-00-00 00:00:00' group by prov.id, prov.fecha_alta order by nombre ";

        $oConexion->executeQuery($sql);
        if($oConexion->getNumRows()>0) {
            while ($fila = $oConexion->getFetchObject()){
                $oObj = new proveedor();
                $oObj->setId($fila->id);
                $oObj->setFechaAlta($fila->fecha_alta);
                $oObj->setDuenio($fila->duenio);
                $oObj->setNombre($fila->nombre);
                $oObj->setDireccion($fila->direccion);
                $oObj->setTelefono($fila->telefono);
                $oObj->setFax($fila->fax);
                $oObj->setIva($fila->iva_id);
                $oObj->setDgr($fila->dgr);
                $oObj->setCuit($fila->cuit);
                $Listado[] = $oObj;
                unset($oObj);
            }
            $oConexion->Clean();
            $oConexion->Close();
            return $Listado;
        } else {
            $oConexion->Clean();
            $oConexion->Close();
            return false;
        }
    }

    /**
     * busca todos los registros que se corresponden con la cadena enviada por parametro
     * @param string $cadena
     * @return proveedor $Listado
     */
     public function searchAllxPresu($cadena, $anio){
        $oConexion=new ConsultaBD();
        $oConexion->Conectar();
        $nueva_cadena = ereg_replace("[^A-Za-zñÑ0-9]", " ", $cadena);
        $sql = "select prov.id, prov.nombre, prov.duenio, prov.direccion, prov.telefono, prov.fax, prov.iva_id, prov.fecha_alta, ";
        $sql.= "prov.dgr, prov.cuit from presupuesto p ";
        $sql.= "inner JOIN proveedor prov on (prov.id=p.proveedor_id and prov.fecha_alta=p.proveedor_fecha )";
        $sql.= "where ";
        $sql.= " CONCAT_WS(' ' , nombre, duenio, direccion) LIKE '%$nueva_cadena%' and p.anticipo_anio = ".$anio." and p.fecha_baja='0000-00-00 00:00:00'";
        $sql.= " group by prov.id, prov.fecha_alta order by nombre";
        
        $oConexion->executeQuery($sql);
        if($oConexion->getNumRows()>0) {
            while ($fila = $oConexion->getFetchObject()){
                $oObj = new proveedor();
                $oObj->setId($fila->id);
                $oObj->setFechaAlta($fila->fecha_alta);
                $oObj->setDuenio($fila->duenio);
                $oObj->setNombre($fila->nombre);
                $oObj->setDireccion($fila->direccion);
                $oObj->setTelefono($fila->telefono);
                $oObj->setFax($fila->fax);
                $oObj->setIva($fila->iva_id);
                $oObj->setDgr($fila->dgr);
                $oObj->setCuit($fila->cuit);
                $Listado[] = $oObj;
                unset($oObj);
            }
            $oConexion->Clean();
            $oConexion->Close();
            return $Listado;
        } else {
            $oConexion->Clean();
            $oConexion->Close();
            return false;
        }
    }
}
?>