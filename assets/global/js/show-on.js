jQuery.fn.showOn = function(n) {
    $(this).each(function() {
        $(this).focus(function() {
            var i = n.bind[$(this).attr("id")];
            $(n.target).find("img").css({
                transform: "scale(" + i[1] + ")",
                "transform-origin": i[0]
            })
        }).blur(function() {
            $(n.target).find("img").css({
                transform: "scale(1)",
                "transform-origin": "0 0"
            })
        })
    })
}, $(function() {});