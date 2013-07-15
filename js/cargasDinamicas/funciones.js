$(document).ready(function() {
    $(".boton").click(function() {
        $(".error").remove();
        if ($(".code").val() == "") {
            $(".code").focus().after("<br><span class='error btn btn-small btn-danger'>Por favor Ingrese su Nombre y Apellido</span>");
            return false;
        } else if ($(".user").val() == "") {
            $(".user").focus().after("<br><span class='error btn btn-small btn-danger'>Por favor Ingrese su Nombre de Usuario</span>");
            return false;
        } else if ($(".pass").val() == "") {
            $(".pass").focus().after("<br><span class='error btn btn-small btn-danger'>Ingrese su Contraseña</span>");
            return false;
        } else if ($(".confirm_pass").val() == "") {
            $(".confirm_pass").focus().after("<br><span class='error btn btn-small btn-danger'>Confirme su Contraseña</span>");
            return false;
        } else if ($(".confirm_pass").val() != $(".pass").val()) {
            $(".confirm_pass").focus().after("<br><span class='error btn btn-small btn-danger'>Las Contraseñas no coinciden</span>");
            return false;
        } else if ($(".email_register").val() == "" || !is_email($(".email_register").val())) {
            $(".email_register").focus().after("<br><span class='error btn btn-small btn-danger'>Por favor Ingrese un Correo Válido</span>");
            return false;
        }


        if ($("#terminosCondiciones").is(':checked')) {
            return true;
        } else {
            $(".terminosCondiciones").focus().after("<span class='error error-terminos btn btn-small btn-danger'>No has aceptado los Terminos y Condiciones de Partituras Musicales.</span>");
            return false;
        }



    });
    $(".code, .user, .pass, .confirm_pass, .email_register").keyup(function() {
        if ($(this).val() != "") {
            $(".error").fadeOut();
            return false;
        }
    });

    $('#terminosCondiciones').change(function() {
        $(".error-terminos").css('display', 'none');
    });


    $('#micheckbox').change(function() {
        var checkeado = $(this).attr("checked");
        if (checkeado) {
            alert('activado');
        } else {
            alert('desactivado');
        }
    });


    $(".botonLogin").click(function() {
        $(".errorLogin").remove();
        if ($(".user_login").val() == "") {
            $(".user_login").focus().after("<br><span class='errorLogin btn btn-small btn-danger'>Por favor Ingrese su Nombre de Usuario</span>");
            return false;
        } else if ($(".pass_login").val() == "") {
            $(".pass_login").focus().after("<br><span class='errorLogin btn btn-small btn-danger'>Por favor Ingrese su Contraseña</span>");
            return false;
        }
    });
    $(".user_login, .pass_login").keyup(function() {
        if ($(this).val() != "") {
            $(".errorLogin").fadeOut();
            return false;
        }
    });



    $(".recuperar_datos").click(function() {
        $(".errorRecuperar").remove();

        if ($(".caja_recuperar_datos").val() == "" || !is_email($(".caja_recuperar_datos").val())) {
            $(".caja_recuperar_datos").focus().after("<br><span class='error error-recuperar btn btn-small btn-danger'>Por favor Ingrese un Correo Válido</span>");
            return false;
        }
    });
    $(".caja_recuperar_datos").keyup(function() {
        if ($(this).val() != "") {
            $(".errorRecuperar").fadeOut();
            return false;
        }
    });


//eventos para controlar vistas Ventana Modal Login, Recupara Datos y Registro
    $("#recuperar_datos").click(function(evento) {
        $("#formularioIngreso").css("display", "none");
        $("#titulo_iniciar_sesion").css("display", "none");
        $("#titulo_recuperar_datos").css("display", "block");
        $("#recuperarDatos").css("display", "block");
    });

    $("#registro_usuario").click(function(evento) {
        $("#formularioIngreso").css("display", "none");
        $("#titulo_iniciar_sesion").css("display", "none");
        $("#titulo_registro_usuario").css("display", "block");
        $("#frmRegistroUsuario").css("display", "block");
    });

    $("#abrir_modal").click(function(evento) {
        $("#formularioIngreso").css("display", "block");
        $("#titulo_iniciar_sesion").css("display", "block");
        $("#titulo_recuperar_datos").css("display", "none");
        $("#recuperarDatos").css("display", "none");
        $("#titulo_registro_usuario").css("display", "none");
        $("#frmRegistroUsuario").css("display", "none");
        limpiaForm($("#formularioLogin"));
        limpiaForm($("#formularioRecovery"));
        limpiaForm($("#formularioRegistro"));
        $(".error-recuperar").css("display", "none");

    });


});






function is_email(email) {
    var result = email.search(/^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z]{2,3})+$/);
    if (result > -1) {
        return true;
    } else {
        return false;
    }
}