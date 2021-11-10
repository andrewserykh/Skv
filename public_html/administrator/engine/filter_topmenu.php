<?if (
$tbl=='topmenu'
)
{ ?>
<ul class="filter-menu">
	<li>Фильтр: </li>
	<li><a href="table.php?tbl=<?=$tbl?>">Показать Все</a></li>
	<li><a href="table.php?tbl=<?=$tbl?>&topmenu_id=1">Корневой</a></li>
<?
	$vals=GetRelNamesArray('topmenu_id');
		$sql1='SELECT * FROM `topmenu` WHERE `url` LIKE ("root")';
		$res1=mysql_query($sql1);
		while ($r1=mysql_fetch_array($res1)) $root_id=$r1[id];
	$sql='SELECT * FROM `topmenu` WHERE `topmenu_id`='.$root_id.' ORDER BY `sort`';
	$res=mysql_query($sql);
	while ($row=mysql_fetch_array($res)) {
	if (isset($topmenu_id)) if ($row[0]==$topmenu_id) $sel='class="selected"'; else $sel="";	
?>
	<li><a href="table.php?tbl=<?=$tbl?>&topmenu_id=<?=$row[id]?>" <?=$sel?>><?=$vals[$row[id]]?></a></li>
<?
	}  
?>
</ul>
<?
} ?>

