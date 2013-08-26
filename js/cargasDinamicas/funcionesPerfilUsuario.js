/* 
 Autor: ALBEIRO ASCUNTAR ROSALES eaar23@hotmail.com
 */

$(document).ready(function() {
    activarEdicionClaveUsuario();
    getInformacionPerfilUsuario();
    validarFormularioEdicionPerfil();
});

function activarEdicionClaveUsuario() {
    $("#edit-claveusuario").hide();
    $("#edit-claveusuario-cancelar").hide();
    $("#edit-claveusuario-mostrar").click(function(event) {
        event.preventDefault();
        $("#edit-claveusuario").show();
        $("#edit-claveusuario-cancelar").show();
        $("#edit-claveusuario-mostrar").hide();
    });
    $("#edit-claveusuario-cancelar").click(function(event) {
        event.preventDefault();
        $("#edit-claveusuario").hide();
        $("#edit-claveusuario-cancelar").hide();
        $("#edit-claveusuario-mostrar").show();
    });
}

function getInformacionPerfilUsuario() {
    $.ajax({
        type: 'POST',
        url: '../funciones/funciones.php',
        data: {
            funcion: "getInformacionPerfilUsuario",
            username: $("#username_perfil").val()
        },
        beforeSend: function() {
            activarObjetoAjax(1);
        },
        success: function(datos) {
            if (datos!==''){
            data = JSON.parse(datos);
            $.each(data, function(i, item) {
                var id = item.Id;
                var nombres = item.Nombres;
                var nomUsuario = item.NomUsuario;
                var correo = item.Correo;
                $("#id_usuario").val(id);
                $("#nom_usuario_edit").val(nomUsuario);
                $("#nom_ape_usuario_edit").val(nombres);
                $("#correo_usuario_edit").val(correo);

            });
            }
        },
        complete: function() {
            activarObjetoAjax(0);
            $("#clave_old").val('');

        },
        cache: false,
        error: function(data, errorThrown)
        {
            console.log('se produjo un error:  ' + errorThrown);
        }
    });
}

function ActualizarContadorDescargasPartitura() {
    $(document).on('click', '.contadorDescargas', function()
    {
        var idFila = $(this).attr('id');
        $.ajax({
            type: 'POST',
            url: '../funciones/funciones.php',
            data: "funcion=actualizarContadorDescargas&id=" + idFila,
            success: function(data) {
            }
        });
    }
    );
}
function activarObjetoAjax(estado) {
    if (estado === 1)
        $('#ajaxModal').modal({backdrop: 'static', keyboard: false});
    if (estado === 0)
        $('#ajaxModal').modal('hide');
}

function validarFormularioEdicionPerfil() {
    
    $(".boton").click(function() {
      
        $(".error").remove();
        if ($("#nom_usuario_edit").val() == "") {
            $("#nom_usuario_edit").focus().after("<br class='error'><br class='error'><span class='error btn btn-small btn-danger'>Por favor Ingrese su Nombre de Usuario</span>");
            return false;
        }else if (!checkUsername($("#nom_usuario_edit").val())) {
            $("#nom_usuario_edit").focus().after("<br class='error'><br class='error'><span class='error btn btn-small btn-danger'>No se admiten Espacios en Blanco o Caracteres Extraños</span>");
            return false;
        } else if ($("#nom_ape_usuario_edit").val() == "") {
            $("#nom_ape_usuario_edit").focus().after("<br class='error'><br class='error'><span class='error btn btn-small btn-danger'>Por favor Ingrese su Nombre y Apellido</span>");
            return false;
        } 
//        else if ($(".pass").val() == "") {
//            $(".pass").focus().after("<br class='error'><span class='error btn btn-small btn-danger'>Ingrese su Contraseña</span>");
//            return false;
//        } else if ($(".confirm_pass").val() == "") {
//            $(".confirm_pass").focus().after("<br class='error'><span class='error btn btn-small btn-danger'>Confirme su Contraseña</span>");
//            return false;
//        } else if ($(".confirm_pass").val() != $(".pass").val()) {
//            $(".confirm_pass").focus().after("<br class='error'><span class='error btn btn-small btn-danger'>Las Contraseñas no coinciden</span>");
//            return false;
//        } 
         else if ($("#correo_usuario_edit").val() == "" || !is_email($("#correo_usuario_edit").val())) {
            $("#correo_usuario_edit").focus().after("<br class='error'><br class='error'><span class='error btn btn-small btn-danger'>Por favor Ingrese un Correo Válido</span>");
            return false;
        }else
            return true;
            

    });
    $("#nom_usuario_edit, #nom_ape_usuario_edit, #correo_usuario_edit").keyup(function() {
        if ($(this).val() != "") {
            $(".error").fadeOut();
            return false;
        }
    });
    $("#nom_usuario_edit, #nom_ape_usuario_edit, #correo_usuario_edit").change(function() {
        if ($(this).val() != "") {
            $(".error").fadeOut();
            return false;
        }
    });
}

