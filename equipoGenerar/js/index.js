// JavaScript Document

$(document).ready(function(){
	
	$("#grilla tbody tr").mouseover(function(){
		$(this).addClass("over");
	}).mouseout(function(){
		$(this).removeClass("over");
	});
});

function fn_cerrar(){
	$.unblockUI({ 
		onUnblock: function(){
			$("#div_oculto").html("");
		}
	}); 
};

function fn_mostrar_frm_agregar(){
	$("#div_oculto").load("ajax_form_agregar.php", function(){
		$.blockUI({
			message: $('#div_oculto'),
			css:{
				top: '20%'
			}
		}); 
	});
};

function fn_mostrar_frm_modificar(ide_per){
	$("#div_oculto").load("ajax_form_modificar.php", {ide_per: ide_per}, function(){
		$.blockUI({
			message: $('#div_oculto'),
			css:{
				top: '20%'
			}
		}); 
	});
};



function fn_paginar(var_div, url){
	var div = $("#" + var_div);
	$(div).load(url);
	/*
	div.fadeOut("fast", function(){
		$(div).load(url, function(){
			$(div).fadeIn("fast");
		});
	});
	*/
}

function fn_eliminar(ide_ofi){
	var respuesta = confirm("Desea eliminar esta dependencia?");
	if (respuesta){
		$.ajax({
			url: 'ajax_eliminar.php',
			data: 'ide_ofi=' + ide_ofi,
			type: 'post',
			success: function(data){
				if(data!="")
					alert(data);
				fn_buscar()
			}
		});
	}
}

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

function fn_mostrar_frm_agregar_marca(ide_tipo){
    $("#div_oculto").load("ajax_form_agregar_marca.php", {ide_tipo: ide_tipo}, function(){
        $.blockUI({
            message: $('#div_oculto'),
            css:{
                top: '20%'
            }
        }); 
    });
};

function fn_mostrar_frm_agregar_adquiriente(){
	$("#div_oculto").load("ajax_form_agregar_adquiriente.php", function(){
		$.blockUI({
			message: $('#div_oculto'),
			css:{
				top: '20%'
			}
		}); 
	});
};

function fn_mostrar_frm_agregar_modelo(ide_tipo, ide_marca){
	$("#div_oculto").load("ajax_form_agregar_modelo.php", {ide_tipo: ide_tipo, ide_marca: ide_marca}, function(){
		$.blockUI({
			message: $('#div_oculto'),
			css:{
				top: '20%'
			}
		}); 
	});
};
