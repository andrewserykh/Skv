<section class="content">

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Измерения канал 1</h4>
                    <div class="flot-chart flot-dynamic1"></div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Измерения канал 3</h4>
                    <div class="flot-chart flot-dynamic3"></div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Измерения канал 2</h4>
                    <div class="flot-chart flot-dynamic2"></div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Измерения канал 4</h4>
                    <div class="flot-chart flot-dynamic4"></div>
                </div>
            </div>
        </div>
    </div>

</section>

<script>
$(document).ready(function () {
function t() {
for (0 < o.length && (o = o.slice(1)); o.length < i;) {
var e = (0 < o.length ? o[o.length - 1] : 50) + 10 * Math.random() - 5;
e < 0 ? e = 0 : 90 < e && (e = 90), o.push(e)
}
for (var t = [], a = 0; a < o.length; ++a)t.push([a, o[a]]);
return t
}

if ($(".flot-dynamic1")[0]) {
var o = [], i = 300, a = $.plot(".flot-dynamic1", [t()], {
series: {
label: "Измерения канал 1",
lines: {show: !0, lineWidth: .2, fill: 1, fillColor: {colors: ["rgba(255,255,255,0.03)", "#fff"]}},
color: "#fff",
shadowSize: 0
},
yaxis: {
min: 0,
max: 100,
tickColor: "rgba(255,255,255,0.1)",
font: {lineHeight: 13, style: "normal", color: "rgba(255,255,255,0.75)", size: 11},
shadowSize: 0
},
xaxis: {
tickColor: "rgba(255,255,255,0.1)",
show: !0,
font: {lineHeight: 13, style: "normal", color: "rgba(255,255,255,0.75)", size: 11},
shadowSize: 0,
min: 0,
max: 250
},
grid: {
borderWidth: 1,
borderColor: "rgba(255,255,255,0.1)",
labelMargin: 10,
hoverable: !0,
clickable: !0,
mouseActiveRadius: 6
},
legend: {
container: ".flot-chart-legends--dynamic",
backgroundOpacity: .5,
noColumns: 0,
lineWidth: 0,
labelBoxBorderColor: "rgba(255,255,255,0)"
}
}), l = 30;
!function e() {
a.setData([t()]), a.draw(), setTimeout(e, 1000)
}()
}
}),

$(document).ready(function () {
    function t() {
        for (0 < o.length && (o = o.slice(1)); o.length < i;) {
            var e = (0 < o.length ? o[o.length - 1] : 50) + 10 * Math.random() - 5;
            e < 0 ? e = 0 : 90 < e && (e = 90), o.push(e)
        }
        for (var t = [], a = 0; a < o.length; ++a)t.push([a, o[a]]);
        return t
    }

    if ($(".flot-dynamic2")[0]) {
        var o = [], i = 300, a = $.plot(".flot-dynamic2", [t()], {
            series: {
                label: "Измерения канал 2",
                lines: {show: !0, lineWidth: .2, fill: 1, fillColor: {colors: ["rgba(255,255,255,0.03)", "#fff"]}},
                color: "#fff",
                shadowSize: 0
            },
            yaxis: {
                min: 0,
                max: 100,
                tickColor: "rgba(255,255,255,0.1)",
                font: {lineHeight: 13, style: "normal", color: "rgba(255,255,255,0.75)", size: 11},
                shadowSize: 0
            },
            xaxis: {
                tickColor: "rgba(255,255,255,0.1)",
                show: !0,
                font: {lineHeight: 13, style: "normal", color: "rgba(255,255,255,0.75)", size: 11},
                shadowSize: 0,
                min: 0,
                max: 250
            },
            grid: {
                borderWidth: 1,
                borderColor: "rgba(255,255,255,0.1)",
                labelMargin: 10,
                hoverable: !0,
                clickable: !0,
                mouseActiveRadius: 6
            },
            legend: {
                container: ".flot-chart-legends--dynamic",
                backgroundOpacity: .5,
                noColumns: 0,
                lineWidth: 0,
                labelBoxBorderColor: "rgba(255,255,255,0)"
            }
        }), l = 30;
        !function e() {
            a.setData([t()]), a.draw(), setTimeout(e, 1000)
        }()
    }
});

</script>