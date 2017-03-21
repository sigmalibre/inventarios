(function () {
    var imagenes = $(".image-background-cover");

    imagenes.addClass("hidden");

    imagenes.each(function (index, element) {
        var img = $(element);

        var url = img.attr("src");

        var parent = img.parent();

        parent.css({
            "background-image": "url('" + url + "')",
            "background-position": "center center",
            "background-size": "cover"
        });
    });
}());
