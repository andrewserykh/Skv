<?if (
$tbl=='page'
)
{ ?>
<ul class="filter-menu">
	<li>Фильтр: </li>
	<li><a href="table.php?tbl=<?=$tbl?>">Показать Все</a></li>
<?
	$vals=GetRelNamesArray('types_id');
	$res=mysql_query("SELECT id FROM types");
	while ($row=mysql_fetch_array($res)) {
	if (isset($types_id)) if ($row[0]==$types_id) $sel='class="selected"'; else $sel="";	
?>
	<li><a href="table.php?tbl=<?=$tbl?>&types_id=<?=$row[id]?>" <?=$sel?>><?=$vals[$row[id]]?></a></li>
<?
	}  
?>
</ul>
<?
} ?>

