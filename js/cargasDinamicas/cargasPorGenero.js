var genero = "";
var tituloGenero = "";
var totalPag=0;
var pos=false;
var pre=false;
var superior=0;
var inferior=0;
        

$(document).ready(function() {
    genero = $("#id_genero").val();
    switch (genero)
    {
        case "s":
            genero = "Salsa";
            tituloGenero = genero;
            break;
        case "m":
            genero = "Merengue";
            tituloGenero = genero;
            break;
        case "c":
            genero = "Cumbia";
            tituloGenero = genero;
            break;
        case "mx":
            genero = "Mexicana";
            tituloGenero = "Musica Mexicana";
            break;
        case "v":
            genero = "Varios";
            tituloGenero = "Musica Variada";
            break;
        default:
            genero = "error";
    }

    if (genero !== "error") {
        $("#titulo_genero").html(tituloGenero);

        cargarPorGenero(0);
        crearPaginador();
    } else {
        $('head').append('<META HTTP-EQUIV="Refresh" CONTENT="3; URL=partituras.php">');
    }
    navegacionPaginador();
});

function crearPaginador() {
    $.ajax({
        type: 'POST',
        url: '../funciones/funciones.php',
        data: {
            funcion: "contadorPartiturasPorGenero",
            genero: genero
        },
        asycn: false,
        beforeSend: function() {
            console.log('estoy entrando a la funcion crearPaginador: ');
        },
        success: function(datos) {
            var vectorPaginador = datos.split("%");
            totalPartituras = vectorPaginador[1];
            totalPaginas = vectorPaginador[0];
            $("#titulo_genero").append(' ' + totalPartituras);
            if (totalPartituras < 25) {
                totalPag = Math.ceil(totalPartituras / 5);
                for (i = 0; i < totalPag; i++) {
                    var limit = i * 5;
                    var li;
                    if (i === 0)
                        li = $("<li style='cursor:pointer'><a id='pagina_" + (i + 1) + "' posicion='" + (i + 1) + "' class='paginas' style='text-decoration: underline; color : black'  limite='" + limit + "'>" + (i + 1) + "</a></li>");
                    else
                        li = $("<li  style='cursor:pointer' ><a id='pagina_" + (i + 1) + "' posicion='" + (i + 1) + "' class='paginas'  limite='" + limit + "'>" + (i + 1) + "</a></li>");
                    $("#paginadorPartituras").append(li);
                }
            } else {
                totalPag = Math.ceil(totalPartituras / 5);
                var Ant = $("<li class='anterior' pos='0' style='cursor: pointer'><a><i class='icon-backward'></i></a></li>");
                $("#paginadorPartituras").append(Ant);
                for (i = 0; i < totalPag; i++) {
                    var limit = i * 5;
                    var li;
                    if (i === 0)
                        li = $("<li  style='display: none; cursor:pointer' class='oculto'><a id='pagina_" + (i + 1) + "' posicion='" + (i + 1) + "' class='paginas' style='text-decoration: underline; color : black'  limite='" + limit + "'>" + (i + 1) + "</a></li>");
                    else
                        li = $("<li  style='display: none; cursor:pointer' class='oculto'><a id='pagina_" + (i + 1) + "' posicion='" + (i + 1) + "' class='paginas'  limite='" + limit + "'>" + (i + 1) + "</a></li>");
                    $("#paginadorPartituras").append(li);
                }
                var Sig = $("<li class='siguiente' pos='2'  style='cursor: pointer'><a><i class='icon-forward'></i></a></li>");
                $("#paginadorPartituras").append(Sig);
            }


        },
        complete: function() {
            console.log('acabe el acceso a la funcion crearPaginador');
            inferior=1;
            superior=5;
            activarPaginas();
        },
        cache: false,
        error: function(data, errorThrown)
        {
            console.log('se produjo un error:  ' + errorThrown);
        }
    });
}

function cargarPorGenero(Limite) {
    $.ajax({
        type: 'POST',
        url: '../funciones/funciones.php',
        data: {
            funcion: "cargarPorGenero",
            genero: genero,
            limite: Limite
        },
        async: true,
        beforeSend: function() {
            console.log('estoy entrando a la funcion cargarPorGenero: ');
        },
        success: function(datos) {
            var data = JSON.parse(datos);
            console.log(data.length);
            $('#contenedorPartiturasCargadas').html('');
            var posicion = 0;
            $.each(data, function(i, item) {
                posicion = (i + 1);
                var id = item.Id;
                var link = item.Link;
                var titulo = item.Titulo;
                var autor = item.Autor;
                var contadorDescargas = item.Contador;
                var fechaVector = item.Fecha;
                var fechaPublicacion = fechaVector.split(' ');
                fechaPublicacion = fechaPublicacion[0];
                //console.log(id+" "+link+" "+titulo+" "+autor);

                var div = $("<div class='span10 well well-large' >" +
                        "<div class='span10 well-small'>" +
                        "<div class='span6'>" +
                        "<a class='pull-left' href='#'>" +
                        "<img class='media-object' src='../img/clave.png' alt='64x64' style='width: 40px; height: 40px;'>" +
                        "</a>" +
                        "<div class='media-body'>" +
                        "<h4 class='media-heading'>" + titulo + "</h4>" +
                        "<h6 class='media-heading'><strong>" + autor + "</strong></h6>" +
                        "Partitura publicada el <strong>" + fechaPublicacion + "</strong><br>" +
                        "Enviada por <strong>Marc Anthony</strong><br>" +
                        "<a href='" + link + "' target='_blank'><i class='icon-download-alt'></i> Descargar</a>" +
                        "</div>" +
                        "</div>" +
                        " <div class='span2'>" +
                        "<h5 class='media-heading' style='margin-left: 40px;'>Estad&iacute;sticas</h5>" +
                        "&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<strong>" + contadorDescargas + "</strong><i class='icon-tasks'></i> Descargas<br>" +
                        "&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<strong>123</strong><i class='icon-thumbs-up'></i> Positivos<br>" +
                        "&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<strong>123</strong><i class='icon-thumbs-down'></i>  Negativos" +
                        "</div>" +
                        "</div>" +
                        "</div>");
                $('#contenedorPartiturasCargadas').append(div);
            });
        },
        complete: function() {
            console.log('acabe el acceso a la funcion cargarPorGenero: ');
           // $("html, body").animate({scrollTop: 0}, 1250);
        },
        cache: false,
        error: function(data, errorThrown)
        {
            console.log('se produjo un error:  ' + errorThrown);
        }
    });
}
function redondeo2decimales(numero)
{
    var original = parseFloat(numero);
    var result = Math.round(original * 100) / 100;
    return result;
}

function navegacionPaginador() {
    $(document).on('click', '.paginas', function()
    {
        var limite = $(this).attr('limite');
        $(".paginas").removeAttr("style");
        $(this).attr('style', 'text-decoration: underline; color : black');
        var siguiente = parseInt($(this).attr('posicion')) + 1;
        $(".siguiente").attr('pos', siguiente);
        var anterior = parseInt($(this).attr('posicion')) - 1;
        $(".anterior").attr('pos', anterior);
        alert('estoy clickeando la posiscion No: '+$(this).attr('posicion'));
        if($(this).attr('posicion')%5===0){
           pos=true;  
        }
        cargarPorGenero(limite);
    }
    );

    $(document).on('click', '.anterior', function()
    {
        
        $("#pagina_" + $(this).attr('pos')).click();
      
    }
    );

    $(document).on('click', '.siguiente', function()
    {
        if(pos===true){
            pos=false;
            activarPaginas();   
        }
        $("#pagina_" + $(this).attr('pos')).click();
    }
    );
}

function activarPaginas(){
   if(superior<=totalPag&&inferior>=1){ 
    contador =1;
    $("li.oculto").each(function() {
        if(contador>=inferior&&contador<=superior){
        console.log('entre a activar las paginas con inferior: '+inferior+' superior: '+superior+' contador: '+contador);    
        $(this).removeAttr("style");
        $(this).attr('style', 'cursor: pointer'); 
        contador++;
        }else{
            console.log('entre a desactivar las paginas con inferior: '+inferior+' superior: '+superior+' contador: '+contador);    
        $(this).attr('style', 'display:none');    
        contador++;
        }
});

inferior=superior+1;
superior=superior+5;
   }
}