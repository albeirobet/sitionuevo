/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

function cerrarSesionIndex(){
       $.ajax({
        type: 'POST',
        url: 'funciones/funciones.php',
        data: "funcion=cerrarSesion",
        success: function(data) {
            var dataJson = eval(data);
            if(dataJson[0].estado=='No'){
                window.location='index.php';  
            }
        }
    }) 
}

function cerrarSesionResto(){
        $.ajax({
        type: 'POST',
        url: '../funciones/funciones.php',
        data: "funcion=cerrarSesion",
        success: function(data) {
            var dataJson = eval(data);
            if(dataJson[0].estado=='No'){
                window.location='../index.php';  
            }
        }
    })
}