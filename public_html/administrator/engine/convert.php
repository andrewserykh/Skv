
<?   // обновление моделей
	include ("top.php");
?><br><h2>Синхронизация таблицы модели (c сайтом Velostrana.ru)</h2><?	
									
									$rs=mysql_query('show full columns FROM velo_model');
									 $nrs=mysql_num_rows($rs);
									for  ($j=0;$j<$nrs; $j++) {
										$row=mysql_fetch_array($rs);
										$velo_model_fields[]=$row[0];
									}										
									$rs=mysql_query('show full columns FROM vmodel');
										$nrs=mysql_num_rows($rs);
									for  ($j=0;$j<$nrs; $j++) {
										$row=mysql_fetch_array($rs);
										$vmodel_fields[]=$row[0];
									}	
										
//print_r($velo_model_fields);


foreach ($vmodel_fields as $fld) { 
if (! in_array($fld,$velo_model_fields))  
 $fld . "  ";
}

echo '<br><br><br>'.
 $sql="SELECT * FROM velo_model WHERE (id*199-99)*199  NOT IN ( SELECT id FROM vmodel)";

$res=mysql_query($sql);
$nr=mysql_num_rows($res);
$ins_row=array(); 
$names=array('vmark_id'=>'marka','vseries_id'=>'seria','year'=>'year_url','title'=>'name_title','url'=>'name_url','artikul'=>'pic');
if ($nr)
	while ($r=mysql_fetch_array($res)){   $k=0;
		$sql="Insert into vmodel VALUES("; 
	foreach ($vmodel_fields as $fld) { $k++;
		if (!in_array($fld,$velo_model_fields) || $fld=='year'){			
			 if (array_key_exists($fld,$names))	$val=$r[$names[$fld]]; else $val='';
		}			
		else $val=$r[$fld];
	if ($fld=='nalichie' && $val==2) $val=0;	
	if ($fld=='justcopied') $val=1;
	if ($fld=='pic') $val=md5($r[id]).'.jpg';
	$sql.=" '$val',";
	}	
	$sql[strlen($sql)-1]=" "; // cut ,
	$sql.="); ";  
	//echo $k.$sql;	
		
	echo 'Добавление модели: <b>'.$r[marka_url].' '.$r[name_title].'</b>';
	//if ($res0=mysql_query($sql)) echo " Ok<br>";
		

	}	
else echo "<p>Нет новых моделей для добаления в базу";	
?>
	<br><br><br><a href="convert2.php">Запустить синхронизацию серий</a>