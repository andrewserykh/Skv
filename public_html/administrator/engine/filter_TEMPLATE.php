<?
    $flt_tbl='complex';   //таблица в которой применять фильтр
	$key_tbl='developer'; //поле по которому фильтровать

	$key=$key_tbl."_id";
?>

<?if ($tbl==$flt_tbl){ ?>
<ul class="filter-menu">
	<li>Фильтр: </li>
	<li><a href="table.php?tbl=<?=$tbl?>">Показать Все</a></li>
<?
	$vals=GetRelNamesArray($key);
	$res=mysql_query("SELECT id FROM ".$key_tbl);
	while ($row=mysql_fetch_array($res)) {
	if (isset($$key)) if ($row[0]==$$key) $sel='class="selected"'; else $sel="";	
?>
	<li><a href="table.php?tbl=<?=$tbl;?>&<?=$key;?>=<?=$row[id];?>" <?=$sel;?>><?=$vals[$row[id]];?></a></li>
<?
	}  
?>
</ul>
<?
} ?>

