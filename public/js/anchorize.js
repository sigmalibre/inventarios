/*global $ window*/

$(function () {
    'use strict';

    $('body').on('click', '.anchorize', function (event) {
        if (window.getSelection().toString().length === 0) {
            window.location.href = $(event.currentTarget).data('href');
        }
    });
    
});
