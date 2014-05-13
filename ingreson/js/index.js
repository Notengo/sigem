// JavaScript Document

$(document).ready(function(){
	fn_buscar();
	$("#grilla tbody tr").mouseover(function(){
		$(this).addClass("over");
	}).mouseout(function(){
		$(this).removeClass("over");
	});
});

function fn_mostrar_frm_asignar(nro, ofcodi, especialidad){
	$("#div_oculto").load("ajax_form_asignar.php", {nro: nro, ofcodi:ofcodi, especialidad:especialidad}, function(){
		$.blockUI({
			message: $('#div_oculto'),
			css:{
				top: '20%'
			}
		}); 
	});
};

function fn_mostrar_frm_modificar(nro, ofcodi, especialidad){
	$("#div_oculto").load("ajax_form_modificar.php", {nro: nro, ofcodi:ofcodi, especialidad:especialidad}, function(){
		$.blockUI({
			message: $('#div_oculto'),
			css:{
				top: '20%'
			}
		}); 
	});
};

function fn_mostrar_frm_estado(nro, usuario){
	$("#div_oculto").load("ajax_form_estado.php", {nro: nro, usuario: usuario}, function(){
		$.blockUI({
			message: $('#div_oculto'),
			css:{
				top: '20%'
			}
		}); 
	});
};

function fn_mostrar_frm_historial(nro){
	$("#div_oculto").load("ajax_form_historial.php", {nro: nro}, function(){
		$.blockUI({
			message: $('#div_oculto'),
			css:{
				top: '20%'
			}
		}); 
	});
};

function fn_cerrar(){
	$.unblockUI({ 
		onUnblock: function(){
			$("#div_oculto").html("");
		}
	}); 
};

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