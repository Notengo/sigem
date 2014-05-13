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
    var fecha = document.getElementById('fecha').value;
    
    var f = new Date();
//    alert(f.getFullYear() +"-"+ (f.getMonth() +1) + "-" +f.getDate() );
    var anio  =  parseInt(fecha.substring(0,4),10);
    var mes  =  parseInt(fecha.substring(5,7),10);
    var dia =  parseInt(fecha.substring(8),10);
    
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
    
    var establecimiento = document.getElementById('establecimiento').value;
    var solicitante = document.getElementById('solicitante').value;     
    var prioridad = document.getElementById('prioridad').value;   
    var recepcion = document.getElementById('recepcion').value;
    var equipo = document.getElementById('equipo').value;  
    var estado = document.getElementById('estado').value;
    var observacion = document.getElementById('observacion').value;
    var listapedido = document.getElementById('listaPedido');
    var listasintoma = document.getElementById('listaSintoma');
    var establecimiento_h = document.getElementById('establecimiento_hidden').value;
    var servicio1 = document.getElementById('servicio1_hidden').value;
    var accesorios = document.getElementById('accesorios').value;


// Controlar que los datos ingresados son correctos.
// Si los mismos son incorrectos indicar que deben de ser cargados.
// Falta ver si se ingreso la ubicacion, servicio y motivo de traslados nuevos.
    
    divMensaje = document.getElementById('mensaje');    
    divMensaje.innerHTML= '';
    
    /*
     * Inicio de controles de la carga de los datos.
     */
    document.getElementById('fecha').style.border='';
    document.getElementById('establecimiento').style.border='';
    document.getElementById('solicitante').style.border='';
    document.getElementById('prioridad').style.border='';
    document.getElementById('recepcion').style.border='';
    document.getElementById('equipo').style.border='';
    document.getElementById('estado').style.border='';
    document.getElementById('observacion').style.border='';
    document.getElementById('pedido').style.border='';
    document.getElementById('sintoma').style.border='';
    
    /* Para cuando se realiza el cambio de ubicacion */
        var nuevaubic = '';
        var nuevaserv = '';
        var nuevamoti = '';
    if(document.getElementById('cambiohabilita').value === 'si'){
        document.getElementById('cambioubicacion').style.border="";
        nuevaubic = document.getElementById('nuevaubic_hidden').value;
        nuevaserv = document.getElementById('nuevaserv_hidden').value;
        nuevamoti = document.getElementById('nuevamoti').value;
        if(nuevaubic === '' || nuevaserv === '' || nuevamoti === '') {
            document.getElementById('cambioubicacion').style.border="2px solid red";
            document.getElementById('mensaje').innerHTML= '<img src="../images/info.gif" />&nbsp;ATENCI&Oacute;N: Complete los datos del traslado.';
            return false;
        }
    }
    
    document.getElementById('fecha').style.border='';
//    if(!validarFecha(fecha)) {
    if(fecha === '') {
        document.getElementById('mensaje').innerHTML= '<img src="../images/info.gif" />&nbsp;ATENCI&Oacute;N: La fecha ingresada no es valida.';
        document.getElementById('fecha').style.border="2px solid red";
        document.getElementById('fecha').focus();
        return false;
    }

    if((establecimiento_h === '')) {
        document.getElementById('mensaje').innerHTML= '<img src="../images/info.gif" />&nbsp;ATENCI&Oacute;N: Debe ingresar un establecimiento.';
        document.getElementById('establecimiento').style.border="2px solid red";
        document.getElementById('establecimiento').focus();
        return false;
    }
    
    if(document.getElementById('equipo').value === '') {
        document.getElementById('mensaje').innerHTML= '<img src="../images/info.gif" />&nbsp;ATENCI&Oacute;N: Debe ingresar un equipo';
        document.getElementById('equipo').style.border="2px solid red";
        document.getElementById('equipo').focus();
        return false;
    }
    
    if(estado === 'T') {
        document.getElementById('mensaje').innerHTML= '<img src="../images/info.gif" />&nbsp;ATENCI&Oacute;N: Seleccione un estado valido.';                    
        document.getElementById('estado').style.border="2px solid red";
        document.getElementById('estado').focus();
        return false;
    }
    
    if(listapedido.value === '') {
//        document.getElementById('mensaje').innerHTML= '<img src="../images/info.gif" />&nbsp;ATENCI&Oacute;N: Seleccione un pedido de trabajo.';                    
//        document.getElementById('pedido').style.border="2px solid red";
//        document.getElementById('pedido').focus();
//        return false;
        listapedido.value = -17;
    }
    
    if(listasintoma.value === '') {
//        document.getElementById('mensaje').innerHTML= '<img src="../images/info.gif" />&nbsp;ATENCI&Oacute;N: Seleccione un pedido de trabajo.';                    
//        document.getElementById('sintoma').style.border="2px solid red";
//        document.getElementById('sintoma').focus();
//        return false;
        listasintoma.value = -1;
    }
//    if((nro=='')||(codeqD=='')||(codeq=='')||(marca=='')) {
//       divMensaje.innerHTML= '<img src="../images/info.gif" />&nbsp;ATENCI&Oacute;N: Debe ingresar los datos requeridos';
//       return false;
//    } else {
        ajax=objetoAjax();
        //usando del medoto POST
        //archivo que realizará la operacion
        ajax.open("POST", "guardaDatos.php" ,true);
        ajax.onreadystatechange=function() {
        if (ajax.readyState === 1){
            divResultado.innerHTML= '<center><img src="../images/cargando.gif"><br/>Guardando los datos...</center>';
        } else if (ajax.readyState==4) {
                //mostrar los nuevos registros en esta capa
                divResultado.innerHTML = ajax.responseText;
                }
        }
        //muy importante este encabezado ya que hacemos uso de un formulario
        ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
        //enviando los valores
            
        ajax.send("equipo="+equipo+
                "&fecha="+fecha+
                "&establecimiento="+establecimiento+
                "&solicitante="+solicitante+
                "&prioridad="+prioridad+
                "&recepcion="+recepcion+
                "&estado="+estado+
                "&observacion="+observacion+
                "&listapedido="+listapedido.value+
                "&listasintoma="+listasintoma.value+
                "&establecimiento_h="+establecimiento_h+
                "&nuevaubic="+nuevaubic+
                "&nuevaserv="+nuevaserv+
                "&nuevamoti="+nuevamoti+
                "&servicio1="+servicio1+
                "&accesorios="+accesorios+
                "&cambio="+document.getElementById('cambiohabilita').value);
        return true;
//    }
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
    if (fecha !=  undefined && fecha.value !=  "" ){
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
            if (comprobarSiBisisesto(anio)){ numDias=29 }else{ numDias=28};
            break;
        default:                                 
            fecha.focus();
            fecha.style.borderColor='brown';
            return false;
    }
 
        if (dia>numDias || dia == 0){                        
	    fecha.focus();
            fecha.style.borderColor='brown';
            return false;
        }
        fecha.style.borderColor='';
        validaMayorQue(fecha, anio, mes, dia);
        return true;
    }
}

function agregarPedido(id){
    var pedido = document.getElementById(id);
    var div = document.getElementById('divPedido');
    if(!document.getElementsByName('pedido'+pedido.value)[0]){
        hijo = document.createElement('div');
        hijo.setAttribute('name', 'pedido'+pedido.value);
        hijo.setAttribute('id', 'pedido'+pedido.value);
        hijo.setAttribute('class', 'detalle');
        hijo.innerHTML = pedido.value+" - "+pedido[pedido.selectedIndex].text +
                "&nbsp;&nbsp;&nbsp;<img alt='borra' src='../css/img_estilos/cancela.png' onclick='borrarPedido(\""+pedido.value+"\")'/>";
        div.appendChild(hijo);
        
       document.getElementById('listaPedido').value = document.getElementById('listaPedido').value + "-" + pedido.value;
    }
}
function borrarPedido(id){
    var pedido = document.getElementById('pedido'+id);
    pedido.parentNode.removeChild(pedido);
    var listapedido = document.getElementById('listaPedido');
    var listado = listapedido.value.split('-');
    var lista = "";
    for (i = 1; i < listado.length; i++){
        if(id !== listado[i] && listado[i] !== '') lista += "-"+listado[i];
    }
    document.getElementById('listaPedido').value = lista;
}
function agregarSintoma(id){
    var sintoma = document.getElementById(id);
    var div = document.getElementById('divSintoma');
    if(!document.getElementsByName('sintoma'+sintoma.value)[0]){
        hijo = document.createElement('div');
        hijo.setAttribute('name', 'sintoma'+sintoma.value);
        hijo.setAttribute('id', 'sintoma'+sintoma.value);
        hijo.setAttribute('class', 'detalle');
        hijo.innerHTML = sintoma.value+" - "+sintoma[sintoma.selectedIndex].text +
                "&nbsp;&nbsp;&nbsp;<img alt='borra' src='../css/img_estilos/cancela.png' onclick='borrarSintoma(\""+sintoma.value+"\")'/>";
        div.appendChild(hijo);
        document.getElementById('listaSintoma').value = document.getElementById('listaSintoma').value + "-" + sintoma.value;
    }
}

function borrarSintoma(id){
    var sintoma = document.getElementById('sintoma'+id);
    sintoma.parentNode.removeChild(sintoma);
    
    var listasintoma = document.getElementById('listaSintoma');
    var listado = listasintoma.value.split('-');
    var lista = "";
    for (i = 1; i < listado.length; i++){
        if(id !== listado[i] && listado[i] !== '') lista += "-"+listado[i];
    }
    document.getElementById('listaSintoma').value = lista;
}

function cargarEquipo(equipo){
    if (!equipo){ return false; };
//    var divResultado = document.getElementById('div_oculto');
    var divResultado = document.getElementById('aparato');
    var establecimiento = document.getElementById('establecimiento_hidden');
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
                document.getElementById('serv').innerHTML = document.getElementById('h_serv').value + "&nbsp;&nbsp;&nbsp; <img src='../images/editar.png' onclick='habilitaCambio();'>";
                document.getElementById('ubic').innerHTML = document.getElementById('h_ubic').value;
                document.getElementById('equipo').style.border = "";
                document.getElementById('mensaje').innerHTML = "";
            } else {
                document.getElementById('mensaje').innerHTML= '<img src="../images/info.gif" />&nbsp;ATENCI&Oacute;N: El equipo especificado no fue encontrado.';
                document.getElementById('equipo').style.border="2px solid red";
                document.getElementById('equipo').focus();
            }
    //        document.getElementById('serv').innerHTML = document.getElementById('h_serv').innerHTML
    //        document.getElementById('ubic').innerHTML = document.getElementById('h_ubic').innerHTML
        }
    };
    //muy importante este encabezado ya que hacemos uso de un formulario
    ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");

    ajax.send("equipo="+equipo+"&establecimiento="+establecimiento.value);
    return true;
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

function cerrar(cierra) {
    div = document.getElementById(cierra);
    div.style.display='none';
    document.formulario.descripcion.value="";   
    document.formulario.abreviatura.value="";   
}