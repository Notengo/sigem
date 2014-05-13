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
	if (!xmlhttp && typeof XMLHttpRequest!=='undefined') {
		xmlhttp = new XMLHttpRequest();
	}
	return xmlhttp;
}

function esInteger(e){
    var charCode;
    if (navigator.appName  ===  "Netscape") // Veo si es Netscape o Explorer (mas adelante lo explicamos)
        charCode = e.which; // leo la tecla que ingreso
    else
        charCode = e.keyCode; // leo la tecla que ingreso
    status = charCode;
    if (charCode > 31 && (charCode < 48 || charCode > 58)) { // Chequeamos que sea un numero comparandolo con los valores ASCII
        return false;
    }
    return true;
};

function asignar(identificador){
//    divResultado = document.getElementById('div_oculto');
    var usuario = document.getElementById('usuarios'+identificador).value;
    
    var divMensaje = document.getElementById('mensaje');
    divMensaje.innerHTML = '';

    ajax=objetoAjax();
    //usando del medoto POST
    //archivo que realizará la operacion
    ajax.open("POST", "asiganarUsuario.php" ,true);
    ajax.onreadystatechange=function() {
        if (ajax.readyState === 1){
            divResultado.innerHTML= '<center><img src="../images/cargando.gif"><br/>Guardando los datos...</center>';
        } else if (ajax.readyState === 4) {
            //mostrar los nuevos registros en esta capa
            divMensaje.innerHTML = ajax.responseText;
        }
    };
    //muy importante este encabezado ya que hacemos uso de un formulario
    ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
    //enviando los valores
    ajax.send("identificador="+identificador+"&usuario="+usuario);
    return true;
}

function guardarDatos(){
    document.getElementById('orden').style.border='';
    document.getElementById('usuario').style.border='';
    document.getElementById('fechaInicio').style.border='';
    document.getElementById('fechaFin').style.border='';
    document.getElementById('tarea').style.border='';
    document.getElementById('objetoTarea').style.border='';
    
    divResultado = document.getElementById('resultado');
//Comienzo recoleccion datos de la tarea.
    var orden = document.getElementById('orden').value;
    var usuario = document.getElementById('usuario').options[document.getElementById('usuario').selectedIndex].value;
    var fechaInicio = document.getElementById('fechaInicio').value;
    var fechaFin = document.getElementById('fechaFin').value;
    var tarea = document.getElementById('tarea').value;
    var objetoTarea = document.getElementById('objetoTarea').value;
    
    if(orden === ''){
        document.getElementById('orden').style.border='2px solid red';
        document.getElementById('orden').focus();
        return false;
    }
    if(usuario === ''){
        document.getElementById('usuario').style.border='2px solid red';
        document.getElementById('usuario').focus();
        return false;
    }
    if(fechaInicio === ''){
        document.getElementById('fechaInicio').style.border='2px solid red';
        document.getElementById('fechaInicio').focus();
        return false;
    }
    if(fechaFin === ''){
        document.getElementById('fechaFin').style.border='2px solid red';
        document.getElementById('fechaFin').focus();
        return false;
    }
    if(tarea === "0"){
        document.getElementById('tarea').style.border='2px solid red';
        document.getElementById('tarea').focus();
        return false;
    }
    if(objetoTarea === ''){
        document.getElementById('objetoTarea').style.border='2px solid red';
        document.getElementById('objetoTarea').focus();
        return false;
    }
//Fin recoleccion datos tarea.

//Comienzo recoleccion datos de repuestos.
    var listaRepuesto = document.getElementById('listaRepuesto');
    var listado = listaRepuesto.value.split('-');

    var cantidadRepuestos = 0;
    var repuesto = new Array();
    var repuestoc = new Array();
    var repuestom = new Array();
    for (i = 1; i < listado.length; i++){
        cantidadRepuestos++;
        repuesto[cantidadRepuestos] = listado[i];
        repuestoc[cantidadRepuestos] = document.getElementById('repuestoc'+listado[i]).value;
        repuestom[cantidadRepuestos] = document.getElementById('repuestom'+listado[i]).value;
    }
//Fin recoleccion datos repuestos.
    
    ajax=objetoAjax();
        //usando del medoto POST
        //archivo que realizará la operacion
        ajax.open("POST", "guardaDatos.php" ,true);
        ajax.onreadystatechange=function() {
        if (ajax.readyState===1){
            divResultado.innerHTML= '<center><img src="../images/cargando.gif"><br/>Guardando los datos...</center>';
        } else if (ajax.readyState===4) {
                //mostrar los nuevos registros en esta capa
                divResultado.innerHTML = ajax.responseText;
                }
        };
        //muy importante este encabezado ya que hacemos uso de un formulario
        ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
        //enviando los valores
        
        ajax.send("repuesto="+repuesto
                +"&repuestoc="+repuestoc
                +"&orden="+orden
                +"&usuario="+usuario
                +"&fechaInicio="+fechaInicio
                +"&fechaFin="+fechaFin
                +"&tarea="+tarea
                +"&objetoTarea="+objetoTarea
                +"&cantidadRepuestos="+cantidadRepuestos
                +"&repuestom="+repuestom);
        return true;
//    }
};

function repuestoAgregar(){
    var ident = document.getElementById('repuesto');
    alert(ident.value);
    if(ident.value === "0"){ return false; }
    var div = document.getElementById('respuestoDiv');
    if(!document.getElementsByName('repuesto'+ident.value)[0]){
        hijo = document.createElement('div');
        hijo.setAttribute('name', 'repuesto'+ident.value);
        hijo.setAttribute('id', 'repuesto'+ident.value);
        hijo.setAttribute('class', 'detalle');
        hijo.innerHTML = "Rep.: " + ident[ident.selectedIndex].text  + " | Monto: U$D " + document.getElementById('monto').value+ " | Cant.: " + document.getElementById('cantidad').value + " | Total: U$D " + document.getElementById('monto').value *document.getElementById('cantidad').value
+                "&nbsp;&nbsp;&nbsp;<img alt='borra' src='../css/img_estilos/cancela.png' onclick='borrarRepuesto(\""+ident.value+"\")'/>";
        div.appendChild(hijo);
        document.getElementById('listaRepuesto').value = document.getElementById('listaRepuesto').value + "-" + ident.value;
        
        
        hijo = document.createElement('input');
        hijo.setAttribute('name', 'repuestom'+ident.value);
        hijo.setAttribute('id', 'repuestom'+ident.value);
        hijo.setAttribute('type', 'hidden');
        div.appendChild(hijo);
        document.getElementById('repuestom'+ident.value).value = document.getElementById('monto').value;
        
        hijo = document.createElement('input');
        hijo.setAttribute('name', 'repuestoc'+ident.value);
        hijo.setAttribute('id', 'repuestoc'+ident.value);
        hijo.setAttribute('type', 'hidden');
        div.appendChild(hijo);
        document.getElementById('repuestoc'+ident.value).value = document.getElementById('cantidad').value;
    }
}

function borrarRepuesto(id){
    var repuesto = document.getElementById('repuesto'+id);
    repuesto.parentNode.removeChild(repuesto);
    
    var repuesto = document.getElementById('repuestoc'+id);
    repuesto.parentNode.removeChild(repuesto);
    
    var repuesto = document.getElementById('repuestom'+id);
    repuesto.parentNode.removeChild(repuesto);

    var listaRepuesto = document.getElementById('listaRepuesto');
    var listado = listaRepuesto.value.split('-');

    var lista = "";
    for (i = 1; i < listado.length; i++){
        if(id !== listado[i] && listado[i] !== '') lista += "-"+listado[i];
    }
    document.getElementById('listaRepuesto').value = lista;
}

function accionObjetoDependiente(accion){
//    alert(accion);
    var divMensaje = document.getElementById('divAccionObjeto');
    ajax=objetoAjax();
    ajax.open("POST", "accionObjetoDependiente.php" ,true);
    ajax.onreadystatechange=function() {
        if (ajax.readyState === 1){
            divResultado.innerHTML= '<center><img src="../images/cargando.gif"><br/>Guardando los datos...</center>';
        } else if (ajax.readyState === 4) {
            //mostrar los nuevos registros en esta capa
            divMensaje.innerHTML = ajax.responseText;
        }
    };
    //muy importante este encabezado ya que hacemos uso de un formulario
    ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
    //enviando los valores
    ajax.send("accion="+accion);
    return true;
}