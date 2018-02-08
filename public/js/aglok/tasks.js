$(function () {
    $('body').on('click', function () {
        //Инициализирует формулы
        MathJax.Hub.Queue(["Typeset", MathJax.Hub]);
    });
});