<?
$Timeout = 1*60; //время после которого считаем что нет связи (секунд)
require_once("/administrator/engine/initdb.php");
ini_set('date.timezone', 'Asia/Krasnoyarsk');
?>

<div class="input-group input-group-lg rbmk-temp-value">
  <div class="input-group-prepend"><span class="input-group-text">t<sub>1</sub></span></div>
  <input type="text" disabled class="form-control <?=GetColor(0,$Timeout);?>" value="<?=GetValue(0,$Timeout);?>">
  <div class="input-group-append"><span class="input-group-text"><sup>o</sup>C</span></div>
</div>

<div class="input-group input-group-lg rbmk-temp-value">
  <div class="input-group-prepend"><span class="input-group-text">t<sub>2</sub></span></div>
  <input type="text" disabled class="form-control <?=GetColor(0,$Timeout);?>" value="<?=GetValue(1,$Timeout);?>">
  <div class="input-group-append"><span class="input-group-text"><sup>o</sup>C</span></div>
</div>

<div class="input-group input-group-lg rbmk-temp-value">
  <div class="input-group-prepend"><span class="input-group-text">t<sub>3</sub></span></div>
  <input type="text" disabled class="form-control <?=GetColor(0,$Timeout);?>" value="<?=GetValue(2,$Timeout);?>">
  <div class="input-group-append"><span class="input-group-text"><sup>o</sup>C</span></div>
</div>

<div class="input-group input-group-lg rbmk-temp-value">
  <div class="input-group-prepend"><span class="input-group-text">t<sub>4</sub></span></div>
  <input type="text" disabled class="form-control <?=GetColor(0,$Timeout);?>" value="<?=GetValue(3,$Timeout);?>">
  <div class="input-group-append"><span class="input-group-text"><sup>o</sup>C</span></div>
</div>

<div class="input-group input-group-lg rbmk-temp-value">
  <div class="input-group-prepend"><span class="input-group-text">t<sub>5</sub></span></div>
  <input type="text" disabled class="form-control <?=GetColor(0,$Timeout);?>" value="<?=GetValue(4,$Timeout);?>">
  <div class="input-group-append"><span class="input-group-text"><sup>o</sup>C</span></div>
</div>

<div class="input-group input-group-lg rbmk-temp-value">
  <div class="input-group-prepend"><span class="input-group-text">t<sub>6</sub></span></div>
  <input type="text" disabled class="form-control <?=GetColor(0,$Timeout);?>" value="<?=GetValue(5,$Timeout);?>">
  <div class="input-group-append"><span class="input-group-text"><sup>o</sup>C</span></div>
</div>

<div class="input-group input-group-lg rbmk-temp-value">
  <div class="input-group-prepend"><span class="input-group-text">t<sub>7</sub></span></div>
  <input type="text" disabled class="form-control <?=GetColor(0,$Timeout);?>" value="<?=GetValue(6,$Timeout);?>">
  <div class="input-group-append"><span class="input-group-text"><sup>o</sup>C</span></div>
</div>

<div class="input-group input-group-lg rbmk-temp-value">
  <div class="input-group-prepend"><span class="input-group-text">t<sub>8</sub></span></div>
  <input type="text" disabled class="form-control <?=GetColor(0,$Timeout);?>" value="<?=GetValue(7,$Timeout);?>">
  <div class="input-group-append"><span class="input-group-text"><sup>o</sup>C</span></div>
</div>

<?
function GetValue ($Channel,$Timeout){
  $value=0;
  $NoSignal="######";	

  $sql0 = 'SELECT * FROM `raw_adam4017_1` WHERE channel='.$Channel.' ORDER BY id DESC LIMIT 1';
  $res0 = mysql_query($sql0);
  while ($r0 = mysql_fetch_array($res0)):
    $value = $NoSignal;	
    if ((strtotime(date("Y-m-d H:i:s"))-strtotime($r0[time])) < $Timeout) 
	$value = $r0[value];
  endwhile;
//---исключения
  if ($value==255) $value="сенсор не подключен";

  return $value;
}

function GetColor ($Channel,$Timeout){
  $NoSignal="";	
  $value="";

  $sql0 = 'SELECT * FROM `raw_adam4017_1` WHERE channel='.$Channel.' ORDER BY id DESC LIMIT 1';
  $res0 = mysql_query($sql0);
  while ($r0 = mysql_fetch_array($res0)):
    $value = $NoSignal;	
    if ((strtotime(date("Y-m-d H:i:s"))-strtotime($r0[time])) < $Timeout) 
	$value = "bg-success";
  endwhile;
  return $value;
}

?>