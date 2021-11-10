<?
$sql1 = 'SELECT * FROM `stand`';
$res1 = mysql_query($sql1);
while ($r1 = mysql_fetch_array($res1)):?>
    <div class="card todo">
        <div class="card-body">
            <h4 class="card-title"><?= mb_strtoupper($r1[title]); ?></h4>
            <h6 class="card-subtitle">Заряд аккумуляторных батарей</h6>
        </div>

        <div class="card widget-pie">
            <div class="widget-pie__inner">
                <?
                $sql2 = '
SELECT `battery`.`machine_id`,`machine`.`title`,`machine`.`addr` FROM `battery`,`machine` WHERE
  `machine`.`stand_id`=' . $r1[id] . ' AND
  `battery`.`machine_id`=`machine`.`id`
GROUP BY `machine`.`addr`
ORDER BY `machine`.`addr` ASC';
                $res2 = mysql_query($sql2);
                while ($r2 = mysql_fetch_array($res2)):

                    $sql3 = '
SELECT `battery`.`value` FROM `battery`
WHERE
  `battery`.`machine_id`=' . $r2[machine_id] . '
ORDER BY `battery`.`id` DESC
LIMIT 1';
                    $res3 = mysql_query($sql3);
                    while ($r3 = mysql_fetch_array($res3)):
                        ?>
                        <div class="col-6 col-sm-4 col-md-6 col-lg-4 widget-pie__item">
                            <a href="graph_batt?id=<?=$r2[machine_id];?>">
                            <div class="easy-pie-chart" data-percent="50" data-size="80"
                                 data-track-color="rgba(0,0,0,0.25)"
                                 data-bar-color="#fff">
                                <span class="easy-pie-chart__value"><?= $r3[value]; ?></span>
                            </div>
                            <div class="widget-pie__title"><?= ($r2[title] . " (" . $r2[addr] . ")"); ?></div>
                            </a>
                        </div>
                        <?
                    endwhile;

                endwhile; ?>
            </div>
        </div>
    </div>
<? endwhile; ?>
