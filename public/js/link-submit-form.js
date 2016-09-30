/*global $ */

$(function () {
    'use strict';

    $('body').on('click', '.link-submit', function (event) {
        event.preventDefault();

        var link = $(event.currentTarget);

        var input = $(':input[name="' + link.data('input') + '"]');
        input.val(link.data('value'));

        input.parent('form').submit();

        return false;
    });
});
