<?php
// Se requiere la clase MysqlActiveRecordAbstractFactory.php
require_once "MysqlActiveRecordAbstractFactory.php";

/**
* Clase que fabrica objetos de tipo Active Record.
*
* Clase que fabrica objetos de tipo Active Record para motores
* MySQL y PostgreSQL.
*
* @copyright  Copyright (c) 2011 Ministerio de Salud (http://http://www.entrerios.gov.ar/salud/portal/)
* @license    http://www.gnu.org/licenses/   GPL License
* @version    1.0
* @link       http://http://www.entrerios.gov.ar/salud/portal/
* @since      Class available since Release 1.0
*/
abstract class ActiveRecordAbstractFactory {
    // Lista de tipos de Active Record soportados por la factoria
    const MYSQL = 1;
    const PGSQL = 2;
    
    public abstract function getOrdenActiveRecord();
    public abstract function getOficexpeActiveRecord();
    public abstract function getRubroActiveRecord();
    public abstract function getEspecialidadesActiveRecord();
    public abstract function getTProblemaActiveRecord();
    public abstract function getProblemaActiveRecord();
    public abstract function getUsuariosActiveRecord();
    public abstract function getAgentesActiveRecord();
    public abstract function getCategoriaActiveRecord();
    public abstract function getAsignadosActiveRecord();
    public abstract function getBloqueoActiveRecord();
    public abstract function getEquipoActiveRecord();
    public abstract function getUbicacionActiveRecord();
    public abstract function getTipoActiveRecord();
    public abstract function getMarcaActiveRecord();
    public abstract function getModeloActiveRecord();
    public abstract function getComponenteActiveRecord();
    public abstract function getRelacionActiveRecord();
    public abstract function getUsuariosEquiposActiveRecord();
    public abstract function getOrdenCompraActiveRecord();
    public abstract function getHistorialActiveRecord();
    public abstract function getNomenclActiveRecord();
    public abstract function getServicioActiveRecord();
    public abstract function getAdquirienteActiveRecord();
    
    public abstract function getPedidoOrdenActiveRecord();
    public abstract function getSintomaOrdenActiveRecord();
    public abstract function getSintomaActiveRecord();
    public abstract function getAccionActiveRecord();
    public abstract function getAccionObjetoActiveRecord();
    public abstract function getRepuestoActiveRecord();
    public abstract function getMotivoTrasladoActiveRecord();
    
    /**
     * Permite obtener la factoria de un Active Record.
     * 
     * @param integer $motor Se especifica el tipo de objeto a crear
     * @return object or false
     */
    public static function getActiveRecordFactory($motor = self::MYSQL) {
        switch ($motor) {
        case self::MYSQL:
            return new MysqlActiveRecordAbstractFactory();
        case self::PGSQL:
            return new PgsqlActiveRecordAbstractFactory();
        default:
            return false;
        }
    }
}
?>
