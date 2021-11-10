<? 
$caption="Редактор Ссылок";
$tablename="links";
$valuefield="link";
$thisfilename="live_links.php";
$column_param_caption="Описание";
$column_value_caption="Ссылка";
$sql5='
SELECT 
	`links`.`id` AS `id`,
	`links`.`title` AS `title`,
	`links`.`link` AS `value`

FROM 
	`links`
';

?>
<? include ("top.php");	?>

<? 
$updated = 0;
$sql0='SELECT * FROM `'.$tablename.'`';
$res0=mysql_query($sql0);
while ($r0=mysql_fetch_array($res0)){
	if (isset ($_POST['field_id_'.$r0['id']])) {
		$sql1 = "UPDATE  `".$tablename."` SET  `".$valuefield."` =  '".$_POST['field_id_'.$r0['id']]."' WHERE  `".$tablename."`.`id` =".$r0[id];
		$res1=mysql_query($sql1);
		$updated++;
	}
}

if ($updated>0){
	echo('<div class="info" style="width: 640px; margin-left: 32px;"><p style="margin-left: 64px;">Изменения сохранены!</p></div>');
	echo('<br><br><br><br><br> <br><div class="barrer"></div>');
}

?>

<div style="padding-left: 10px; padding-bottom: 10px; font-size: 18px; font-decoration: bold;"><?=$caption;?></div>
<form enctype="multipart/form-data" name="form1" method="post" action="<?=$thisfilename;?>"> 

<div class="barrer"></div>
<ul class="tools-menu">
	<li><a href="javascript:history.go(-1)">Отмена</a></li>
	<input type="submit" name="sub" value="Сохранить изменения">
</ul>


<?

echo '<table class="bordered">';
echo '<thead><tr>';
echo '<th>№</th>';
echo '<th>'.$column_param_caption.'</th>';
echo '<th>'.$column_value_caption.'</th>';
echo '</tr></thead>';

$res5=mysql_query($sql5);
while ($r5=mysql_fetch_array($res5)){
	$n++;
	echo ('<td>'.$n.'</td>');
	echo ('<td>'.$r5['title'].'</td>');
	echo ('<td><input name="field_id_'.$r5[id].'" value="'.$r5['value'].'" size=100 /></td>');
	echo '</tr>';
}
echo "</table>";

?>


</form>

<?	include("foot.php");	?>