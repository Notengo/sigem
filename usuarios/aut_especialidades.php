<?php 
require 'aut_verifica.inc.php'; // incluir motor de autentificacion.
require_once '../ClasesBasicas/ActiveRecordAbstractFactory.php';
include_once '../Clases/ActiveRecord/MysqlUsuariosActiveRecord.php';
include_once '../Clases/ActiveRecord/MysqlEspecialidadesActiveRecord.php';
include_once '../Clases/ActiveRecord/MysqlCategoriaActiveRecord.php';
include_once '../Clases/ActiveRecord/MysqlBloqueoActiveRecord.php';
include_once '../Clases/ActiveRecord/MysqlOficexpeActiveRecord.php';

if ( $_SESSION['usuario_nivel'] != "Z") {
   echo "<div align=center class=error>Acceso Incorrecto</div>";
   exit;
}

if(isset($_POST['ident'])) {
    $id = $_POST['ident'];
} else {  
    if(isset($_GET['ident'])) 
        $id = $_GET['ident'];        
}
    

$oMysql = ActiveRecordAbstractFactory::getActiveRecordFactory(ActiveRecordAbstractFactory::MYSQL);
$oMysql->conectar();

$oUsuario = new UsuariosValueObject();
$oMySqlUsuarios = $oMysql->getUsuariosActiveRecord();

$oUsuario->setId($id);
$oUsuario = $oMySqlUsuarios->find($oUsuario);

?>
<!DOCTYPE html>
<html>
   <head>
      <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
      <title>Gesti&oacute;n de Usuarios</title>
      <link rel="shortcut icon" href="../images/ingreso.ico" />
      <link rel="stylesheet" href="../css/plantilla.css" type="text/css"  media="screen" />
      <link rel="stylesheet" href="../css/estilos.css" type="text/css" />
      <script type="text/javascript" src="js/validacion.js"></script>
   </head>
   <body id="nav3" onload="formulario.oficina.focus()">
      <div class="contenedor">
         <header><?php include_once 'Encabezado.php'; ?></header>
         <div id="cuerpo">
            <h1>Gesti&oacute;n de Usuarios</h1>                        
            <ul id="navegacion">
               <li class="nav1"><a href="aut_nuevo_usuario.php">Nuevo Usuario</a></li>
               <li class="nav2"><a href="aut_lista_usuarios.php">Listado de Usuarios</a></li>  
               <li class="nav3"><a href="aut_modifica_usuario.php">Actualización de Usuarios</a></li>
               <li class="nav4"><a href="aut_modifica_clave.php">Cambio de Clave</a></li>
            </ul>
            <br/>
            <?php echo "Usuario: ".$oUsuario->getIdentificacion()?>
            <br/>
            <form id="two" name="formulario" autocomplete="off" method="post" action="guardar.php">
               <input type="hidden" name="ident" id="ident" value="<?php echo $id; ?>">
               <div id="vista">
                  <fieldset>
                     <legend>Especialidades</legend>
                     <div align="center"><table id="tablaBorde"><tr>
                         <?php 
                         $oEspecialidad = new EspecialidadesValueObject();
                         $oMysqlEspec = $oMysql->getEspecialidadesActiveRecord();
                         $aEspec = $oMysqlEspec->findAll();
                         
                         $oCategoria = new CategoriaValueObject();
                         $oCategoria->setIdUsuario($id);
                         $oMysqlCatego = $oMysql->getCategoriaActiveRecord();                         
                         
                         $i=0;
                         if($aEspec <> false) {
                             foreach ($aEspec as $value) {
                                 if($i==5) {$i=0; echo "</tr><tr>";}
                                 $oCategoria->setIdEspecialidad($value->getId());                                 
                                 if($oMysqlCatego->find($oCategoria)==false)
                                    echo "<td><input type='checkbox' value=".$value->getId()." name=".$value->getId()." />".$value->getDescripcion()."</td>";
                                 else
                                    echo "<td><input type='checkbox' value=".$value->getId()." name=".$value->getId()." checked/>".$value->getDescripcion()."</td>";                                     
                                 $i++;
                             }
                         }
                         ?>
                         </tr></table>
                        <br/>
                     </div>
                  </fieldset>
                  <fieldset>
                     <legend>Oficinas Bloqueadas</legend>
                     <div style="margin-left: 50px;">
                         <table id="tablaBorde">
                     <?php 
                     $oBloqueo = new BloqueoValueObject();
                     $oBloqueo->setIdUsuario($id);
                     $oMysqlBloqueo = $oMysql->getBloqueoActiveRecord();
                     $aBloqueo = $oMysqlBloqueo->find($oBloqueo);
                     
                     $oOfcodi = new OficexpeValueObject();
                     $oMysqlOficexpe = $oMysql->getOficexpeActiveRecord();
                     
                     if($aBloqueo <> false) {
                         foreach ($aBloqueo as $bloqueados) {
                             
                         $oOfcodi->set_ofcodi($bloqueados->getOfcodi());
                         $oOfcodi = $oMysqlOficexpe->find($oOfcodi);
                         echo "<tr><td><input type='checkbox' name=z".$oOfcodi->get_ofcodi()." value=".$oOfcodi->get_ofcodi()." checked>&nbsp;".$oOfcodi->get_nombre()."</td></tr>";
                         }
                     }
                     ?>
                            </table>
                     <br/>
                    Nueva oficina a bloquear <input type="text" id="oficina" name="oficina" value="" onKeyUp="ajax_showOptionsOficina(this,'getOficinaByLetters',event)" size="80" onFocus="this.style.color='blue'" onBlur="this.style.color='#333333'" />
                    <input type="hidden" id="oficina_hidden" name="oficina_ID" />
                    </div>
                     <br/>
                  </fieldset>
                  <br />
                  <div align="center">
                        <input type="submit" class="button" name="Submit" value="&nbsp;&nbsp;Guardar&nbsp;&nbsp;" onclick="">
                        <input type="button" class="button" value="&nbsp;&nbsp;Cancelar&nbsp;&nbsp;" onclick="javascript:location.href='aut_modifica_usuario.php'">
                        <div id="falta_dato" class="falta_dato" style="display:inline"></div>
                  </div>
                  <div id="resultado">
                  </div>
            </form>
         </div>
               </div>
         <footer><?php include_once '../ClasesBasicas/Pie.php'; ?></footer>
      </div>
   </body>
</html>
