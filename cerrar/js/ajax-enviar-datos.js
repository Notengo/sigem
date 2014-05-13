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

function guardarDatos(){
    divResultado = document.getElementById('resultado'); 
    var orden = document.getElementById('orden').value;
    var usuario = document.getElementById('usuario').options[document.getElementById('usuario').selectedIndex].value;
    var fechaFin = document.getElementById('fechaFin').value;
    var fechaRetirado = document.getElementById('fechaRetirado').value;
    
    var f = new Date();
    var anio  =  parseInt(fechaFin.substring(0,4),10);
    var mes  =  parseInt(fechaFin.substring(5,7),10);
    var dia =  parseInt(fechaFin.substring(8),10);
    
    if(f.getFullYear() < anio){
        alert("La fecha debe ser menor o igual al año actual.");
        return false;
    }
    if((f.getMonth()+1) < mes){
        alert("El mes debe ser menor o igual al mes actual.");
        return false;
    }
    if(f.getDate() < dia){
        alert("El dia debe ser menor o igual al dia actual.");
        return false;
    }

    /*
     * Inicio de controles de la carga de los datos.
     */
    document.getElementById('fechaRetirado').style.border='';
    document.getElementById('fechaFin').style.border='';

    if(fechaFin === '') {
//        document.getElementById('mensaje').innerHTML= '<img src="../images/info.gif" />&nbsp;ATENCI&Oacute;N: La fecha ingresada no es valida.';
        document.getElementById('fechaFin').style.border="2px solid red";
        document.getElementById('fechaFin').focus();
        return false;
    }
    
    if(fechaRetirado === '') {
//        document.getElementById('mensaje').innerHTML= '<img src="../images/info.gif" />&nbsp;ATENCI&Oacute;N: La fecha ingresada no es valida.';
//        document.getElementById('fechaRetirado').style.border="2px solid red";
//        document.getElementById('fechaRetirado').focus();
//        return false;
        fechaRetirado = "0000-00-00";
    }

    ajax=objetoAjax();
    //usando del medoto POST
    //archivo que realizará la operacion
    ajax.open("POST", "guardaDatos.php" ,true);
    ajax.onreadystatechange=function() {
    if (ajax.readyState === 1){
        divResultado.innerHTML= '<center><img src="../images/cargando.gif"><br/>Guardando los datos...</center>';
    } else if (ajax.readyState === 4) {
            //mostrar los nuevos registros en esta capa
            divResultado.innerHTML = ajax.responseText;
            }
    };
    //muy importante este encabezado ya que hacemos uso de un formulario
    ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
    //enviando los valores

    ajax.send("orden="+orden+
            "&fechaFin="+fechaFin+
            "&fechaRetirado="+fechaRetirado+
            "&usuario="+usuario);
    return true;
}


function soloFecha(evt){
    //asignamos el valor de la tecla a keynum
    if(window.event){// IE
    keynum = evt.keyCode;
    }else{ // otro navegador
    keynum = evt.which;
    }
    if((keynum>47 && keynum<58)||(keynum==0)||(keynum==13)||(keynum==8)||(keynum==47)){
        return true;
    } else {
        return false;
    }
}

function fechaControl(valor, evento){
    var valor1 = document.getElementById(valor);
    if(window.event){// IE
        keynum = evento.keyCode;
    } else { // otro navegador
        keynum = evento.which;
    }

    if(keynum===8 && valor1.value.length === 2) {
        valor1.value = valor1.value.substring(0,1);
        return true;
    }
    
    if(keynum===8 && valor1.value.length === 5) {
        valor1.value = valor1.value.substring(0,4);
        return true;
    }
    
    if(valor1.value.length===2||valor1.value.length===5){
        valor1.value=valor1.value+"/";
    };
}

function validarFecha(fecha){
    if (fecha !==  undefined && fecha.value !==  "" ){
        if (!/^\d{2}\/\d{2}\/\d{4}$/.test(fecha.value)){            
            fecha.style.borderColor='brown';
            fecha.focus();
            return false;
        }
        var dia  =  parseInt(fecha.value.substring(0,2),10);
        var mes  =  parseInt(fecha.value.substring(3,5),10);
        var anio =  parseInt(fecha.value.substring(6),10);
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
            if (comprobarSiBisisesto(anio)){ numDias=29; }else{ numDias=28; };
            break;
        default:                                 
            fecha.focus();
            fecha.style.borderColor='brown';
            return false;
    }
 
        if (dia>numDias || dia === 0){                        
	    fecha.focus();
            fecha.style.borderColor='brown';
            return false;
        }
        fecha.style.borderColor='';
        validaMayorQue(fecha, anio, mes, dia);
        return true;
    }
}

function cerrar(cierra) {
    div = document.getElementById(cierra);
    div.style.display='none';
    document.formulario.descripcion.value="";   
    document.formulario.abreviatura.value="";   
}