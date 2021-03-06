// JavaScript Document

$(document).ready(function(){
	fn_buscar();
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
}

function fn_eliminar(ide){
    var respuesta = confirm("Realmente esea eliminar el pedido?");
    if (respuesta){
        $.ajax({
            url: 'ajax_eliminar.php',
            data: 'ide=' + ide,
            type: 'post',
            success: function(data){
                if(data !== "")
                    alert(data);
                fn_buscar();
            }
        });
    }
}

function fn_mostrar_frm_eliminar(nro){
    $("#div_oculto").load("ajax_form_eliminar.php", {nro: nro}, function(){
        $.blockUI({
            message: $('#div_oculto'),
            css:{
                top: '20%'
            }
        }); 
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