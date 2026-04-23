// JavaScript Document
 
// Función para recoger los datos de PHP según el navegador, se usa siempre.
function objetoAjax(){
    var xmlhttp=false;
	try {
        xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
	} catch (e) {

        try {
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        } catch (E) {
            xmlhttp = false;
        }
    }
 
    if (!xmlhttp && typeof XMLHttpRequest!='undefined') {
        xmlhttp = new XMLHttpRequest();
    }
    return xmlhttp;
} 

//Función para recoger los datos del formulario y enviarlos por post  
function verPublicados(){

    //div donde se mostrará lo resultados
    divResultado = document.getElementById('listado_procesos');
    //recogemos los valores de los inputs
    

    //instanciamos el objetoAjax
    ajax=objetoAjax();
 
    //uso del medotod POST
    //archivo que realizará la operacion
    //registro.php
    ajax.open("POST", "consulta_procesos.php",true);
    //cuando el objeto XMLHttpRequest cambia de estado, la función se inicia
    ajax.onreadystatechange=function() {
        //la función responseText tiene todos los datos pedidos al servidor
        if (ajax.readyState==4) {
  		    //mostrar resultados en esta capa
            divResultado.innerHTML = ajax.responseText;
  		    //llamar a funcion para limpiar los inputs
            //LimpiarCampos();
        }
    }
	//ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	//enviando los valores a registro.php para que inserte los datos
	ajax.send();
}

//Función para recoger los datos del formulario y enviarlos por post  
function eliminarBibliografia(id,curso){
    var id = id;

    //div donde se mostrará lo resultados
    divResultado = document.getElementById('listadoBli');
    //recogemos los valores de los inputs
    //instanciamos el objetoAjax
    ajax=objetoAjax();
 
    //uso del medotod POST
    //archivo que realizará la operacion
    //registro.php
    ajax.open("POST", "eliminarBli.php",true);
    //cuando el objeto XMLHttpRequest cambia de estado, la función se inicia
    ajax.onreadystatechange=function() {
        //la función responseText tiene todos los datos pedidos al servidor
        if (ajax.readyState==4) {
            //mostrar resultados en esta capa
            divResultado.innerHTML = ajax.responseText
            //llamar a funcion para limpiar los inputs
        }
    }
    ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
    //enviando los valores a registro.php para que inserte los datos
    ajax.send("id="+id+"&idcurso="+curso)
}
 
//función para limpiar los campos
function LimpiarCampos(){
    document.nueva_bibliografia.bliautor.value="";
    document.nueva_bibliografia.blititulo.value="";
    document.nueva_bibliografia.blieditorial.value="";
    document.nueva_bibliografia.bliciudad.value="";
    document.nueva_bibliografia.blianio.value="";
}

//Función para recoger los datos del formulario y enviarlos por post  
function enviarDatosCibergrafia(){
    //div donde se mostrará lo resultados
    divResultado = document.getElementById('listadoCib');
    //recogemos los valores de los inputs
    ape=document.nueva_cibergrafia.cibapellidonombre.value;
    tit=document.nueva_cibergrafia.cibtitulo.value;
    edi=document.nueva_cibergrafia.cibedicion.value;
    lug=document.nueva_cibergrafia.ciblugar.value;
    ani=document.nueva_cibergrafia.cibanio.value;
    url=document.nueva_cibergrafia.ciburl.value;
    fec=document.nueva_cibergrafia.cibfecha.value;
    cur=document.nueva_cibergrafia.idcurso.value;

    //instanciamos el objetoAjax
    ajax=objetoAjax();
 
    //uso del medotod POST
    //archivo que realizará la operacion
    //registro.php
    ajax.open("POST", "registroCib.php",true);
    //cuando el objeto XMLHttpRequest cambia de estado, la función se inicia
    ajax.onreadystatechange=function() {
        //la función responseText tiene todos los datos pedidos al servidor
        if (ajax.readyState==4) {
            //mostrar resultados en esta capa
            divResultado.innerHTML = ajax.responseText
            //llamar a funcion para limpiar los inputs
            LimpiarCamposCib();
        }
    }
    ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
    //enviando los valores a registro.php para que inserte los datos
    ajax.send("apellidonombre="+ape+"&titulo="+tit+"&edicion="+edi+"&lugar="+lug+"&anio="+ani+"&url="+url+"&fecha="+fec+"&idcurso="+cur)
}

//Función para recoger los datos del formulario y enviarlos por post  
function eliminarCibergrafia(id,curso){

    var id = id;

    //div donde se mostrará lo resultados
    divResultado = document.getElementById('listadoCib');
    //recogemos los valores de los inputs
    //instanciamos el objetoAjax
    ajax=objetoAjax();
 
    //uso del medotod POST
    //archivo que realizará la operacion
    //registro.php
    ajax.open("POST", "eliminarCib.php",true);
    //cuando el objeto XMLHttpRequest cambia de estado, la función se inicia
    ajax.onreadystatechange=function() {
        //la función responseText tiene todos los datos pedidos al servidor
        if (ajax.readyState==4) {
            //mostrar resultados en esta capa
            divResultado.innerHTML = ajax.responseText
            //llamar a funcion para limpiar los inputs
        }
    }
    ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
    //enviando los valores a registro.php para que inserte los datos
    ajax.send("id="+id+"&idcurso="+curso)
}
 
//función para limpiar los campos
function LimpiarCamposCib(){
    document.nueva_cibergrafia.cibapellidonombre.value="";
    document.nueva_cibergrafia.cibtitulo.value="";
    document.nueva_cibergrafia.cibedicion.value="";
    document.nueva_cibergrafia.ciblugar.value="";
    document.nueva_cibergrafia.cibanio.value="";
    document.nueva_cibergrafia.ciburl.value="";
    document.nueva_cibergrafia.cibfecha.value="";
}
