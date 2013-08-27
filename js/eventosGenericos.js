function is_email(email) {
    var result = email.search(/^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z]{2,3})+$/);
    if (result > -1) {
        return true;
    } else {
        return false;
    }
}

function activarObjetoAjax(estado) {
    if (estado === 1)
        $('#ajaxModal').modal({backdrop: 'static', keyboard: false});
    if (estado === 0)
        $('#ajaxModal').modal('hide');
}

//Imprimir un vector json en un alert.
function print_r(arr, level) {
    var dumped_text = "";
    if (!level)
        level = 0;

//The padding given at the beginning of the line.
    var level_padding = "";
    for (var j = 0; j < level + 1; j++)
        level_padding += "    ";

    if (typeof(arr) == 'object') { //Array/Hashes/Objects 
        for (var item in arr) {
            var value = arr[item];

            if (typeof(value) == 'object') { //If it is an array,
                dumped_text += level_padding + "'" + item + "' ...\n";
                dumped_text += print_r(value, level + 1);
            } else {
                dumped_text += level_padding + "'" + item + "' => \"" + value + "\"\n";
            }
        }
    } else { //Stings/Chars/Numbers etc.
        dumped_text = "===>" + arr + "<===(" + typeof(arr) + ")";
    }
    return dumped_text;
}



function checkUsername(username) {
    var iChars = "!@#$%^&*()+=-[]\\';,./{}|\":<>?";
    if (username.search(" ") == -1) {
        for (var i = 0; i < username.length; i++) {
            if (iChars.indexOf(username.charAt(i)) != -1) {
                return false;
            }
        }
        return true;
    } else {
        return false;
    }
}

function clearconsole() {
    console.log(window.console);
    if (window.console || window.console.firebug) {
        console.clear();
    }
}

/*
 * Funcion Creada para mostrar mensajes del Informativos para el usuario
 * Parametros
 * idDiv del Div donde se mostrara el mensaje
 * tipoMensaje: Puede ser de 4 tipos: error, advertencia, informacion ó  exito
 * tituloMensaje: El titulo del mensaje para el usuario
 * mensaje: Es el mensaje que se va a mostrar al usuario
 * cerrarMensaje: variable booleana para permitir cerrar el mensaje
 */


function mostrarMensajeSistema(idDiv, tipoMensaje, tituloMensaje, mensaje, cerrarMensaje) {
     $('#' + idDiv).html('').removeClass();
    var claseMensaje ='';
    var botonCerrarMensaje = '<button type="button" class="close" data-dismiss="alert">&times;</button>';
    switch (tipoMensaje) {
        case 'error':
            claseMensaje='alert alert-error';
            break;
        case 'advertencia':
             claseMensaje='alert alert-block';
            break;
        case 'informacion':
             claseMensaje='alert alert-info';
            break;
        case 'exito':
             claseMensaje='alert alert-success';
            break;
    }
    if(!cerrarMensaje){
       botonCerrarMensaje=''; 
    }
    var titulo = '<h6>'+tituloMensaje+'</h6>';
    $('#' + idDiv).addClass(claseMensaje).html(botonCerrarMensaje+titulo+mensaje).css('display', 'block');
}

function ocultarMensajeSistema() {

}

