/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 * 
 * 
 * Utilizar ON en lugar de LIVE jquery
 * 
 * //$('#tablaAdministracionPartituras').on('click', '.imagen',function()
 */

$(document).ready(function(){ 
    cargarTablaPartituras();  
  

    $('#tablaAdministracionPartituras').on('click', '.imagen',function()
    {  
        var idFila=$(this).attr('id');
        $.prompt('¿Esta seguro de Eliminar esta Partitura?',{
            buttons:[
            {
                title: 'Si',
                value:true
            },
            {
                title: 'No',
                value:false
            }
            ], 
            submit: function(e,v,m,f){ 
                if(v){
                    $("div#jqi").remove();
                    $("div#jqibox").remove();
                    EliminarPartitura(idFila);
                }else{
                    $("div#jqi").remove();
                    $("div#jqibox").remove();
                }
            } 
        });
    }
    ); 
  
    $(document).on('click', '.jqiclose',function()
    {  
        $("div#jqi").remove();
        $("div#jqibox").remove();
    }
    );
  
    //Funcion para eliminar una partitura
    function EliminarPartitura(idFila){
        $.ajax({
            type: "POST",
            url:"../funciones/funciones.php",
            data: "funcion=borrarRegistroTablaPartituras&id="+idFila,
            cache: false,
            success: function(html)
            {
                var d = document.getElementById("tablaAdministracionPartituras");
                while (d.hasChildNodes()){
                    d.removeChild(d.firstChild);
                }
                var tabla = $('<tbody>'
                    +'<tr class="head">'
                    +'<th>Genero</th>'
                    +'<th>Titulo</th>'
                    +'<th>Autor</th>'
                    +'<th>Link Descarga</th>'
                    +'<th>Eliminar</th>'
                    +'</tr>'
                    +'</tbody>  ');
                $('.innerTablaAdministracion').append(tabla);
                cargarTablaPartituras();
                Alerta('Partitura Eliminada Correctamente');
            }
        });  
    }
 

    $('#tablaAdministracionPartituras').on('click', '.edit_tr',function()
    {
        var ID=$(this).attr('id');
        $("#genero_"+ID).hide();
        $("#titulo_"+ID).hide();
        $("#autor_"+ID).hide();
        $("#link_"+ID).hide();
        $("#genero_input_"+ID).show();
        $("#titulo_input_"+ID).show();
        $("#autor_input_"+ID).show();
        $("#link_input_"+ID).show();
    }).on('change', '.edit_tr',function()
    {
        var ID=$(this).attr('id');
        var genero = $("#genero_input_"+ID).val();
        var titulo = $("#titulo_input_"+ID).val();
        var autor  = $("#autor_input_"+ID).val();
        var link   = $("#link_input_"+ID).val();
        if(genero.length>0&&titulo.length>0&&autor.length>0&&link.length>0)
        {
            $.ajax({
                type: "POST",
                url:"../funciones/funciones.php",
                data: "funcion=actualizarTablaPartituras&id="+ID+"&genero="+genero+"&titulo="+titulo+"&autor="+autor+"&link="+link,
                cache: false,
                success: function(html)
                {
                    $("#genero_"+ID).html(genero);
                    $("#titulo_"+ID).html(titulo);
                    $("#autor_"+ID).html(autor);
                    $("#link_"+ID).html(link);
                }
            });
        }
        else
        {
            Alerta('Los Campos no pueden quedar vacios');
            return false;
            
        }
    }
    );

    $(".selectGeneros").live('mouseup',(function() 
    {
        return false
    }));

   
    // Edit input box click action
    $(".editbox").live('mouseup',(function() 
    {
        return false
    })
    );
        
    $(".input-mini").live('mouseup',(function() 
    {
        return false
    })
    );  
        
    $(".desaparece_textarea").live('mouseup',(function() 
    {
        return false
    })
    );     
 
    $(document).live('mouseup',(function() 
    {
        $(".editbox").hide();
        $(".desaparece_textarea").hide();
        $(".input-mini").hide();
        $(".selectGeneros").hide();
        $(".text").show();
    }));
    
    //Enviar Formulario Mediante Ajax
    $('#formularioIngresoNuevo').submit(function() {
        $('#result').html('<img src="cargando.gif" alt="" with>');
        $.ajax({
            type: 'POST',
            url: 'funciones/funciones.php',
            data: $(this).serialize(),
            success: function(data) {
                $('#result').html(data);
           
            }
        })
        return false;
    });
});

//funcion para cargar la tabla dinamicamente

function cargarTablaPartituras(){
    $('#gifAjax').html('<img class="aligncenter" src="../images/cargando.gif" alt="" height="30" width="30" >'
        +'<br> Cargando por favor espere...<br><br>');
    $.ajax({
        type: "POST",
        url:"../funciones/funciones.php",
        async: true,
        processData: true,
        data: "funcion=cargarTablaPartituras",
        success: function(datos){
            var dataJson = eval(datos);
            for(var i in dataJson){      
                
                
                var tr =$('<tr id="'+dataJson[i].Id+'" class="edit_tr">'
                    +'<td class="edit_td">'
                    +'<span id="genero_'+dataJson[i].Id+'" class="text" style="display: inline; ">'+dataJson[i].Genero+'</span>'
                    + '<select id="genero_input_'+dataJson[i].Id+'" style="display: none;" class="selectGeneros">'
                    + '<option value="Varios">Escoger</option>'
                    + '<option value="Salsa">Salsa</option>'
                    + '<option value="Merengue">Merengue</option>'
                    + '<option value="Bachata">Bachata</option>'
                    + '<option value="Tropical">Tropical</option>'
                    + '<option value="Vallenato">Vallenato</option>'
                    + '<option value="Cumbia">Cumbia</option>'
                    + '<option value="Varios">Varios</option>'
                    +'</select>'
                    +'</td>'
                       
                    +'<td class="edit_td">'
                    +'<span id="titulo_'+dataJson[i].Id+'" class="text" style="display: inline; ">'+dataJson[i].Titulo+'</span>'
                    +'<textarea class="desaparece_textarea" rows="4"  id="titulo_input_'+dataJson[i].Id+'" style="display: none;" required="required">'+dataJson[i].Titulo+'</textarea>'
                    +'</td>'
                       
                    +'<td class="edit_td">'
                    +'<span id="autor_'+dataJson[i].Id+'" class="text" style="display: inline; ">'+dataJson[i].Autor+'</span>'
                    +'<textarea class="desaparece_textarea" rows="4"  id="autor_input_'+dataJson[i].Id+'" style="display: none;" required="required">'+dataJson[i].Autor+'</textarea>'
                    +'</td>'
                       
                    +'<td class="edit_td">'
                    +'<span id="link_'+dataJson[i].Id+'" class="text" style="display: inline; ">'+dataJson[i].Link+'</span>'
                    +'<textarea  class="desaparece_textarea" rows="4" id="link_input_'+dataJson[i].Id+'" style="display: none;" required="required">'+dataJson[i].Link+'</textarea>'
                    +'</td>'
                
                    +'<td><p  class="elimnar_td"> <img id="'+dataJson[i].Id+'" src="../images/menos.png" alt="" height="30" width="30" class="imagen"></p></td>'
                           
                    +'</tr>');
                $('.innerTablaAdministracion').append(tr);    
                
                if(dataJson[i].Genero=='Salsa'){
                    $("#genero_input_"+dataJson[i].Id+" option[value='Salsa']").attr("selected",true); 
                }
                if(dataJson[i].Genero=='Merengue'){
                    $("#genero_input_"+dataJson[i].Id+" option[value='Merengue']").attr("selected",true); 
                }
                if(dataJson[i].Genero=='Bachata'){
                    $("#genero_input_"+dataJson[i].Id+" option[value='Bachata']").attr("selected",true); 
                }
                if(dataJson[i].Genero=='Tropical'){
                    $("#genero_input_"+dataJson[i].Id+" option[value='Tropical']").attr("selected",true); 
                }
                if(dataJson[i].Genero=='Vallenato'){
                    $("#genero_input_"+dataJson[i].Id+" option[value='Vallenato']").attr("selected",true); 
                }
                if(dataJson[i].Genero=='Cumbia'){
                    $("#genero_input_"+dataJson[i].Id+" option[value='Cumbia']").attr("selected",true); 
                }
                if(dataJson[i].Genero=='Varios'){
                    $("#genero_input_"+dataJson[i].Id+" option[value='Varios']").attr("selected",true); 
                }
              }  	
            $('#gifAjax').html('');
        }
    });  
}


function buscarDatosTablaAdministracion(buscando){
    $('#gifAjax').html('<img class="aligncenter" src="../images/cargando.gif" alt="" height="30" width="30" >'
        +'<br> Cargando por favor espere...<br><br>');
    $.ajax({
        type: "POST",
        url:"../funciones/funciones.php",
        async: true,
        processData: true,
        data: "funcion=buscarDatosTablaAdministracion&buscando="+buscando,
        success: function(datos){
            var d = document.getElementById("tablaAdministracionPartituras");
            while (d.hasChildNodes()){
                d.removeChild(d.firstChild);
            }
            var tabla = $('<tbody>'
                +'<tr class="head">'
                +'<th>Genero</th>'
                +'<th>Titulo</th>'
                +'<th>Autor</th>'
                +'<th>Link Descarga</th>'
                +'<th>Eliminar</th>'
                +'</tr>'
                +'</tbody>  ');
            $('.innerTablaAdministracion').append(tabla);
            var dataJson = eval(datos);
            for(var i in dataJson){
                var tr =$('<tr id="'+dataJson[i].Id+'" class="edit_tr">'
                    +'<td class="edit_td">'
                    +'<span id="genero_'+dataJson[i].Id+'" class="text" style="display: inline; ">'+dataJson[i].Genero+'</span>'
                    // +'<input type="text" value="'+dataJson[i].Genero+'" class="input-mini" id="genero_input_'+dataJson[i].Id+'" style="display: none;" required="required">'
                    + '<select id="genero_input_'+dataJson[i].Id+'" style="display: none;" class="selectGeneros">'
                    + '<option value="Varios">Escoger</option>'
                    + '<option value="Salsa">Salsa</option>'
                    + '<option value="Merengue">Merengue</option>'
                    + '<option value="Bachata">Bachata</option>'
                    + '<option value="Tropical">Tropical</option>'
                    + '<option value="Vallenato">Vallenato</option>'
                    + '<option value="Cumbia">Cumbia</option>'
                    + '<option value="Varios">Varios</option>'
                    +'</select>'
                    +'</td>'
                       
                    +'<td class="edit_td">'
                    +'<span id="titulo_'+dataJson[i].Id+'" class="text" style="display: inline; ">'+dataJson[i].Titulo+'</span>'
                  
                    +'<textarea class="desaparece_textarea" rows="4"  id="titulo_input_'+dataJson[i].Id+'" style="display: none;" required="required">'+dataJson[i].Titulo+'</textarea>'
                    +'</td>'
                       
                    +'<td class="edit_td">'
                    +'<span id="autor_'+dataJson[i].Id+'" class="text" style="display: inline; ">'+dataJson[i].Autor+'</span>'
                  
                    +'<textarea class="desaparece_textarea" rows="4"  id="autor_input_'+dataJson[i].Id+'" style="display: none;" required="required">'+dataJson[i].Autor+'</textarea>'
                    +'</td>'
                       
                    +'<td class="edit_td">'
                    +'<span id="link_'+dataJson[i].Id+'" class="text" style="display: inline; ">'+dataJson[i].Link+'</span>'
                    +'<textarea  class="desaparece_textarea" rows="4" id="link_input_'+dataJson[i].Id+'" style="display: none;" required="required">'+dataJson[i].Link+'</textarea>'
                    +'</td>'
                    +'<td><p  class="elimnar_td"> <img id="'+dataJson[i].Id+'" src="../images/menos.png" alt="" height="30" width="30" class="imagen"></p></td>'
                           
                    +'</tr>');
                $('.innerTablaAdministracion').append(tr);   
                if(dataJson[i].Genero=='Salsa'){
                    $("#genero_input_"+dataJson[i].Id+" option[value='Salsa']").attr("selected",true); 
                }
                if(dataJson[i].Genero=='Merengue'){
                    $("#genero_input_"+dataJson[i].Id+" option[value='Merengue']").attr("selected",true); 
                }
                if(dataJson[i].Genero=='Bachata'){
                    $("#genero_input_"+dataJson[i].Id+" option[value='Bachata']").attr("selected",true); 
                }
                if(dataJson[i].Genero=='Tropical'){
                    $("#genero_input_"+dataJson[i].Id+" option[value='Tropical']").attr("selected",true); 
                }
                if(dataJson[i].Genero=='Vallenato'){
                    $("#genero_input_"+dataJson[i].Id+" option[value='Vallenato']").attr("selected",true); 
                }
                if(dataJson[i].Genero=='Cumbia'){
                    $("#genero_input_"+dataJson[i].Id+" option[value='Cumbia']").attr("selected",true); 
                }
                if(dataJson[i].Genero=='Varios'){
                    $("#genero_input_"+dataJson[i].Id+" option[value='Varios']").attr("selected",true); 
                }
            }
            $('#gifAjax').html('');
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
        close: function () {
            console.log("toast is closed ...");
        }
    });
}

