window.onload = function () {
    'use strict';

    /* Constants */
    // Sorry don't know what that element does yet, so the name is just generic.
    var ELEM = document.getElementById('b_regenFiles');

    ELEM.addEventListener('click', function (event) {
        var check = window.confirm(
            "You are about to regenerate all output files.\n" +
            "This will overwrite all existing files!\n\n" + 
            "Are you sure that you want to do this?");
        if (!check) {
            event.preventDefault();
        }
    });
};