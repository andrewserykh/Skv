<?
$default_date = date("Y-m-d");

$sql="
SELECT
  `user`.`title`,
  `user_login`.`date` 
FROM `user_login`,`user` 
WHERE
  `user_login`.`user_id` = `user`.`id`
";
$res = mysql_query($sql);
$arr=array();
while ($r = mysql_fetch_array($res)) $arr[(date("Y-m-d", strtotime($r[date])))]=$r[title];
foreach ($arr as $key=>$value) $events.= "{title:\"".$value."\", start:\"".$key."\"},";
$events = substr($events, 0, -1); //удаляем последнюю запятую

//---
?>

<div class="card widget-calendar">
    <div class="actions">
        <a href="calendar.html" class="actions__item zwicon-plus"></a>
        <div class="dropdown actions__item">
            <i class="zwicon-more-h" data-toggle="dropdown"></i>
            <div class="dropdown-menu dropdown-menu-right">
                <a class="dropdown-item" href="">Обновить</a>
                <a class="dropdown-item" href="">Настройки</a>
            </div>
        </div>
    </div>
    <div class="widget-calendar__header">
        <div class="widget-calendar__year"></div>
        <div class="widget-calendar__day"></div>
    </div>

    <div id="widget-calendar-body"></div>
</div>

<script>
    $(document).ready(function () {
        if ($("#widget-calendar-body")[0]) {
            var t = document.getElementById("widget-calendar-body"), e = new Date;
            (i = new FullCalendar.Calendar(t, {
                plugins: ["dayGrid"],
                header: {right: "next", center: "title", left: "prev"},
                defaultDate: "<?=$default_date;?>",
                events: [ <?=$events;?> ]
            })).render(), $(".widget-calendar__year").html(e.getFullYear()), $(".widget-calendar__day").html(["Воскресенье", "Понедельник", "Вторник", "Среда", "Четверг", "Пятница", "Суббота"][e.getDay()] + ", " + ["Январь", "Февраль", "Март", "Апрель", "Май", "Июнь", "Июль", "Август", "Сентябрь", "Октябрь", "Ноябрь", "Декабрь"][e.getMonth()].substring(0, 3) + " " + e.getDay())
        }
    });
</script>