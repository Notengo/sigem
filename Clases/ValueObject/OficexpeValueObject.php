<?php
/**
* Archivo de la clase OficexpeValueObject.
*
* Archivo de la clase OficinaValueObject que nos permite
* mapear la estructura de la tabla en un objeto para poder
* realizar operaciones de tipo CRUD u otras sobre la tabla
* Oficexpe de la base de datos.
*
*
* @copyright  Copyright (c) 2012 DIVISION DESARROLLO | DEPARTAMENTO INFORMATICA
* @license    http://www.gnu.org/licenses/   GPL License
* @version    1.0
* @since      Class available since Release 1.0
*/

/**
* Clase que nos permite mapear la tabla Oficexpe
*
* Clase que nos permite mapear la tabla Oficexpe a un objeto
* que utlizaremos luego para realizar operaciones de tipo
* CRUD y otras sobre la tabla Oficexpe ubicada en la DB.
*
*/
class OficexpeValueObject
{
        private $_ofcodi, $_nombre, $_domicilio, $_coddpto, $_codloc, $_localiza;
        private $_tipo, $_cp, $_telefono, $_telefono2, $_fax, $_email, $_email2, $_complejidad;

        public function get_ofcodi() {
            return $this->_ofcodi;
        }

        public function set_ofcodi($_ofcodi) {
            $this->_ofcodi = $_ofcodi;
        }

        public function get_nombre() {
            return $this->_nombre;
        }

        public function set_nombre($_nombre) {
            $this->_nombre = $_nombre;
        }

        public function get_domicilio() {
            return $this->_domicilio;
        }

        public function set_domicilio($_domicilio) {
            $this->_domicilio = $_domicilio;
        }

        public function get_coddpto() {
            return $this->_coddpto;
        }

        public function set_coddpto($_coddpto) {
            $this->_coddpto = $_coddpto;
        }

        public function get_codloc() {
            return $this->_codloc;
        }

        public function set_codloc($_codloc) {
            $this->_codloc = $_codloc;
        }

        public function get_localiza() {
            return $this->_localiza;
        }

        public function set_localiza($_localiza) {
            $this->_localiza = $_localiza;
        }

        public function get_tipo() {
            return $this->_tipo;
        }

        public function set_tipo($_tipo) {
            $this->_tipo = $_tipo;
        }

        public function get_cp() {
            return $this->_cp;
        }

        public function set_cp($_cp) {
            $this->_cp = $_cp;
        }

        public function get_telefono() {
            return $this->_telefono;
        }

        public function set_telefono($_telefono) {
            $this->_telefono = $_telefono;
        }

        public function get_telefono2() {
            return $this->_telefono2;
        }

        public function set_telefono2($_telefono2) {
            $this->_telefono2 = $_telefono2;
        }

        public function get_fax() {
            return $this->_fax;
        }

        public function set_fax($_fax) {
            $this->_fax = $_fax;
        }

        public function get_email() {
            return $this->_email;
        }

        public function set_email($_email) {
            $this->_email = $_email;
        }

        public function get_email2() {
            return $this->_email2;
        }

        public function set_email2($_email2) {
            $this->_email2 = $_email2;
        }

        public function get_complejidad() {
            return $this->_complejidad;
        }

        public function set_complejidad($_complejidad) {
            $this->_complejidad = $_complejidad;
        }

}