<? //код построения графика (2.0a)

modUserAccess_check(0);

//предзагрузка
$object_id = $_POST['object_id'];
$date_from = $_POST['date_from'];
$date_to = $_POST['date_to'];

//include 
//---определение исходных данных
$title_view=($object_id>0?"Канал ".$object_id:"");
$descr_view="График изменения температуры";
$title_legend="температура, <sup>o</sup>C";

$sql_filter="SELECT raw_adam4017_1.channel AS id FROM raw_adam4017_1 GROUP BY raw_adam4017_1.channel LIMIT 32";

$sql_limit=100;
$sql="
SELECT 
raw_adam4017_1.time AS x,
raw_adam4017_1.value AS y
FROM raw_adam4017_1 
WHERE 
raw_adam4017_1.channel = $object_id AND
raw_adam4017_1.time 
BETWEEN 
STR_TO_DATE('$date_from', '%Y-%m-%d %H:%i') AND 
STR_TO_DATE('$date_to', '%Y-%m-%d %H:%i');
";

$res = mysql_query($sql);
$arr=array();
while ($r = mysql_fetch_array($res)) array_push($arr,$r['y']);
foreach ($arr as $key=>$value) $graph_data.= "[".$key.",".$value."],";
$graph_data = substr($graph_data, 0, -1); //удаляем последнюю запятую

$res_filter = mysql_query($sql_filter);
$arr_filter=array();
while ($r1 = mysql_fetch_array($res_filter)) array_push($arr_filter,$r1['id']);

//---

?>

<section class="content">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title"><?=$title_view;?></h4>
            <h6 class="card-subtitle" style="margin-bottom:4px;"><?=$descr_view;?></h6>
        
	<form action="<?=$pg;?>" method="POST">
	<div class="row">
	  <div class="form-group">
	      <select class="form-control bg-dark" id="object_id" name="object_id">
		<?foreach ($arr_filter as $key=>$value) echo '<option value="'.$value.'" '.($object_id==$key?'selected':'').'>Канал '.($value+1).'</option>';?>
	      </select>
	  </div>

	  <div class="col-sm-4">
	      <div class="input-group">
	          <div class="input-group-prepend">
	              <span class="input-group-text"><i class="zwicon-calendar-never"></i></span>
	          </div>
	          <input type="text" class="form-control datetime-picker" placeholder="дата, время от:" id="date_from" name="date_from" value="<?=$date_from;?>">
	      </div>
	  </div>

	  <div class="col-sm-4">
	      <div class="input-group">
	          <div class="input-group-prepend">
	              <span class="input-group-text"><i class="zwicon-calendar-never"></i></span>
	          </div>
	          <input type="text" class="form-control datetime-picker" placeholder="дата, время до:" id="date_to" name="date_to" value="<?=$date_to;?>">
	      </div>
	  </div>
	  <button type="submit" class="btn btn-theme" style="height: 38px;">Отобразить</button>
  	</div>
	
	
  	</form>

            <div class="flot-chart flot-curved-line"></div>
            <div class="flot-chart-legends flot-chart-legends--curved"></div>
        </div>
    </div>
</section>

<script>
    $(document).ready(function () {
        $(".flot-chart")[0] && ($(".flot-chart").on("plothover", function (e, t, a) {
            if (a) {
                var o = a.datapoint[0].toFixed(2), i = a.datapoint[1].toFixed(2);
                $(".flot-tooltip").html(a.series.label + " of " + o + " = " + i).css({
                    top: a.pageY + 5,
                    left: a.pageX + 5
                }).show()
            } else $(".flot-tooltip").hide()
        }), $('<div class="flot-tooltip"></div>').appendTo("body"))
    }), $(document).ready(function () {
        var e = {
            series: {
                shadowSize: 0,
                curvedLines: {apply: !0, active: !0, monotonicFit: !0},
                lines: {show: !1, lineWidth: 0}
            },
            grid: {borderWidth: 0, labelMargin: 10, hoverable: !0, clickable: !0, mouseActiveRadius: 6},
            xaxis: {tickDecimals: 0, ticks: !1},
            yaxis: {tickDecimals: 0, ticks: !1},
            legend: {show: !1}
        };
        $(".flot-curved-line")[0] && $.plot($(".flot-curved-line"), [ {
            label: "<?=$title_legend;?>",
            color: "rgba(255,255,255,0.8)",
            lines: {show: !0, lineWidth: .1, fill: 1, fillColor: {colors: ["rgba(255,255,255,0.01)", "#fff"]}},
            data: [<?=$graph_data;?>]
        }], {
            series: {shadowSize: 0, curvedLines: {apply: !0, active: !0, monotonicFit: !0}, points: {show: !1}},
            grid: {borderWidth: 1, borderColor: "rgba(255,255,255,0.1)", show: !0, hoverable: !0, clickable: !0},
            xaxis: {
                tickColor: "rgba(255,255,255,0.1)",
                tickDecimals: 0,
                font: {lineHeight: 13, style: "normal", color: "rgba(255,255,255,0.75)", size: 2}
            },
            yaxis: {
                tickColor: "rgba(255,255,255,0.1)",
                font: {lineHeight: 13, style: "normal", color: "rgba(255,255,255,0.75)", size: 11},
                min: 5
            },
            legend: {
                container: ".flot-chart-legends--curved",
                backgroundOpacity: .5,
                noColumns: 0,
                lineWidth: 0,
                labelBoxBorderColor: "rgba(255,255,255,0)"
            }
        })

    });
</script>
