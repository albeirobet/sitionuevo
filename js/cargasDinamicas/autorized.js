/* 
 Desarrollado por Albeiro Ascuntár eaar23@hotmail.com Octubre 2012
 */


$(document).ready(function(){
    $('#formularioLogin').submit(function(){
        $.ajax({
            type: 'POST',
            url: '../funciones/funciones.php',
            data: $(this).serialize(),
            success: function(data) {
                if(data=='Si'){
                    $("table#tablaIngresos").remove(); 
                    $("input#botonLogin").remove();
                  
                    var botonIngresar = $('<h5>Datos verificados, por favor haga clic para continuar</h5>'
                        +'<br>'
                        +'<button class="btn btn-mini btn-primary cerrar" >Continuar</button>');
  
                    $('.centrarBoton').append(botonIngresar);      
                }else{
                    alert('hola');   
                }
            }
        })
        return false;  
    
    });

    $('.cerrar').live('click',function(eEvento){
        $("div#ventanaEmergente").remove(); 
        $("div#divOverlay").remove(); 
    });

});