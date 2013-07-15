$(document).ready(function() {
    $(".boton").click(function() {
        $(".error").remove();
        if ($(".code").val() == "") {
            $(".code").focus().after("<br class='error'><span class='error btn btn-small btn-danger'>Por favor Ingrese su Nombre y Apellido</span>");
            return false;
        } else if ($(".user").val() == "") {
            $(".user").focus().after("<br class='error'><span class='error btn btn-small btn-danger'>Por favor Ingrese su Nombre de Usuario</span>");
            return false;
        } else if ($(".pass").val() == "") {
            $(".pass").focus().after("<br class='error'><span class='error btn btn-small btn-danger'>Ingrese su Contraseña</span>");
            return false;
        } else if ($(".confirm_pass").val() == "") {
            $(".confirm_pass").focus().after("<br class='error'><span class='error btn btn-small btn-danger'>Confirme su Contraseña</span>");
            return false;
        } else if ($(".confirm_pass").val() != $(".pass").val()) {
            $(".confirm_pass").focus().after("<br class='error'><span class='error btn btn-small btn-danger'>Las Contraseñas no coinciden</span>");
            return false;
        } else if ($(".email_register").val() == "" || !is_email($(".email_register").val())) {
            $(".email_register").focus().after("<br class='error'><span class='error btn btn-small btn-danger'>Por favor Ingrese un Correo Válido</span>");
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
            $(".user_login").focus().after("<br class='errorLogin'><span class='errorLogin btn btn-small btn-danger'>Por favor Ingrese su Nombre de Usuario</span>");
            return false;
        } else if ($(".pass_login").val() == "") {
            $(".pass_login").focus().after("<br  class='errorLogin'><span class='errorLogin btn btn-small btn-danger'>Por favor Ingrese su Contraseña</span>");
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
            $(".caja_recuperar_datos").focus().after("<br  class='errorRecuperar'><span class='error error-recuperar btn btn-small btn-danger'>Por favor Ingrese un Correo Válido</span>");
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
    
    $(document).on('click', '.contadorDescargas',function()
    {  
        var idFila=$(this).attr('id_partitura');
        var idContador=$(this).attr('id');
        var id=idContador.charAt(idContador.length-1);
        $.ajax({
            type: 'POST',
            url: 'funciones/funciones.php',
            data: "funcion=actualizarContadorDescargas&id="+idFila,
            success: function(data) {
            $("#cantidad_descargas_partitura_mas_descargada_"+id).html(''); 
            $("#cantidad_descargas_partitura_mas_descargada_"+id).html(data);    
            }
        });
    }
    );

    getCantidadPartituras();
    getPartiturasMasDescargadas();
    getPartiturasRecientes();
});

function getCantidadPartituras(){
     $.ajax({
        type: "POST",
        url:"funciones/funciones.php",
        data: "funcion=getCantidadPartituras",
       
       // async: false,
        dataType: 'text',
        beforeSend: function(data) {
          //  $('#ajax-loader').show();
        },
        success: function(data)
        {
            var dataJson = eval(data);
            $("#CantidadPartituras").text(dataJson[0].Cantidad);
        },
        complete: function() {
//            $("#btnEnviAudit").show();
//            $('#ajax-loader').hide();
        }
    });
}

function getPartiturasRecientes(){
    $.ajax({
        type: "POST",
        url:"funciones/funciones.php",
        data: "funcion=cargarRecientes",
        dataType: 'text',
        beforeSend: function(data) {
        },
        success: function(data)
        {
            var data = eval(data);
//            alert(data[0].Titulo);
           $.each(data, function(i,item)
            {
            var id=i+1;
            $("#titulo_partitura_reciente_"+id).html(item.Titulo);
            $("#artista_partitura_reciente_"+id).html(item.Autor);
            $("#donante_partitura_reciente_"+id).html("Anonimo");
            $("#pais_donante_partitura_reciente_"+id).html("Anonimo");
            $("#link_partitura_reciente_"+id).attr("href",item.Link);
            $("#link_partitura_reciente_"+id).attr("id_partitura",item.Id);
            });
        },
        complete: function() {
        }
    }); 
}

function getPartiturasMasDescargadas(){
    $.ajax({
        type: "POST",
        url:"funciones/funciones.php",
        data: "funcion=topDescargas",
        dataType: 'json',
        beforeSend: function(data) {
        },
        success: function(data)
        {
           $.each(data, function(i,item)
            {
            var id=i+1;
            $("#titulo_partitura_mas_descargada_"+id).html(item.Titulo);
            $("#artista_partitura_mas_descargada_"+id).html(item.Autor);
            $("#donante_partitura_mas_descargada_"+id).html("Anonimo");
            $("#pais_donante_partitura_mas_descargada_"+id).html("Anonimo");
            $("#cantidad_descargas_partitura_mas_descargada_"+id).html(item.Contador);
            $("#link_partitura_mas_descargada_"+id).attr("href",item.Link);
            $("#link_partitura_mas_descargada_"+id).attr("id_partitura",item.Id);
            });
        },
        complete: function() {
        }
    }); 
}

function is_email(email) {
    var result = email.search(/^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z]{2,3})+$/);
    if (result > -1) {
        return true;
    } else {
        return false;
    }
}