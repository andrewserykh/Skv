<section class="content">

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="flot-chart flot-dynamic0"></div>
                    <div><h4>Канал 1: <b>0</b></h4></div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="flot-chart flot-dynamic2"></div>
                    <div><h4>Канал 3: <b>0</b></h4></div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="flot-chart flot-dynamic1"></div>
                    <div><h4>Канал 2: <b>0</b></h4></div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="flot-chart flot-dynamic3"></div>
                    <div><h4>Канал 4: <b>0</b></h4></div>
                </div>
            </div>
        </div>
    </div>

</section>

<script>
    $(document).ready(function () {
        function t() {
            let arr;
            var value = 0;
            $.ajax({
                url: "ajax_channels.php",
                success: function(data){
                    //alert( "Прибыли данные: " + data );
                    arr = data.split(';');
                    value = Number(arr[0]);
                    o.push(value);
                }
            });
            for (0 < o.length && (o = o.slice(1)); o.length < i;) {
                var e = value;
                e < 0 ? e = 0 : 90 < e && (e = 90), o.push(e)
            }
            for (var t = [], a = 0; a < o.length; ++a)t.push([a, o[a]]);

            return t
        }

        if ($(".flot-dynamic0")[0]) {
            var o = [], i = 250, a = $.plot(".flot-dynamic0", [t()], {
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
                    container: ".flot-chart-legends--dynamic0",
                    backgroundOpacity: .5,
                    noColumns: 0,
                    lineWidth: 0,
                    labelBoxBorderColor: "rgba(255,255,255,0)"
                }
            }), l = 30;
            !function e() {
                a.setData([t()]), a.draw(), setTimeout(e, 100)
            }()
        }

    });

</script>


<script>
    $(document).ready(function () {
        function t() {
            let arr;
            var value = 0;
            $.ajax({
                url: "ajax_channels.php",
                success: function(data){
                    //alert( "Прибыли данные: " + data );
                    arr = data.split(';');
                    value = Number(arr[1]);
                    o.push(value);
                }
            });
            for (0 < o.length && (o = o.slice(1)); o.length < i;) {
                var e = value;
                e < 0 ? e = 0 : 90 < e && (e = 90), o.push(e)
            }
            for (var t = [], a = 0; a < o.length; ++a)t.push([a, o[a]]);

            return t
        }

        if ($(".flot-dynamic1")[0]) {
            var o = [], i = 250, a = $.plot(".flot-dynamic1", [t()], {
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
                    container: ".flot-chart-legends--dynamic1",
                    backgroundOpacity: .5,
                    noColumns: 0,
                    lineWidth: 0,
                    labelBoxBorderColor: "rgba(255,255,255,0)"
                }
            }), l = 30;
            !function e() {
                a.setData([t()]), a.draw(), setTimeout(e, 100)
            }()
        }

    });

</script>



<script>
    $(document).ready(function () {
        function t() {
            let arr;
            var value = 0;
            $.ajax({
                url: "ajax_channels.php",
                success: function(data){
                    //alert( "Прибыли данные: " + data );
                    arr = data.split(';');
                    value = Number(arr[2]);
                    o.push(value);
                }
            });
            for (0 < o.length && (o = o.slice(1)); o.length < i;) {
                var e = value;
                e < 0 ? e = 0 : 90 < e && (e = 90), o.push(e)
            }
            for (var t = [], a = 0; a < o.length; ++a)t.push([a, o[a]]);

            return t
        }

        if ($(".flot-dynamic2")[0]) {
            var o = [], i = 250, a = $.plot(".flot-dynamic2", [t()], {
                series: {
                    label: "Измерения канал 3",
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
                    container: ".flot-chart-legends--dynamic2",
                    backgroundOpacity: .5,
                    noColumns: 0,
                    lineWidth: 0,
                    labelBoxBorderColor: "rgba(255,255,255,0)"
                }
            }), l = 30;
            !function e() {
                a.setData([t()]), a.draw(), setTimeout(e, 100)
            }()
        }

    });

</script>

<script>
    $(document).ready(function () {
        function t() {
            let arr;
            var value = 0;
            $.ajax({
                url: "ajax_channels.php",
                success: function(data){
                    //alert( "Прибыли данные: " + data );
                    arr = data.split(';');
                    value = Number(arr[3]);
                    o.push(value);
                }
            });
            for (0 < o.length && (o = o.slice(1)); o.length < i;) {
                var e = value;
                e < 0 ? e = 0 : 90 < e && (e = 90), o.push(e)
            }
            for (var t = [], a = 0; a < o.length; ++a)t.push([a, o[a]]);

            return t
        }

        if ($(".flot-dynamic3")[0]) {
            var o = [], i = 250, a = $.plot(".flot-dynamic3", [t()], {
                series: {
                    label: "Измерения канал 4",
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
                    container: ".flot-chart-legends--dynamic3",
                    backgroundOpacity: .5,
                    noColumns: 0,
                    lineWidth: 0,
                    labelBoxBorderColor: "rgba(255,255,255,0)"
                }
            }), l = 30;
            !function e() {
                a.setData([t()]), a.draw(), setTimeout(e, 100)
            }()
        }

    });

</script>
