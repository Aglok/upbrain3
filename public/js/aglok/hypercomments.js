
// Выводит количество комментариев
let WIDGET_ID = 99093;
const selector = '.count-comments';
const label = "{%COUNT%}";


_hcwp = window._hcwp || [];
_hcwp.push({widget:"Bloggerstream", widget_id: WIDGET_ID, selector: selector , label: label});

(function() {
    if("HC_LOAD_INIT" in window)return;
    HC_LOAD_INIT = true;
    var lang = (navigator.language || navigator.systemLanguage || navigator.userLanguage ||  "en").substr(0, 2).toLowerCase();
    var hcc = document.createElement("script"); hcc.type = "text/javascript"; hcc.async = true;
    hcc.src = ("https:" == document.location.protocol ? "https" : "http")+"://w.hypercomments.com/widget/hc/" +WIDGET_ID+"/"+lang+"/widget.js";
    var s = document.getElementsByTagName("script")[0];
    s.parentNode.insertBefore(hcc, s.nextSibling);
})();