<? //код отчета за интервал дат (1.0)

modUserAccess_check(0);

//предзагрузка
$object_id = $_POST['object_id'];
$date_from = $_POST['date_from'];
$date_to = $_POST['date_to'];

//include 
//---определение исходных данных
$title_view=($object_id>0?"Канал ".$object_id:"");
$descr_view="Отчет по выбранной величине";
$title_legend="температура, <sup>o</sup>C";

$limit=10000;

$sql_filter="SELECT raw_adam4017_1.channel AS id FROM raw_adam4017_1 GROUP BY raw_adam4017_1.channel LIMIT 32";

$sql_limit=100;
$sql="
SELECT 
raw_adam4017_1.time AS time,
raw_adam4017_1.value AS value
FROM raw_adam4017_1 
WHERE 
raw_adam4017_1.channel = $object_id AND
raw_adam4017_1.time 
BETWEEN 
STR_TO_DATE('$date_from', '%Y-%m-%d %H:%i') AND 
STR_TO_DATE('$date_to', '%Y-%m-%d %H:%i')
LIMIT $limit;
";

$res = mysql_query($sql);
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
<?if (isset($object_id)){?>
<div class="invoice">
                        <div class="row invoice__attrs">
                            <div class="col-3">
                                <div class="invoice__attrs__item">
                                    <small>Параметр</small>
                                    <h3>Канал <?=$object_id+1;?></h3>
                                </div>
                            </div>

                            <div class="col-3">
                                <div class="invoice__attrs__item">
                                    <small>Дата от:</small>
                                    <h4><?=(date('j.m.Y H:i', strtotime($date_from)));?></h4>
                                </div>
                            </div>

                            <div class="col-3">
                                <div class="invoice__attrs__item">
                                    <small>Дата по:</small>
                                    <h4><?=(date('j.m.Y H:i', strtotime($date_to)));?></h4>
                                </div>
                            </div>

                            <div class="col-3">
                                <div class="invoice__attrs__item">
                                    <small>Ед.изм</small>
                                    <h3>мА</h3>
                                </div>
                            </div>
                        </div>


                        <table class="table table-bordered invoice__table">
                            <thead>
                                <tr class="text-uppercase">
                                    <th>Дата, время</th>
                                    <th>Величина</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
			<?	while ($r = mysql_fetch_array($res)):?>
				  <tr>
				    <td><?=(date('j.m.Y H:i', strtotime($r[time])));?></td><td><?=ValueConversation($r[value]);?></td>
				  </tr>
			<?	endwhile;?>
                            </tbody>
                        </table>
                    </div>

                    <button class="btn btn-light btn--action btn--fixed " data-sa-action="print"><i class="zwicon-printer"></i></button>
<?}//isset?>	
        </div>
    </div>
</section>
<?
function ValueConversation($value){

  if ($value==255) $value="сенсор не подключен";

  return $value;
}
?>