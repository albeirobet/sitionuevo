var genero = "";
var tituloGenero = "";
var totalPag = 0;
var pos = false;
var pre = false;
var superior = 0;
var inferior = 0;
var banderaPaginador = 0;
var filtro = '';
var palabra = '';
var criterio = '';

$(document).ready(function() {
    genero = $("#id_genero").val();
    $("#busquedaEspecifica").hide();
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
        $("#titulo_genero").html(tituloGenero + " <span id='cantidad_genero'> </span>");
        filtro = 'autor';
        cargarPorGenero(0);
        crearPaginador();
    } else {
        $('head').append('<META HTTP-EQUIV="Refresh" CONTENT="3; URL=partituras.php">');
    }
    navegacionPaginador();
    filtroPartituras();
    actualizarContadorDescargas();
});

function crearPaginador() {
    $.ajax({
        type: 'POST',
        url: '../funciones/funciones.php',
        data: {
            funcion: "contadorPartiturasPorGenero",
            genero: genero,
            palabra: palabra
        },
        asycn: false,
        beforeSend: function() {
            activarObjetoAjax(1);
        },
        success: function(datos) {
            var vectorPaginador = datos.split("%");
            totalPartituras = vectorPaginador[1];
            totalPaginas = vectorPaginador[0];
            $("#cantidad_genero").html(totalPartituras);
            if (totalPartituras < 25) {
                banderaPaginador = 1;
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

            if (banderaPaginador !== 1) {
                inferior = 1;
                superior = 5;
                activarPaginas();
            }
            activarObjetoAjax(0);
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
            limite: Limite,
            filtro: filtro,
            palabra: palabra
        },
        async: true,
        beforeSend: function() {
            activarObjetoAjax(1);
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
                var puntos_positivos = item.PuntosPositivos;
                var puntos_negativos = item.PuntosNegativos;
                var Donador = item.Donador;
                fechaPublicacion = fechaPublicacion[0];

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
                        "Enviada por <strong>" + Donador + "</strong><br>" +
                        "<a href='" + link + "' class='contadorDescargas' id='" + id + "' target='_blank'><i class='icon-download-alt'></i> Descargar</a>" +
                        "</div>" +
                        "</div>" +
                        " <div class='span3'>" +
                        "<h5 class='media-heading' style='margin-left: 40px;'>Estad&iacute;sticas</h5>" +
                        "&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<strong id='contDescargas_" + id + "'>" + contadorDescargas + "</strong><i class='icon-tasks'></i> Descargas<br>" +
                        "&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<strong>" + puntos_positivos + "</strong><i class='icon-thumbs-up'></i> Positivos<br>" +
                        "&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<strong>" + puntos_negativos + "</strong><i class='icon-thumbs-down'></i>  Negativos" +
                        "</div>" +
                        "</div>" +
                        "</div>");
                $('#contenedorPartiturasCargadas').append(div);
            });
        },
        complete: function() {
            console.log('acabe el acceso a la funcion cargarPorGenero: ');
            activarObjetoAjax(0);
            $("html, body").animate({scrollTop: 0}, 1250);

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
        if (siguiente < totalPag + 1) {
            $(".siguiente").attr('pos', siguiente);
            $(".siguiente").show();
        } else {
            $(".siguiente").hide();
        }
        var anterior = parseInt($(this).attr('posicion')) - 1;
        if (anterior > 0) {
            $(".anterior").attr('pos', anterior);
            $(".anterior").show();
        } else {
            $(".anterior").hide();
        }
        cargarPorGenero(limite);
    }
    );

    $(document).on('click', '.anterior', function()
    {
        var multiplo = $(this).attr('pos') % 5;
        $("#pagina_" + $(this).attr('pos')).click();
        if (multiplo === 0) {

            superior = parseInt($(this).attr('pos')) + 1;
            inferior = parseInt($(this).attr('pos')) - 3;
            if (inferior === 0)
                inferior = 1;
            activarPaginas();
        }

    }
    );

    $(document).on('click', '.siguiente', function()
    {
        var multiplo = (parseInt($(this).attr('pos')) - 1) % 5;
        if (multiplo === 0) {
            superior = parseInt($(this).attr('pos')) + 4;
            inferior = parseInt($(this).attr('pos'));
            activarPaginas();
        }
        $("#pagina_" + $(this).attr('pos')).click();
    }
    );
}

function activarPaginas() {
    if (superior > totalPag)
        superior = totalPag;
    if (superior <= totalPag && inferior >= 1) {
        contador = 1;
        $("li.oculto").each(function() {
            if (contador >= inferior && contador <= superior) {
                $(this).removeAttr("style");
                $(this).attr('style', 'cursor: pointer');
                contador++;
            } else {
                $(this).attr('style', 'display:none');
                contador++;
            }
        });
    }
}

function filtroPartituras() {
    $(".afiltro").click(function() {
        $('#paginadorPartituras').html('');
        filtro = ($(this).attr('valor'));
        if (filtro === 'activar_busqueda_especifica' || filtro === 'activar_busqueda_filtros') {
            if (filtro === 'activar_busqueda_especifica') {
                $("#busquedaEspecifica").show();
                $("#busquedaFiltros").hide();
            }
            if (filtro === 'activar_busqueda_filtros') {
                $("#palabra_buscar").val('');
                palabra = '';
                filtro = 'autor';
                inferior = 1;
                superior = 5;
                banderaPaginador = 0;
                $("#busquedaFiltros").show();
                $("#busquedaEspecifica").hide();
                cargarPorGenero(0);
                crearPaginador();
            }

        } else {
            cargarPorGenero(0);
            crearPaginador();
        }
    });

    $('#palabra_buscar').keypress(function(e) {
        if (e.which == 13) {
            var pal = $("#palabra_buscar").val();

            if (pal !== '') {
                palabra = pal;
                $('#paginadorPartituras').html('');
                cargarPorGenero(0);
                crearPaginador();
            } else {
                $("#palabra_buscar").focus();
            }
        }

    });
}

function actualizarContadorDescargas() {
    $(document).on('click', '.contadorDescargas', function()
    {
        var idFila = $(this).attr('id');
        var idContador = $(this).attr('id');
        var id = idContador.charAt(idContador.length - 1);
        $.ajax({
            type: 'POST',
            url: '../funciones/funciones.php',
            data: "funcion=actualizarContadorDescargas&id=" + idFila,
            beforeSend: function() {
                activarObjetoAjax(1);
            },
            success: function(data) {
                $("#contDescargas_" + idFila).html('');
                $("#contDescargas_" + idFila).html(data);
            },
        complete: function() {
            activarObjetoAjax(0);
        }
        });
    }
    );
}