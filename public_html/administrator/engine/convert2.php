
<?   // обновление серий (дозагрузка)
	include ("top.php");
	?><br><h2>Синхронизация таблицы серии</h2><?
	$names=array('vmark_id'=>'marka','title'=>'seria_title','url'=>'seria_url');
									
									$rs=mysql_query('show full columns FROM velo_seria');
									 $nrs=mysql_num_rows($rs);
									for  ($j=0;$j<$nrs; $j++) {
										$row=mysql_fetch_array($rs);
										$velo_seria_fields[]=$row[0];
									}	
									
									$rs=mysql_query('show full columns FROM vseries');
									  $nrs=mysql_num_rows($rs);
									for  ($j=0;$j<$nrs; $j++) {
										$row=mysql_fetch_array($rs);
										$vser_fields[]=$row[0];
									}	
										
//print_r($velo_seria_fields);
echo "<br>";

foreach ($vser_fields as $fld) { 
if (! in_array($fld,$velo_seria_fields))  
 $fld . "  ";
}

echo '<br><br><br>';
$sql="SELECT * FROM velo_seria WHERE id NOT IN ( SELECT id FROM vseries)";

$res=mysql_query($sql);
$nr=mysql_num_rows($res);
//$ins_row=array(); 

if ($nr)
	while ($r=mysql_fetch_array($res)){   $k=0;
		$sql="Insert into vseries VALUES("; 
	foreach ($vser_fields as $fld) { $k++;
		if (!in_array($fld,$velo_seria_fields)){			
			 if (array_key_exists($fld,$names))	$val=$r[$names[$fld]]; else $val='';
		}			
		else $val=$r[$fld];
	if ($fld=='ok') $val=0;	
	
	$sql.=" '$val',";
	}	
	$sql[strlen($sql)-1]=" "; // cut ,
	$sql.="); ";  
	//echo $k.$sql;			
	echo "Добавление модели: #$r[id] <b>".$r[marka_url].' '.$r[seria_title].'</b>';
	if ($res0=mysql_query($sql)) echo " Ok<br>";		

	}	
else echo "<p>Нет новых серий для добавления в базу"	
?>
