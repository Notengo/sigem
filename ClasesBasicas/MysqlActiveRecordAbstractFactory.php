<?php
// Se requiere de la clase ActiveRecordAbstractFactory
require_once 'ActiveRecordAbstractFactory.php';
require_once '../Clases/ActiveRecord/MysqlAccionObjetoActiveRecord.php';
require_once '../Clases/ActiveRecord/MysqlAccionActiveRecord.php';
require_once '../Clases/ActiveRecord/MysqlOrden.php';
require_once '../Clases/ActiveRecord/MysqlTareaAvtiveRecord.php';
require_once '../Clases/ActiveRecord/MysqlTareaRepuestoActiveRecord.php';
require_once '../Clases/ActiveRecord/MysqlOficexpeActiveRecord.php';
require_once '../Clases/ActiveRecord/MysqlServicioActiveRecord.php';
require_once '../Clases/ActiveRecord/MysqlEquipoActiveRecord.php';
require_once '../Clases/ActiveRecord/MysqlNomenclActiveRecord.php';
require_once '../Clases/ActiveRecord/MysqlMarcaActiveRecord.php';
require_once '../Clases/ActiveRecord/MysqlModeloActiveRecord.php';
require_once '../Clases/ActiveRecord/MysqlSintomaOrdenActiveRecord.php';
require_once '../Clases/ActiveRecord/MysqlPedidoOrdenActiveRecord.php';
require_once '../Clases/ActiveRecord/MysqlPedidoActiveRecord.php';
require_once '../Clases/ActiveRecord/MysqlSintomaActiveRecord.php';
require_once '../Clases/ActiveRecord/MysqlUbicacionActiveRecord.php';
require_once '../Clases/ActiveRecord/MysqlMotivoTrasladoActiveRecord.php';

/**
* Clase que nos permite conectar al motor MySQL y crear objetos
* de tipo Active Record para cada una de tablas del sistema.
*
* Clase que nos permite conectar al motor MySQL y crear objetos
* de tipo Active Record para cada una de tablas del sistema.
*
* @copyright  Copyright (c) 2011 DIVISION DESARROLLO | DEPARTAMENTO INFORMATICA
* @license    http://www.gnu.org/licenses/   GPL License
* @version    1.0
* @since      Class available since Release 1.0
*/
class MysqlActiveRecordAbstractFactory extends ActiveRecordAbstractFactory
{
    
    public static function getActiveRecordFactory($motor = self::MYSQL) {
        return parent::getActiveRecordFactory($motor);
    }

   const HOST = 'localhost';
   const USER = 'root';
   const PASS = 'root';
   const DB = 'sigem';

   /**
   * Nos permite conectar al motor MySQL con los datos de
   * conexi�n especificados como constantes. Luego se hace
   * la selecci�n de la base de datos.
   */
   public function conectar()
   {
      mysql_connect(self::HOST, self::USER, self::PASS);
      mysql_select_db(self::DB);
   }

   /**
   * Nos permite obtener un objeto de tipo
   * MysqlOrden.
   * 
   * @return MysqlOrden
   */
   public function getOrdenActiveRecord() {
      return new MysqlOrden();
   }
   
   /**
   * Nos permite obtener un objeto de tipo
   * MysqlOficexpeActiveRecord.
   * 
   * @return MysqlOficexpeActiveRecord
   */
   public function getOficexpeActiveRecord() {
      return new MysqlOficexpeActiveRecord();
   }
 
      /**
   * Nos permite obtener un objeto de tipo
   * MysqlRubroActiveRecord.
   * 
   * @return MysqlRubroActiveRecord
   */
   public function getRubroActiveRecord() {
      return new MysqlRubroActiveRecord();
   }

      /**
   * Nos permite obtener un objeto de tipo
   * MysqlEspecialidadesActiveRecord.
   * 
   * @return MysqlEspecialidadesActiveRecord
   */
   public function getEspecialidadesActiveRecord() {              
      return new MysqlEspecialidadesActiveRecord();
   }   
   
   /**
   * Nos permite obtener un objeto de tipo
   * MysqlTProblemaActiveRecord.
   * 
   * @return MysqlTProblemaActiveRecord
   */
   public function getTProblemaActiveRecord() {              
      return new MysqlTProblemaActiveRecord();
   }   
   
   /**
   * Nos permite obtener un objeto de tipo
   * MysqlProblemaActiveRecord.
   * 
   * @return MysqlProblemaActiveRecord
   */
   public function getProblemaActiveRecord() {              
      return new MysqlProblemaActiveRecord();
   }   
   
      /**
   * Nos permite obtener un objeto de tipo
   * MysqlUsuariosActiveRecord.
   * 
   * @return MysqlUsuariosActiveRecord
   */
   public function getUsuariosActiveRecord() {              
      return new MysqlUsuariosActiveRecord();
   }  
   
  /**
   * Nos permite obtener un objeto de tipo
   * MysqlAgentesActiveRecord.
   * 
   * @return MysqlAgentesActiveRecord
   */
   public function  getAgentesActiveRecord() {              
      return new MysqlAgentesActiveRecord();
   }  
   
   /**
   * Nos permite obtener un objeto de tipo
   * MysqlCategoriaActiveRecord.
   * 
   * @return MysqlCategoriaActiveRecord
   */
   public function  getCategoriaActiveRecord() {              
      return new MysqlCategoriaActiveRecord();
   }  
   
    /**
   * Nos permite obtener un objeto de tipo
   * MysqlAsignadosActiveRecord.
   * 
   * @return MysqlAsignadosActiveRecord
   */
   public function getAsignadosActiveRecord() {              
      return new MysqlAsignadosActiveRecord();
   }  
   
       /**
   * Nos permite obtener un objeto de tipo
   * MysqlBloqueoActiveRecord.
   * 
   * @return MysqlBloqueoActiveRecord
   */
   public function getBloqueoActiveRecord() {              
      return new MysqlBloqueoActiveRecord();
   } 
   
          /**
   * Nos permite obtener un objeto de tipo
   * MysqlDepartamentoActiveRecord.
   * 
   * @return MysqlDepartamentoActiveRecord
   */
   public function getDepartamentoActiveRecord() {              
      return new MysqlDepartamentoActiveRecord();
   } 
   
             /**
   * Nos permite obtener un objeto de tipo
   * MysqlLocalidadActiveRecord.
   * 
   * @return MysqlLocalidadActiveRecord
   */
   public function getLocalidadActiveRecord() {              
      return new MysqlLocalidadActiveRecord();
   } 
   
    /**
   * Nos permite obtener un objeto de equipo
   * MysqlEquipoActiveRecord.
   * 
   * @return MysqlEquipoActiveRecord
   */
   public function getEquipoActiveRecord() {              
      return new MysqlEquipoActiveRecord();
   } 
   
       /**
   * Nos permite obtener un objeto de equipo
   * MysqlUbicacionActiveRecord.
   * 
   * @return MysqlUbicacionActiveRecord
   */
   public function getUbicacionActiveRecord() {              
      return new MysqlUbicacionActiveRecord();
   } 
   
    /**
   * Nos permite obtener un objeto
   * MysqlTipoActiveRecord.
   * 
   * @return MysqlTipoActiveRecord
   */
   public function getTipoActiveRecord() {              
      return new MysqlTipoActiveRecord();
   } 
   
    /**
   * Nos permite obtener un objeto
   * MysqlMarcaActiveRecord.
   * 
   * @return MysqlMarcaActiveRecord
   */
   public function getMarcaActiveRecord() {              
      return new MysqlMarcaActiveRecord();
   } 
   
       /**
   * Nos permite obtener un objeto
   * MysqlModeloActiveRecord.
   * 
   * @return MysqlModeloActiveRecord
   */
   public function getModeloActiveRecord() {              
      return new MysqlModeloActiveRecord();
   } 
   
          /**
   * Nos permite obtener un objeto
   * MysqlComponenteActiveRecord.
   * 
   * @return MysqlComponenteActiveRecord
   */
   public function getComponenteActiveRecord() {              
      return new MysqlComponenteActiveRecord();
   } 
   
   
    /**
   * Nos permite obtener un objeto
   * MysqlRelacionActiveRecord.
   * 
   * @return MysqlRelacionActiveRecord
   */
   public function getRelacionActiveRecord() {              
      return new MysqlRelacionActiveRecord();
   }
   
       /**
   * Nos permite obtener un objeto
   * MysqlUsuariosEquiposActiveRecord.
   * 
   * @return MysqlUsuariosEquiposActiveRecord
   */
   public function getUsuariosEquiposActiveRecord() {              
      return new MysqlUsuariosEquiposActiveRecord();
   }
   
       /**
   * Nos permite obtener un objeto
   * MysqlOrdenCompraActiveRecord.
   * 
   * @return MysqlOrdenCompraActiveRecord
   */
   public function getOrdenCompraActiveRecord() {              
      return new MysqlOrdenCompraActiveRecord();
   }   
      
    /**
   * Nos permite obtener un objeto
   * MysqlHistorialActiveRecord.
   * 
   * @return MysqlHistorialActiveRecord
   */
   public function getHistorialActiveRecord() {              
      return new MysqlHistorialActiveRecord();
   }   
   
    /**
   * Nos permite obtener un objeto
   * MysqlNomenclActiveRecord.
   * 
   * @return MysqlNomenclActiveRecord
   */
   public function getNomenclActiveRecord() {              
      return new MysqlNomenclActiveRecord();
   }   
   
       /**
   * Nos permite obtener un objeto
   * MysqlServicioActiveRecord.
   * 
   * @return MysqlServicioActiveRecord
   */
   public function getServicioActiveRecord() {              
      return new MysqlServicioActiveRecord();
   } 
      
       /**
   * Nos permite obtener un objeto
   * MysqlAdquirienteActiveRecord.
   * 
   * @return MysqlAdquirienteActiveRecord
   */
   public function getAdquirienteActiveRecord() {              
      return new MysqlAdquirienteActiveRecord();
   } 
      
       /**
   * Nos permite obtener un objeto
   * MysqlSintomaActiveRecord.
   * 
   * @return MysqlSintomaActiveRecord
   */
   public function getSintomaActiveRecord() {              
      return new MysqlSintomaActiveRecord();
   }
      
    /**
   * Nos permite obtener un objeto
   * MysqlSintomaOrdenActiveRecord.
   * 
   * @return MysqlSintomaOrdenActiveRecord
   */
   public function getSintomaOrdenActiveRecord() {              
      return new MysqlSintomaOrdenActiveRecord();
   }
      
    /**
   * Nos permite obtener un objeto
   * MysqlPedidoActiveRecord.
   * 
   * @return MysqlPedidoActiveRecord
   */
   public function getPedidoActiveRecord() {              
      return new MysqlPedidoActiveRecord();
   }
      
    /**
   * Nos permite obtener un objeto
   * MysqlPedidoOrdenActiveRecord.
   * 
   * @return MysqlPedidoOrdenActiveRecord
   */
   public function getPedidoOrdenActiveRecord() {              
      return new MysqlPedidoOrdenActiveRecord();
   }
   
   /**
   * Nos permite obtener un objeto
   * MysqlAccionActiveRecord.
   * 
   * @return MysqlAccionActiveRecord
   */
   public function getAccionActiveRecord() {              
      return new MysqlAccionActiveRecord();
   }
   
   /**
   * Nos permite obtener un objeto
   * MysqlAccionObjetoActiveRecord.
   * 
   * @return MysqlAccionObjetoActiveRecord
   */
   public function getAccionObjetoActiveRecord() {              
      return new MysqlAccionObjetoActiveRecord();
   }
   
   /**
   * Nos permite obtener un objeto
   * MysqlRepuestoActiveRecord.
   * 
   * @return MysqlRepuestoActiveRecord
   */
   public function getRepuestoActiveRecord() {              
      return new MysqlRepuestoActiveRecord();
   } 
   
   /**
   * Nos permite obtener un objeto
   * MysqlRepuestoActiveRecord.
   * 
   * @return MysqlTareaAvtiveRecord
   */
   public function getTareaAvtiveRecord() {
      return new MysqlTareaAvtiveRecord();
   }

   /**
   * Nos permite obtener un objeto
   * MysqlTareaRepuestoActiveRecord.
   * 
   * @return MysqlTareaRepuestoActiveRecord
   */
   public function getTareaRepuestoActiveRecord() {              
      return new MysqlTareaRepuestoActiveRecord();
   } 

   /**
   * Nos permite obtener un objeto
   * MysqlMotivoTrasladoActiveRecord.
   * 
   * @return MysqlMotivoTrasladoActiveRecord
   */
   public function getMotivoTrasladoActiveRecord() {
      return new MysqlMotivoTrasladoActiveRecord();
   }
}
?>