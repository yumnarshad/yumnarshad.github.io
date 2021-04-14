! function() {
    function e(e) {
        this.element = e, this.blocks = this.element.getElementsByClassName("js-cd-block"), this.images = this.element.getElementsByClassName("js-cd-img"), this.contents = this.element.getElementsByClassName("js-cd-content"), this.offset = .8, this.hideBlocks()
    }
    e.prototype.hideBlocks = function() {
        if (!(!1 in document.documentElement))
            for (var e, t = this, n = 0; n < this.blocks.length; n++) e = n, t.blocks[e].getBoundingClientRect().top > window.innerHeight * t.offset && (t.images[e].classList.add("cd-is-hidden"), t.contents[e].classList.add("cd-is-hidden"))
    }, e.prototype.showBlocks = function() {
        if (!(!1 in document.documentElement))
            for (var e, t = this, n = 0; n < this.blocks.length; n++) e = n, t.contents[e].classList.contains("cd-is-hidden") && t.blocks[e].getBoundingClientRect().top <= window.innerHeight * t.offset && (t.images[e].classList.add("cd-timeline__img--bounce-in"), t.contents[e].classList.add("cd-timeline__content--bounce-in"), t.images[e].classList.remove("cd-is-hidden"), t.contents[e].classList.remove("cd-is-hidden"))
    };
    var t, n = document.getElementsByClassName("js-cd-timeline"),
        o = [],
        s = !1;
    if (n.length > 0) {
        for (var i = 0; i < n.length; i++) t = i, o.push(new e(n[t]));
        window.addEventListener("scroll", function(e) {
            s || (s = !0, window.requestAnimationFrame ? window.requestAnimationFrame(d) : setTimeout(d, 250))
        })
    }

    function d() {
        o.forEach(function(e) {
            e.showBlocks()
        }), s = !1
    }
}(), $(document).ready(function() {
    $("#showModal").on("show.bs.modal", function(e) {
        $(".portfolio-wrapper ul li a").addClass("bnw");
        var t = $(e.relatedTarget),
            n = t.data("projname"),
            o = t.data("projdesc"),
            s = t.data("projres"),
            i = t.data("projtech"),
            d = t.data("projimgs");
        modal = $(this), modal.find(".modal-title").text(n), modal.find("#folio-res").text(s), modal.find("#proj-desc").text(o), $.each(d, function(e, t) {
            var n = "<a href='" + t + "' target='_blank'><img src='" + t + "' class='src img-responsive'></a>";
            modal.find("#folio-imgs").append(n)
        }), $.each(i, function(e, t) {
            var n = "<li>" + t + "</li>";
            modal.find("#tech-used").append(n)
        })
    }), $("#showModal").on("hidden.bs.modal", function(e) {
        $(".portfolio-wrapper ul li a").removeClass("bnw"), modal.find("#folio-imgs, #tech-used,#folio-res, #proj-desc").empty()
    });
    var e = (new Date).getHours();
    e < 12 ? ($(".about-me").addClass("good-morning"), $(".sun-anim").removeClass("hidden"), $("#wlcm").text(" Good Morning!")) : e < 18 ? $("#wlcm").text(" Good After noon!") : ($(".about-me").addClass("good-evening"), $(".twinkle-stars").removeClass("hidden"), $("#wlcm").text(" Good Evening!"))
}), /*$(window).on("load", function() {
    $("body").css("overflow : hidden"), setTimeout(function() {
        $("#splashscreen").fadeOut(), $("body").removeClass("no-scroll"), $("html, body").animate({
            scrollTop: 0
        }, 10)
    }, 3e3)*/
$(".hello > span:gt(0)").hide(), setInterval(function() {
    $(".hello > span:first").fadeOut(300).next().fadeIn(300).end().appendTo(".hello")
}, 300);