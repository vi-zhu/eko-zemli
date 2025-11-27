//Скрипт вставляет кнопку "вверх", нсли нужно чтобы кнопка останавливалась перед футером или к.-л. другим блоком, нужно дать ему class="upStoper". Для правильной работы, необходимо, чтобы высота body была равна высоте контента.
//Для выравнивания по контенту используется блок limiter(он может быть свой для каждой страницы и является стандартным блоком-выравнивателем контента) 
//Для работы требуется jquery (от 1.7)

$(window).on("load", function (e) {
	addUpBtn();
	scrollTop();
});

function addUpBtn() {
    var body = $("body"),
        upBtn = $('<div id="scrollTopWrap"><div class="container-fluid"><div class="container"> \n\t<div class="limiter">\n\t\t<a id="scrollTop" href="#">\n\t\t</a>\n\t</div>\n</div></div>\n</div>'),
        style = $('<style>body{position:relative;}#scrollTopWrap .limiter{position:relative;overflow:visible;}#scrollTopWrap {position: fixed;width:100%;bottom: 0;left: 0;height: 0px;z-index: 30000;display: none;}#scrollTop{right: 0;position: absolute;bottom: 60px;width: 50px;height: 50px;z-index: 30000;cursor: pointer;margin-right: -70px;background: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADQAAACeCAYAAAB9/yljAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAA2ZpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuMy1jMDExIDY2LjE0NTY2MSwgMjAxMi8wMi8wNi0xNDo1NjoyNyAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wTU09Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9tbS8iIHhtbG5zOnN0UmVmPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvc1R5cGUvUmVzb3VyY2VSZWYjIiB4bWxuczp4bXA9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC8iIHhtcE1NOk9yaWdpbmFsRG9jdW1lbnRJRD0ieG1wLmRpZDpGOTdGMTE3NDA3MjA2ODExODIyQTgyRkYxNDNFNzc1MiIgeG1wTU06RG9jdW1lbnRJRD0ieG1wLmRpZDo0MjAyRTVFQTNGMzgxMUU0QUQyQjlFMEU5MTQ1NDU3MiIgeG1wTU06SW5zdGFuY2VJRD0ieG1wLmlpZDo0MjAyRTVFOTNGMzgxMUU0QUQyQjlFMEU5MTQ1NDU3MiIgeG1wOkNyZWF0b3JUb29sPSJBZG9iZSBQaG90b3Nob3AgQ1M2IChXaW5kb3dzKSI+IDx4bXBNTTpEZXJpdmVkRnJvbSBzdFJlZjppbnN0YW5jZUlEPSJ4bXAuaWlkOkZBN0YxMTc0MDcyMDY4MTE4MjJBODJGRjE0M0U3NzUyIiBzdFJlZjpkb2N1bWVudElEPSJ4bXAuZGlkOkY5N0YxMTc0MDcyMDY4MTE4MjJBODJGRjE0M0U3NzUyIi8+IDwvcmRmOkRlc2NyaXB0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) no-repeat;}#scrollTop:hover {background-position: 0 -54px;}#scrollTop:active{background-position:0 0;}@media screen and (max-width:1160px){#scrollTopWrap .limiter{width: 100%;-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;}#scrollTop{margin-right: -10px !important;background-position: 0 -107px;}#scrollTop:hover{background-position: 0 -54px;}}</style>');
    body.append(upBtn);
    body.append(style);
};

function scrollTop() {
    var btn = $("#scrollTop"),
        btnCont = $("#scrollTopWrap"),
        docH = $(document).height();

    $(document).click(function () {
        var docH2 = $(document).height();
        setTimeout(function () {
            if (docH != docH2) {
                docH = docH2;
               //console.log(docH2 + " : " + docH);
               checkH();
            }
        }, 500);
            
        })

    btn.click(function (e) {
        e.preventDefault();
        $('html, body').animate({ scrollTop: 0 }, '600');
    });

    checkH();

    $(window).scroll(function () {
        checkH();
    });

    $(window).resize(function () {
        checkH();
    });

    function checkH() {

        var scrollTW = $(window).scrollTop(); 
        var winW = $(window).width(),
            winScrollL = $(window).scrollLeft();

        if (scrollTW > 500) { btnCont.show(); } //появление кнопки вверх
        else btnCont.hide(); //исчезновения кнопки вверх


        if ($(".upStoper").length) {
            var upStoper = $(".upStoper"),
                posStoper = $(".upStoper").offset().top,
                docH = $(document).height(),
                upStoperH = docH - posStoper,
                delta = $(window).height() - upStoperH;
                
                //alert('scrollTW:'+scrollTW+', delta:'+delta+', docH:'+docH+', upStoperH:'+upStoperH);

            if ((scrollTW + delta) >= (docH - 2*upStoperH)) {//умножаем на 2 --- учитывааем момент .upStoper внизу экрана
                var bottom = upStoperH;
                var winW = $(window).width(),
                winScrollL = $(window).scrollLeft();
                btnCont.css({ "position": "absolute", "bottom": bottom });
                if (winW + winScrollL < $(document).width()) btn.css({ "right": $(document).width() - (winW + winScrollL) });
                else btn.css({ "right": "" });
            }
            else {
                btnCont.css({ "position": "fixed", "bottom": 0 });
                btn.css({ "right": "" });
            }
        }

    };
};