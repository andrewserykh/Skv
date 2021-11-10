<?	include("top.php");	?>

<script type="text/javascript" src="/admin/data/server/update_model.js" charset='utf-8'></script>
<script type="text/javascript" src="/admin/data/server/add_sim_model.js" charset='utf-8'></script>
<?if ($mp){?> <script>alert('Файлы фотоизображений успешно созданы.')</script> <?}?>

<Table width="95%" align="center"><tr><td>
<?php  
$lim=''; 
if (!isset($_GET['p'])) $p=0;
$p=$_GET['p']; //added 25012018
$lim='limit '.($p*$on_page).','.$on_page;
// ------ search ----------

$where='';
if (isset($_GET)){  //  prepare where query if get sets
	$sql='';
	foreach ($_GET as $name=>$val) if (($name!="oby")&&($name!="tbl")&&($name!="p")&&($name!="sim")) $sql.=" $name='$val' and";
    if ($sql) $sql=substr($sql,0,-4);   // cut last AND
   	if ($sql) $where=" where $sql";
}

if (!isset($oby)) {$oby='id DESC'; if ($tbl=='vmodel') $oby='`title` ';}
 $qry="SELECT * FROM $tbl $where ORDER BY $oby $lim"; 
$buf='';
if ($tbl=="search") 
{
  for ($i=0 ;$i< mysql_num_fields($allres); $i++)     
  {
   	$nm=mysql_field_name($allres,$i);
	if ($_POST[$nm]!="не важно" && $_POST[$nm]!="")
	 $buf=$buf.mysql_field_name($allres,$i)."= '". $_POST[$nm]."' and ";
  }  
	$buf=substr($buf,0,strlen($buf)-4);   
    if  ($buf!="") $buf="WHERE ".$buf;
	$qry= "SELECT * FROM main ".$buf; 
    //echo $qry; 
}
 //---------------- search ---------------
$result=mysql_query($qry);  //echo $result;
 
if ((mysql_num_rows($result) == 0) ||(!$result)):
	include ('filter.php');
?>
	<ul class="tools-menu">
		<li><a href="add.php?<?=$_SERVER[QUERY_STRING]?>">Добавить запись</a></li>
	</ul>
	<div class="barrer"></div>
<?=('
<div class="alert">
Записей удовлетворяющих запросу не обнаружено</p><p><i>Возможно выбранная таблица или категория пуста</i>
</div> 
');
else:	
//echo '<div class="tbl-name">'.$tblnms[$tbl].'</div>';

include ('filter.php');

// if ($tbl=='vmodel') $z=82; else $z=0;
// if ($z) $img_w=75; else $img_w=100;  //little preview for models
?>

<div class="barrer"></div>
<ul class="tools-menu">
	<li><a href="add.php?<?=$_SERVER[QUERY_STRING]?>">Добавить запись</a></li>
	<? include("listpages.php"); ?>
</ul>
<div class="editlist">
<table class="bordered">
 <thead>
   <tr>
     <th>Действия</th>
     <?php
	   $num_flds=mysql_num_fields($result);
       if ($z) echo '<th>&nbsp;Фото&nbsp;</th>';
 	   for ($i=0 ;$i< $num_flds-$z; $i++) {	 if ($tbl=='vmodel' && $i==3) continue;    
		 //echo ('<th><a title="сортировать"  href="table.php?tbl='.$tbl.'&oby='.mysql_field_name($result,$i).' ">&nbsp;'.$fld_name[$i]. '&nbsp;</a></th>');   
		echo ('<th>&nbsp;'.$fld_name[$i]. '&nbsp;</th>');
		
	   }
		 ?>	
		 <?if ($z):?><th width=55px>Цена</th><th width=25px >Тип</th>	<?endif?>
	</tr>
	</thead>
	<tbody><form id="frm" name="bform" action="status.php" method="POST">
	<?php
		$bgcolor=" bgcolor=\"#F3F3F3\"";   
	    for ($i= 0 ;$i< mysql_num_rows($result); $i++) {
		 $row_array = mysql_fetch_array($result);	
		 if (isset($row_array[ok]) && !$row_array[ok]) $stl=" style='color:#aaaaaa'"; else $stl='';
		 if ($row_array[justcopied]==1) $stl=" style='color:#ff1010'"; else $stl='';
	     echo("<tr $bgcolor $stl >");
		
		  $ed_year=$year; $ed_mark=$vmark_id;// series filter exception
		  ?>
<td width=70 style="text-align:right;">
	<a onClick="return confirm('Внимание! Удаление записи #<?=$row_array[0]?>. Вы уверены?')"  title="Удалить" href="del.php?<?=$_SERVER[QUERY_STRING];?>&id=<?=$row_array[0];?>" ><img src="img/del32.png"><a>
<?	echo ('<a title="Изменить" href="edit.php?'.$_SERVER[QUERY_STRING].'&id='.$row_array[0].'" ><img  src="img/edit32.png"><a>'); ?>
</td>
<?
	if ($z) echo "<td>&nbsp;<a class=zoom href='$pic_path$row_array[pic]'>". createpreview($pic_path.$row_array['pic'],$img_w)."</a></td>";

	for ($j = 0; $j <$num_flds-$z; $j++){ 
		if ($tbl=='vmodel' && $j==3) continue;
		$fn=mysql_field_name($result,$j);
		$vhref="<a href='edit.php?&tbl=$tbl&id=$row_array[0]'>"; $vhref2='</a>';
		
		if ($fn=="object")
		  echo ('<td><a href="input.php?id='.$row_array[0].'" >' . $row_array[$j] . '<a></td>'."\n");  //href to input window only for admin
		else 
		{
		  $exception=0;
		  if (strpos($fn,"pic")>-1) { 
			if (file_exists($pic_path.$row_array[$j])){
			  echo "<td>&nbsp;". createpreview($pic_path.$row_array[$j],75,90,'','','',75)."</td>"; 
			} else {
			  echo "<td></td>"; 
			}
			$exception++;
		  }
		  if (strpos($fn,"png")>-1) { 
			if (file_exists($pic_path.$row_array[$j])){
			  echo "<td>&nbsp; <img src='". $pic_path.$row_array[$j]."' width=40 height=40> </td>"; 
			} else {
			  echo "<td></td>"; 			  
			}
			$exception++;
		  }

		  if (strpos($fn,"date")>-1) {
			echo '<td><div class="pub-green">'.date('j.m.Y', strtotime($row_array[$j])).'</div></td>';
			$exception++;
		  }
		  if ($fn=="pub") {
			if ($row_array[$j]=='1') echo '<td><div class="pub-on">+</div></td>';
			if ($row_array[$j]=='0') echo '<td><div class="pub-off">-</div></td>';
			if ($row_array[$j]!='0'&&$row_array[$j]!='1') echo ('<td>&nbsp;'.$vhref.GetShortStr($row_array[$j]).$vhref2.'</td>');
			$exception++;
		  }
		  if ($fn=="text") {
			if ($row_array[$j][0]=='{') { 
				echo '<td><div class="pub-link">'.$row_array[$j].'</div></td>'; 
			} else {
				if ($row_array[$j]=="") {
					echo '<td><div class="pub-red">запись пуста</div></td>'; 
				} else {
					echo '<td><div class="pub-green">есть содержимое</div></td>'; 
				}
			}
			
			$exception++;
		  }
		  if ($exception==0) {
		      if (strpos($fn,"_id")>0) echo '<td><div class="pub-blue">&nbsp;'. GetRelFldById($row_array[$j],$fn).'</div></td>';
		        else echo ('<td>&nbsp;'.$vhref.GetShortStr($row_array[$j]).$vhref2.'</td>');
		  }
		}
	}		

	if ($z):// exception for ajax edit subgroup ,posadka ...?>
		<td width=25px><?=$row_array[cost_active];?></td>
		<td width=25px><?=echo_selector('vtype_id',$row_array[vtype_id],$row_array[0]);?><br>
	<?endif;
	echo ("</tr>"); 
	if ($bgcolor=="") $bgcolor=" bgcolor=\"#F3F3F3\""; else $bgcolor="";
}
?>
		
</tbody>
</table>
</div>
<?endif;?>

</form>
</td></tr></Table>

<?      if ($tbl=='page') { include("live_menu.php"); } ?>
<?	include("foot.php");	?>

