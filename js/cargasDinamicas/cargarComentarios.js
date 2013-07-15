/* 
 Autor: ALBEIRO ASCUNTAR ROSALES eaar23@hotmail.com
 2012
 */

$(document).ready(function(){
    cargarComentarios(); 
    
    $(".respon").live('click',(function() 
    {
        var ID=$(this).attr('id');   
        //         $("#formularioRespuesta").css("display", "block");
        $("#formularioRespuesta_"+ID).css("display", "block");
        $("#divCancelarComentario_"+ID).css("display", "block");
        $("#divResponderComentario_"+ID).css("display", "none");
    }));
    

    $(".ocultarRespuestas").live('click',(function() 
    {
        var ID=$(this).attr('id');   
       
        $("#divOcultarRespuestas_"+ID).css("display", "none");
        $("#divRespuestas_"+ID).css("display", "block");
        $(".respuestasVarias_"+ID).css("display", "none");
    }));
    
    
    
    $(".mostrarRespuestas").live('click',(function() 
    {
        var ID=$(this).attr('id');   
       
        $("#divOcultarRespuestas_"+ID).css("display", "block");
        $("#divRespuestas_"+ID).css("display", "none");
        $(".respuestasVarias_"+ID).css("display", "block");
    }));
    
    
    
    $(".cancelcom").live('click',(function() 
    {
        var ID=$(this).attr('id');   
        //         $("#formularioRespuesta").css("display", "block");
        $("#formularioRespuesta_"+ID).css("display", "none");
        $("#divCancelarComentario_"+ID).css("display", "none");
        $("#divResponderComentario_"+ID).css("display", "block");
    }));

    
    $(".submitclase").live('click',(function() 
    {
        var Id=$(this).attr('id');
        //        var funcion = 'respuestaComentario';
        var nombreRespuesta = $('input[name="nombreRespuesta_'+Id+'"]').val();
        var email =  $('input[name="email_'+Id+'"]').val();
        var emailRespuesta =  $('input[name="emailRespuesta_'+Id+'"]').val();
        var respuesta =  $('textarea[name="comentarioRespuesta_'+Id+'"]').val();
        if(nombreRespuesta==''||email==''||emailRespuesta==''||respuesta==''){
            $('#camposRequeridos_'+Id).html('¡Por favor completar todos los campos!');
            return false;
        }
         $('#camposRequeridos_'+Id).css('color', '#93CEEE');
         $('#camposRequeridos_'+Id).html('¡Comentario Enviado..!');
         
        $.ajax({
            type: "POST",
            url:"../funciones/funciones.php",
            data: "funcion=respuestaComentario&id="+Id+"&nombreRespuesta="+nombreRespuesta+"&emailDestino="+email+"&emailRespuesta="+emailRespuesta+"&respuesta="+respuesta+"&fecha="+horaFechaCliente(),
            cache: false,
            success: function(html)
            {
                AlertaComentarioEnviado('Gracias por tu comentario. \n Recuerda agregarnos a tus contactos de correo:  administrador@partiturasmusicales.capnix.com \n para recibir respuestas a tus comentarios.');
                setTimeout("location.reload()",6000);	    
            }
        });
        return false;
    }));
    
    $('#contact-form').submit(function() {
        if($('#nombre').val()==''||$('#email').val()==''||$('#comentario').val()==''){
            $('#camposRequeridos').html('¡Por favor completar todos los campos!');  
        }     
        else{
            $('#informacionRegistro').css('color', '#93CEEE');
            $('#camposRequeridos').html('¡Comentario Enviado..!');  
            var datos =  $(this).serialize()+"&fecha="+horaFechaCliente();
            $.ajax({
                type: 'POST',
                url: '../funciones/funciones.php',
                data: datos,
                success: function(data) {
                    $('#nombre').val('');
                    $('#email').val('');
                    $('#comentario').val('');
                    $('#camposRequeridos').html(''); 
                    var d = document.getElementById("contenedorComentarios");
                    while (d.hasChildNodes()){
                        d.removeChild(d.firstChild);
                    }
                    cargarComentarios();
                    AlertaComentarioEnviado('Gracias por tu comentario. \n Recuerda agregarnos a tus contactos de correo:  administrador@partiturasmusicales.capnix.com \n para recibir respuestas a tus comentarios.');
                }
            })
            
        }      
        return false;
    }); 


});
//      
          
function cargarComentarios(){
    $('#gifAjax').html('<img class="aligncenter" src="../images/cargando.gif" alt="" height="30" width="30" >'
        +'<br> Cargando por favor espere...<br><br>');
    $.ajax({
        type: "POST",
        url:"../funciones/funciones.php",
        async: true,
        processData: true,
        data: "funcion=cargarComentarios",
        success: function(datos){
            var dataJson = eval(datos);
            TotalComentarios=dataJson[0].Numero;
            var d = document.getElementById("contadorComentarios");
                    while (d.hasChildNodes()){
                        d.removeChild(d.firstChild);
                    }
            $('.contadorComentarios').append(TotalComentarios);
            for(var i in dataJson){                            
                var Nombre = dataJson[i].Nombre;
                var Fecha = dataJson[i].Fecha;
                var Comentario = dataJson[i].Comentario;
                var Id = dataJson[i].Id;
                var Email = dataJson[i].Email;
                var NumRespuestas = dataJson[i].NumRespuestas;
                var Activa = dataJson[i].Activa;
                var comen;
                if(Activa==1){
                var Nombre_Usuario= dataJson[i].Nombre_Usuario;
                var Correo_Usuario= dataJson[i].Correo_Usuario;
                var Tipo_Usuario= dataJson[i].Tipo_Usuario;  
                $('#nombre').attr("value", Nombre_Usuario); 
                $('#email').attr("value", Correo_Usuario); 
                
                 if(NumRespuestas>0){
                    comen = $('<div  class="comentario_estilo comentarioNum_'+Id+'">'
                        +' <div class="avatar">'
                        +'<img class="avatar_comentario" src="../images/clave.png">'
                        +'</div>'
                        +'<div class="nombre_usuario"><strong>'+Nombre+'</strong></div>'
                        +'<div class="fecha_comentario"><h6 style="font-size: 13px;line-height: 20px;">'+Fecha+'</h6s></div>'
                        +'<br><br>'
                        +'<div class="contenido_comentario">'+Comentario+'</div>'
                    
                        +'<div id="divResponderComentario_'+Id+'" class="contenido_comentario" style="color: #0164F7;text-decoration: underline;"><a id="'+Id+'" class="respon" style="cursor: pointer"><h6 style="font-size: 13px;line-height: 20px;">Responder</h6></a></div>'
                      
                        +'<div id="divCancelarComentario_'+Id+'" class="contenido_comentario" style="color: #0164F7;text-decoration: underline; display: none;"><a id="'+Id+'" class="cancelcom" style="cursor: pointer">Cancelar</a></div>'
                        +'<div id="divRespuestas_'+Id+'" class="contenido_comentario" style="color: #0164F7;text-decoration: underline;"><a id="'+Id+'" class="mostrarRespuestas numeroRespuestas" style="cursor: pointer; text-decoration: underline;"><h6 style="font-size: 13px;line-height: 20px;">Ver '+NumRespuestas+' Respuestas</h6></a></div>'
                        +'<div id="divOcultarRespuestas_'+Id+'" class="contenido_comentario" style="color: #0164F7;text-decoration: underline; display: none;"><a id="'+Id+'" class="ocultarRespuestas numeroRespuestas" style="cursor: pointer; text-decoration: underline;"><h6 style="font-size: 13px;line-height: 20px;">Ocultar Respuestas</h6></a></div>'
                        +'<br>'
                        +'<div  name="formularioRespuesta_'+Id+'"  id="formularioRespuesta_'+Id+'" class="contact-form-respuesta" style="position: relative;left: 30px; display: none;">'
                        +'<form id="contact-form-respuesta" name="#contact-form-respuesta">'
                    
                        +'<input type="hidden" id="id_resp_'+Id+'" name="id_resp_'+Id+'" value="'+Id+'">'
                        +'<input type="hidden" id="email_'+Id+'" name="email_'+Id+'" value="'+Email+'">'
                        +'<fieldset>'
                        +'<label>'
                        +'<span class="name-input">Nombre:</span>'
                        +'<input type="text" name="nombreRespuesta_'+Id+'" id="nombreRespuesta_'+Id+'" required="required" style="width:479px;padding:6px 12px;margin:0;font-family:Arial, Helvetica, sans-serif;font-size:13px;line-height:1.25em;color:#a1a1a1;border:1px solid #333333;background:none;outline:none;" value="'+Nombre_Usuario+'" />'
                        +'</label><br><br>'
                        +'<label>'
                        +'<span class="name-input">E-mail:</span>'
                        +'<input type="email" name="emailRespuesta_'+Id+'" id="emailRespuesta_'+Id+'" required="required" style="width:479px;padding:6px 12px;margin:0;font-family:Arial, Helvetica, sans-serif;font-size:13px;line-height:1.25em;color:#a1a1a1;border:1px solid #333333;background:none;outline:none;" value="'+Correo_Usuario+'" />'
                        +'</label>'
                        +'<label><br><br>'
                        +'<span class="name-input">Respuesta:</span>'
                        +'<textarea  id="comentarioRespuesta_'+Id+'" name="comentarioRespuesta_'+Id+'" required="required" style="height:184px;margin:0;width:479px;padding:6px 12px;margin:0;font-family:Arial, Helvetica, sans-serif;font-size:13px;line-height:1.25em;color:#a1a1a1;border:1px solid #333333;background:none;overflow:auto;outline:none;" ></textarea>'
                        +'</label>'
                        +'</fieldset>'
                        +'<span id="camposRequeridos_'+Id+'" style="color: red; position: relative;left: 77px; "></span>'
                        +'<div id="botonPublicar"  style="position: relative;    left: 446px;">'
                        +'<button id="'+Id+'" type="submit" class="btn btn-small btn-primary submitclase" style="position: relative;left: 15px;" >Enviar Respuesta</button>'
                        +'</div>'
                        +'<div class="clear"></div>'
                        +'</form>'
                        +'</div>'
                        +'<br>'); 
                    
                }else{
                    comen = $('<div  class="comentario_estilo comentarioNum_'+Id+'">'
                        +' <div class="avatar">'
                        +'<img class="avatar_comentario" src="../images/clave.png">'
                        +'</div>'
                        +'<div class="nombre_usuario"><strong>'+Nombre+'</strong></div>'
                        +'<div class="fecha_comentario"><h6 style="font-size: 13px;line-height: 20px;">'+Fecha+'</h6s></div>'
                        +'<br><br>'
                        +'<div class="contenido_comentario">'+Comentario+'</div>'
                       
                        +'<div id="divResponderComentario_'+Id+'" class="contenido_comentario" style="color: #0164F7;text-decoration: underline;"><a id="'+Id+'" class="respon" style="cursor: pointer"><h6 style="font-size: 13px;line-height: 20px;">Responder</h6></a></div>'
                        
                        +'<div id="divCancelarComentario_'+Id+'" class="contenido_comentario" style="color: #0164F7;text-decoration: underline; display: none;"><a id="'+Id+'" class="cancelcom" style="cursor: pointer">Cancelar</a></div>'
                        +'<br>'
                        +'<div  name="formularioRespuesta_'+Id+'"  id="formularioRespuesta_'+Id+'" class="contact-form-respuesta" style="position: relative;left: 30px; display: none;">'
                        +'<form id="contact-form-respuesta" name="#contact-form-respuesta">'
                    
                        +'<input type="hidden" id="id_resp_'+Id+'" name="id_resp_'+Id+'" value="'+Id+'">'
                        +'<input type="hidden" id="email_'+Id+'" name="email_'+Id+'" value="'+Email+'">'
                        +'<fieldset>'
                        +'<label>'
                        +'<span class="name-input">Nombre:</span>'
                        +'<input type="text" name="nombreRespuesta_'+Id+'" id="nombreRespuesta_'+Id+'" required="required" style="width:479px;padding:6px 12px;margin:0;font-family:Arial, Helvetica, sans-serif;font-size:13px;line-height:1.25em;color:#a1a1a1;border:1px solid #333333;background:none;outline:none;" value="'+Nombre_Usuario+'" />'
                        +'</label><br><br>'
                        +'<label>'
                        +'<span class="name-input">E-mail:</span>'
                        +'<input type="email" name="emailRespuesta_'+Id+'" id="emailRespuesta_'+Id+'" required="required" style="width:479px;padding:6px 12px;margin:0;font-family:Arial, Helvetica, sans-serif;font-size:13px;line-height:1.25em;color:#a1a1a1;border:1px solid #333333;background:none;outline:none;" value="'+Correo_Usuario+'" />'
                        +'</label><br><br>'
                        +'<label>'
                        +'<span class="name-input">Respuesta:</span>'
                        +'<textarea  id="comentarioRespuesta_'+Id+'" name="comentarioRespuesta_'+Id+'" required="required" style="height:184px;margin:0;width:479px;padding:6px 12px;margin:0;font-family:Arial, Helvetica, sans-serif;font-size:13px;line-height:1.25em;color:#a1a1a1;border:1px solid #333333;background:none;overflow:auto;outline:none;" ></textarea>'
                        +'</label>'
                        +'</fieldset>'
                        +'<span id="camposRequeridos_'+Id+'" style="color: red; position: relative;left: 77px; "></span>'
                        +'<div id="botonPublicar"  style="position: relative;    left: 446px;">'
                        +'<button id="'+Id+'" type="submit" class="btn btn-small btn-primary submitclase" style="position: relative;left: 15px;" >Enviar Respuesta</button>'
                        +'</div>'
                        +'<div class="clear"></div>'
                        +'</form>'
                        +'</div>'
                        +'<br>'); 
                }
                $('.comentarios').append(comen);
                
                
                if(NumRespuestas>0){
                     var contenedorRespuestas = $('<div id="respuestaComentarios" class="respuestasVarias_'+Id+'" style="width: 783px; display:none;">'
                        +'<div class="nombre_usuario_respuesta"><strong>Respuestas...</strong></div><br><br>'
                        +'</div>');
                    $('.comentarioNum_'+Id).append(contenedorRespuestas);
                    
                    $.ajax({
                        type: 'POST',
                        url: '../funciones/funciones.php',
                        data: "funcion=cargarRespuestas&id="+Id,
                        success: function(data) {
                            var dat = eval(data);
                            var idTemporal =0;
                            for(var i in dat){ 
                                var NombreRespuesta = dat[i].Nombre;
                                var FechaRespuesta = dat[i].Fecha;
                                var Respuesta = dat[i].Comentario;
                                var Referencia = dat[i].Referencia;  
                                idTemporal = Referencia;
                                var respuestas = $('<div class="nombre_usuario_respuesta"><strong>'+NombreRespuesta+'</strong><br><h6 style="font-size: 13px;line-height: 20px;">'+FechaRespuesta+'</h6></div>'
                                    +'<br><br>'
                                    +'<div class="contenido_comentario_respuesta">'+Respuesta+'</div><hr class="estilo_hr">');
                                $('.respuestasVarias_'+Referencia).append(respuestas);
                                
                            }
                            var espacios = $('<br><br>');
                            $('.respuestasVarias_'+idTemporal).append(espacios);
                        }
                    })
                }    
                }else{
                    if(NumRespuestas>0){
                    comen = $('<div  class="comentario_estilo comentarioNum_'+Id+'">'
                        +' <div class="avatar">'
                        +'<img class="avatar_comentario" src="../images/clave.png">'
                        +'</div>'
                        +'<div class="nombre_usuario"><strong>'+Nombre+'</strong></div>'
                        +'<div class="fecha_comentario"><h6 style="font-size: 13px;line-height: 20px;">'+Fecha+'</h6s></div>'
                        +'<br><br>'
                        +'<div class="contenido_comentario">'+Comentario+'</div>'
                    
                        +'<div id="divResponderComentario_'+Id+'" class="contenido_comentario" style="color: #0164F7;text-decoration: underline;"><a id="'+Id+'" href="RegistroLogin.php" style="cursor: pointer"><h6 style="font-size: 13px;line-height: 20px;">Para responder Regístrate ó Inicia Sesión</h6></a></div>'
                      
                        +'<div id="divCancelarComentario_'+Id+'" class="contenido_comentario" style="color: #0164F7;text-decoration: underline; display: none;"><a id="'+Id+'" class="cancelcom" style="cursor: pointer">Cancelar</a></div>'
                        +'<div id="divRespuestas_'+Id+'" class="contenido_comentario" style="color: #0164F7;text-decoration: underline;"><a id="'+Id+'" class="mostrarRespuestas numeroRespuestas" style="cursor: pointer; text-decoration: underline;"><h6 style="font-size: 13px;line-height: 20px;">Ver '+NumRespuestas+' Respuestas</h6></a></div>'
                        +'<div id="divOcultarRespuestas_'+Id+'" class="contenido_comentario" style="color: #0164F7;text-decoration: underline; display: none;"><a id="'+Id+'" class="ocultarRespuestas numeroRespuestas" style="cursor: pointer; text-decoration: underline;"><h6 style="font-size: 13px;line-height: 20px;">Ocultar Respuestas</h6></a></div>'
                        +'<br>'
                        +'<br>'); 
                }else{
                    comen = $('<div  class="comentario_estilo comentarioNum_'+Id+'">'
                        +' <div class="avatar">'
                        +'<img class="avatar_comentario" src="../images/clave.png">'
                        +'</div>'
                        +'<div class="nombre_usuario"><strong>'+Nombre+'</strong></div>'
                        +'<div class="fecha_comentario"><h6 style="font-size: 13px;line-height: 20px;">'+Fecha+'</h6s></div>'
                        +'<br><br>'
                        +'<div class="contenido_comentario">'+Comentario+'</div>'
                       
                        +'<div id="divResponderComentario_'+Id+'" class="contenido_comentario" style="color: #0164F7;text-decoration: underline;"><a id="'+Id+'" href="RegistroLogin.php" style="cursor: pointer"><h6 style="font-size: 13px;line-height: 20px;">Para responder Regístrate</h6></a></div>'
                        
                        +'<div id="divCancelarComentario_'+Id+'" class="contenido_comentario" style="color: #0164F7;text-decoration: underline; display: none;"><a id="'+Id+'" class="cancelcom" style="cursor: pointer">Cancelar</a></div>'
                        +'<br>'
                        +'<br>'); 
                }
                $('.comentarios').append(comen);
                
                if(NumRespuestas>0){
                     var contenedorRespuestas = $('<div id="respuestaComentarios" class="respuestasVarias_'+Id+'" style="width: 783px; display:none;">'
                        +'<div class="nombre_usuario_respuesta"><strong>Respuestas...</strong></div><br><br>'
                        +'</div>');
                    $('.comentarioNum_'+Id).append(contenedorRespuestas);
                    
                    $.ajax({
                        type: 'POST',
                        url: '../funciones/funciones.php',
                        data: "funcion=cargarRespuestas&id="+Id,
                        success: function(data) {
                            var dat = eval(data);
                            var idTemporal =0;
                            for(var i in dat){ 
                                var NombreRespuesta = dat[i].Nombre;
                                var FechaRespuesta = dat[i].Fecha;
                                var Respuesta = dat[i].Comentario;
                                var Referencia = dat[i].Referencia;  
                                idTemporal = Referencia;
                                var respuestas = $('<div class="nombre_usuario_respuesta"><strong>'+NombreRespuesta+'</strong><br><h6 style="font-size: 13px;line-height: 20px;">'+FechaRespuesta+'</h6></div>'
                                    +'<br><br>'
                                    +'<div class="contenido_comentario_respuesta">'+Respuesta+'</div><hr class="estilo_hr">');
                                $('.respuestasVarias_'+Referencia).append(respuestas);
                                
                            }
                            var espacios = $('<br><br>');
                            $('.respuestasVarias_'+idTemporal).append(espacios);
                        }
                    })
             
                   
                } 
                }
                
                               
            }
                      
            $('#gifAjax').html('');
        }
       
    });  
}




function horaFechaCliente() {
    var hours, minutes, seconds, ap;
    var intHours, intMinutes, intSeconds;
    var today;
    today = new Date();
    intHours = today.getHours();
    intMinutes = today.getMinutes();
    intSeconds = today.getSeconds();
    switch(intHours){
        case 0:
            intHours = 12;
            hours = intHours+":";
            ap = "A.m.";
            break;
        case 12:
            hours = intHours+":";
            ap = "P.m.";
            break;
        case 24:
            intHours = 12;
            hours = intHours + ":";
            ap = "A.m.";
            break;
        default:
            if (intHours > 12)           {
                intHours = intHours - 12;
                hours = intHours + ":";
                ap = "p.m.";
                break;
            }
            if(intHours < 12)           {
                hours = intHours + ":";
                ap = "a.m.";
            }
    }
    if (intMinutes < 10) {
        minutes = "0"+intMinutes+":";
    } else {
        minutes = intMinutes+":";
    }
    if (intSeconds < 10) {
        seconds = "0"+intSeconds+" ";
    } else {
        seconds = intSeconds+" ";
    }
    var timeString =today.getFullYear()+'/'+today.getMonth()+'/'+today.getDay()+'  '+ hours+minutes+seconds+ap;
    return timeString;
//Clock.innerHTML = timeString;
//window.setTimeout("tick();", 100);
}

function AlertaComentarioEnviado(mensaje) {
    $().toastmessage('showToast', {
        text: mensaje,
        sticky: true,
        position: 'middle-center', //top-left, top-center, top-right, middle-left, middle-center, middle-right
        type: 'success', // notice, warning, error, success
        closeText: '',
        close: function () {
            console.log("toast is closed ...");
        }
    });
}