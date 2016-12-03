/*global $ */

$(function () {
    'use strict';

    var setValue = function () {
        if ($('.new-product-category-select').val().length === 0) {
            $('.new-product-cat-preview').text('--');
            return;
        }
        $('.new-product-cat-preview').text($('.new-product-category-select').val());
    };

    $('body').on('change', '.new-product-category-select', function () {
        setValue();
    });

    setValue();
});
