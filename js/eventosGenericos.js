function is_email(email) {
    var result = email.search(/^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z]{2,3})+$/);
    if (result > -1) {
        return true;
    } else {
        return false;
    }
}

function activarObjetoAjax(estado) {
    if (estado === 1)
        $('#ajaxModal').modal({backdrop: 'static', keyboard: false});
    if (estado === 0)
        $('#ajaxModal').modal('hide');
}

//Imprimir un vector json en un alert.
function print_r(arr, level) {
    var dumped_text = "";
    if (!level)
        level = 0;

//The padding given at the beginning of the line.
    var level_padding = "";
    for (var j = 0; j < level + 1; j++)
        level_padding += "    ";

    if (typeof(arr) == 'object') { //Array/Hashes/Objects 
        for (var item in arr) {
            var value = arr[item];

            if (typeof(value) == 'object') { //If it is an array,
                dumped_text += level_padding + "'" + item + "' ...\n";
                dumped_text += print_r(value, level + 1);
            } else {
                dumped_text += level_padding + "'" + item + "' => \"" + value + "\"\n";
            }
        }
    } else { //Stings/Chars/Numbers etc.
        dumped_text = "===>" + arr + "<===(" + typeof(arr) + ")";
    }
    return dumped_text;
}



function checkUsername(username) {
    var iChars = "!@#$%^&*()+=-[]\\';,./{}|\":<>?";
    if (username.search(" ") == -1) {
        for (var i = 0; i < username.length; i++) {
            if (iChars.indexOf(username.charAt(i)) != -1) {
               return false;
            }
        }
        return true;
    } else {
        return false;
    }
}


