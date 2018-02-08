(function ( $ ) {
  "use strict";
  $.fn.toImage = function () {

    $(this).each(function () {

        let i = (new Date()).getTime();

        //Подключаемые элементы для svg <path>, mathjax отображает отдельно в <head>
        let $glyphs = $("#MathJax_SVG_glyphs").clone();

        $glyphs.attr("id", "MathJax_SVG_glyphs-" + i).find("path").each(function(j, path) {
            $(path).attr("id", $(path).attr("id") + "-" + i);
        });

        //Вставляем в сам элемент svg
        $(this).prepend($glyphs);
        $(this).attr("id", "svg-"+i);

        //И привязываем id <path> к id <use>
        $(this).find("use").each(function (j, use) {
            $(use).attr("href", $(use).attr("href") + "-" + i);
        });

        let that = this;
        //Сериализация для svg элемента
        let svgData = new XMLSerializer().serializeToString(this);

        let image = new Image();
        image.src = "data:image/svg+xml;base64," + btoa(svgData);

        //Создаём canvas объект
        let canvas = document.createElement("canvas");
        let context = canvas.getContext("2d");
        canvas.width = this.getBoundingClientRect().width*0.9;
        canvas.height = this.getBoundingClientRect().height;

        image.onload = function() {
            //Вставляем изображение в canvas
            context.drawImage(image, 0, 0);

            //Преобразуем svg формат в png
            let canvasdata = canvas.toDataURL("image/png", 1.0);

            let $img = $("<img></img>");
            //var div = $('<div></div>').addClass('SVG_Display');
            $img.attr({"id": "img-"+i, 'src':canvasdata});
            //div.append($img);
            $(that).parent().parent().after($img).remove();
      };

    });
  };
})( jQuery );