<?include("top.php");

$qry="SHOW COLUMNS FROM ".$tbl;
$res=mysql_query($qry);
$row=mysql_fetch_row($res);  // w/o Id

$qr="SELECT * FROM ".$tbl." Where id=".$id;
 $result=mysql_query($qr);
 $datarow=mysql_fetch_row($result);  // !! call once cause working with only one record  id=$id
echo "<h2>Просмотр: ".$tblnms_[$tbl]." | ID=$id</h2>";
 
?>
<?if ($tbl=='product'){?><br><br><a href='add.php?tbl=prod_detail&product_id=<?=$id?>'>Добавить новый тип</a><?}?>	   
	<br><br>

<table  border="1" width="70%">
<?

//$bgcolor=" bgcolor=\"#F3F3F3\"";
  for  ($j=1;$j< mysql_num_fields($result); $j++) 
  {
	  $sql_fn=mysql_field_name($result,$j);
	if (substr($sql_fn,0,5)=='param' && $tbl=="aks_model"){   //exception for aks params
		if ($par_names[$datarow[1]][$sql_fn]) $fld_name[$j]=$par_names[$datarow[1]][$sql_fn];  //aks_razdel_id
		else continue;
	} 
	  
$vals=array();
echo("<tr $bgcolor>");
$row=mysql_fetch_row($res);
$sql_fn=mysql_field_name($result,$j);
$sql_fl=mysql_field_len($result,$j);
if ($fld_null[$j]=='NO') $ttl=' title="заполнить"'; else $ttl='';  // not NULL field
echo ("<td>&nbsp;".$fld_name[$j]."  </td>");
$subst=substr($row[1],0,4);

$tmpvals=explode("'",$row[1]);         // get values of enum field     BAD TO PUT THIS INTO 
$ni=round(count($tmpvals)/2)-1;
for ($i=0; $i<$ni;$i++)  	$vals[$i]=$tmpvals[$i+$i+1];
if (strpos($sql_fn,"_id")>0)  $vals=GetRelNamesArray($sql_fn);
//echo "val=".$vals[1];
if ($subst=='text') {$h=50;$stl='style="text-align:justify"';} else {$stl=''; $h=25;}
echo("<td width=75% height=$h $stl>");
  if (($subst=="enum") || (strpos($sql_fn,"_id")>0 )) {
        // echo('<select '.$ttl.' name='. mysql_field_name($result,$j).'> <option value="">---</option>');
			foreach ($vals as $key=>$val){   
				$sel='';
				  if  ($subst=="enum") $post_val=$val ; else $post_val=$key;  // id if  use rel. table
				 if (($subst=="enum")&&($val==$datarow[$j])) $sel="selected";			
				  if ($key==$datarow[$j] && $datarow[$j]!=null) $sel="selected";  // 'selected ' adds if vals are equal     	          
			  if ($sel) echo $val;
            }
        // echo('</select>'."\n");  			
   }  else
            if ($subst=="text") echo nl2br($datarow[$j]); else 
			  if (substr($sql_fn,0,3)=='pic') echo "<img src='$pic_path$datarow[$j]'>";
				else echo $datarow[$j];
        
  echo("&nbsp;</td>\n");
  echo('</tr>');
  //if ($bgcolor=="") $bgcolor=" bgcolor=\"#F3F3F3\""; else $bgcolor="";
 }
   ?>
   </table> 
<?if ($tbl=='12product'){?><br><br><a href='add.php?tbl=prod_detail&product_id=<?=$id?>'>Добавить новый тип</a><?}?>	   
<?if ($tbl=='12factory'){?><br><br><a href='add.php?tbl=brand&factory_id=<?=$id?>'>Добавить новый бренд</a><?}?>	
<?if ($tbl=='12groups'){?><br><br><a href='add.php?tbl=subgroup&groups_id=<?=$id?>'>Добавить подгруппу</a><?}?>	   
<br><br><a href='edit.php?tbl=<?=$tbl?>&id=<?=$id?>'>Изменить</a>	
<br><br><a href='javascript:history.go(-1)'>Назад (вернуться к списку)</a>	
 <br><br> 
 
 <?include("foot.php");?>
 