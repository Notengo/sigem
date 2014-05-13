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



function buscarEscuela(){
   var escuela = document.formulario.escuela_hidden.value;
   if(escuela==0) {
       document.getElementById('falta_escuela').style.display='inline';    
       return false;
   } else {
        formulario.submit();
        return true;
   }
}

function modificarDatosEscuela(){
   divResultado = document.getElementById('resultado');  
   var escuela = document.formulario.escuela_hidden.value;
   var anio = document.getElementById('anio').value;
   var nro = document.getElementById('nro').value;
   if(escuela==0) {
       document.getElementById('falta_escuela').style.display='inline';    
       return false;
   } else {
        ajax=objetoAjax();
        //usando del medoto POST
        //archivo que realizará la operacion
        ajax.open("POST", "guardaModificacionEscuela.php" ,true);
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
        ajax.send("cue="+escuela+"&anio="+anio+"&nro="+nro);
        return true;
   }
}

function guardarDatos(){
    divResultado = document.getElementById('resultado');    
    var nro = document.getElementById('nro').value;
    var ofcodi = document.getElementById('oficina_hidden').value; 
    var prioridad = document.getElementById('prioridad').options[document.getElementById('prioridad').selectedIndex].value;
    var recepcion = document.getElementById('recepcion').options[document.getElementById('recepcion').selectedIndex].value;
    var categoria = document.getElementById('categoria').options[document.getElementById('categoria').selectedIndex].value;
    var especialidades = document.getElementById('especialidades').options[document.getElementById('especialidades').selectedIndex].value;
    var problema = document.getElementById('problema').options[document.getElementById('problema').selectedIndex].value;
    var descripcion = document.getElementById('descripcion').value;
    var tipoEquipo = document.getElementById('tipoEquipo').options[document.getElementById('tipoEquipo').selectedIndex].value;
    var usoEquipo = document.getElementById('usoEquipo').options[document.getElementById('usoEquipo').selectedIndex].value;
    var nroEquipo = document.getElementById('equipo').value; 
    var agente = document.getElementById('agente_hidden').value; 
    var nuevaCategoria = "";
    var nuevaEspecialidad = "";
    var nuevoProblema = "";
    if(categoria==9999) {
        nuevaCategoria = document.getElementById('nuevaCategoria').value;        
    }
    if(especialidades==9999) {
        nuevaEspecialidad = document.getElementById('nuevaEspecialidad').value;        
    }
    if(problema==9999) {
        nuevoProblema = document.getElementById('nuevoTProblema').value;        
    }
    var error=0;
    if((categoria==9999)&&(nuevaCategoria=="")) {
         error=1;
    }
    if((especialidades==9999)&&(nuevaEspecialidad=="")) {
         error=1;
    }
    if((problema==9999)&&(nuevoProblema=="")) {
         error=1;
    }
    divMensaje = document.getElementById('mensaje');    
    divMensaje.innerHTML= '';
    if((agente=='')&&(document.getElementById('agente').value!='')) {
        divMensaje.innerHTML= '<img src="../images/info.gif" />&nbsp;ATENCI&Oacute;N: El usuario ingresado no existe';             
       return false;
    }        
    if((error==1)||(categoria==0)||(especialidades==0)||(problema==0)||(ofcodi=="")) {
       divMensaje.innerHTML= '<img src="../images/info.gif" />&nbsp;ATENCI&Oacute;N: Debe ingresar todos los datos requeridos';             
       return false;
    } else {
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
        ajax.send("nro="+nro+"&ofcodi="+ofcodi+"&prioridad="+prioridad+"&recepcion="+recepcion+"&categoria="+categoria+"&especialidades="+especialidades+"&problema="+problema+"&descripcion="+descripcion+"&nuevaCategoria="+nuevaCategoria+"&nuevaEspecialidad="+nuevaEspecialidad+"&nuevoProblema="+nuevoProblema+"&nroEquipo="+nroEquipo+"&agente="+agente+"&usoEquipo="+usoEquipo+"&tipoEquipo="+tipoEquipo);
        return true;
    }
}

function modificarDatosNinio(){
    divResultado = document.getElementById('resultado');    
    var nro = document.getElementById('nro').value;
    var anio = document.getElementById('anio').value;
    var dni = document.getElementById('dni').value;
    var nombre = document.getElementById('nombre').value;
    for(i=0; i < document.formulario.sexo.length; i++){    
        if(document.formulario.sexo[i].checked){
            sexo = document.formulario.sexo[i].value;
        }
    }        
    var fnac = document.getElementById('fnac').value;
    var edad = document.getElementById('edad').value;
    var domicilio = document.getElementById('domicilio').value;
    var telefono = document.getElementById('telefono').value;
    var grado = document.getElementById('grado').value;
    var division = document.getElementById('division').value;
    var turno = document.getElementById('turno').value;     
    for(i=0; i < document.formulario.cobertura.length; i++){    
        if(document.formulario.cobertura[i].checked){
            cobertura = document.formulario.cobertura[i].value;
        }
    }   
    var coberturaDescri = document.getElementById('coberturaDescri').value;    
    for(i=0; i < document.formulario.prematuro.length; i++){    
        if(document.formulario.prematuro[i].checked){
            prematuro = document.formulario.prematuro[i].value;
        }
    } 
    var pesoNacimiento = document.getElementById('pesoNacimiento').value;
    var desempeno = document.getElementById('desempeno').value;
    for(i=0; i < document.formulario.desempeno.length; i++){    
        if(document.formulario.desempeno[i].checked){
            desempeno = document.formulario.desempeno[i].value;
        }
    }     
    for(i=0; i < document.formulario.repitente.length; i++){    
        if(document.formulario.repitente[i].checked){
            repitente = document.formulario.repitente[i].value;
        }
    }     
    document.getElementById("grado").style.borderColor ='';
    document.getElementById("dni").style.borderColor = '';
    divMensaje = document.getElementById('mensaje');    
    divMensaje.innerHTML= '';
    
    if((dni=='')||(grado=='')) {
       divMensaje.innerHTML= '<img src="../images/info.gif" />&nbsp;ATENCI&Oacute;N: debe ingresar al menos el DNI y el Grado del ni&ntilde;o para poder generar la planilla';
       if(grado=='') {
            document.getElementById("grado").style.borderColor = "red"; 
            document.getElementById("grado").focus();       
       }
       if(dni=='') {
            document.getElementById("dni").style.borderColor = "red"; 
            document.getElementById("dni").focus();       
       }            
       return false;
    } else {
    ajax=objetoAjax();
    //usando del medoto POST
    //archivo que realizará la operacion
    ajax.open("POST", "guardaModificacionNinio.php" ,true);
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
    ajax.send("nro="+nro+"&anio="+anio+"&dni="+dni+"&nombre="+nombre+"&grado="+grado+"&sexo="+sexo+"&fnac="+fnac+"&edad="+edad+"&domicilio="+domicilio+"&telefono="+telefono+"&division="+division+"&turno="+turno+"&cobertura="+cobertura+"&coberturaDescri="+coberturaDescri+"&prematuro="+prematuro+"&pesoNacimiento="+pesoNacimiento+"&desempeno="+desempeno+"&repitente="+repitente);
    return true;
    }
}

function IsNum(obj) { 
    divMensaje = document.getElementById('mensaje');                
    if (isNaN(obj.value)){         
        divMensaje.innerHTML= '<img src="../images/info.gif" />&nbsp;El dato ingresado no es valido';
        obj.focus();
        obj.style.borderColor='red';
        return false; 
    } else { 
        divMensaje.innerHTML='';
        obj.style.borderColor='';
        return true; 
    } 
} 

function IsNumTa(obj) { 
    divMensaje = document.getElementById('mensaje');                
    if (isNaN(obj.value)){         
        divMensaje.innerHTML= '<img src="../images/info.gif" />&nbsp;El dato ingresado no es valido';
        obj.focus();
        obj.style.borderColor='red';
        return false; 
    } else {
        divMensaje.innerHTML='';
        obj.style.borderColor='';
//        if (obj.id == 'tamax'){
//            if (obj.value > 100)
//                document.getElementById("ptamax").value = '75/100';
//            if (obj.value == 100)
//                document.getElementById("ptamax").value = 75;
//            if (obj.value == 90)
//                document.getElementById("ptamax").value = 50;
//            if (obj.value == 80)
//                document.getElementById("ptamax").value = 25;
//            if (obj.value < 80)
//                document.getElementById("ptamax").value = '00/25';
//        }
//        if (obj.id == 'tamin'){
//            if (obj.value > 70)
//                document.getElementById("ptamin").value = '75/100';
//            if (obj.value == 70)
//                document.getElementById("ptamin").value = 75;
//            if (obj.value == 60)
//                document.getElementById("ptamin").value = 50;
//            if (obj.value == 50)
//                document.getElementById("ptamin").value = 25;
//            if (obj.value < 50)
//                document.getElementById("ptamin").value = '00/25';
//        }

        divMensaje.innerHTML='';
        obj.style.borderColor='';

        var nro = document.getElementById('nro').value ;
        var anio = document.getElementById('anio').value;
        ajax=objetoAjax();
         //usando del medoto POST
         //archivo que realizará la operacion
         var divResultado = document.getElementById('resultado');
         ajax.open("POST", "calcularTa.php" ,true);
         ajax.onreadystatechange=function() {
            if (ajax.readyState==1){
               divResultado.innerHTML= '<center><img src="../images/cargando.gif"><br/>Buscando los datos...</center>';
            } else if (ajax.readyState==4) {
               //mostrar los nuevos registros en esta capa
               divResultado.innerHTML = ajax.responseText;
               if (obj.id == 'tamax'){
                   document.getElementById('ptamax').value = document.getElementById('ptamax_aux').value;
               }
               if (obj.id == 'tamin'){
                   document.getElementById('ptamin').value = document.getElementById('ptamin_aux').value;
               }
            }
         }
         //muy importante este encabezado ya que hacemos uso de un formulario
         ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
         //enviando los valores
         ajax.send(obj.id+"="+obj.value+"&nro="+nro+"&anio="+anio);
         return true;


        return true; 
    } 
} 

function IsNumEstatura(obj) { 
    divMensaje = document.getElementById('mensaje');                
    if (isNaN(obj.value)){         
        divMensaje.innerHTML= '<img src="../images/info.gif" />&nbsp;El dato ingresado no es valido';
        obj.focus();
        obj.style.borderColor='red';
        return false; 
    } else { 
        divMensaje.innerHTML='';
        obj.style.borderColor='';
        /*
         * Necesito para calcular el percentil.
         * la edad y el sexo y la altura.
         * 
         */
        var nro = document.getElementById('nro').value ;
        var anio = document.getElementById('anio').value;
        ajax=objetoAjax();
         //usando del medoto POST
         //archivo que realizará la operacion
         var divResultado = document.getElementById('resultado');
         ajax.open("POST", "calcularEstatura.php" ,true);
         ajax.onreadystatechange=function() {
            if (ajax.readyState==1){
               divResultado.innerHTML= '<center><img src="../images/cargando.gif"><br/>Buscando los datos...</center>';
            } else if (ajax.readyState==4) {
               //mostrar los nuevos registros en esta capa
               divResultado.innerHTML = ajax.responseText;
               document.getElementById('ptalla').value = document.getElementById('perTalla').value;
               calcularIMC();
            }
         }
         //muy importante este encabezado ya que hacemos uso de un formulario
         ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
         //enviando los valores
         ajax.send("nro="+nro+"&anio="+anio+"&estatura="+obj.value);
         return true;
    }
} 

function IsNumPeso(obj) { 
    divMensaje = document.getElementById('mensaje');                
    if (isNaN(obj.value)){         
        divMensaje.innerHTML= '<img src="../images/info.gif" />&nbsp;El dato ingresado no es valido';
        obj.focus();
        obj.style.borderColor='red';
        return false; 
    } else { 
        divMensaje.innerHTML='';
        obj.style.borderColor='';
        /*
         * Necesito para calcular el percentil.
         * la edad y el sexo y la altura.
         */
        var nro = document.getElementById('nro').value ;
        var anio = document.getElementById('anio').value;
        ajax=objetoAjax();
         //usando del medoto POST
         //archivo que realizará la operacion
         var divResultado = document.getElementById('resultado');
         ajax.open("POST", "calcularPeso.php" ,true);
         ajax.onreadystatechange=function() {
            if (ajax.readyState==1){
               divResultado.innerHTML= '<center><img src="../images/cargando.gif"><br/>Buscando los datos...</center>';
            } else if (ajax.readyState==4) {
               //mostrar los nuevos registros en esta capa
               divResultado.innerHTML = ajax.responseText;
               document.getElementById('ppeso').value = document.getElementById('perPeso').value;
               calcularIMC();
            }
         }
         //muy importante este encabezado ya que hacemos uso de un formulario
         ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
         //enviando los valores
         ajax.send("nro="+nro+"&anio="+anio+"&peso="+obj.value);
         return true;
    }
} 

function calcularIMC() { 
   var peso = document.getElementById('peso').value ;
   var talla = document.getElementById('talla').value;
   if(peso > 0 && talla > 0){
      talla /=100;
      var imc = peso/(talla*talla);
      document.getElementById('imc').value = imc.toFixed(2);
      
      var nro = document.getElementById('nro').value ;
      var anio = document.getElementById('anio').value;
      ajax=objetoAjax();
      //usando del medoto POST
      //archivo que realizará la operacion
      var divResultado = document.getElementById('resultado');
      ajax.open("POST", "calcularImc.php" ,true);
      ajax.onreadystatechange=function() {
         if (ajax.readyState==1){
            divResultado.innerHTML= '<center><img src="../images/cargando.gif"><br/>Buscando los datos...</center>';
         } else if (ajax.readyState==4) {
            //mostrar los nuevos registros en esta capa
            divResultado.innerHTML = ajax.responseText;
            document.getElementById('pimc').value = document.getElementById('perImc').value;
         }
      }
      //muy importante este encabezado ya que hacemos uso de un formulario
      ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
      //enviando los valores
      ajax.send("nro="+nro+"&anio="+anio+"&imc="+imc.toFixed(2));
      
      return true;
   } else {
      document.getElementById('imc').value = 0;
      document.getElementById('pimc').value = 0;
      return false;
   }
} 

function imprSelec(muestra)
{var ficha=document.getElementById(muestra);
    var ventimp=window.open(' ','popimpr');
        var contenido = "<html><head><link href='../css/impresion.css' rel='stylesheet' type='text/css' media='print'></head><body onload='window.print();'>" +ficha.innerHTML + "</body></html>";
    ventimp.document.write(contenido);
    ventimp.document.close();
    ventimp.print();
    ventimp.close();
}
