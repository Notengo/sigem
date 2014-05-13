function nuevoAjax()
{ 
	/* Crea el objeto AJAX. Esta funcion es generica para cualquier utilidad de este tipo, por
	lo que se puede copiar tal como esta aqui */
	var xmlhttp=false;
	try
	{
		// Creacion del objeto AJAX para navegadores no IE
		xmlhttp=new ActiveXObject("Msxml2.XMLHTTP");
	}
	catch(e)
	{
		try
		{
			// Creacion del objet AJAX para IE
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		catch(E)
		{
			if (!xmlhttp && typeof XMLHttpRequest!='undefined') xmlhttp=new XMLHttpRequest();
		}
	}
	return xmlhttp; 
}

// Declaro los selects que componen el documento HTML. Su atributo ID debe figurar aqui.
var listadoSelects=new Array();
listadoSelects[0]="categoria";
listadoSelects[1]="especialidades";
listadoSelects[2]="problema";

function buscarEnArray(array, dato)
{
	// Retorna el indice de la posicion donde se encuentra el elemento en el array o null si no se encuentra
	var x=0;
	while(array[x])
	{
		if(array[x]==dato) return x;
		x++;
	}
	return null;
}

function cargaContenido(idSelectOrigen)
{
	// Obtengo la posicion que ocupa el select que debe ser cargado en el array declarado mas arriba
	var posicionSelectDestino=buscarEnArray(listadoSelects, idSelectOrigen)+1;
	// Obtengo el select que el usuario modifico
	var selectOrigen=document.getElementById(idSelectOrigen);
        var opcionAnterior =0;
        if(selectOrigen.name=='categoria') {            
            if(document.getElementById('categoria').options[document.getElementById('categoria').selectedIndex].value==9999) {
                document.getElementById('nuevaCategoria').type='text';
            } else {
                document.getElementById('nuevaCategoria').type='hidden';
            }
        }
        if(selectOrigen.name=='especialidades') {
            opcionAnterior = document.getElementById('categoria').options[document.getElementById('categoria').selectedIndex].value;           
            if(document.getElementById('especialidades').options[document.getElementById('especialidades').selectedIndex].value==9999) {
                document.getElementById('nuevaEspecialidad').type='text';
            } else {
                document.getElementById('nuevaEspecialidad').type='hidden';
            }
        }
    
	// Obtengo la opcion que el usuario selecciono
	var opcionSeleccionada=selectOrigen.options[selectOrigen.selectedIndex].value;
        
	// Si el usuario eligio la opcion "Elige", no voy al servidor y pongo los selects siguientes en estado "Selecciona opcion..."
	if(opcionSeleccionada==0)
	{
		var x=posicionSelectDestino, selectActual=null;
		// Busco todos los selects siguientes al que inicio el evento onChange y les cambio el estado y deshabilito
		while(listadoSelects[x])
		{
			selectActual=document.getElementById(listadoSelects[x]);
			selectActual.length=0;
			
			var nuevaOpcion=document.createElement("option");nuevaOpcion.value=0;nuevaOpcion.innerHTML="Seleccione";
			selectActual.appendChild(nuevaOpcion);selectActual.disabled=true;
			x++;
		}
	}
	// Compruebo que el select modificado no sea el ultimo de la cadena
	else if(idSelectOrigen!=listadoSelects[listadoSelects.length-1])
	{
		// Obtengo el elemento del select que debo cargar
		var idSelectDestino=listadoSelects[posicionSelectDestino];
		var selectDestino=document.getElementById(idSelectDestino);
		// Creo el nuevo objeto AJAX y envio al servidor el ID del select a cargar y la opcion seleccionada del select origen
		var ajax=nuevoAjax();
     
                if(opcionAnterior==0)
                    ajax.open("GET", "selectDependientesProceso.php?select="+idSelectDestino+"&opcion="+opcionSeleccionada+"&opcion2=0", true);
                else 
                    ajax.open("GET", "selectDependientesProceso.php?select="+idSelectDestino+"&opcion="+opcionSeleccionada+"&opcion2="+opcionAnterior, true);
		ajax.onreadystatechange=function() 
		{ 
			if (ajax.readyState==1)
			{
				// Mientras carga elimino la opcion "Selecciona Opcion..." y pongo una que dice "Cargando..."
				selectDestino.length=0;
				var nuevaOpcion=document.createElement("option");nuevaOpcion.value=0;nuevaOpcion.innerHTML="Cargando...";
				selectDestino.appendChild(nuevaOpcion);selectDestino.disabled=true;	
			}
			if (ajax.readyState==4)
			{
				selectDestino.parentNode.innerHTML=ajax.responseText;
			} 
		}
		ajax.send(null);
	}
}

function cargaTProblema()
{
    if(document.getElementById('problema').options[document.getElementById('problema').selectedIndex].value==9999) {
                document.getElementById('nuevoTProblema').type='text';
            } else {
                document.getElementById('nuevoTProblema').type='hidden';
            }
}