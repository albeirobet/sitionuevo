/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function() {
    activoIconosMenu();
});


function  activoIconosMenu() {
    $(".activo_comentario").mouseover(function() {
        $("#activo_comentario").addClass("icon-white");
    });
    $(".activo_comentario").mouseout(function() {
        $("#activo_comentario").removeClass("icon-white");
    });

    $(".activo_quienes_somos").mouseover(function() {
        $("#activo_quienes_somos").addClass("icon-white");
    });
    $(".activo_quienes_somos").mouseout(function() {
        $("#activo_quienes_somos").removeClass("icon-white");
    });

    $(".activo_partituras").mouseover(function() {
        $("#activo_partituras").addClass("icon-white");
    });
    $(".activo_partituras").mouseout(function() {
        $("#activo_partituras").removeClass("icon-white");
    });

    $(".activo_inicio").mouseover(function() {
        $("#activo_inicio").addClass("icon-white");
    });
    $(".activo_inicio").mouseout(function() {
        $("#activo_inicio").removeClass("icon-white");
    });
    
     $(".activo_login_registro").mouseover(function() {
        $("#activo_login_registro").addClass("icon-white");
    });
    $(".activo_login_registro").mouseout(function() {
        $("#activo_login_registro").removeClass("icon-white");
    });
}
