/*global $ */

$(function () {
    'use strict';
    $('body').on('input propertychange', '.has-clear input[type="text"]', function (event) {
        var visible = Boolean($(event.currentTarget).val());
        $(event.currentTarget).siblings('.form-control-clear').toggleClass('hidden', !visible);
    }).trigger('propertychange');

    $('body').on('click', '.form-control-clear', function (event) {
        $(event.currentTarget).siblings('input[type="text"]').val('').trigger('propertychange').focus();
    });
});
