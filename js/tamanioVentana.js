/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


$(document).ready(function() {
    window.onresize = function() {
        var d = document.getElementById("tamventana");
        while (d.hasChildNodes()) {
            d.removeChild(d.firstChild);
        }
        var Tam = TamVentana();
        $('.tamventana').append(Tam);
    };
});


function TamVentana() {
    var Tamanyo = [0, 0];
    if (typeof window.innerWidth != 'undefined')
    {
        Tamanyo = [
            window.innerWidth,
            window.innerHeight
        ];
    }
    else if (typeof document.documentElement != 'undefined'
            && typeof document.documentElement.clientWidth !=
            'undefined' && document.documentElement.clientWidth != 0)
    {
        Tamanyo = [
            document.documentElement.clientWidth,
            document.documentElement.clientHeight
        ];
    }
    else {
        Tamanyo = [
            document.getElementsByTagName('body')[0].clientWidth,
            document.getElementsByTagName('body')[0].clientHeight
        ];
    }
    return Tamanyo;
}

