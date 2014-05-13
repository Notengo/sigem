<?php
	
// Se chequea si existe un login
require_once '../usuarios/aut_verifica.inc.php';

// Se requieren los script para acceder a los datos de la DB
require_once '../ClasesBasicas/ActiveRecordAbstractFactory.php';
require_once '../Clases/ActiveRecord/MysqlEquipoActiveRecord.php';
require_once '../Clases/ActiveRecord/MysqlNomenclActiveRecord.php';
require_once '../Clases/ActiveRecord/MysqlOficexpeActiveRecord.php';
require_once '../Clases/ActiveRecord/MysqlOrdenCompraActiveRecord.php';
require_once '../Clases/ActiveRecord/MysqlUbicacionActiveRecord.php';
require_once '../Clases/ActiveRecord/MysqlMarcaActiveRecord.php';
require_once '../Clases/ActiveRecord/MysqlModeloActiveRecord.php';
require_once '../Clases/ActiveRecord/MysqlNomenclActiveRecord.php';
require_once '../Clases/ActiveRecord/MysqlServicioActiveRecord.php';
require_once '../Clases/ActiveRecord/MysqlAdquirienteActiveRecord.php';
require_once '../ClasesBasicas/proveedor.php';
require_once 'funciones.php';
        
$oMysql = ActiveRecordAbstractFactory::getActiveRecordFactory(ActiveRecordAbstractFactory::MYSQL);
$oMysql->conectar();

$oMysqlEquipo = $oMysql->getEquipoActiveRecord();
$ofcodi = $nroOC = $nombre = $idMarca = $idModelo = $edad = $intensificador = '';
$validaEquipo = $existe = $soloVer = 0;
$manual = '';
if(!isset($_GET['cambio'])) {
    // busca el ultimo nro ingresado de equipo   
    $nro = $oMysqlEquipo->findUltimoPar();    
    $nro++;        
   // $nroImp = $nro;
} else { 
    // si se ingreso un nro diferente al sugerido busca si existe
    $nro = $_GET['nro']; 
    $oEquipo = new EquipoValueObject();
    $oEquipo->setNro($nro);
    $oEquipo = $oMysqlEquipo->find($oEquipo);    
    // si el equipo existe cargo las variables para mostrarlas
    if($oEquipo) {
        $existe = 1;
        $nroSe = $oEquipo->getNroSerie();
        $detalle = $oEquipo->getDetalle();
        $garantiaDesde = $oEquipo->getGarantiaDesde();
        $garantiaHasta = $oEquipo->getGarantiaFin();
        $manual = $oEquipo->getManual();
        $fechaIng = $oEquipo->getFechaAlta();
        $fechaBaja = $oEquipo->getFechaBaja();
        $edad = $oEquipo->getEdad();            
        $kv = $oEquipo->getKv();
        $ma = $oEquipo->getMa();
        $alimentacion = $oEquipo->getAlimentacion();
        $intensificador = $oEquipo->getIntensificador();
        $idAdquiriente = $oEquipo->getIdAdquiriente();
        $nroOC = $oEquipo->getOrdenCompra();

        $oUbicacion = new UbicacionValueObject();
        $oUbicacion->setIdEquipo($oEquipo->getId());
        $oMysqlUbicacion = $oMysql->getUbicacionActiveRecord();
        $oUbicacion = $oMysqlUbicacion->find($oUbicacion);        
        if($oUbicacion) {
            $ofcodi = $oUbicacion->getOfcodi();
            $oOfi = new OficexpeValueObject();               
            if($ofcodi<>'') {
                $oOfi->set_ofcodi($ofcodi);
                $oMysqlOfi = $oMysql->getOficexpeActiveRecord();
                $oOfi = $oMysqlOfi->findCompleta($oOfi);
                if($oOfi->get_tipo()<>null) {
                $tipo .=" - ".$oOfi->get_tipo();
                if($oOfi->get_localiza()<>null)
                    $tipo .=" - ".$oOfi->get_localiza()." ";
            }
            $nombre = $oOfi->get_ofcodi()." ".  htmlentities($oOfi->get_nombre())." ".$tipo;                
            $oServicio = new ServicioValueObject();
            $oServicio->setId($oUbicacion->getIdServicio());
            $oMysqlServicio = $oMysql->getServicioActiveRecord();
            $oMysqlServicio->find($oServicio);
            $servicio = $oServicio->getDescripcion();
            $subservicio = $oUbicacion->getSubServicio();
            } else {$ofcodi=""; $nombre="";}
        } else {$ofcodi=""; $nombre="";}   


        $oMysqlMarca = $oMysql->getMarcaActiveRecord();
        $oMysqlModelo = $oMysql->getModeloActiveRecord();
        $oMarca = new MarcaValueObject();                    
        $oMarca = $oMysqlMarca->findId($oEquipo->getIdMarca());
        $marca = $oMarca->getDescripcion();            
        $idMarca = $oEquipo->getIdMarca();

        if($oEquipo->getIdModelo()) {
            $oModelo = new ModeloValueObject();        
            $oModelo = $oMysqlModelo->findId($oEquipo->getIdModelo());
            $modelo = $oModelo->getDescripcion();
            $idModelo = $oEquipo->getIdModelo();
        } else {$idModelo = ""; $modelo = "";}


        if($oEquipo->getCod_eq()) {
             $oMysqlCodEq = $oMysql->getNomenclActiveRecord();
             $oCodEq = new NomenclValueObject();
             $oCodEq->setCod_eq($oEquipo->getCod_eq());
             $oMysqlCodEq->findId($oCodEq);
             $codeqD = $oCodEq->getDes_eq();
             $codeq = $oEquipo->getCod_eq().$oCodEq->getRx();
        }            

        $oProveedor = new proveedor();
        $oProveedor->setId($oEquipo->getIdProveedor());            
        $oProveedor->findOne($oUbicacion);        
        if($oProveedor) {
          $proveed=$oProveedor->getNombre();
          $proveedId = $oProveedor->getId();
        } else {$proveed="";} 

        $oAdquiriente = new AdquirienteValueObject();
        $oAdquiriente->setId($oEquipo->getIdAdquiriente());
        $oMysqlAdquiriente = $oMysql->getAdquirienteActiveRecord();
        $oMysqlAdquiriente->find($oAdquiriente);
        $adquiriente = $oAdquiriente->getDescripcion();
    } else {
       $validaEquipo = 1;
    }        
}    
?>
<!DOCTYPE html>
<html>
    <head>
        <title>SIGEM - Alta Equipo</title>
        <link rel="shortcut icon" href="../images/ingreso.ico" />    
        <link rel="stylesheet" href="../css/estilos.css" type="text/css" />      	   
        <script language="javascript" type="text/javascript" src="js/jquery-1.4.3.min.js"></script>
        <script language="javascript" type="text/javascript" src="js/jquery.blockUI.js"></script>
        <script language="javascript" type="text/javascript" src="js/jquery.validate.1.5.2.js"></script>
        <script language="javascript" type="text/javascript" src="js/index.js"></script>      
        <script language="javascript" type="text/javascript" src="js/validar_fecha.js"></script>      
        <script language="javascript" type="text/javascript" src="js/ajax-enviar-datos.js"></script>      
        <!-- lista dinamica -->
        <script type="text/javascript" src="js/ajax-dynamic-list.js"></script>
        <script type="text/javascript" src="js/ajax.js"></script>      
    </head>
    <body onload="document.getElementById('nro').focus();">
        <div class="contenedor">
            <header> <?php include_once '../ClasesBasicas/EncabezadoInventario.php'; ?> </header>
            <div id="cuerpo" style="min-height: 700px;" >
                <h1>Ingreso de Equipo</h1>   
                <form action="" id="frm_buscar" name="frm_buscar" autocomplete="off">
                    <div id="resultado">
                        <center>    
                            <div align="right" style="margin-right:137px;">    
                                <a href="../admEquipo">&laquo;&nbsp;Regresar</a>
                            </div>
                            <div align="right" style="margin-right: 137px; font-weight: bold;" >    
                                <?php
                                echo "Usuario: ".$_SESSION['usuario_nombre']." ".$_SESSION['usuario_apellido'];
                                $tabindex=1;
                                ?>    
                            </div>
                            <fieldset>
                                <?php
                                $tabindex++;
                                if(isset($fechaIng)){
                                    ?>
                                    <div  align="right" style="margin: 5px;"  >
                                        Fecha Ingreso:
                                        <?php
                                        echo $fechaIng;
                                        if($fechaBaja<>'00/00/0000') {
                                            echo "<br/>Equipo dado de baja";
                                            $soloVer=1;
                                        }
                                        ?>
                                    </div>
                                <?php
                                }
                                ?>
                                <p>
                                    <?php $tabindex++; ?>
                                    <label for="numero" class="detalle">N&uacute;mero:</label>
                                    <input type="text" name="nro" id="nro" class="imputbox" onKeyPress="return esInteger(event)"  maxlength="150" size="9" onFocus="this.style.color='blue'" onBlur="this.style.color='#333333'" value="<?php echo $nro ?>" tabindex="<?php echo $tabindex;?>" onChange="javascript:window.location='index.php?cambio=1&nro='+this.value" value="<?php echo $nro; ?>" />*
                                    <br/>
                                    <?php
                                    if($soloVer==0) {
                                        //EQUIPO PARA MODIFICACION
                                        ?>
                                        <label for="componente" class="detalle" >Descripci&oacute;n:</label>
                                        <?php $tabindex++; ?>    
                                        <input type="text" id="codeq" name="codeq" value="<?php if(isset($codeqD)){ echo $codeqD; } ?>"
                                               onKeyUp="ajax_showOptionsNomencl(this,'getCodeqByLetters',event)"
                                               size="65" onFocus="this.style.color='blue'" onBlur="this.style.color='#333333';"
                                               tabindex="<?php echo $tabindex;?>" />*
                                        <input type="hidden" id="codeq_hidden" name="codeq_ID" value="<?php echo $codeq; ?>" />
                                        <br/>
                                        <?php $tabindex++; ?>
                                        <label for="marca" class="detalle" >Marca y Modelo:</label>
                                        <input type="text" id="marca" name="marca" value="<?php if(isset($marca)) echo $marca; ?>" onKeyUp="ajax_showOptionsMarca(this,'getMarcaByLetters',event)" size="20" onFocus="this.style.color='blue'" onBlur="this.style.color='#333333'" tabindex="<?php echo $tabindex;?>" placeholder="marca"/>*
                                        <input type="hidden" id="marca_hidden" name="marca_ID" value="<?php echo $idMarca; ?>" />
                                        <a href="javascript: fn_mostrar_frm_agregar_marca(1);" ><img src="../css/img_estilos/add.png" ></a>
                                        <?php $tabindex++; ?>
                                        <input type="text" id="modelo" name="modelo" value="<?php if(isset($modelo)) echo $modelo ?>" onKeyUp="ajax_showOptionsModelo(this,'getModeloByLetters',event)" size="20" onFocus="this.style.color='blue'" onBlur="this.style.color='#333333'" tabindex="<?php echo $tabindex; ?>" placeholder="modelo" />
                                        <input type="hidden" id="modelo_hidden" name="modelo_ID" value="<?php echo $idModelo; ?>"/>
                                        <a href="javascript: fn_mostrar_frm_agregar_modelo(1, marca_hidden.value);"><img src="../css/img_estilos/add.png"></a>
                                        <?php $tabindex++; ?>
                                        N/S: <input type="text" id="nrose" name="nrose" value="<?php if(isset($nroSe)){ echo $nroSe; } ?>"  size="20" onFocus="this.style.color='blue'" onBlur="this.style.color='#333333'" tabindex="<?php echo $tabindex;?>" placeholder="nro serie"/>
                                        <br/>
                                        <?php $tabindex++; ?>
                                        <label for="rx"  >RX: <cite style="font-size: 12px;">completar s&oacute;lo si es un equipo RX</cite></label>
                                        <br/>
                                        <label class="detalle"></label>
                                        Ma: <input type="text" id="ma" name="ma" value="<?php if(isset($ma)) echo $ma; ?>"  size="2"  tabindex="<?php echo $tabindex;?>" placeholder=""/>
                                        <?php $tabindex++; ?>
                                        Kv: <input type="text" id="kv" name="kv" value="<?php if(isset($kv)) echo $kv; ?>"  size="2"  tabindex="<?php echo $tabindex;?>" placeholder=""/>
                                        <br/>
                                        <label class="detalle"></label>
                                        <?php $tabindex++;
                                        $aAlimentacion = array(20=>'Bifasica', 22=>'monofasica', 21=>'trifasica');
                                        $tabindex++;
                                        ?>
                                        Alimentaci&oacute;n:
                                        <select name="alimentacion" id="alimentacion" tabindex="<?php echo $tabindex; ?>" >
                                            <option value="0">Seleccione</option>
                                            <?php
                                            foreach ($aAlimentacion as $id => $value) {
                                                if($id==$alimentacion) {
                                                    echo "<option value='$id' selected>".$id." - ".$value."</option>";
                                                } else {
                                                    echo "<option value='$id'>".$id." - ".$value."</option>";
                                                }
                                            }
                                            ?>
                                        </select>
                                        <?php $tabindex++; ?>
                                        Intensificador:
                                        <input type="radio" id="intensificador" name="intensificador" value="N"  size="20" tabindex="<?php echo $tabindex;?>" checked="checked"/>NO        
                                        <input type="radio" id="intensificador" name="intensificador" value="S" <?php if($intensificador=='S') echo "checked"; ?> size="20"  tabindex="<?php echo $tabindex;?>" />SI    
                                        <br/>
                                        <?php $tabindex++; ?>
                                        <label for="detalle" class="detalle">Detalle:</label>
                                        <textarea name="detalle" id="detalle" rows="2" cols="50" style="border-color: grey;" tabindex="<?php echo $tabindex;?>"><?php if(isset($detalle)) echo $detalle; ?></textarea>
                                        <br/>
                                        <?php $tabindex++; ?>
                                        <label for="capacidad" class="detalle" >Antig&uuml;edad:</label>
                                        <input type="text" id="edad" name="edad" value="<?php if(isset($edad)) { echo /*calculaedad($edad);*/ $edad;} ?>" size="5" onFocus="this.style.color='blue'" onBlur="this.style.color='#333333'" tabindex="<?php echo $tabindex;?>" />&nbsp;<cite style="font-size: 12px">a&ntilde;os</cite>
                                        <br/> 
                                        <?php $tabindex++; ?>
                                        <label for="oficina" class="detalle">Ubicaci&oacute;n:</label>
                                        <?php
                                        if($existe <> 0 ){                    
                                        if($nombre<>'') { 
                                            ?>
                                            <input type="hidden" id="oficina_hidden" name="oficina_ID" value="<?php if(isset($ofcodi)) echo $ofcodi?>" />
                                            <input type="hidden" id="oficina" name="oficina" value="<?php if(isset($nombre)) echo $nombre?>"  />
                                            <input type="hidden" id="servicio" name="subservicio" value="<?php if(isset($servicio)) echo $servicio ?>" />
                                            <input type="hidden" id="subservicio" name="subservicio" value="<?php if(isset($subservicio)) echo $subservicio ?>" />
                                            <?php
                                            echo '<label class=datos>'.$nombre."</label><br/>";
                                            echo '<label for="servicio" class="detalle" >Servicio:</label><label class=datos>'.$servicio.' Sala: '.$subservicio.'</label><br/>';    
                                        } else {
                                             ?>
                                            <input type="hidden" id="oficina_hidden" name="oficina_ID" value="<?php echo 0?>" />
                                            <input type="hidden" id="oficina" name="oficina" value="<?php echo 0?>"  />
                                            <input type="hidden" id="servicio" name="subservicio" value="<?php echo 0 ?>" />
                                            <input type="hidden" id="subservicio" name="subservicio" value="<?php echo 0 ?>" />
                                            <?php
                                            echo '<label class=datos>No ingresado</label><br/>';
                                            echo '<label for="servicio" class="detalle" >Servicio:</label><label class=datos>No ingresado Sala: No ingresada</label><br/>';    
                                        }
                                        } else { ?>
                                            <input type="text" id="oficina" name="oficina" value="<?php echo $nombre?>" onKeyUp="ajax_showOptionsOficina(this,'getOficinaByLetters',event)" size="65" onFocus="this.style.color='blue'" onBlur="this.style.color='#333333'" tabindex="<?php echo $tabindex;?>" />
                                            <input type="hidden" id="oficina_hidden" name="oficina_ID" value="<?php echo $ofcodi?>" /><br/>    
                                            <label for="servicio" class="detalle" >Servicio:</label>    
                                            <?php 
                                            $tabindex++;
                                            $oServicio = new ServicioValueObject();
                                            $oMysqlServicio = $oMysql->getServicioActiveRecord();
                                            $aServicio = $oMysqlServicio->findAll();
                                            mostrarCategorias("servicio",0,$aServicio,"getIdServicio", "getDescripcion", $tabindex);       
                                            $tabindex++; ?>    
                                            Sala: <input type="text" id="subservicio" name="subservicio" value="<?php if(isset($subservicio)) echo $subservicio; ?>" size="15" tabindex="<?php echo $tabindex; ?>" />
                                            <br/>
                                        <?php
                                        }
                                        $tabindex++;
                                        ?>
                                        <label for="adquiriente" class="detalle">Adquiriente:</label>
                                        <input type="text" id="adquiriente" name="adquiriente" value="<?php if(isset($adquiriente)) echo $adquiriente; ?>" onKeyUp="ajax_showOptionsAdquiriente(this,'getAdquirienteByLetters',event)" size="65" onFocus="this.style.color='blue'" onBlur="this.style.color='#333333'" tabindex="<?php echo $tabindex;?>" />
                                        <input type="hidden" id="adquiriente_hidden" name="adquiriente_ID" value="<?php echo $idAdquiriente; ?>"/>            
                                        <a href="javascript: fn_mostrar_frm_agregar_adquiriente();" ><img src="../css/img_estilos/add.png" ></a>   
                                        <br/>
                                        <?php $tabindex++; ?>       
                                        <label for="capacidad" class="detalle" >Manuales:</label>
                                        <input type="radio" id="manuales" name="manuales" value="N" tabindex="<?php echo $tabindex; ?>" checked="checked"/>Ninguno
                                        <?php $tabindex++; ?>
                                        <input type="radio" id="manuales" name="manuales" value="O" <?php if($manual == 'O') echo "checked"; ?> tabindex="<?php echo $tabindex;?>" />Operativo
                                        <?php $tabindex++; ?>   
                                        <input type="radio" id="manuales" name="manuales" value="M"  <?php if($manual == 'M') echo "checked"; ?> tabindex="<?php echo $tabindex;?>" />Mantenimiento
                                        <?php $tabindex++; ?>   
                                        <input type="radio" id="manuales" name="manuales" value="T"  <?php if($manual == 'T') echo "checked"; ?> tabindex="<?php echo $tabindex;?>" />Ambos
                                        <br/> 
                                        <?php $tabindex++; ?>
                                        <label for="oc" class="detalle">Orden Compra:</label>
                                        <input type="text" id="oc" name="oc" value="<?php echo $nroOC ?>" size="20" onFocus="this.style.color='blue'" onBlur="this.style.color='#333333'" tabindex="<?php echo $tabindex;?>" placeholder="nro oc" />
                                        <br/>
                                        <?php $tabindex++; ?>
                                        <label for="oc" class="detalle">Garant&iacute;a:</label>
                                        <cite style="font-size: 12px">Desde&nbsp;</cite><input type="text" id="garantiaDesde" name="garantiaDesde" value="<?php if(isset($garantiaDesde)) echo $garantiaDesde; ?>" size="10" tabindex="<?php echo $tabindex;?>" placeholder="dd/mm/aaaa" onblur="validar_fecha(this);" onkeypress="ver(this);"/>
                                        <cite style="font-size: 12px">Hasta&nbsp;</cite><input type="text" id="garantiaHasta" name="garantiaHasta" value="<?php if(isset($garantiaHasta)) echo $garantiaHasta; ?>" size="10" tabindex="<?php echo $tabindex;?>" placeholder="dd/mm/aaaa" onblur="validar_fecha(this);" onkeypress="ver(this);"/>    
                                        <br/>
                                        <?php $tabindex++; ?>        
                                        <label for="oficina" class="detalle">Proveedor:</label>    
                                        <input type="text" id="proveedor" name="proveedor" value="<?php if(isset($proveed)) echo $proveed?>" onKeyUp="ajax_showOptionsProveedor(this,'getProveedorByLetters',event)" size="65" onFocus="this.style.color='blue'" onBlur="this.style.color='#333333'" tabindex="<?php echo $tabindex;?>" />
                                        <input type="hidden" id="proveedor_hidden" name="proveedor_ID" value="<?php echo $proveedId?>" /><br/>    
                                        <br/>
                                    <?php
                                    } else {
                                        // muestra el equipo
                                        ?>
                                        <label for="componente" class="detalle" >Descripci&oacute;n:</label>    
                                        <label class="datos"><?php echo $codeqD; ?>    </label>
                                        <br/>    
                                        <label for="marca" class="detalle" >Marca y Modelo:</label>
                                        <label class="datos"><?php echo $marca." ".$modelo; ?>
                                        <?php echo $nroSe; ?></label>
                                        <br/>         
                                        <label for="rx">Equipo RX: </label>
                                        <br/>    
                                        <label for="rx"  class="detalle" ></label>
                                        <label class="datos"><cite style="font-size: 12px;">Ma:</cite>&nbsp;<?php echo $ma; ?>
                                        <cite style="font-size: 12px;">Kv:</cite> <?php echo $kv; ?></label>
                                        <br/>
                                        <label class="detalle"></label>
                                        <label class="datos"><cite style="font-size: 12px;">Alimentaci&oacute;n: </cite>
                                        <?php
                                        switch ($alimentacion) {
                                            case 20:
                                                echo 'Bifasica';
                                                break;
                                            case 22:
                                                echo 'monofasica';
                                                break;
                                            case 21:
                                                echo 'trifasica';
                                                break;
                                            default:
                                                break;
                                        }
                                        ?>
                                        &nbsp;&nbsp;<cite style="font-size: 12px;">Intensificador:</cite>
                                        <?php if($intensificador == 'S') echo "SI"; else "NO"; ?> </label>
                                        <br/>
                                        <label for="detalle" class="detalle">Detalle:</label>
                                        <label class="datos">
                                            <?php echo $detalle; ?>
                                        </label>
                                        <br/>
                                        <label for="capacidad" class="detalle">
                                            Antig&uuml;edad:
                                        </label>
                                        <label class="datos">
                                            <?php if($edad) echo calculaedad($edad) . " a&ntilde;os"; ?>
                                        </label>
                                        <br/>
                                        <label for="oficina" class="detalle">Ubicaci&oacute;n:</label>
                                        <?php
                                        echo '<label class=datos>'.$nombre."</label><br/>";
                                        echo '<label for="servicio" class="detalle" >Servicio:</label><label class=datos>'.$servicio.' '.$subservicio.'</label><br/>';
                                        ?>
                                        <label for="adquiriente" class="detalle">Adquiriente:</label>
                                        <?php echo $adquiriente; ?>
                                        <br/>       
                                        <label for="capacidad" class="detalle" >Manuales:</label>
                                        <label class="datos" >
                                            <?php
                                            switch ($manual) {
                                                case 'O':
                                                    echo "Operativo";
                                                    break;
                                                case 'M':
                                                    echo "Mantenimiento";
                                                    break;
                                                case 'T':
                                                    echo "Ambos";
                                                    break;
                                                default:
                                                    echo "Ninguno";
                                                    break;
                                            }                
                                            ?>
                                        </label>
                                        <br/>
                                        <label for="oc" class="detalle">Orden Compra:</label>
                                        <label class="datos"><?php echo $nroOC ?></label>
                                        <br/>    
                                        <label for="oc" class="detalle">Garant&iacute;a:</label>
                                        <label class="datos"><cite style="font-size: 12px">Desde: _ </cite><?php echo $garantiaDesde; ?></label>
                                        <label class="datos"><cite style="font-size: 12px">Hasta: _ </cite><?php echo $garantiaHasta; ?></label>
                                        <br/>    
                                        <label for="oficina" class="detalle">Proveedor:</label>    
                                        <label class="datos"><?php echo $proveed; ?></label>
                                        <br/>
                                    <?php
                                    }
                                    ?>
                                </p>
                            </fieldset>
                            <p>
                                <?php $tabindex++; ?>
                                <input type="button" value="&nbsp;&nbsp;&nbsp;Guardar&nbsp;&nbsp;&nbsp;" class="button" onclick="guardarDatos()" tabindex="<?php echo $tabindex;?>"/>                     
                                <?php $tabindex++; ?>
                                <input type="button" value="&nbsp;&nbsp;&nbsp;Cancelar&nbsp;&nbsp;&nbsp;" class="button" onclick="javascript:window.location='index.php'" tabindex="<?php echo $tabindex;?>"/>
                            </p>  
                            <div id="mensaje" style="color:brown; "></div>
                        </center>
                    </div>
                <div id="div_listar"></div>
                <div id="div_oculto" style="display: none;"></div>
                </form>
            </div>       
            <footer><?php include_once '../ClasesBasicas/Pie.php'; ?></footer>
        </div>
    </body>
</html>