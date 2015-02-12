window.onload = function () {
    'use strict';
    
    document.getElementById("b_regenFiles").onclick = function (event) {
        var check = window.confirm(
            "You are about to regenerate all output files.\n" +
            "This will overwrite all existing files!\n\n" + 
            "Are you sure that you want to do this?");
        if (!check) {
            event.preventDefault();
        }
    };
};