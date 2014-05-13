// JavaScript Document

$(document).ready(function(){
	fn_buscar();
	$("#grilla tbody tr").mouseover(function(){
		$(this).addClass("over");
	}).mouseout(function(){
		$(this).removeClass("over");
	});
});



function fn_buscar(){
	var str = $("#frm_buscar").serialize();
	$.ajax({
		url: 'ajax_listar.php',
		type: 'get',
		data: str,
		success: function(data){
			$("#div_listar").html(data);
		}
	});
}

var RequestObject = false;
//directorio donde tenemos el archivo ajax.php
var Archivo = 'ajax_listar.php?fecha';
// el tiempo X que tardará en actualizarse 
window.setInterval("actualizacion_reloj()", 300000);

if (window.XMLHttpRequest) RequestObject = new XMLHttpRequest();
if (window.ActiveXObject) RequestObject = new ActiveXObject("Microsoft.XMLHTTP");

  function ReqChange() { 
  // Si se ha recibido la información correctamente
    if (RequestObject.readyState==4) {
     // si la información es válida 
     if (RequestObject.responseText.indexOf('invalid') == -1) {
     // Buscamos la div con id online 
       document.getElementById("div_listar").innerHTML = RequestObject.responseText;
     } else { 
      // Por si hay algun error document.getElementById("online").innerHTML = "Error llamando"; 
     }
    } 
  }

  function llamadaAjax() {
        // Mensaje a mostrar mientras se obtiene la información remota...
    document.getElementById("div_listar").innerHTML = ""; 
    // Preparamos la obtención de datos
    RequestObject.open("GET", Archivo , true);
    RequestObject.onreadystatechange = ReqChange; 
    // Enviamos
    RequestObject.send(null);
  }

  function actualizacion_reloj() {
   llamadaAjax();
  }