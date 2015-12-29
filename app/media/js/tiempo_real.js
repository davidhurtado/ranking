
var RequestObject = false;
//directorio donde tenemos el archivo ajax.php
var Archivo = datos[0];
var div = datos[1];
var tabla = datos[2];
// el tiempo X que tardará en actualizarse 
window.setInterval("actualizacion_reloj()", 1000);
if (window.XMLHttpRequest)
    RequestObject = new XMLHttpRequest();
if (window.ActiveXObject)
    RequestObject = new ActiveXObject("Microsoft.XMLHTTP");
function ReqChange() {
    // Si se ha recibido la información correctamente
    if (RequestObject.readyState === 4) {
        // si la información es válida 
        if (RequestObject.responseText.indexOf('invalid') === -1) {
            // Buscamos la div con id online 
            $(this.div).html(RequestObject.responseText);
        } //else {
        //Por si hay algun error
        //   $("#resultado").html("Error al actualizar lista");
        // }
    }
}
function llamadaAjax() {
    // Mensaje a mostrar mientras se obtiene la información remota...
    // document.getElementById("resultado").innerHTML = "";
    $(this.div).load(this.Archivo + ' ' + this.tabla);
    // Preparamos la obtención de datos
    RequestObject.open("GET", Archivo + "?" + Math.random(), true);
    RequestObject.onreadystatechange = ReqChange;
    // Enviamos
    RequestObject.send(null);
}
function actualizacion_reloj() {
    llamadaAjax();
}
function datos_page(controlador, div, tabla) {
    this.Archivo = controlador;
    this.div = div;
    this.tabla = tabla;
}