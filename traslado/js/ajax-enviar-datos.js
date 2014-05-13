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
    var equipo = document.getElementById('equipo').value;
    var nuevaubic = document.getElementById('nuevaubic_hidden').value;
    var nuevaserv = document.getElementById('nuevaserv_hidden').value;
    var nuevamoti = document.getElementById('nuevamoti_hidden').value;
    
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
    ajax.send("equipo="+equipo+
            "&nuevaubic="+nuevaubic+
            "&nuevaserv="+nuevaserv+
            "&nuevamoti="+nuevamoti);
    return true;
}

function guardarDatosRecibido(){
    divResultado = document.getElementById('resultado'); 
    var equipo = document.getElementById('equipo').value;

    ajax=objetoAjax();
    //usando del medoto POST
    //archivo que realizará la operacion
    ajax.open("POST", "guardarDatosRecibido.php" ,true);
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
    ajax.send("equipo="+equipo);
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

function cargarEquipo(equipo){
    if (!equipo){ return false; };
//    var divResultado = document.getElementById('div_oculto');
    var divResultado = document.getElementById('aparato');
    
    ajax=objetoAjax();
    //archivo que realizará la operacion
    ajax.open("POST", "buscarEquipo.php" ,true);
    ajax.onreadystatechange=function() {
        if (ajax.readyState === 1){
            divResultado.innerHTML= '<center><img src="../images/cargando.gif"><br/>Guardando los datos...</center>';
        } else if (ajax.readyState === 4) {
            //mostrar los nuevos registros en esta capa
            divResultado.innerHTML = ajax.responseText;
            if(document.getElementById('h_encontrado').value === 'si'){
                document.getElementById('desc').innerHTML = document.getElementById('h_desc').value;
                document.getElementById('seri').innerHTML = document.getElementById('h_seri').value;
                document.getElementById('mode').innerHTML = document.getElementById('h_mode').value;
                document.getElementById('prov').innerHTML = document.getElementById('h_prov').value;
                document.getElementById('falt').innerHTML = document.getElementById('h_falt').value;
                document.getElementById('edad').innerHTML = document.getElementById('h_edad').value;
                document.getElementById('manu').innerHTML = document.getElementById('h_manu').value;
                document.getElementById('serv').innerHTML = document.getElementById('h_serv').value;
                document.getElementById('ubic').innerHTML = document.getElementById('h_ubic').value;
                document.getElementById('equipo').style.border = "";
                document.getElementById('mensaje').innerHTML = "";
            } else {
                document.getElementById('mensaje').innerHTML= '<img src="../images/info.gif" />&nbsp;ATENCI&Oacute;N: El equipo especificado no fue encontrado.';
                document.getElementById('equipo').style.border="2px solid red";
                document.getElementById('equipo').focus();
            }
        }
    };
    //muy importante este encabezado ya que hacemos uso de un formulario
    ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");

    ajax.send("equipo="+equipo
                +"&confirma=S");
    return true;
}

function cargarEquipoRecibido(equipo){
    if (!equipo){
        return false;
    } else {
        if(cargarEquipo(equipo)){
            var divResultado = document.getElementById('aparato1');

            ajax1=objetoAjax();
            //archivo que realizará la operacion
            ajax1.open("POST", "buscarEquipoEnviado.php" ,true);
            ajax1.onreadystatechange=function() {
                if (ajax1.readyState === 1){
                    divResultado.innerHTML= '<center><img src="../images/cargando.gif"><br/>Guardando los datos...</center>';
                } else if (ajax.readyState === 4) {
                    //mostrar los nuevos registros en esta capa
                    divResultado.innerHTML = ajax1.responseText;
                    document.getElementById('nuevaserv').innerHTML = document.getElementById('h_serv1').value;
                    document.getElementById('nuevaubic').innerHTML = document.getElementById('h_ubic1').value;
                    document.getElementById('nuevamoti').innerHTML = document.getElementById('h_moti1').value;
                }
            };
            //muy importante este encabezado ya que hacemos uso de un formulario
            ajax1.setRequestHeader("Content-Type","application/x-www-form-urlencoded");

            ajax1.send("equipo="+equipo+"&confirma=N");
            return true;
        }
    }
}

function habilitaCambio(){
    if(document.getElementById('cambiohabilita').value === 'no'){
        var cambio1 = document.getElementById('cambioubicacion');
        cambio1.style.display = 'inline';
        document.getElementById('cambiohabilita').value = 'si';
    } else {
        var cambio1 = document.getElementById('cambioubicacion');
        cambio1.style.display = 'none';
        document.getElementById('cambiohabilita').value = 'no';
    }
}