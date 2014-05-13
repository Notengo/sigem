function esInteger(e)
{
    var charCode
    if (navigator.appName  ==  "Netscape") // Veo si es Netscape o Explorer (mas adelante lo explicamos)
        charCode = e.which // leo la tecla que ingreso
    else
        charCode = e.keyCode // leo la tecla que ingreso
    status = charCode
    if (charCode > 31 && (charCode < 48 || charCode > 58))
    { // Chequeamos que sea un numero comparandolo con los valores ASCII
            return false
    }   
            return true
}

function objetoAjax(){
	var xmlhttp=false;
	try{
		xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
	}catch(e){
		try{
			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		}catch(E){
			xmlhttp = false;
  		}
	}
	if (!xmlhttp && typeof XMLHttpRequest!='undefined') {
		xmlhttp = new XMLHttpRequest();
	}
	return xmlhttp;
}

function validar_fecha(fecha){
    if(fecha.value != '')
    if (fecha !=  undefined && fecha.value !=  ""){
        if (!/^\d{2}\/\d{2}\/\d{4}$/.test(fecha.value)){
            divMensaje = document.getElementById('mensaje');                
            divMensaje.innerHTML= '<img src="../images/info.gif" />&nbsp;La fecha debe tener el formato: dd/mm/aaaa';            
            fecha.style.borderColor='red';
            fecha.focus();
            return false;
        }    
        var dia  =  parseInt(fecha.value.substring(0,2),10);
        var mes  =  parseInt(fecha.value.substring(3,5),10);
        var anio =  parseInt(fecha.value.substring(6),10);
        divMensaje = document.getElementById('mensaje');      
        switch(mes){
            case 1:
            case 3:
            case 5:
            case 7:
            case 8: 
            case 10:
            case 12:
                numDias=31;
                break;
            case 4: case 6: case 9: case 11:
                numDias=30;
                break;
            case 2:
                if (comprobarSiBisisesto(anio)){ numDias=29 }else{ numDias=28};
                break;
            default:                     
                divMensaje.innerHTML= '<img src="../images/info.gif" />&nbsp;La fecha ingresada es incorrecta';
                fecha.focus();
                fecha.style.borderColor='red';
                return false;
        }
 
        if (dia>numDias || dia == 0){            
            divMensaje.innerHTML= '<img src="../images/info.gif" />&nbsp;La fecha ingresada es incorrecta';
	    fecha.focus();
            fecha.style.borderColor='red';
            return false;
        }
        fecha.style.borderColor='';
        divMensaje.innerHTML= '';              
        return true;
    }
}

function comprobarSiBisisesto(anio){
if ( ( anio % 100 !=  0) && ((anio % 4  ==  0) || (anio % 400  ==  0))) {
    return true;
    }
else {
    return false;
    }
}


function ver(e)
{
    if (((e.value.length+1)==3)||((e.value.length+1)==6))
        e.value += '/';
}


function guardarDatos(){    
    divResultado = document.getElementById('resultado'); 
    var nro = document.getElementById('nro').value;
    var codeqD = document.getElementById('codeq').value;    
    var codeq = document.getElementById('codeq_hidden').value;     
    var marca = document.getElementById('marca_hidden').value;   
    var marcaD = document.getElementById('marca').value;   
    var modelo = document.getElementById('modelo_hidden').value;
    var modeloD = document.getElementById('modelo').value;
    var nrose = document.getElementById('nrose').value;  
    var detalle = document.getElementById('detalle').value;            
    var edad = document.getElementById('edad').value; 
    var ofcodi = document.getElementById('oficina_hidden').value; 
    var ofcodiD = document.getElementById('oficina').value; 
    var servicio = document.getElementById('servicio').value;      
    var subservicio = document.getElementById('subservicio').value;      
    var proveedor = document.getElementById('proveedor_hidden').value; 
    var proveedorD = document.getElementById('proveedor').value; 
    var adquiriente = document.getElementById('adquiriente_hidden').value;     
    var oc = document.getElementById('oc').value;
    var garantiaDesde = document.getElementById('garantiaDesde').value;       
    var garantiaHasta = document.getElementById('garantiaHasta').value;         
    var ma = document.getElementById('ma').value;      
    var kv = document.getElementById('kv').value;      
    var alimentacion = document.getElementById('alimentacion').value;      
    
    var diaD  =  parseInt(garantiaDesde.substring(0,2),10);
    var mesD  =  parseInt(garantiaDesde.substring(3,5),10);
    var anioD =  parseInt(garantiaDesde.substring(6),10);
    
    var diaH  =  parseInt(garantiaHasta.substring(0,2),10);
    var mesH  =  parseInt(garantiaHasta.substring(3,5),10);
    var anioH =  parseInt(garantiaHasta.substring(6),10);
   
    var intens="N";
    for(i=0;i<document.frm_buscar.intensificador.length;i++){
        if(document.frm_buscar.intensificador[i].checked) {
            intens=i;
        }
    }
    intens = document.frm_buscar.intensificador[intens].value;   
    
    var manual="N";
    for(i=0;i<document.frm_buscar.manuales.length;i++){
        if(document.frm_buscar.manuales[i].checked) {
            manual=i;
        }
    }
    manual = document.frm_buscar.manuales[manual].value;
    
    divMensaje = document.getElementById('mensaje');    
    divMensaje.innerHTML= '';
    document.getElementById('codeq').style.border="";
    document.getElementById('nro').style.border="";
    document.getElementById('marca').style.border="";
    document.getElementById('ma').style.border="";
    document.getElementById('kv').style.border="";
    document.getElementById('alimentacion').style.border="";
    document.getElementById('intensificador').style.border="";
    
    document.getElementById('marca').style.border='';
    document.getElementById('modelo').style.border='';
    if((document.getElementById('marca').value!='')&&(document.getElementById('marca_hidden').value=='')) {
        document.getElementById('mensaje').innerHTML= '<img src="../images/info.gif" />&nbsp;ATENCI&Oacute;N: La marca ingresada no existe';                    
        document.getElementById('marca').style.border="2px solid red";
        document.getElementById('marca').focus();
        return false;
    }
    if((document.getElementById('marca_hidden').value=='')&&((document.getElementById('modelo').value!='')||((document.getElementById('nrose').value!='')))) {
        document.getElementById('mensaje').innerHTML= '<img src="../images/info.gif" />&nbsp;ATENCI&Oacute;N: Debe ingresar la marca del componente';                    
        document.getElementById('marca').style.border="2px solid red";
        document.getElementById('marca').focus();
        return false;
    }
    if((document.getElementById('modelo').value!='')&&(document.getElementById('modelo_hidden').value=='')) {
        document.getElementById('mensaje').innerHTML= '<img src="../images/info.gif" />&nbsp;ATENCI&Oacute;N: El modelo ingresado no existe';                    
        document.getElementById('modelo').style.border="2px solid red";
        document.getElementById('modelo').focus();
        return false;
    }
    document.getElementById('oficina').style.border='';
    if((document.getElementById('oficina').value!='')&&(ofcodi=='')) {
        document.getElementById('mensaje').innerHTML= '<img src="../images/info.gif" />&nbsp;ATENCI&Oacute;N: La ubicacion ingresada no existe';                    
        document.getElementById('oficina').style.border="2px solid red";
        document.getElementById('oficina').focus();
        return false;
    }
    
    document.getElementById('proveedor').style.border='';
    if((document.getElementById('proveedor').value!='')&&(proveedor=='')) {
        document.getElementById('mensaje').innerHTML= '<img src="../images/info.gif" />&nbsp;ATENCI&Oacute;N: El proveedor ingresado no existe';                    
        document.getElementById('proveedor').style.border="2px solid red";
        document.getElementById('proveedor').focus();
        return false;
    }
    
    document.getElementById('adquiriente').style.border='';
    if((document.getElementById('adquiriente').value!='')&&(adquiriente=='')) {
        document.getElementById('mensaje').innerHTML= '<img src="../images/info.gif" />&nbsp;ATENCI&Oacute;N: El proveedor ingresado no existe';                    
        document.getElementById('adquiriente').style.border="2px solid red";
        document.getElementById('adquiriente').focus();
        return false;
    }
    
    if((nro=='')||(codeqD=='')||(codeq=='')||(marca=='')) {
       divMensaje.innerHTML= '<img src="../images/info.gif" />&nbsp;ATENCI&Oacute;N: Debe ingresar los datos requeridos';                    
       if(nro=='')
           document.getElementById('nro').style.border="2px solid red";
       if(codeqD=='')
            document.getElementById('codeq').style.border="2px solid red";
       if(marca=='')
            document.getElementById('marca').style.border="2px solid red";
       return false;              
    } else {
        if(codeq!='') {
           var eq_rx = codeq.substring(codeq.length, codeq.length-1);                            
           if(eq_rx=='N') {
               if((ma!='')||(kv!='')||(alimentacion!='0')) {
                    divMensaje.innerHTML= '<img src="../images/info.gif" />&nbsp;ATENCI&Oacute;N: La descripci&oacute;n no corresponde a un equipo RX';                                       
                    if(ma!='')
                        document.getElementById('ma').style.border="2px solid red";
                    if(kv!='')
                        document.getElementById('kv').style.border="2px solid red";
                    if(alimentacion!=0)
                        document.getElementById('alimentacion').style.border="2px solid red";                  
                    return false;
               }
           } else {                
                if(alimentacion==0) {
                    divMensaje.innerHTML= '<img src="../images/info.gif" />&nbsp;ATENCI&Oacute;N: Debe ingresar los datos del equipo RX';                                       
                    document.getElementById('alimentacion').style.border="2px solid red";                
                    return false;
                }
           }
       }  
       
        if(anioH==anioD) {
            if(mesH==mesD) {
                if(diaD>diaH) {
                    divMensaje.innerHTML= '<img src="../images/info.gif" />&nbsp;ATENCI&Oacute;N: Ha ingresado fechas incorrectas';                                       
                    return false;
                }
            }
            if(mesD>mesH) {
                divMensaje.innerHTML= '<img src="../images/info.gif" />&nbsp;ATENCI&Oacute;N: Ha ingresado fechas incorrectas';                                       
                return false;            
            }
        }
        if(anioD>anioH) {
            divMensaje.innerHTML= '<img src="../images/info.gif" />&nbsp;ATENCI&Oacute;N: Ha ingresado fechas incorrectas';                                       
            return false;    
        }
        
        ajax=objetoAjax();
        //usando del medoto POST
        //archivo que realizará la operacion
        ajax.open("POST", "guardaDatos.php" ,true);
        ajax.onreadystatechange=function() {
        if (ajax.readyState==1){
            divResultado.innerHTML= '<center><img src="../images/cargando.gif"><br/>Guardando los datos...</center>';
        } else if (ajax.readyState==4) {
                //mostrar los nuevos registros en esta capa
                divResultado.innerHTML = ajax.responseText;
                }
        }
        //muy importante este encabezado ya que hacemos uso de un formulario
        ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
        //enviando los valores            
        ajax.send("nro="+nro+"&codeq="+codeq+"&codeqD="+codeqD+"&marca="+marca+"&marcaD="+marcaD+"&modelo="+modelo+"&modeloD="+modeloD+"&nrose="+nrose+"&detalle="+detalle+"&edad="+edad+"&ofcodi="+ofcodi+"&ofcodiD="+ofcodiD+"&garantiaDesde="+garantiaDesde+"&garantiaHasta="+garantiaHasta+"&oc="+oc+"&proveedor="+proveedor+"&proveedorD="+proveedorD+"&manual="+manual+"&kv="+kv+"&ma="+ma+"&alimentacion="+alimentacion+"&intensificador="+intens+"&adquiriente="+adquiriente+"&servicio="+servicio+"&subservicio="+subservicio+"&eq_rx="+eq_rx);
        return true;
    }
}