/*global $ window*/

$(function () {
    'use strict';

    $('body').on('click', '.anchorize', function (event) {
        var url = $(event.currentTarget).data('href');
        window.location.href = url;
    });
});
