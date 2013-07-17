/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function() {
    cargarComboArtistas();
    $('#selectIngresoAutorPartitura').on('change', function() {
        var autor = $('#selectIngresoAutorPartitura').val();
        if (autor == "NO SE ENCUENTRA EL ARTISTA DESEADO") {
            $('#selectIngresoAutorPartitura').hide();
            $('#autorIngresoNuevo').show();
        }
    });


    //Enviar Formulario Mediante Ajax
    $('#formularioIngresoNuevaPartitura').submit(function() {
        //   $('#result').html('<img src="cargando.gif" alt="" with>');
        var autorGeneral;
        var genero = $('#selectIngresoPartitura').val();
        var titulo = $('#tituloIngresoNuevo').val();
        var autor = $('#selectIngresoAutorPartitura').val();
        var autorInput = $('#autorIngresoNuevo').val();
        if (autor == "NO SE ENCUENTRA EL ARTISTA DESEADO") {
            autorGeneral = autorInput;
        } else {
            autorGeneral = autor;
        }
        var link = $('#linkIngresoNuevo').val();
        $.ajax({
            type: "POST",
            url: "../funciones/funciones.php",
            data: "funcion=ingresoNuevaPartitura&genero=" + genero + "&titulo=" + titulo + "&autor=" + autorGeneral + "&link=" + link,
            cache: false,
            beforeSend: function(data) {
                activarObjetoAjax(1);
            },
            success: function(data) {
                var d = document.getElementById("selectIngresoPartitura");
                while (d.hasChildNodes()) {
                    d.removeChild(d.firstChild);
                }
                var opti = $('<option value="Varios">Escoger</option>'
                        + '<option value="Salsa">Salsa</option>'
                        + '<option value="Merengue">Merengue</option>'
                        + '<option value="Bachata">Bachata</option>'
                        + '<option value="Tropical">Tropical</option>'
                        + '<option value="Vallenato">Vallenato</option>'
                        + '<option value="Cumbia">Cumbia</option>'
                        + '<option value="Varios">Varios</option>');
                $('.input-perzonalizado-select-partituras').append(opti);

                var d2 = document.getElementById("selectIngresoAutorPartitura");
                while (d2.hasChildNodes()) {
                    d2.removeChild(d2.firstChild);
                }
                var opti2 = $('<option value="Varios">Escoger</option>'
                        + '<option value="NO SE ENCUENTRA EL ARTISTA DESEADO">NO SE ENCUENTRA EL ARTISTA DESEADO</option>'
                        );
                $('.selectAutor').append(opti2);
                cargarComboArtistas();
                $('#tituloIngresoNuevo').val('');
                $('#linkIngresoNuevo').val('');
                $('#autorIngresoNuevo').val('');
                $('#autorIngresoNuevo').hide();
                $('#selectIngresoAutorPartitura').show();
                $('#autorIngresoNuevo').hide();
            },
            complete: function() {
                activarObjetoAjax(0);
            }
        })
        Alerta('Registro ingresado correctamente');
        return false;
    });




});
function cargarComboArtistas() {
    $.ajax({
        type: "POST",
        url: "../funciones/funciones.php",
        async: true,
        processData: true,
        data: "funcion=cargarComboArtistas",
        success: function(datos) {
            var select = document.getElementById("selectIngresoAutorPartitura");
            var dataJson = eval(datos);
            for (var i in dataJson) {
                var option = document.createElement("option");
                option.setAttribute('value', dataJson[i].Autor);
                option.innerHTML = dataJson[i].Autor;
                select.appendChild(option);
            }
        }

    });
}


function Alerta(mensaje) {
    $().toastmessage('showToast', {
        text: mensaje,
        sticky: true,
        position: 'middle-center', //top-left, top-center, top-right, middle-left, middle-center, middle-right
        type: 'success', // notice, warning, error, success
        closeText: '',
        close: function() {
            console.log("toast is closed ...");
        }
    });
}





//
//
//
//
//function comprobar(){
//    
////    var formulario = document.getElementById("myform");	
////	var dato = formulario[0];
//// 
////	if (dato.value=="enviar"){
////		alert("Enviando el formulario");
////		formulario.submit();
////		return true;
////	} else {
////		alert("No se envía el formulario");
////		return false;
////	}
//    
//
//   alert("Llegando por lo menos");   
//      
//    var user =$('#username').val();
//    var pass =$('#password').val();
//        
//    $.ajax({
//        type: "POST",
//        url:"../funciones/funciones.php",
//        data: "funcion=comprobar&user="+user+"&pass="+pass,
//        cache: false,
//         success: function(datos){
//            var dataJson = eval(datos);
//            var estado;
//            for(var i in dataJson){
//              estado=dataJson[i].estado;
//            }
//            if(estado=='Si'){
//              //document.formularioLogin.submit();
//              alert("vamos bien");
//            }
//            else{
//                alert("pailas");
//            }
//            
//        }
//    })
//}
