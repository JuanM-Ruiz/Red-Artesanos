function logincorrecto(){
	$('#logincorrecto').modal('show');

}

function nav(active){
	var perfil = document.getElementById("perfil");
	var albums = document.getElementById("albums");
	var seguidores = document.getElementById("seguidores");
	switch (active) {
    case 1:
        perfil.className= "active";
        albums.className= "";
        seguidores.className= "";
        break;
    case 2:
        perfil.className= "";
        albums.className= "active";
        seguidores.className= "";
        break;
    case 3:
        perfil.className= "";
        albums.className= "";
        seguidores.className= "active";
        break;
    default: 
        perfil.className= "";
        albums.className= "";
        seguidores.className= "";
    }
}


function vmodal(idfoto){
$('.thumbnail').click(function(){
$('.afoto').removeAttr("onclick");
      $('.modal-b-mod').empty();
    var title = $(this).parent('a').attr("title");
    var idf = $(this).parent('a').attr("value");

    $('.modal-t-mod').html(title);
    $('#com1').html("<textarea name='com' id='com' onkeyup='autosize();' class='pull-left' rows='1' ></textarea> <input type='hidden' id='idf' value='"+ idf+"'>");
    $($(this).parents('div').html()).appendTo('.modal-b-mod');
    cargarcomentarios(idfoto);
    $('#myModal').modal({show:true});
});

}



function autosize(){
var el = document.querySelector('#com');
  setTimeout(function(){
    el.style.cssText = 'height:auto; padding:0';
    el.style.cssText = 'height:' + (el.scrollHeight+5) + 'px';
  },0);
}


// carga comentarios a una foto 
//========================================================
function cargarcomentarios(idfoto) {
	var xmlHttp;
	if (window.ActiveXObject){
		xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
	}else{
		xmlHttp = new XMLHttpRequest();
	}
	
	var dato = "idfoto=" + idfoto;
	var re = document.getElementById("comentarios");
	
	xmlHttp.onreadystatechange = function () {
		if(xmlHttp.readyState === 4 && xmlHttp.status === 200){
			
			var mensaje = xmlHttp.responseText;
			re.innerHTML=mensaje + "<span id='final'></span>";
		}
		
	}
	xmlHttp.open("POST", "cargarcomentarios.php", true);
	xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlHttp.send(dato);
// colback
}

// crear comnetario
// ======================================================

function crearcomentario(iduser ,user){
	var xmlHttp;
	if (window.ActiveXObject){
		xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
	}else{
		xmlHttp = new XMLHttpRequest();
	}
	var comentario = document.getElementById("com");
	if (comentario.value != "") {
		
	var idfoto = document.getElementById("idf");
	
	var dato = "idfoto=" + idfoto.value + "&idusuario="+iduser+"&comentario="+comentario.value;
	var re = document.getElementById("comentarios");
	
	
	xmlHttp.open("POST", "crearcomentario.php", true);
	xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlHttp.send(dato);
	recargar(idfoto.value, user, comentario.value);
	}
}


// borrar comentario
// ===========================================
function borrarComentario(idcomentario, idfoto){
	
	var xmlHttp;
	if (window.ActiveXObject){
		xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
	}else{
		xmlHttp = new XMLHttpRequest();
	}

	var dato = "idcomentario=" + idcomentario;
	
	xmlHttp.open("POST", "borrarcomentario.php", true);
	xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlHttp.send(dato);
	cargarcomentarios(idfoto);
	cargarcomentarios(idfoto);
}

// recarga los comentarios despues de crear comentario
// ====================================================

function recargar(idfoto ,user, comentario){
	var coment = document.getElementById("com");
	coment.value="";
	cargarcomentarios(idfoto);
	cargarcomentarios(idfoto);
}

function redirpag(url) {
	location.href =url;
}

function mod(idalbum){
	var modificar = document.getElementById("modalbum");
	modificar.value=idalbum;
}

function modf(idfoto , privacidad, titulo){
	var	rad1 = document.getElementById("rad1");
	var	rad2 = document.getElementById("rad2");
	var	titl = document.getElementById("titl");
	var	idfot = document.getElementById("idfot");
	idfot.value=idfoto;
	if (titl!="") {
	titl.value=titulo;
	}
	if (privacidad == 1) {
		rad.checked =true;
	}else{
		rad1.checked =true;
	}

	$('#modf').modal('show');
}

function borraralbum (idalbum) {
	if(confirm('¿Desea eliminar el album?'))
	{
		location.href ="albums.php?id="+idalbum;
	}
}

function borrarf(idfoto){
	if(confirm('¿Desea eliminar la foto?'))
	{
		location.href ="fotos.php?borrarf="+idfoto;
	}
	
}
// seleccion las fotos a subir con un limite de 20
function anadirfoto (cantidad){
	
	var cont = document.getElementById("c");
	var url = document.getElementById("foto"+cont.value);
	var contenedorfoto = document.getElementById("fotofile");
	var contenedortitulo = document.getElementById("titulo-cont");
	var contenedorradio1 = document.getElementById("radio-cont1");
	var contenedorradio2 = document.getElementById("radio-cont2");
	if(url.value != ""){
		// cuenta cuantas fotos se han ingresado
		idfiles = parseInt(cont.value);

		// determina la cantidad de fotos que se pueden ingresar
		var fotos =  document.getElementsByClassName('select-inputs');
		cant =  20 - cantidad;
		
		if (cant >= fotos.length) {
			// genera input titulo
			var titulo = document.getElementById("titulo"+idfiles);
			titulo.className="form-control borrar-file";
			if (cant != fotos.length) {
			var titulos=document.createElement('input');
			titulos.id = "titulo"+(idfiles+1);
			titulos.type = "text"
			titulos.className= "form-control";
			titulos.name="titulo[]";
			titulos.placeholder="Ingresa un titulo";
			contenedortitulo.appendChild(titulos);

			}
			// generar radios 

			var rad1 = document.getElementById("oradio");
			var rad2 = document.getElementById("oradio1");
			
			var radi1=document.createElement('input');
			radi1.id = "radio"+(idfiles);
			radi1.type = "hidden";
			radi1.name="privacidad[]";
			contenedorradio1.appendChild(radi1);

			if (rad1.checked  == true) {
			
				radi1.value = rad1.value ;
			}else {
				
				radi1.value = rad2.value ;
			}
			

			contenedorradio1.removeChild(rad1);
 			contenedorradio2.removeChild(rad2);

			if (cant != fotos.length) {
			var radio1=document.createElement('input');
			radio1.id = "oradio";
			radio1.type = "radio";
			radio1.value= "1";
			radio1.checked =true;
			radio1.name="priv";
			contenedorradio1.appendChild(radio1);

			var radio2=document.createElement('input');
			radio2.id = "oradio1";
			radio2.type = "radio";
			radio2.value= "0";
			radio2.name="priv";
			contenedorradio2.appendChild(radio2);
			}
			// crea los distintos labels para las fotos seleccionadas con sus atributos
			var url = document.getElementById("foto"+idfiles);
			var label=document.createElement('label');
			label.id = idfiles;
			label.title="Quitar";
			if (titulo.value!= ""){
			label.innerHTML = titulo.value;
			}else {
				label.innerHTML = "img";
			}
			label.className= "label-seleccion";
			contenedorfoto.appendChild(label);
			var seleclabel = document.getElementById(idfiles);
			seleclabel.setAttribute("onclick" , "borrarfoto ('foto"+idfiles+"', "+idfiles+")");
			idfiles = idfiles + 1;

			// esconde el input actual y genera uno nuevo para agregar
			// otra foto si no se han seleccionado mas de 20.
			url.setAttribute("class", "form-control borrar-file select-inputs");

			if (cant != fotos.length) {
			var input=document.createElement('input');
			input.type='file';
			input.id = 'foto'+idfiles;
			input.className= 'form-control select-inputs';
			input.name='fotos[]';
			contenedorfoto.appendChild(input);
			}
			document.getElementById("c").value = idfiles;
			document.getElementById("idradios").value = idradios;
			
			


		} else {
			var url = document.getElementById("foto"+idfiles);
			url.setAttribute("class", "form-control borrar-file select-inputs");
		}
		document.getElementById("c").value = idfiles;
	}
}	

function Comprobar (){
	 var url = document.getElementsByClassName("borrar-file");
	 var aviso = document.getElementById("avisoenvio");
	 var formfoto = document.getElementById("formfoto");
	if(url[0] === undefined){
		aviso.innerHTML = "Seleccione al menos una imagen";
	}else {
		formfoto.submit();
	}
	
}

function CancelarSubida() {
	setTimeout('document.location.reload()',100);
}
	
// borra fotos de la seleccion.
function borrarfoto (idinput , id){
	// contenedores
	var contenedorfoto = document.getElementById("fotofile");
	var contenedortitulo = document.getElementById("titulo-cont");
	var contenedorradio1 = document.getElementById("radio-cont1");
	var contenedorradio2 = document.getElementById("radio-cont2");
	// input files
	var url = document.getElementById(idinput);
	var label = document.getElementById(id);
	// input title
	var titulo = document.getElementById("titulo"+id);
	//input radio
	var rad1 = document.getElementById("radio"+id);
	
	// borra input files
	contenedorfoto.removeChild(url);
	contenedorfoto.removeChild(label);

	// borra input title
	contenedortitulo.removeChild(titulo);

	// borra input radio

	contenedorradio1.removeChild(rad1);	

}

function cargarfotos() {
	var xmlHttp;
	if (window.ActiveXObject){
		xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
	}else{
		xmlHttp = new XMLHttpRequest();
	}
	var cant = document.getElementById("cantfotos").value;
	var dato = "dato=" + cant;
	var re = document.getElementById("otronombre");
	
	xmlHttp.onreadystatechange = function () {
		if(xmlHttp.readyState === 4 && xmlHttp.status === 200){

			var mensaje = xmlHttp.responseText;
			re.innerHTML+=mensaje;
			if (mensaje != "") {
				cant = parseInt(cant);
				document.getElementById("cantfotos").value = cant+10;
			}
		}
		
	}
	xmlHttp.open("POST", "cuerpoindex.php", true);
	xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlHttp.send(dato);

}


