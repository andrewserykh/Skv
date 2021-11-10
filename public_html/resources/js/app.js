"use strict";
$(document).ready(function () {
    $("body").on("click", "[data-sa-action]", function (e) {
        e.preventDefault();
        var t = $(this), a = "";
        switch (t.data("sa-action")) {
            case"search-open":
                $(".search").addClass("search--toggled");
                break;
            case"search-close":
                $(".search").removeClass("search--toggled");
                break;
            case"aside-open":
                a = t.data("sa-target"), t.addClass("toggled"), $("body").addClass("aside-toggled"), $(a).addClass("toggled"), $(".content, .header").append('<div class="sa-backdrop" data-sa-action="aside-close" data-sa-target=' + a + " />");
                break;
            case"aside-close":
                a = t.data("sa-target"), $("body").removeClass("aside-toggled"), $('[data-sa-action="aside-open"], ' + a).removeClass("toggled"), $(".content, .header").find(".sa-backdrop").remove();
                break;
            case"fullscreen":
                !function (e) {
                    e.requestFullscreen ? e.requestFullscreen() : e.mozRequestFullScreen ? e.mozRequestFullScreen() : e.webkitRequestFullscreen ? e.webkitRequestFullscreen() : e.msRequestFullscreen && e.msRequestFullscreen()
                }(document.documentElement);
                break;
            case"print":
                window.print();
                break;
            case"login-switch":
                a = t.data("sa-target"), $(".login__block").removeClass("active"), $(a).addClass("active");
                break;
            case"notifications-clear":
                e.stopPropagation();
                var o = $(".top-nav__notifications .listview__item"), i = o.length, l = 0;
                t.fadeOut(), o.each(function () {
                    var e = $(this);
                    setTimeout(function () {
                        e.addClass("animated fadeOutRight")
                    }, l += 150)
                }), setTimeout(function () {
                    o.remove(), $(".top-nav__notifications").addClass("top-nav__notifications--cleared")
                }, 180 * i);
                break;
            case"toolbar-search-open":
                $(this).closest(".toolbar").find(".toolbar__search").fadeIn(200), $(this).closest(".toolbar").find(".toolbar__search input").focus();
                break;
            case"toolbar-search-close":
                $(this).closest(".toolbar").find(".toolbar__search input").val(""), $(this).closest(".toolbar").find(".toolbar__search").fadeOut(200)
        }
    })
}), $(window).on("load", function () {
    setTimeout(function () {
        $(".page-loader").fadeOut()
    }, 500)
}), $(window).on("scroll", function () {
    20 <= $(window).scrollTop() ? $(".header").addClass("header--scrolled") : $(".header").removeClass("header--scrolled")
}), $(document).ready(function () {
    var a = $("body");
    if ($(".clock")[0]) {
        var e = new Date;
        e.setDate(e.getDate()), setInterval(function () {
            var e = (new Date).getSeconds();
            $(".time__sec").html((e < 10 ? "0" : "") + e)
        }, 1e3), setInterval(function () {
            var e = (new Date).getMinutes();
            $(".time__min").html((e < 10 ? "0" : "") + e)
        }, 1e3), setInterval(function () {
            var e = (new Date).getHours();
            $(".time__hours").html((e < 10 ? "0" : "") + e)
        }, 1e3)
    }
    a.on("click", ".themes__item", function (e) {
        e.preventDefault(), $(".themes__item").removeClass("active"), $(this).addClass("active");
        var t = $(this).data("sa-value");
        a.attr("data-sa-theme", t)
    }), a.on("focus", ".search__text", function () {
        $(this).closest(".search").addClass("search--focus")
    }), a.on("blur", ".search__text", function () {
        $(this).val(""), $(this).closest(".search").removeClass("search--focus")
    }), a.on("click", ".navigation__sub > a", function (e) {
        e.preventDefault(), $(this).parent().toggleClass("navigation__sub--toggled"), $(this).next("ul").slideToggle(250)
    }), $(".form-group--float")[0] && ($(".form-group--float").each(function () {
        0 == !$(this).find(".form-control").val().length && $(this).find(".form-control").addClass("form-control--active")
    }), a.on("blur", ".form-group--float .form-control", function () {
        0 == $(this).val().length ? $(this).removeClass("form-control--active") : $(this).addClass("form-control--active")
    })), a.on("click", ".dropdown-menu--active", function (e) {
        e.stopPropagation()
    })
}), $(document).ready(function () {
    $(".textarea-autosize")[0] && autosize($(".textarea-autosize"))
}), $(document).ready(function () {
    $(".color-picker")[0] && ($(".color-picker__value").colorpicker(), $("body").on("change", ".color-picker__value", function () {
        $(this).closest(".color-picker").find(".color-picker__preview").css("backgroundColor", $(this).val())
    }))
}), $(document).ready(function () {
    $('[data-toggle="popover"]')[0] && $('[data-toggle="popover"]').popover(), $('[data-toggle="tooltip"]')[0] && $('[data-toggle="tooltip"]').tooltip(), $("body").on("change", ".custom-file-input", function () {
        var e = $(this).val();
        $(this).next(".custom-file-label").html(e)
    }), $("body").on("click", '[data-dismiss="toast"]', function () {
        $(this).closest(".toast").toast("hide")
    })
}), $(document).ready(function () {
    var a;
    $(".notes__body")[0] && $(".notes__body").each(function (e, t) {
        a = $(this).prev().is(".notes__title") ? 4 : 6, $clamp(t, {clamp: a})
    })
}), $(document).ready(function () {
    if ($("#data-table")[0]) {
        $("#data-table").DataTable({
            autoWidth: !1,
            responsive: !0,
            lengthMenu: [[15, 30, 45, -1], ["15 Rows", "30 Rows", "45 Rows", "Everything"]],
            language: {searchPlaceholder: "Search for records..."},
            sDom: '<"dataTables__top"flB<"dataTables_actions">>rt<"dataTables__bottom"ip><"clear">',
            buttons: [{extend: "excelHtml5", title: "Export Data"}, {
                extend: "csvHtml5",
                title: "Export Data"
            }, {extend: "print", title: "Material Admin"}],
            initComplete: function () {
                $(".dataTables_actions").html('<i class="zwicon-more-h" data-toggle="dropdown" /><div class="dropdown-menu dropdown-menu-right"><a data-table-action="print" class="dropdown-item">Print</a><a data-table-action="fullscreen" class="dropdown-item">Fullscreen</a><div class="dropdown-divider" /><div class="dropdown-header border-bottom-0 pt-0"><small>Download as</small></div><a data-table-action="excel" class="dropdown-item">Excel (.xlsx)</a><a data-table-action="csv" class="dropdown-item">CSV (.csv)</a></div>')
            }
        }), $("body").on("click", "[data-table-action]", function (e) {
            e.preventDefault();
            var t = $(this).data("table-action");
            if ("excel" === t && $("#data-table_wrapper").find(".buttons-excel").click(), "csv" === t && $("#data-table_wrapper").find(".buttons-csv").click(), "print" === t && $("#data-table_wrapper").find(".buttons-print").click(), "fullscreen" === t) {
                var a = $(this).closest(".card");
                a.hasClass("card--fullscreen") ? (a.removeClass("card--fullscreen"), $body.removeClass("data-table-toggled")) : (a.addClass("card--fullscreen"), $body.addClass("data-table-toggled"))
            }
        })
    }
}), $("#dropzone-upload")[0] && (Dropzone.autoDiscover = !1), $(document).ready(function () {
    $("#dropzone-upload")[0] && $("#dropzone-upload").dropzone({url: "/file/post", addRemoveLinks: !0})
}), $(document).ready(function () {
    $(".datetime-picker")[0] && $(".datetime-picker").flatpickr({
        enableTime: !0,
        nextArrow: '<i class="zwicon-arrow-right" />',
        prevArrow: '<i class="zwicon-arrow-left" />'
    }), $(".date-picker")[0] && $(".date-picker").flatpickr({
        enableTime: !1,
        nextArrow: '<i class="zwicon-arrow-right" />',
        prevArrow: '<i class="zwicon-arrow-left" />'
    })
}), $(document).ready(function () {
    var e = [{name: "node1", children: [{name: "node1_1"}, {name: "node1_2"}, {name: "node1_3"}]}, {
        name: "node2",
        children: [{name: "node2_1"}, {name: "node2_2"}, {name: "node2_3"}]
    }];
    $(".treeview")[0] && $(".treeview").tree({
        data: [{
            name: "node1",
            children: [{
                name: "node1_1",
                children: [{name: "node1_1_1"}, {name: "node1_1_2"}, {name: "node1_1_3"}]
            }, {name: "node1_2"}, {name: "node1_3"}]
        }, {name: "node2", children: [{name: "node2_1"}, {name: "node2_2"}, {name: "node2_3"}]}, {
            name: "node3",
            children: [{name: "node3_1"}, {name: "node3_2"}, {name: "node3_3"}]
        }], closedIcon: $('<i class="zwicon-plus"></i>'), openedIcon: $('<i class="zwicon-minus"></i>')
    }), $(".treeview-expanded")[0] && $(".treeview-expanded").tree({
        data: e,
        autoOpen: !0,
        closedIcon: $('<i class="zwicon-plus"></i>'),
        openedIcon: $('<i class="zwicon-minus"></i>')
    }), $(".treeview-drag")[0] && $(".treeview-drag").tree({
        data: e,
        dragAndDrop: !0,
        autoOpen: !0,
        closedIcon: $('<i class="zwicon-plus"></i>'),
        openedIcon: $('<i class="zwicon-minus"></i>')
    }), $(".treeview-escape")[0] && $(".treeview-escape").tree({
        data: [{
            label: "node1",
            children: [{name: '<a href="example1.html">node1_1</a>'}, {name: '<a href="example2.html">node1_2</a>'}, '<a href="example3.html">Example </a>']
        }],
        autoEscape: !1,
        autoOpen: !0,
        closedIcon: $('<i class="zwicon-plus"></i>'),
        openedIcon: $('<i class="zwicon-minus"></i>')
    })
}), $(document).ready(function () {
    $("input-mask")[0] && $(".input-mask").mask()
}), $(document).ready(function () {
    $(".text-counter")[0] && $(".text-counter").each(function () {
        var e = $(this).data("min-length") || 0, t = $(this).data("max-length");
        $(this).textcounter({
            min: e,
            max: t,
            countDown: !0,
            inputErrorClass: "is-invalid",
            counterErrorClass: "text-red"
        })
    })
}), $(document).ready(function () {
    $(".easy-pie-chart")[0] && $(".easy-pie-chart").each(function () {
        $(this).data("value");
        var e = $(this).data("size"), t = $(this).data("track-color"), a = $(this).data("bar-color");
        $(this).find(".easy-pie-chart__value").css({
            lineHeight: e - 2 + "px",
            fontSize: e / 5 + "px",
            color: a
        }), $(this).easyPieChart({
            easing: "easeOutBounce",
            barColor: a,
            trackColor: t,
            scaleColor: "rgba(255,255,255,0.15)",
            lineCap: "round",
            lineWidth: 1,
            size: e,
            animate: 3e3,
            onStep: function (e, t, a) {
                $(this.el).find(".percent").text(Math.round(a))
            }
        })
    })
}), $(document).ready(function () {
    $(".map-visitors")[0] && $(".map-visitors").vectorMap({
        map: "world_en",
        backgroundColor: "rgba(0,0,0,0)",
        color: "rgba(255,255,255,0.2)",
        borderColor: "rgba(255,255,255,0.2)",
        hoverOpacity: 1,
        selectedColor: "rgba(255,255,255,0.9)",
        enableZoom: !1,
        showTooltip: !0,
        normalizeFunction: "polynomial",
        selectedRegions: ["US", "EN", "NZ", "CN", "JP", "SL", "BR", "AU", "EG", "BA"],
        onRegionClick: function (e) {
            e.preventDefault()
        }
    }), $(".jqvmap")[0] && $(".jqvmap").each(function () {
        var e = $(this).data("map");
        $(this).vectorMap({
            map: e,
            backgroundColor: "rgba(0,0,0,0)",
            color: "rgba(255,255,255,0.5)",
            borderColor: "rgba(255,255,255,0.5)",
            hoverColor: "rgba(255,255,255,0.75)",
            selectedColor: "#fff",
            enableZoom: !0
        })
    })
}), $(document).ready(function () {
    $(".lightbox")[0] && $(".lightbox").lightGallery({enableTouch: !0})
}), $(document).ready(function () {
    if ($("#input-slider")[0]) {
        var e = document.getElementById("input-slider");
        noUiSlider.create(e, {
            start: [20],
            connect: "lower",
            range: {min: 0, max: 100}
        }), e.noUiSlider.on("update", function (e, t) {
            document.getElementById("input-slider-value").value = e[t]
        })
    }
    if ($("#input-slider-range")[0]) {
        var t = document.getElementById("input-slider-range"),
            a = [document.getElementById("input-slider-range-value-1"), document.getElementById("input-slider-range-value-2")];
        noUiSlider.create(t, {
            start: [20, 80],
            connect: !0,
            range: {min: 0, max: 100}
        }), t.noUiSlider.on("update", function (e, t) {
            a[t].value = e[t]
        })
    }
    if ($(".input-slider")[0])for (var o = document.getElementsByClassName("input-slider"),
                                       i = 0; i < o.length; i++)noUiSlider.create(o[i], {
        start: [20],
        connect: "lower",
        range: {min: 0, max: 100}
    })
}), $(document).ready(function () {
    var e = $(".scrollbar");
    e[0] && e.overlayScrollbars({scrollbars: {autoHide: "l", clickScrolling: !0}, className: "os-theme-light"})
}), $(document).ready(function () {
    $(".peity-bar")[0] && $(".peity-bar").each(function () {
        var e = $(this).attr("data-width") ? $(this).attr("data-width") : 65;
        $(this).peity("bar", {height: 36, fill: ["rgba(255,255,255,0.85)"], width: e, padding: .2})
    }), $(".peity-line")[0] && $(".peity-line").each(function () {
        var e = $(this).attr("data-width") ? $(this).attr("data-width") : 65;
        $(this).peity("line", {
            height: 50,
            fill: "rgba(255,255,255,0.8)",
            stroke: "rgba(255,255,255,0)",
            width: e,
            padding: .2
        })
    }), $(".peity-pie")[0] && $(".peity-pie").each(function () {
        $(this).peity("pie", {fill: ["#fff", "rgba(255,255,255,0.6)", "rgba(255,255,255,0.2)"], height: 50, width: 50})
    }), $(".peity-donut")[0] && $(".peity-donut").each(function () {
        $(this).peity("donut", {
            fill: ["#fff", "rgba(255,255,255,0.6)", "rgba(255,255,255,0.2)"],
            height: 50,
            width: 50
        })
    })
}), $(document).ready(function () {
    $(".rating")[0] && $(".rating").each(function () {
        var e = $(this).data("rating");
        $(this).rateYo({rating: e, normalFill: "rgba(255,255,255,0.3)", ratedFill: "#ffc107"})
    })
}), $(document).ready(function () {
    if ($("select.select2")[0]) {
        var e = $(".select2-parent")[0] ? $(".select2-parent") : $("body");
        $("select.select2").select2({dropdownAutoWidth: !0, width: "100%", dropdownParent: e})
    }
}), $(document).ready(function () {
    $("#sa-basic").click(function () {
        swal.fire({
            text: "You clicked the button!",
            background: "#000",
            backdrop: "rgba(0,0,0,0.2)",
            buttonsStyling: !1,
            padding: "3rem 3rem 2rem",
            customClass: {confirmButton: "btn btn-link", title: "ca-title", container: "ca"}
        })
    }), $("#sa-basic-title").click(function () {
        swal.fire({
            title: "Good job!",
            text: "You clicked the button!",
            background: "#000",
            backdrop: "rgba(0,0,0,0.2)",
            buttonsStyling: !1,
            padding: "3rem 3rem 2rem",
            customClass: {confirmButton: "btn btn-link", title: "ca-title", container: "ca"}
        })
    }), $("#sa-basic-footer").click(function () {
        swal.fire({
            title: "Good job!",
            text: "You clicked the button!",
            background: "#000",
            backdrop: "rgba(0,0,0,0.2)",
            buttonsStyling: !1,
            padding: "3rem 3rem 2rem",
            customClass: {confirmButton: "btn btn-link", title: "ca-title", container: "ca"},
            footer: "<a href>Why do I have this issue?</a>"
        })
    }), $("#sa-basic-content").click(function () {
        swal.fire({
            title: "Good job!",
            text: "Etiam porta sem malesuada magna mollis euismod. Vestibulum id ligula porta felis euismod semper. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean lacinia bibendum nulla sed consectetur. Maecenas faucibus mollis interdum. Nullam id dolor id nibh ultricies vehicula ut id elit. Aenean eu leo quam. Pellentesque ornare sem lacinia quam venenatis vestibulum. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec ullamcorper nulla non metus auctor fringilla. Aenean lacinia bibendum nulla sed consectetur. Aenean lacinia bibendum nulla sed consectetur. Cras mattis consectetur purus sit amet fermentum. Morbi leo risus, porta ac consectetur ac, vestibulum at eros. Nulla vitae elit libero, a pharetra augue. Aenean lacinia bibendum nulla sed consectetur. Aenean lacinia bibendum nulla sed consectetur. Sed posuere consectetur est at lobortis. Nulla vitae elit libero, a pharetra augue. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. Morbi leo risus, porta ac consectetur ac, vestibulum at eros. Aenean eu leo quam. Pellentesque ornare sem lacinia quam venenatis vestibulum. Curabitur blandit tempus porttitor. Etiam porta sem malesuada magna mollis euismod. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Etiam porta sem malesuada magna mollis euismod. Nulla vitae elit libero, a pharetra augue. Donec ullamcorper nulla non metus auctor fringilla. Nulla vitae elit libero, a pharetra augue. Vestibulum id ligula porta felis euismod semper. Nulla vitae elit libero, a pharetra augue. Donec ullamcorper nulla non metus auctor fringilla. Morbi leo risus, porta ac consectetur ac, vestibulum at eros. Integer posuere erat a ante venenatis dapibus posuere velit aliquet. Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit. Morbi leo risus, porta ac consectetur ac, vestibulum at eros. Sed posuere consectetur est at lobortis. Etiam porta sem malesuada magna mollis euismod. Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Sed posuere consectetur est at lobortis. Aenean lacinia bibendum nulla sed consectetur.",
            background: "#000",
            backdrop: "rgba(0,0,0,0.2)",
            buttonsStyling: !1,
            padding: "3rem 3rem 2rem",
            customClass: {confirmButton: "btn btn-link", container: "ca"}
        })
    }), $("#sa-basic-html").click(function () {
        swal.fire({
            title: '<span class="text-green">Good</span> &nbsp;job!',
            html: '<span class="text-red">You</span> clicked this <u>awesome</u> button! <i class="text-yellow zwicon-smile"></i>',
            background: "#000",
            backdrop: "rgba(0,0,0,0.2)",
            buttonsStyling: !1,
            padding: "3rem 3rem 2rem",
            customClass: {confirmButton: "btn btn-link", title: "ca-title", container: "ca"}
        })
    }), $(".btn-sa-types").on("click", function () {
        var e = $(this).data("type");
        swal.fire({
            type: e.toLowerCase(),
            title: e + "!",
            text: "You clicked the " + e.toLowerCase() + " button!",
            background: "#000",
            backdrop: "rgba(0,0,0,0.2)",
            buttonsStyling: !1,
            padding: "3rem 3rem 2rem",
            customClass: {confirmButton: "btn btn-link", title: "ca-title", container: "ca"}
        })
    }), $(".btn-sa-position").on("click", function () {
        var e = $(this).data("position");
        swal.fire({
            position: e,
            title: "Good job!!",
            text: "You clicked the right button!",
            background: "#000",
            backdrop: "rgba(0,0,0,0.2)",
            buttonsStyling: !1,
            padding: "3rem 3rem 2rem",
            customClass: {confirmButton: "btn btn-link", title: "ca-title", container: "ca"}
        })
    })
}), $(document).ready(function () {
    $(".wysiwyg-editor")[0] && $(".wysiwyg-editor").trumbowyg({autogrow: !0})
}), $(document).ready(function () {
    if ($(".flot-bar")[0]) {
        $.plot($(".flot-bar"), [{
            label: "2015",
            data: [[1, 60], [2, 30], [3, 50], [4, 100], [5, 10], [6, 90], [7, 85]],
            bars: {order: 0, fillColor: "#fff"},
            color: "#fff"
        }, {
            label: "2016",
            data: [[1, 20], [2, 90], [3, 60], [4, 40], [5, 100], [6, 25], [7, 65]],
            bars: {order: 1, fillColor: "rgba(255,255,255,0.5)"},
            color: "rgba(255,255,255,0.5)"
        }, {
            label: "2017",
            data: [[1, 100], [2, 20], [3, 60], [4, 90], [5, 80], [6, 10], [7, 5]],
            bars: {order: 2, fillColor: "rgba(255,255,255,0.15)"},
            color: "rgba(255,255,255,0.15)"
        }], {
            series: {bars: {show: !0, barWidth: .075, fill: 1, lineWidth: 0}},
            grid: {borderWidth: 1, borderColor: "rgba(255,255,255,0.1)", show: !0, hoverable: !0, clickable: !0},
            yaxis: {
                tickColor: "rgba(255,255,255,0.1)",
                tickDecimals: 0,
                font: {lineHeight: 13, style: "normal", color: "rgba(255,255,255,0.75)", size: 11},
                shadowSize: 0
            },
            xaxis: {
                tickColor: "rgba(255,255,255,0.1)",
                tickDecimals: 0,
                font: {lineHeight: 13, style: "normal", color: "rgba(255,255,255,0.75)", size: 11},
                shadowSize: 0
            },
            legend: {
                container: ".flot-chart-legends--bar",
                backgroundOpacity: .5,
                noColumns: 0,
                lineWidth: 0,
                labelBoxBorderColor: "rgba(255,255,255,0)"
            }
        })
    }
}),  $(document).ready(function () {
    if ($(".flot-line")[0]) {
        $.plot($(".flot-line"), [{
            label: "2015",
            data: [[1, 60], [2, 30], [3, 50], [4, 100], [5, 10], [6, 90], [7, 85]],
            color: "#fff"
        }, {
            label: "2016",
            data: [[1, 20], [2, 90], [3, 60], [4, 40], [5, 100], [6, 25], [7, 65]],
            color: "rgba(255,255,255,0.5)"
        }, {
            label: "2017",
            data: [[1, 100], [2, 20], [3, 60], [4, 90], [5, 80], [6, 10], [7, 5]],
            color: "rgba(255,255,255,0.15)"
        }], {
            series: {lines: {show: !0, barWidth: .05, fill: 0}},
            shadowSize: .1,
            grid: {borderWidth: 1, borderColor: "rgba(255,255,255,0.1)", show: !0, hoverable: !0, clickable: !0},
            yaxis: {
                tickColor: "rgba(255,255,255,0.1)",
                tickDecimals: 0,
                font: {lineHeight: 13, style: "normal", color: "rgba(255,255,255,0.75)", size: 11},
                shadowSize: 0
            },
            xaxis: {
                tickColor: "rgba(255,255,255,0.1)",
                tickDecimals: 0,
                font: {lineHeight: 13, style: "normal", color: "rgba(255,255,255,0.75)", size: 11},
                shadowSize: 0
            },
            legend: {
                container: ".flot-chart-legends--line",
                backgroundOpacity: .5,
                noColumns: 0,
                lineWidth: 0,
                labelBoxBorderColor: "rgba(255,255,255,0)"
            }
        })
    }
}), $(document).ready(function () {
    var e = [{data: 1, color: "rgba(255,255,255,0.25)", label: "Toyota"}, {
        data: 2,
        color: "rgba(255,255,255,0.5)",
        label: "Nissan"
    }, {data: 3, color: "rgba(255,255,255,0.75)", label: "Hyundai"}, {data: 5, color: "#fff", label: "Daihatsu"}];
    $(".flot-pie")[0] && $.plot(".flot-pie", e, {
        series: {pie: {show: !0, stroke: {width: 0}}},
        legend: {
            container: ".flot-chart-legend--pie",
            noColumns: 0,
            lineWidth: 0,
            labelBoxBorderColor: "rgba(255,255,255,0)"
        }
    }), $(".flot-donut")[0] && $.plot(".flot-donut", e, {
        series: {pie: {innerRadius: .5, show: !0, stroke: {width: 0}}},
        legend: {
            container: ".flot-chart-legend--donut",
            noColumns: 0,
            lineWidth: 0,
            labelBoxBorderColor: "rgba(255,255,255,0)"
        }
    })
});