// Login Form
var correoRegistro ='';
$(document).ready(function() {

    $('#formularioLogin').submit(function() {

        $("#infor_entrando").removeClass("ocultar");
        $("#infor_entrando").addClass("mostrar");
        $.ajax({
            type: 'POST',
            url: 'funciones/funciones.php',
            data: $(this).serialize(),
            beforeSend: function(data) {
                activarObjetoAjax(1);
            },
            success: function(data) {
                var dataJson = eval(data);
                var estado = dataJson[0].estado;
                if (estado == '1') {
                    $("#infor_entrando").addClass("ocultar");
                    $("#infor_error").addClass("ocultar");
                    $("#infor_confirmacion").removeClass("ocultar");
                    $("#infor_confirmacion").addClass("mostrar");
                    window.location = 'index.php';
                }
                else {
                    if (estado == '2') {
                        $("#infor_entrando").addClass("ocultar");
                        $("#infor_error").addClass("ocultar");
                        $("#infor_confirmacion").removeClass("ocultar");
                        $("#infor_confirmacion").addClass("mostrar");
                        window.location = 'index.php';
                    } else {

                        $("#infor_entrando").addClass("ocultar");
                        $("#infor_confirmacion").addClass("mostrar");
                        $("#infor_error").removeClass("ocultar");
                        $("#infor_error").addClass("mostrar");
                        $('#username_login').val('');
                        $('#password_login').val('');
                    }
                }
            },
            complete: function() {
                activarObjetoAjax(0);
            }
        })
        return false;
    });


    $('#formularioRecovery').submit(function() {
        $("#esperandoConfirmacion").css("display", "block");
        $.ajax({
            type: 'POST',
            url: 'funciones/funciones.php',
            data: $(this).serialize(),
            beforeSend: function(data) {
                activarObjetoAjax(1);
            },
            success: function(data) {
                var dataJson = eval(data);
                var estado = dataJson[0].estado;
                if (estado == '1') {
                    $("#sinConfirmacion").css("display", "none");
                    $("#esperandoConfirmacion").css("display", "none");
                    cuentaRegresivaRecovery();
                }
                else {
                    if (estado == '0') {
                        $("#sinConfirmacion").css("display", "block");
                        $("#esperandoConfirmacion").css("display", "none");
                    }
                }
            },
            complete: function() {
                activarObjetoAjax(0);
            }
        })
        return false;
    });



    $('#formularioRegistro').submit(function() {
        $('#informacionRegistro').html("Enviando Datos...");
        if (comprobarCaracter($('#username').val()) == true) {
            $.ajax({
                type: 'POST',
                url: 'funciones/funciones.php',
                data: $(this).serialize(),
                beforeSend: function(data) {
                    activarObjetoAjax(1);
                },
                success: function(data) {
                    var dataJson = eval(data);
                    var estado = dataJson[0].estado;
                    if (estado == '1') {
                        activarObjetoAjax(0);
                        $("#titulo_registro_usuario").css("display", "none");
                        $("#frmRegistroUsuario").css("display", "none");
                        $("#formularioIngreso").css("display", "none");
                        $("#titulo_iniciar_sesion").css("display", "none");
                        $("#confirmarCuenta").css('display', 'block');
                        $("#titulo_confirmar_cuenta").css("display", "block");
                        $("#cuentaCorreo").html($("#email_register").val());

                    } else {
                        activarObjetoAjax(0);
                        $('#informacionRegistro').html("El nombre de usuario o email ya estan en uso.");
                        $('#informacionRegistro').css('color', 'Red');
                        $('#username').val('');
                        $('#email_register').val('');
                    }
                },
                complete: function() {
                    activarObjetoAjax(0);
                }
            })
        } else {
            $('#informacionRegistro').html("No utilizar caracteres extraños.");
            $('#informacionRegistro').css('color', 'Red');
            $('#username').val('');
            $('#email_register').val('');
        }
        return false;
    });
});

$(function() {
    var button = $('#loginButton');
    var box = $('#loginBox');
    var form = $('#loginForm');
    button.removeAttr('href');
    button.mouseup(function(login) {
        box.toggle();
        button.toggleClass('active');
    });
    form.mouseup(function() {
        return false;
    });
    $(this).mouseup(function(login) {
        if (!($(login.target).parent('#loginButton').length > 0)) {
            button.removeClass('active');
            box.hide();
        }
    });
});

var tiempo = 6;
function cuentaRegresiva() {
    if (tiempo > 0) {
        tiempo--;
    }
    else {
        window.location = 'paginas/partituras.php';
    }
    $('#informacionRegistro').css('color', 'Green');
    $('#informacionRegistro').html("Registrado Correctamente, redireccionando en " + tiempo);
    setTimeout("cuentaRegresiva()", 1000)
}
var tiempo = 8;
function cuentaRegresivaRecovery() {
    if (tiempo > 0) {
        tiempo--
    }
    else {
        window.location = 'index.php';
    }
    $("#Confirmacionhecha").css("display", "block");
    setTimeout("cuentaRegresivaRecovery()", 1000)
}




function comprobarCaracter(username) {
    for (var i = 0; i < username.length; i++) {
        if (username.charAt(i) == '#' || username.charAt(i) == '*' || username.charAt(i) == '#?' || username.charAt(i) == '¿')
            return false;
    }
    return true;
}

function limpiaForm(miForm) {
// recorremos todos los campos que tiene el formulario
    $(":input", miForm).each(function() {
        var type = this.type;
        var tag = this.tagName.toLowerCase();
//limpiamos los valores de los campos…
        if (type == "text" || type == "password" || tag == "textarea" || type == "email")
            this.value = "";
// excepto de los checkboxes y radios, le quitamos el checked
// pero su valor no debe ser cambiado
        else if (type == "checkbox" || type == "radio")
            this.checked = false;
// los selects le ponesmos el indice a -
        else if (tag == "select")
            this.selectedIndex = -1;
    });
}