/*global $ */

$(function () {
    'use strict';

    $('body').on('change', '.new-product-category-select', function (event) {
        if (event.currentTarget.value.length === 0) {
            $('.new-product-cat-preview').text('--');
            return;
        }
        $('.new-product-cat-preview').text(event.currentTarget.value);
    });
});
