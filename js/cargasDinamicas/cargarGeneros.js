/* 
 Autor: ALBEIRO ASCUNTAR ROSALES eaar23@hotmail.com
 */

$(document).ready(function() {
  
    loadScoresGenero('Salsa');
    loadScoresGenero('Merengue');
    loadScoresGenero('Cumbia');
    loadScoresGenero('Varios');
    ActivarMensajesTooltips();
});


function loadScoresGenero(Genero) {
    $.ajax({
        type: 'POST',
        url: '../funciones/funciones.php',
        data: {
            funcion: "cargarGeneros",
            genero: Genero
        },
        beforeSend: function() {
            console.log('estoy entrando a la funcion loadScoresGenero: '+Genero);
        },
        success: function(datos) {
            data = JSON.parse(datos);
            var posicion = 0;
            $.each(data, function(i, item) {
                posicion=(i+1); 
                var id = item.Id;
                var link = item.Link;
                var titulo = item.Titulo;
                var autor = item.Autor;
                var Link = $("<a target='_blank' class='contadorDescargas' id='" +id+ "' rel='tooltip' href='" + link + "' data-toggle='tooltip' data-placement='right' title='Descargar " +titulo.toLowerCase()+ "'>" + titulo+ " - "+autor + "</a>");
                $('#part'+Genero+posicion).html(Link);
            });
            if(posicion<10){
                for(i=posicion+1;i<=10;i++){
                    $("#part"+Genero+i).css('display', 'none');
                }
            }
        },
        complete: function() {
            console.log('acabe el acceso a la funcion loadScoresGenero: '+Genero);
        },
        cache: false,
        error: function(data, errorThrown)
        {
            console.log('se produjo un error:  ' + errorThrown);
        }
    });
}

function ActualizarContadorDescargasPartitura(){
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

function ActivarMensajesTooltips(){
  if ($("[rel=tooltip]").length) {
        $("[rel=tooltip]").tooltip();
    }  
}
