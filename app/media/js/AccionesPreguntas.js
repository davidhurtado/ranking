var id, pregunta, lenguaje, accion, page;

/*RECIBIENDO LOS DATOS*/
function datos(id, pregunta, lenguaje, accion, page) {
    this.id = id;
    this.pregunta = pregunta;
    this.lenguaje = lenguaje;
    this.accion = accion;
    this.page = page;
       $('#estado_eliminar_lenguaje').html("");
}
function modal(titulo,tipo,input1,input2) {
    
    var label="";
      if(tipo==='opciones'){
        label="OPCION";
    }
    if(tipo==='lenguaje'){
        label="LENGUAJE";
    }
    
    $('#modal-titulo').html("<h4 class='modal-title' id='modal-titulo'>"+titulo+" "+label+"</h4>");
  
     $('#modal-label').html("<label id='modal-label'>"+label+"</label>");
    $('#modal-hidden').html("<input type='hidden'  name='modal-hidden' id='modal-hidden'/>");
    $('#modal-dato').html("<input type='text'  class='form-control' placeholder='INGRESE "+label+"' name='modal-dato' id='modal-dato'/>");
    $('#modal-boton').html("<button type='button' class='btn btn-primary' id='modal-boton'>"+titulo+"</button>");
console.log("si");
       //$('#estado_eliminar_lenguaje').html("");
}
/*AGREGAR LENGUAJE*/
$('#botonAgregarLenguaje').on('click', function () {

    $.ajax({
        method: 'POST',
        url: '/PlataformaRanking/json_lenguajes',
        data: {
            nombre: $('#agregar_lenguaje').val(),
            accion: 'agregar',
            page: 'preguntas'
        },
        success: function (response) {
            $('#id_lenguaje').append(response);
            $("#id_lenguaje").trigger("chosen:updated");
            $('#estado_agregar_lenguaje').html('<div class="alert alert-success">Lenguaje: <strong>' + $('#agregar_lenguaje').val() + '</strong> agregado.<br>Cierre la ventana y verifique en las opciones.</div>');
            $('#agregar_lenguaje').val('');
        }
    });
});

/*AGREGAR OPCIONES*/
$('.chosen').chosen({
    no_results_text: "No se encontraron resultados",
    placeholder_text_multiple: "Seleccione alternativas"
});
var seleccionados = document.getElementById('listaOpciones');
var letra = 1;
var opciones_select = document.getElementById('listaOpciones');
function agregar() {
    var opcion = document.getElementById('agregar_opcion').value;
    var opt = document.createElement('option');
    opt.appendChild(document.createTextNode(opcion));
    opt.value = opcion;
    opt.id = letra;
    opciones_select.appendChild(opt);
    letra++;
}
function ocultar_mensaje() {
    $('#estado_agregar').html('<div></div>');
    $('#estado_agregar_lenguaje').html('<div></div>');
}
$("#listaOpciones").change(function () {
    var myOpts = document.getElementById('respuesta');
    var first = document.getElementById('listaOpciones');
    var options = first.innerHTML;
    var second = document.getElementById('respuesta');
    second.innerHTML = "";
    second.className = "form-control";


    var opt = document.createElement('option');
    opt.appendChild(document.createTextNode("Ingrese la respuesta"));
    opt.value = "Ingrese la respuesta";
    opt.id = "#";
    myOpts.appendChild(opt);

    var opciones = seleccionados.options;
    for (i = 0; i < opciones.length; i++) {
        if (opciones[i].selected === true) {
            var grupos = opciones[i].text;
            var opt = document.createElement('option');
            opt.appendChild(document.createTextNode(grupos));
            opt.value = i + 1;
            opt.id = i + 1;
            myOpts.appendChild(opt);
            // console.log(grupos);
        }
    }
});
$('#botonAgregarOpcion').on('click', function () {

    $.ajax({
        method: 'POST',
        url: 'json_preguntas.php',
        data: {
            nombre: $('#agregar_opcion').val(),
            id: letra
        },
        success: function (response) {
            $('#listaOpciones').append(response);
            $("#listaOpciones").trigger("chosen:updated");
            $('#estado_agregar').html('<div class="alert alert-success">Opcion: <strong>' + $('#agregar_opcion').val() + '</strong> agregada.<br>Cierre la ventana y verifique en las opciones.</div>');
            $('#agregar_opcion').val('');
        }
    });
});

$('#botonEliminarPregunta').on('click', function () {
    $.ajax({
        method: 'POST',
        url: '/PlataformaRanking/json_preguntas',
        data: {
            id: id,
            pregunta: pregunta,
            lenguaje: lenguaje,
            accion: accion,
            page: page
        },
        success: function (response) {
            //console.log(" response-> " + response);
            $("#resultado").load('lista #tblDatos');
            $("#resultado").trigger("chosen:updated");
            //$('#estado_agregar_lenguaje').html('<div class="alert alert-success">Lenguaje: <strong>' + $('#agregar_lenguaje').val() + '</strong> agregado.<br>Cierre la ventana y verifique en las opciones.</div>');
            // $('#agregar_lenguaje').val('');
        }
    });
});

 /***********************************************************************************************************/

$('#botonEditarlenguaje').on('click', function () {
    $.ajax({
        method: 'POST',
        url: '/PlataformaRanking/json_lenguajes',
        data: {
            nombre_lenguaje: $('#editar-lenguaje-modal').val(),
            id_lenguaje: $('#id-lenguaje-hidden').val(),
            accion: 'editar'
        },
        success: function (response) {
            var mensaje;
            switch (response) {
                case '1':
                    mensaje = "<div class='alert alert-success'>Lenguaje: <strong>'" + $('#editar-lenguaje-modal').val() + "'</strong> editado.<br>Cierre la ventana y verifique</div>";
                    break;
                case '2':
                    mensaje = "<div class='alert alert-danger'><strong>No existe lenguaje</strong></div>";
                    break;
                case '3':
                    mensaje = "<div class='alert alert-danger'><strong>Ingrese lenguaje</strong> </div>";
                    break;
                default:
                    mensaje = "<div class='alert alert-danger'><strong>Error intente de nuevo</strong> </div>";
                    break;
            }
            $("#resultado").load('lista #tblDatos');
            $("#resultado").trigger("chosen:updated");
            $('#estado_editar_lenguaje').html(mensaje);
            $('#editar-lenguaje-modal').val('');
            //location.reload();
        }
    });
});
function ocultar_mensaje() {
    $('#estado_agregar').html('<div></div>');
    $('#estado_agregar_lenguaje').html('<div></div>');
    $('#estado_editar_lenguaje').html('<div></div>');
}
$('#botonAgregarLenguaje').on('click', function () {

    $.ajax({
        method: 'POST',
        url: '/PlataformaRanking/json_lenguajes',
        data: {
            nombre: $('#agregar_lenguaje').val(),
            accion: 'agregar',
            page: 'lista'
        },
        success: function (response) {
            //$('#resultado').append("<tr class='danger'><td>"+response[0]+"</td>"+response[1]+"<tr>");
            //console.log(response[0].value+" -> "+response[1]);
            $("#resultado").load('lista #tblDatos');
            $("#resultado").trigger("chosen:updated");
            $('#estado_agregar_lenguaje').html('<div class="alert alert-success">Lenguaje: <strong>' + $('#agregar_lenguaje').val() + '</strong> agregado.<br>Cierre la ventana y verifique en las opciones.</div>');
            $('#agregar_lenguaje').val('');
        }
    });
});
function datos_id(id, lenguaje) {
    $('#editar-lenguaje-modal').val(lenguaje);
    $('#id-lenguaje-hidden').val(id);
    $('#eliminar-lenguaje-modal').val(lenguaje);
    $('#id-eliminar-lenguaje-hidden').val(id);
    $('#estado_eliminar_lenguaje').html("");
}
$('#botonEliminarlenguaje').on('click', function () {
    $.ajax({
        method: 'POST',
        url: '/PlataformaRanking/json_lenguajes',
        data: {
            nombre: $('#eliminar-lenguaje-modal').val(),
            id: $('#id-eliminar-lenguaje-hidden').val(),
            accion: 'eliminar',
            page: 'lista'
        },
        success: function (response) {
            var mensaje;
            switch (response) {
                case '1':
                    mensaje = "<div class='alert alert-success'>Lenguaje eliminado.<br>Cierre la ventana y verifique</div>";
                    break;
                case '2':
                    mensaje = "<div class='alert alert-danger'><strong>No existe lenguaje</strong></div>";
                    break;
                case '3':
                    mensaje = "<div class='alert alert-danger'><strong>Seleccione lenguaje</strong> </div>";
                    break;
                default:
                    mensaje = "<div class='alert alert-danger'><strong>Error intente de nuevo</strong> </div>";
                    break;
            }
            $("#resultado").load('lista #tblDatos');
            $("#resultado").trigger("chosen:updated");
            $('#estado_eliminar_lenguaje').html(mensaje);
            $('#eliminar-lenguaje-modal').val('');
            $('#id-eliminar-lenguaje-hidden').val('');
        }
    });
});