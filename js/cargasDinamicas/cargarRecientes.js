/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function(){
    cargar_Recientes();
    topDescargas();
    contadorVisitas();
    
    $(document).on('click', '.contadorDescargas',function()
    {  
        var idFila=$(this).attr('id');
        $.ajax({
            type: 'POST',
            url: 'funciones/funciones.php',
            data: "funcion=actualizarContadorDescargas&id="+idFila,
            success: function(data) {          
            }
        })
    }
    );
  
    $('.inicioSesionIndex').click(function(){
        window.location='paginas/RegistroLogin.php';  
    });
  
    $('.registroIndex').click(function(){
        window.location='paginas/RegistroLogin.php';  
    });
    
    
});

function cargar_Recientes(){
    $.ajax({
        type: "POST",
        url:"funciones/funciones.php",
        async: true,
        processData: true,
        data: "funcion=cargarRecientes",
        success: function(datos){
            //var select = document.getElementById("departamentos");
            var div1 =document.getElementById("div_recientes1");
            var div2 =document.getElementById("div_recientes2");
            var div3 =document.getElementById("div_recientes3");
            var div4 =document.getElementById("div_recientes4");
            var div5 =document.getElementById("div_recientes5");
            var div6 =document.getElementById("div_recientes6");
            var div7 =document.getElementById("div_recientes7");
            var div8 =document.getElementById("div_recientes8");
            var div9 =document.getElementById("div_recientes9");
            var dataJson = eval(datos);
            
            
            for(var i in dataJson){
                var Id = dataJson[i].Id;
                
                if(i==0){
                    var h4 = document.createElement("h4");
                    h4.setAttribute('class', 'indent-top');
                    var a = document.createElement("a");
                    a.setAttribute('target', '_blank');
                    a.setAttribute('href', dataJson[i].Link);
                    a.setAttribute('id', dataJson[i].Id);
                    a.setAttribute('class', 'contadorDescargas');
                    a.innerHTML = dataJson[i].Titulo;
                    h4.appendChild(a);
                    var p = document.createElement("p");
                    p.innerHTML=dataJson[i].Autor;
                    div1.appendChild(h4);
                    div1.appendChild(p);                      
                }
                if(i==1){
                    var h4 = document.createElement("h4");
                    h4.setAttribute('class', 'indent-top');
                    var a = document.createElement("a");
                    a.setAttribute('target', '_blank');
                    a.setAttribute('href', dataJson[i].Link);
                    a.setAttribute('class', 'contadorDescargas');
                    a.setAttribute('id', dataJson[i].Id);
                    a.innerHTML = dataJson[i].Titulo;
                    h4.appendChild(a);
                    var p = document.createElement("p");
                    p.innerHTML=dataJson[i].Autor;
                    div2.appendChild(h4);
                    div2.appendChild(p);                      
                }
                if(i==2){
                    var h4 = document.createElement("h4");
                    h4.setAttribute('class', 'indent-top');
                    var a = document.createElement("a");
                    a.setAttribute('target', '_blank');
                    a.setAttribute('href', dataJson[i].Link);
                    a.setAttribute('class', 'contadorDescargas');
                    a.setAttribute('id', dataJson[i].Id);
                    a.innerHTML = dataJson[i].Titulo;
                    h4.appendChild(a);
                    var p = document.createElement("p");
                    p.innerHTML=dataJson[i].Autor;
                    div3.appendChild(h4);
                    div3.appendChild(p);                      
                }
                if(i==3){
                    var h4 = document.createElement("h4");
                    h4.setAttribute('class', 'indent-top');
                    var a = document.createElement("a");
                    a.setAttribute('target', '_blank');
                    a.setAttribute('href', dataJson[i].Link);
                    a.setAttribute('class', 'contadorDescargas');
                    a.setAttribute('id', dataJson[i].Id);
                    a.innerHTML = dataJson[i].Titulo;
                    h4.appendChild(a);
                    var p = document.createElement("p");
                    p.innerHTML=dataJson[i].Autor;
                    div4.appendChild(h4);
                    div4.appendChild(p);                      
                }
                if(i==4){
                    var h4 = document.createElement("h4");
                    h4.setAttribute('class', 'indent-top');
                    var a = document.createElement("a");
                    a.setAttribute('target', '_blank');
                    a.setAttribute('href', dataJson[i].Link);
                    a.setAttribute('class', 'contadorDescargas');
                    a.setAttribute('id', dataJson[i].Id);
                    a.innerHTML = dataJson[i].Titulo;
                    h4.appendChild(a);
                    var p = document.createElement("p");
                    p.innerHTML=dataJson[i].Autor;
                    div5.appendChild(h4);
                    div5.appendChild(p);                      
                }
                if(i==5){
                    var h4 = document.createElement("h4");
                    h4.setAttribute('class', 'indent-top');
                    var a = document.createElement("a");
                    a.setAttribute('target', '_blank');
                    a.setAttribute('href', dataJson[i].Link);
                    a.setAttribute('class', 'contadorDescargas');
                    a.setAttribute('id', dataJson[i].Id);
                    a.innerHTML = dataJson[i].Titulo;
                    h4.appendChild(a);
                    var p = document.createElement("p");
                    p.innerHTML=dataJson[i].Autor;
                    div6.appendChild(h4);
                    div6.appendChild(p);                      
                }
                if(i==6){
                    var h4 = document.createElement("h4");
                    h4.setAttribute('class', 'indent-top');
                    var a = document.createElement("a");
                    a.setAttribute('target', '_blank');
                    a.setAttribute('href', dataJson[i].Link);
                    a.setAttribute('class', 'contadorDescargas');
                    a.setAttribute('id', dataJson[i].Id);
                    a.innerHTML = dataJson[i].Titulo;
                    h4.appendChild(a);
                    var p = document.createElement("p");
                    p.innerHTML=dataJson[i].Autor;
                    div7.appendChild(h4);
                    div7.appendChild(p);                      
                }
                if(i==7){
                    var h4 = document.createElement("h4");
                    h4.setAttribute('class', 'indent-top');
                    var a = document.createElement("a");
                    a.setAttribute('target', '_blank');
                    a.setAttribute('href', dataJson[i].Link);
                    a.setAttribute('class', 'contadorDescargas');
                    a.setAttribute('id', dataJson[i].Id);
                    a.innerHTML = dataJson[i].Titulo;
                    h4.appendChild(a);
                    var p = document.createElement("p");
                    p.innerHTML=dataJson[i].Autor;
                    div8.appendChild(h4);
                    div8.appendChild(p);                      
                }
                if(i==8){
                    var h4 = document.createElement("h4");
                    h4.setAttribute('class', 'indent-top');
                    var a = document.createElement("a");
                    a.setAttribute('target', '_blank');
                    a.setAttribute('href', dataJson[i].Link);
                    a.setAttribute('class', 'contadorDescargas');
                    a.setAttribute('id', dataJson[i].Id);
                    a.innerHTML = dataJson[i].Titulo;
                    h4.appendChild(a);
                    var p = document.createElement("p");
                    p.innerHTML=dataJson[i].Autor;
                    div9.appendChild(h4);
                    div9.appendChild(p);                      
                }
            }

        }
        
    });  
}

function topDescargas(){
    
    $.ajax({
        type: "POST",
        url:"funciones/funciones.php",
        async: true,
        processData: true,
        data: "funcion=topDescargas",
        success: function(data) {
            var posicion =1;
            var dataJson = eval(data);
            for(var i in dataJson){
                var Id = dataJson[i].Id;
                var Titulo = dataJson[i].Titulo;
                var Autor = dataJson[i].Autor;
                var Link = dataJson[i].Link;
                var Contador = dataJson[i].Contador;
                var topDescargas = $('<div class="wrapper img-indent-bot2">'
                    +'<time style="position: relative;float: left;" ><IMG SRC="images/clave.png" height="30" width="30" alt=""></time>'
                    +'<div class="extra-wrap" id="div_recientes1" style="position: relative;float: left;margin-top: -5px">'
                    +'<a target="_blank" href="'+Link+'"   class="contadorDescargas" id="'+Id+'"><h6>'+posicion+'. '+Titulo+' - '+Autor+' </h6>'+Contador+' Descargas</a>'
                    +'</div></div>');   
                $('.topDescargas').append(topDescargas);
                posicion++;
            }             
        }
        
    }); 



}



function contadorVisitas(){
    $.ajax({
        type: "POST",
        url:"funciones/funciones.php",
        async: true,
        processData: true,
        data: "funcion=contadorVisitas",
        success: function(data) {
            var dataJson = eval(data);
            var  visitas =dataJson[0].visitas;
            $('.contador').append(visitas);
        }
        
    });  
}

function navegacionPaginador(){
     $(document).on('click', '.contadorDescargas',function()
    {  
        var idFila=$(this).attr('id');
        $.ajax({
            type: 'POST',
            url: 'funciones/funciones.php',
            data: "funcion=actualizarContadorDescargas&id="+idFila,
            success: function(data) {          
            }
        })
    }
    );
}
