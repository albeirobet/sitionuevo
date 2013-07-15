/* 
 Autor: ALBEIRO ASCUNTAR ROSALES eaar23@hotmail.com
 */

$(document).ready(function(){
    cargarTodasSalsa(); 
    
    $(document).on('click', '.contadorDescargas',function()
    {  
        var idFila=$(this).attr('id');    
        $.ajax({
            type: 'POST',
            url: '../funciones/funciones.php',
            data: "funcion=actualizarContadorDescargas&id="+idFila,
            success: function(data) {          
            }
        })
    }
    );
    
});

function cargarTodasSalsa(){
    $('#gifAjax').html('<img class="aligncenter" src="../images/cargando.gif" alt="" height="30" width="30" >'
        +'<br> Cargando por favor espere...<br><br>');
    
    $.ajax({
        type: "POST",
        url:"../funciones/funciones.php",
        async: true,
        processData: true,
        data: "funcion=cargarTodasSalsa",
        success: function(datos){
            var dataJson = eval(datos);
            var Disponibles; 
            for(var i in dataJson){
                var fila=$('<tr>'
                    +'<td><p>'+dataJson[i].Titulo+'</p></td>'
                    +'<td><p>'+ dataJson[i].Autor+'</p></td>'
                    +'<td ><p class="centradoColumna"><a target="_blank"   href="'+dataJson[i].Link+'"><img id="'+dataJson[i].Id+'" class="contadorDescargas" src="../images/download.png" height="25" width="25" alt="" title="Descargar"/></a><p></td>'
                    +'</tr>');
                $('.tblSalsa').append(fila);
                Disponibles= dataJson[i].Cantidad;  
                      
            }
            $('.SalsaDisponibles').append(Disponibles); 
            $('#gifAjax').html('');
        }
        
    });  
}

function buscarDatosTablaSalsa(buscando){
    $.ajax({
        type: "POST",
        url:"../funciones/funciones.php",
        async: true,
        processData: true,
        data: "funcion=buscarDatosTablaSalsa&buscando="+buscando,
        success: function(datos){
            var d = document.getElementById("tabla_todas_salsa");
            while (d.hasChildNodes()){
                d.removeChild(d.firstChild);
            }
            var tabla= $('<thead>'
                +'<tr>'
                +'    <th class="color-4">Título</th>'
                +'    <th class="color-4">Autor</th>'
                +'    <th class="color-4-2">Link de Descarga</th>'
                +'</tr>'
                +'</thead>' );
            $('.tblSalsa').append(tabla);
            var dataJson = eval(datos);
            var Disponibles; 
            for(var i in dataJson){
                var fila=$('<tr>'
                    +'<td><p>'+dataJson[i].Titulo+'</p></td>'
                    +'<td><p>'+ dataJson[i].Autor+'</p></td>'
                    +'<td ><p class="centradoColumna"><a target="_blank"   href="'+dataJson[i].Link+'"><img id="'+dataJson[i].Id+'" class="contadorDescargas" src="../images/download.png" height="25" width="25" alt="" title="Descargar"/></a><p></td>'
                    +'</tr>');
                $('.tblSalsa').append(fila);
                Disponibles= dataJson[i].Cantidad;  
                      
            }
            $('.SalsaDisponibles').append(Disponibles); 	
        }
    });  
    
}